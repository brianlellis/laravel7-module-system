<?php

if (! function_exists('parseFeExpression')) {
    // LOOPING THROUGH EXPRESSION WHICH IS A COMMA DELIMITED STRING OF ASSETS TO PARS
    function parseFeExpression($passed_expression, $cache_prefix, $prefix_path, $filetype, $is_module = false)
    {
        $expression = explode(',', preg_replace('/[\s\']+/', '', $passed_expression));
        $return_val = '';

        foreach ($expression as $path) {
          if (strpos($path, 'http') !== false) {
            $return_val .= "<script src='".$path."'></script>";
          } else {
            // IF IN DEVELOPMENT FETCH VIA HTTP RESOURCE
            if (strpos('.com', url()->current()) === false) {
              if ($is_module) {
                if ($filetype === '.css') {
                    $fe_asset = "<link rel='stylesheet' href='{$prefix_path}{$path}{$filetype}' />";
                } else {
                    $fe_asset = "<script src='{$prefix_path}{$path}{$filetype}'></script>";
                }
              } else {
                // Remove public from beginning of string
                $prefix_path = str_replace('/public/resources', '/resources', $prefix_path);
                $prefix_path = str_replace('/public/admin', '/admin', $prefix_path);

                if ($filetype === '.css') {
                    $fe_asset = "<link rel='stylesheet' href='{$prefix_path}{$path}{$filetype}' />";;
                } else {
                    $fe_asset = "<script src='{$prefix_path}{$path}{$filetype}'></script>";
                }
              }
              $return_val .= $fe_asset;
            } // IF IN PRODUCTION THEN INLINE ASSETS INSTEAD OF GRABBING RESOURCES
            else {
              $return_val .= assetCacheCheck($path, $cache_prefix, $prefix_path, $filetype);
            }
          }
        }

        return $return_val;
    }
}

if (! function_exists('assetCacheCheck')) {
    // CACHING MECHANISM FOR FE ASSETS TO REMOVE THE NEED TO READ FILE IF NOT CHANGED
    // SINCE LAST READ
    function assetCacheCheck($path, $cache_prefix, $prefix_path, $filetype)
    {
        $id = preg_replace('/\//', '.', $path);

        if (Cache::has($cache_prefix . $id)) {
            $fe_asset = cache($cache_prefix . $id);

            $cur_time = filemtime(base_path() . $prefix_path . $path . $filetype);
            $cache_time = cache($cache_prefix . 'mtime_' . $id);

            // IF FILE IS NEWER THAN CACHED OBJECT REPLACE CACHE
            if ($cur_time > $cache_time) {
                Cache::forget($cache_prefix . $id);
                Cache::forget($cache_prefix . 'mtime_' . $id);

                if ($filetype === '.css') {
                    $fe_asset = '<style>' . File::get(base_path() . $prefix_path . $path . $filetype) . '</style>';
                } else {
                    $fe_asset = '<script>' . File::get(base_path() . $prefix_path . $path . $filetype) . '</script>';
                }

                Cache::forever($cache_prefix . $id, $fe_asset);

                $cur_time = filemtime(base_path() . $prefix_path . $path . $filetype);
                Cache::forever($cache_prefix . 'mtime_' . $id, $cur_time);
            }
        } else {
            if ($filetype === '.css') {
                $fe_asset = '<style>' . File::get(base_path() . $prefix_path . $path . $filetype) . '</style>';
            } else {
                $fe_asset = '<script>' . File::get(base_path() . $prefix_path . $path . $filetype) . '</script>';
            }

            Cache::forever($cache_prefix . $id, $fe_asset);

            $cur_time = filemtime(base_path() . $prefix_path . $path . $filetype);
            Cache::forever($cache_prefix . 'mtime_' . $id, $cur_time);
        }

        return $fe_asset;
    }
}

/*
 * ASSET DELIVERY DIRECTIVES
 */
Blade::directive('pagescript', function ($expression) {
  return parseFeExpression($expression, 'public_pagescript_', '/public/resources/public/js/', '.js');
});

Blade::directive('pagestyle', function ($expression) {
    return parseFeExpression($expression, 'public_pagestyle_', '/public/resources/public/css', '.css');
});

// ADMIN SPECIFIC ASSETS
// Blade::directive('admin_pageimg', function ($expression) {
//     $resource_path = public_path('/themes/frostbite/dist/css/' . $expression . '.css');
//     return '<style>'. File::get($resource_path) . '</style>';
// });


Blade::directive('admin_pagestyle', function ($expression) {
    return parseFeExpression($expression, 'admin_pagestyle_', '/public/admin_pub/', '.css');
});

Blade::directive('admin_pagescript', function ($expression) {
    return parseFeExpression($expression, 'admin_pagescript_', '/public/admin_pub/', '.js');
});

Blade::directive('module_pagestyle', function ($expression) {
    $expression = preg_replace('/[\'\"]+/', '', $expression);
    $asset = explode(';', $expression);
    return parseFeExpression(
      $asset[2], 
      'module_pagestyle_'.$asset[0].'_'.$asset[1], 
      '/modules/'.$asset[0].'/Resources/'.$asset[1].'/sass/', 
      '.css',
      true
    );
});

Blade::directive('module_pagescript', function ($expression) {
    $expression = preg_replace('/[\'\"]+/', '', $expression);
    $asset = explode(';', $expression);
    return parseFeExpression(
      $asset[2], 
      'module_pagescript_'.$asset[0].'_'.$asset[1], 
      '/modules/'.$asset[0].'/Resources/'.$asset[1].'/js/', 
      '.js',
      true
    );
});


/*
 * DASHBOARD HEADER
 *
 * This takes in
 * 1 - Label for buttons and header
 * 2 - Creation Path OR searchbox to get swisnl running
 * 3 - Model Scope **This also dictates what the file name will be
 *
**/
Blade::directive('dashboard_table_header', function ($expression) {
  $data        = explode(',', preg_replace('/[\s\']+/', '', $expression));

  if (substr($data[0], -1) === 'y') {
    $y_fix = substr($data[0], 0, -1) .'ie';
  } else {
    $y_fix = null;
  }

  if (count($data) === 2 && $data[1] === 'searchbox') {
    $dom  = '<div class="row dashboard__table-actions" style="margin-bottom: 20px">';
    $dom .= '<div class="col-lg-12 margin-tb"><div class="pull-left"><h2>Browse '.$data[0].'</h2>';
    $dom .= '</div></div></div>';

    // Search box
    $dom .= '<div class="row dashboard__table-search" style="margin-bottom: 20px">';
    $dom .= '<div class="col-lg-12 margin-tb">';
    $dom .= '<div class="form-group"><div class="row gutters-xs"><div class="col">';
    $dom .= '<input id="search_dashboard_input" type="text" class="form-control" placeholder="Search for '.$data[0].'s...">';
		$dom .= '</div><span class="col-auto">';
		$dom .= '<button id="search_dashboard_submit" class="btn btn-primary" type="button"><i class="fe fe-search"></i></button>';
		$dom .= '</span></div></div></div></div>';

    // JS for Search box
    $dom .= '<script>let old_search = window.location.href.split("?search=");';

    // Enter Key Event
    $dom .= 'document.getElementById("search_dashboard_input").addEventListener("keypress", function (e) {';
    $dom .= 'if (e.key === "Enter") {';
    $dom .= 'let search_val = document.getElementById("search_dashboard_input").value;';
    $dom .= 'if(search_val !== "") {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname + "?search=" + encodeURI(search_val);';
    $dom .= '} else {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname;';
    $dom .= '}}});';

    // Click Event
    $dom .= 'document.getElementById("search_dashboard_submit").addEventListener("click",function () {';
    $dom .= 'let search_val = document.getElementById("search_dashboard_input").value;';
    $dom .= 'if(search_val !== "") {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname + "?search=" + encodeURI(search_val);';
    $dom .= '} else {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname;';
    $dom .= '}});';


    $dom .= 'if (Rapyd.Core.Url.props.params && Rapyd.Core.Url.props.params.hasOwnProperty("search")) document.getElementById("search_dashboard_input").value = decodeURI(Rapyd.Core.Url.props.params.search)';
    $dom .= '</script>';
  } elseif (count($data) === 1) {
    $dom  = '<div class="row dashboard__table-actions" style="margin-bottom: 20px">';
    $dom .= '<div class="col-lg-12 margin-tb"><div class="pull-left"><h2>Browse '.$data[0].'</h2>';
    $dom .= '</div></div></div>';
  } else {
    $export_path = route('rapyd.data.export', $data[2]);
    $import_path = route('rapyd.data.import');

    $dom  = '<div class="row dashboard__table-actions" style="margin-bottom: 20px">';
    $dom .= '<div class="col-lg-12 margin-tb"><div class="pull-left"><h2>Browse '.($y_fix ? $y_fix : $data[0]).'s</h2>';

    $dom .= '<a class="btn btn-primary mr-2" href="'.$export_path.'">Export '.($y_fix ? $y_fix : $data[0]).'s</a>';
    $dom .= '<a class="btn btn-success" href="'.$data[1].'"> Create New '.$data[0].'</a>';

    $dom .= '</div><div class="pull-right">';
    $dom .= '<form action="'.$import_path.'" method="POST" enctype="multipart/form-data">';
    $dom .= '<input type="hidden" name="_token" value="'.csrf_token().'">';

    $dom .= '<div class="pull-right"><input type="hidden" name="scope" value="'.$data[2].'">';
    $dom .= '<input type="file" name="file" class="form-control">';

    $dom .= '<button class="btn btn-primary pull-right" style="margin-top: 10px">Import '.($y_fix ? $y_fix : $data[0]).'s</button>';
    $dom .= '</div></form></div></div></div>';

    // Search box
    $dom .= '<div class="row dashboard__table-search" style="margin-bottom: 20px">';
    $dom .= '<div class="col-lg-12 margin-tb">';
    $dom .= '<div class="form-group"><div class="row gutters-xs"><div class="col">';
    $dom .= '<input id="search_dashboard_input" type="text" class="form-control" placeholder="Search for '.$data[0].'s...">';
		$dom .= '</div><span class="col-auto">';
		$dom .= '<button id="search_dashboard_submit" class="btn btn-primary" type="button"><i class="fe fe-search" style="cursor: pointer;"></i></button>';
		$dom .= '</span></div></div></div></div>';

    // JS for Search box
    $dom .= '<script>let old_search = window.location.href.split("?search=");';

    // Enter Key Event
    $dom .= 'document.getElementById("search_dashboard_input").addEventListener("keypress", function (e) {';
    $dom .= 'if (e.key === "Enter") {';
    $dom .= 'let search_val = document.getElementById("search_dashboard_input").value;';
    $dom .= 'if(search_val !== "") {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname + "?search=" + encodeURI(search_val);';
    $dom .= '} else {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname;';
    $dom .= '}}});';

    // Click Event
    $dom .= 'document.getElementById("search_dashboard_submit").addEventListener("click",function () {';
    $dom .= 'let search_val = document.getElementById("search_dashboard_input").value;';
    $dom .= 'if(search_val !== "") {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname + "?search=" + encodeURI(search_val);';
    $dom .= '} else {';
    $dom .= 'window.location.href = window.location.origin + window.location.pathname;';
    $dom .= '}});';


    $dom .= 'if (Rapyd.Core.Url.props.params && Rapyd.Core.Url.props.params.hasOwnProperty("search")) document.getElementById("search_dashboard_input").value = decodeURI(Rapyd.Core.Url.props.params.search)';
    $dom .= '</script>';
  }

  return $dom;
});

/*
 * DASHBOARD TABLE
 */
Blade::directive('dashboard_table', function ($expression) {
   $data      = explode(',', preg_replace('/[\s\']+/', '', $expression));
   $hideSort  = in_array('hide_sort', $data);

   if (($key = array_search('hide_sort', $data)) !== false) {
     unset($data[$key]);
   }

   $links = array_pop($data);

   // Pagination Links
   $dom  = '<div class="row dashboard__table-pagination" style="margin: 10px 0"><div class="col-sm-12"><div class="pull-right">';
   $dom .= $links;
   $dom .= '</div></div></div>';

   // Dashboard Data Table
   $dom .= '<div class="row dashboard__table-table"><div class="col-12"><div class="card"><div><div class="grid-margin">';
   $dom .= '<div><div class="table-responsive"><table class="table card-table table-vcenter text-nowrap  align-items-center">';
   $dom .= '<thead class="thead-light"><tr>';

   foreach ($data as $head_title) {
    $dom .= "<th>${head_title}";

    if (strtolower($head_title) != 'action' && $hideSort !== true) {
      $sort_term = strtolower(preg_replace("/[^A-Za-z]/", '', str_replace(" ", "-",$head_title)));

      $dom .= '<i class="sorter fa fa-long-arrow-up" style="cursor: pointer;" data-sortorder="asc" data-sortterm="'.$sort_term.'" onclick="sort_rapyd_table(this)"></i>';
      $dom .= '<i class="sorter fa fa-long-arrow-down" style="cursor: pointer;" data-sortorder="desc" data-sortterm="'.$sort_term.'" onclick="sort_rapyd_table(this)"></i>';
    }
   }
   $dom .= '</tr></thead><tbody>';

   // SORTER JS LOGIC
   $dom .= "
      <script>
      var sorters = document.getElementsByClassName('sorter');

      if(Rapyd.Core.Url.props.params && Rapyd.Core.Url.props.params.hasOwnProperty('sortorder')) {
        for(var i = 0; i < sorters.length; i++){
          if (sorters[i].dataset.sortorder == Rapyd.Core.Url.props.params.sortorder &&
              sorters[i].dataset.sortterm == Rapyd.Core.Url.props.params.sort) {
              sorters[i].classList.add('active');
            }
          }
      }

      function sort_rapyd_table(e) {
        if(Rapyd.Core.Url.props.params){
          var query = ''
          var index = 0;
          for(key in Rapyd.Core.Url.props.params) {
            if(key !== 'sortorder' && key !== 'sort'){
              var type = index === 0 ? '?' : '&'
              query += type + key + '=' + Rapyd.Core.Url.props.params[key]
              index += 1;
            }
          }

          if(query !== '') {
            query += '&sortorder=' + e.dataset.sortorder + '&sort=' + e.dataset.sortterm;
          } else {
            query = '?sortorder=' + e.dataset.sortorder + '&sort=' + e.dataset.sortterm;
          }

          window.location = window.location.origin + window.location.pathname + query
        } else {
          window.location = window.location.origin + window.location.pathname +
            '?sortorder=' + e.dataset.sortorder + '&sort=' + e.dataset.sortterm;
        }
      }
      </script>
   ";


   return $dom;
});

Blade::directive('end_dashboard_table', function ($expression) {
    // Close Dashboard Data Table
    $dom  = '</tbody></table></div></div></div></div></div></div></div>';

    // Pagination Links
    $dom .= '<div class="row dashboard__table-pagination" style="margin: -5px 0 10px 0"><div class="col-sm-12"><div class="pull-right">';
    $dom .= $expression;
    $dom .= '</div></div></div>';

    return $dom;
});

Blade::directive('url', function ($expression) {
  $str    = preg_replace('/[\'"]/', '', $expression);
  $first  = substr($str, 0,1);
  if ($first == '/') {
    $str  = substr($str, 1);
  }
  $host   = request()->getSchemeAndHttpHost().'/'.$str;
  return $host;
});


// ------------ ACCOUNTING PAGE SPECIFIC
// DOM SNIPPETS
Blade::directive('active_invoice_table_head', function ($expression) {
  $data    = explode(";", $expression);
  $data[1] = explode(",", $data[1]);

  $dom     =  "<thead class='{$data[0]}'><tr class='head-row'>";
  foreach($data[1] as $row) {
    $dom  .= "<th class='sort-head'>{$row}</th>";
  }
  $dom    .= "</tr></thead>";

  return $dom;
});
