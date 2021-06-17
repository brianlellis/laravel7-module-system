<?php

namespace Rapyd;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Core
{
  public static function slugify($str)
  {
    if (is_array($str)) {
      $str_arr = array_map(
        function ($val) {
          $new_str = strtolower(
            trim(
              preg_replace('/[^A-Za-z0-9]+/', '-', $val)
            , '-')
          );
          $new_str = str_replace('---', '-', $new_str);
          return $$new_str;
        },
        $str
      );

      return join("", $str_arr);
    } else {
      $new_str = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $str), '-'));
      return str_replace('---', '-', $new_str);
    }
  }

  public static function increment_model_view($model,$model_id)
  { 
    $model_views = \m_ModelViews::where('model',$model)->where('model_id',$model_id)->first();
    if ($model_views) {
      $model_views->update(['view_count' => (intval($model_views->view_count) + 1)]);
    } else {
      \m_ModelViews::insert([
        'model'       => $model,
        'model_id'    => $model_id,
        'view_count'  => 1
      ]);
    }
    return true;
  }

  public static function admin_menu_build()
  {
    $user_permissions = \Auth::user()->getAllPermissions();

    \Cache::rememberForever("admin_menu", function () {
      return \DB::table('menu_items')
        ->select('menu_items.*', 'menus.name as menu_name')
        ->join('menus', 'menu_items.menu_id', 'menus.id')
        ->where('menus.name', 'admin')
        ->get();
    });

    $menu_data = \Cache::get("admin_menu");

    // Build the HTML
    $menu_html = '<ul class="side-menu">';
    foreach ($menu_data->where('parent_id', null)->sortBy('order') as $menu_parent) {
      // Check if perm allows parent menu
      $slugged_parent       = self::slugify($menu_parent->title);
      $slugged_parent_found = false;

      foreach ($user_permissions as $permission) {
        if (strpos($permission->name, $slugged_parent) !== false) {
          $slugged_parent_found = true;
        }
      }

      if ($slugged_parent_found) {
        $menu_html .= '<li class="slide"><a class="side-menu__item" data-toggle="slide" href="#">';
        $menu_html .= '<i class="side-menu__icon ' . $menu_parent->icon_class . '"></i>';
        $menu_html .= '<span class="side-menu__label">' . $menu_parent->title . '</span>';
        $menu_html .= '<i class="angle fa fa-angle-right"></i></a><ul class="slide-menu">';


        foreach ($menu_data->where('parent_id', $menu_parent->id)->where('url', '!=', '')->sortBy('order') as $menu_items) {
          // Check if perm allows sub-items for parent menu
          $slugged_subitem       = self::slugify($menu_items->title);
          $slugged_subitem_found = false;
          foreach ($user_permissions as $permission) {
            if (strpos($permission->name, $slugged_subitem) !== false || !$menu_items->need_permission) {
              $slugged_subitem_found = true;
            }
          }

          if ($slugged_subitem_found) {
            $menu_html .= '<li><a class="slide-item" href="' . $menu_items->url . '"><span>' . $menu_items->title . '</span></a></li>';
          }
        }

        $menu_html .= '</ul>';
      }
    }

    $menu_html .= '</ul>';

    return $menu_html;
  }

  public static function send_contact_form()
  {
    \RapydEvents::send_mail('sitewide_contact_form', 'sitewide_contact_form', ['message' => request('message'), 'user' => request('email')]);
    return back();
  }

  public static function send_contact_agent()
  {
    \RapydMail::build_email_template(
        'system-default',
        'agent-contact',
        request('agent_email'),
        request('agent_name'),
        ['event_mail_subject' => 'User Contact'],
        [
            'recipient_to_email' => request('agent_email'),
            'message' => request('message'),
            'email' => request('user_email'),
            'name' => request('user_name')
        ]
      );
    return back();
  }

  public static function blade_from_string($string, $data = false)
  {
    $php = \Blade::compileString($string);

    $obLevel = ob_get_level();
    ob_start();

    if ($data !== false) {
      extract($data, EXTR_SKIP);
    }

    try {
      eval('?' . '>' . $php);
    } catch (Exception $e) {
      while (ob_get_level() > $obLevel) ob_end_clean();
      throw $e;
    } catch (Throwable $e) {
      while (ob_get_level() > $obLevel) ob_end_clean();
      throw new FatalThrowableError($e);
    }

    return ob_get_clean();
  }

  public static function compile_public_blade($page_id, $page_title, $view_lookup)
  {
    return response()
            ->view('rapyd_master::master', [
              'blade_data'        => [
                    'page_id'    => 'agent_profile',
                    'page_title' => 'BX Agent Profile',
                    'css_asset'  => false,
               ],
              'view_lookup'       => $view_lookup, 
              'via_pageslug'      => false,
              'via_pageslug_type' => false,
              'pageslug_data'     => false,
              'default_blog_wrap' => false,
            ], 200);
  }

  public static function paginate(Collection $results, $pageSize)
  {
      $page = Paginator::resolveCurrentPage('page');
      
      $total = $results->count();

      return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
          'path' => Paginator::resolveCurrentPath(),
          'pageName' => 'page',
      ]);

  }

  protected static function paginator($items, $total, $perPage, $currentPage, $options)
  {
      return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
          'items', 'total', 'perPage', 'currentPage', 'options'
      ));
  }

  public static function format_phone_number($str) {
    return "(".substr($str, 0, 3).") ".substr($str, 3, 3)." ".substr($str,6);
  }

  /**
   *
   * DATE MANIPULATION TOOLS
  **/
  public static function get_month_name($month_num)
  {
    return date("F", strtotime('00-'.$month_num.'-01'));
  }
  public static function date_days_in_month($use_month = false, $use_year = false)
  {
    if (!$use_month) {
      $days_in_month = \Carbon\Carbon::now()->daysInMonth;
    }

    return $days_in_month;
  }

  /**
   * Calculates the weeks in a given month.
   * Also provides the total full weeks if overflow is present
  **/
  public static function date_weeks_in_month($use_month = false, $use_year = false)
  {
    if (!$use_month) {
      $days_in_month = \Carbon\Carbon::now()->daysInMonth;
    }

    $result               = $days_in_month / 7;
    $numberOfFullWeeks    = floor($result);
    $numberOfRemaningDays = ($result - $numberOfFullWeeks) * 7;
    $first_last_day       = self::date_first_last_day($use_month, $use_year);

    $data_return = [
      'weeks'               => [
        'num'  => $numberOfFullWeeks,
        'data' => []
      ],
      'weeks_with_overflow' => false,
      'days'                => $numberOfRemaningDays
    ];

    // Check for overflow data of the weeks
    $weeks_with_overflow = 0;
    if ($first_last_day['underflow']) {
      $weeks_with_overflow += 1;
    }
    if ($first_last_day['overflow']) {
      $weeks_with_overflow += 1;
    }

    // Create data based on current week in the form of start/end date
    // of the current week rotation
    if ($weeks_with_overflow > 0) {
      $data_return['weeks_with_overflow'] = [
        'num' => $numberOfFullWeeks + $weeks_with_overflow
      ];

      for ($i=1; $i <= $data_return['weeks_with_overflow']['num'] ; $i++) {
        # code...
      }
    }

    // Create data based on current week in the form of start/end date
    // of the current week rotation
    $week_loop = $data_return['weeks_with_overflow'] ? $data_return['weeks_with_overflow']['num'] : $data_return['weeks']['num'];

    if ($first_last_day['underflow']) {
      $calc_start_week_date = $first_last_day['underflow']['date'];
    } else {
      $calc_start_week_date = $first_last_day['first_month']['date'];
    }

    // When you run methods against a Carbon object
    // it updates the object itself.
    // Therefore addDay() moves the value of Carbon one day forward
    for ($i=1; $i <= $week_loop ; $i++) {
      if ($i === 1) {
        $calc_start_week_date = $calc_start_week_date->copy();
      } else {
        $calc_start_week_date = $calc_start_week_date->copy()->addDays(7);
      }

      $calc_end_week_date     = $calc_start_week_date->copy()->addDays(6);

      $data_return['weeks']['data']["week_{$i}"] = [
        'start' => [
          'date'    => $calc_start_week_date,
          'string'  => $calc_start_week_date->format('m/d/Y'),
          'string2' => $calc_start_week_date->format('Y-m-d')
        ],
        'end'   => [
          'date'    => $calc_end_week_date,
          'string'  => $calc_end_week_date->format('m/d/Y'),
          'string2' => $calc_end_week_date->format('Y-m-d')
        ]
      ];
    }

    return $data_return;
  }

  /**
   * Gets the first and last day of the chosen month.
   * Also formats the day to a string and retrieves the prev month (underflow)
   * and the next month (overflow) if the day is not Monday/Tuesday as needed.
  **/
  public static function date_first_last_day($use_month = false, $use_year = false)
  {
    if (!$use_month) {
      $days_in_month = \Carbon\Carbon::now()->daysInMonth;
      $first_month   = \Carbon\Carbon::now()->firstOfMonth();
      $end_month     = \Carbon\Carbon::now()->endOfMonth();
    }

    switch($first_month->format('l')) {
      case 'Tuesday':   $underflow_val = 1; break;
      case 'Wednesday': $underflow_val = 2; break;
      case 'Thursday':  $underflow_val = 3; break;
      case 'Friday':    $underflow_val = 4; break;
      case 'Saturday':  $underflow_val = 5; break;
      case 'Sunday':    $underflow_val = 6; break;
      default: $underflow_val = false;
    }
    if ($underflow_val) {
      $underflow = \Carbon\Carbon::now()->firstOfMonth()->subDays($underflow_val);
    }

    switch($end_month->format('l')) {
      case 'Monday':    $overflow_val = 6; break;
      case 'Tuesday':   $overflow_val = 5; break;
      case 'Wednesday': $overflow_val = 4; break;
      case 'Thursday':  $overflow_val = 3; break;
      case 'Friday':    $overflow_val = 2; break;
      case 'Saturday':  $overflow_val = 1; break;
      default: $overflow_val = false;
    }
    if ($overflow_val) {
      $overflow = \Carbon\Carbon::now()->endOfMonth()->addDays($overflow_val);
    }

    $data_return = [
      'first_month' => [
        'month' => [
          'num'    => $first_month->format('m'),
          'string' => $first_month->format('F')
        ],
        'day'   => [
          'num'    => $first_month->format('d'),
          'string' => $first_month->format('l')
        ],
        'date'  => $first_month
      ],
      'end_month' => [
        'month' => [
          'num'    => $end_month->format('m'),
          'string' => $end_month->format('F')
        ],
        'day'   => [
          'num'    => $end_month->format('d'),
          'string' => $end_month->format('l')
        ],
        'date'  => $end_month
      ]
    ];

    if ($underflow_val) {
      $data_return['underflow'] = [
        'month' => [
          'num'    => $underflow->format('m'),
          'string' => $underflow->format('F')
        ],
        'day'   => [
          'num'    => $underflow->format('d'),
          'string' => $underflow->format('l')
        ],
        'date'  => $underflow
      ];
    } else {
      $data_return['underflow'] = false;
    }

    if ($overflow_val) {
      $data_return['overflow'] = [
        'month' => [
          'num'    => $overflow->format('m'),
          'string' => $overflow->format('F')
        ],
        'day'   => [
          'num'    => $overflow->format('d'),
          'string' => $overflow->format('l')
        ],
        'date'  => $overflow
      ];
    } else {
      $data_return['overflow'] = false;
    }

    return $data_return;
  }

  /**
   *
   * ARRAY FUNCTIONALITY
   *
  **/
  public static function group_multidimens($passed_arr, $sort_key, $nest_obj=false) {
    $new_arr = [];


    foreach ($passed_arr as $key => $value) {
      // If nested value is object format
      if ($nest_obj) {
        $new_key = $value->$sort_key;
      } else {
        $new_key = $value[$sort_key];
      }

      // Set $sort_key as index value of new array grouping
      if (!isset($new_arr[$new_key])) {
        $new_arr[$new_key] = [];
      }

      $new_arr[$new_key][] = $value;
    }

    return $new_arr;
  }

  /**
   *
   * DATA PERSISTENCE TOOLS
   *
  **/
  public function persist_flat_array($passed_data, $model)
  {
    $chunk_size   = 500;

    foreach(array_chunk($passed_data,$chunk_size) as $chunk) {
      call_user_func($model .'::insert', $chunk);
    }
  }

  /**
   *
   * UTILITY BENCHMARKING FUNCTIONS
   *
  **/
  public static function benchmark($endpoint='start', $fn_name='',$time_format='ms', $return_data='time')
  {
    // CACHE STORAGE TIME
    $cache_storage_time = now()->addMinutes(20);

    // STARTING POINT
    if ($endpoint === 'start') {
      $start_time      = self::convert_microtime($time_format);
      $start_mem       = memory_get_usage(false);
      $start_mem_alloc = memory_get_usage(true);

      \Cache::put('core_fn'.$fn_name.'_start_time', $start_time, $cache_storage_time);
      \Cache::put('core_fn'.$fn_name.'_start_mem', $start_mem, $cache_storage_time);
      \Cache::put('core_fn'.$fn_name.'_start_mem_alloc', $start_mem_alloc, $cache_storage_time);

      // Set up total variables
      if(!\Cache::has('core_benchmark_total_start_time')) {
        \Cache::put('core_benchmark_total_start_time', $start_time, $cache_storage_time);
        \Cache::put('core_benchmark_total_start_mem', $start_mem, $cache_storage_time);
        \Cache::put('core_benchmark_total_start_mem_alloc', $start_mem_alloc, $cache_storage_time);
      }
      return;
    } 

    // ENDING POINT
    $fn_end_mem         = memory_get_usage(false);
    $fn_end_mem_alloc   = memory_get_usage(true);

    // DETERMINE WHICH POINT TO CALCULATE
    if (strpos($endpoint, 'total') !== false) {
      $return_data    = $endpoint;
      $calc_time      = self::convert_microtime($time_format) - \Cache::get('core_benchmark_total_start_time');
      $calc_mem       = $fn_end_mem - \Cache::get('core_benchmark_total_start_mem');
      $calc_mem_alloc = $fn_end_mem_alloc - \Cache::get('core_benchmark_total_start_mem_alloc');

      // Data Return Variables
      $return_mem_start       = self::convert_byte(\Cache::get('core_benchmark_total_start_mem'));
      $return_mem_start_alloc = self::convert_byte(\Cache::get('core_benchmark_total_start_mem_alloc'));

      // CLEAR OUT TOTAL TIMES AS A QUICKER FLUSH
      \Cache::forget('core_benchmark_total_start_time');
      \Cache::forget('core_benchmark_total_start_mem');
      \Cache::forget('core_benchmark_total_start_mem_alloc');
    } else {
      $calc_time      = self::convert_microtime($time_format) - \Cache::get('core_fn'.$fn_name.'_start_time');
      $calc_mem       = $fn_end_mem - \Cache::get('core_fn'.$fn_name.'_start_mem');
      $calc_mem_alloc = $fn_end_mem_alloc - \Cache::get('core_fn'.$fn_name.'_start_mem_alloc');

      // Data Return Variables
      $return_mem_start       = self::convert_byte(\Cache::get('core_fn'.$fn_name.'_start_mem'));
      $return_mem_start_alloc = self::convert_byte(\Cache::get('core_fn'.$fn_name.'_start_mem_alloc'));
    }

    // RETURN VALUES
    if (strpos($return_data, 'time') !== false) {
      return round($calc_time,2) . $time_format;
    } elseif (strpos($return_data, 'mem') !== false) {
      return [
        'memory'  => [
          'used'      => [
            'start' => $return_mem_start,
            'end'   => self::convert_byte($fn_end_mem),
            'diff'  => self::convert_byte($calc_mem)
          ],
          'allocated' => [
            'start' => $return_mem_start_alloc,
            'end'   => self::convert_byte($fn_end_mem_alloc),
            'diff'  => self::convert_byte($calc_mem_alloc)
          ]
        ]
      ];
    } else {
      return [
        'time'    => round($calc_time,2) . $time_format,
        'memory'  => [
          'used'      => [
            'start' => $return_mem_start,
            'end'   => $return_mem_end,
            'diff'  => $return_mem_calc
          ],
          'allocated' => [
            'start' => $return_mem_start_alloc,
            'end'   => $return_mem_end_alloc,
            'diff'  => $return_mem_calc_alloc
          ]
        ]
      ];
    }
  }


  public static function convert_microtime($time_size='ms') {
    $mt   = explode(' ', microtime());
    $calc = ((float)$mt[1]) + ((float)$mt[0]);

    if ($time_size === 'ms') {
      return ($calc * 1000);
    } elseif ($time_size === 's') {
      return (($calc * 1000) / 1000);
    }
  }

  public static function convert_byte($size)
  {
    $base = log($size) / log(1024);
    $suffix = array("B", "KB", "MB", "GB", "TB");
    $f_base = floor($base);
    return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
  }
}
