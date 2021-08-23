<?php

namespace Rapyd;
use Rapyd\Bond\BondPolicyHelper;

class RapydEventEmailModel
{

  /** 
   * NOTE:
   * 
   * THE MODELERS ARE USED TO MAKE SURE RELATION OF RELATIONS
   * DO NOT CAUSE BOMB OUTS OF A MAIL TEMPLATE IF THE END USER
   * USES A VARIABLE NOT PRESENT 
  **/

  // Sanitize all data objects combinding in one array
  // Used for email templates and testing process
  public static function sanitized_models($passed_group = '', $model_id = false)
  {
    if(is_array($model_id) && array_key_exists('errors', $model_id)) {
      $eval = 'errors';
    } else {
      $eval = strtolower($passed_group);
    }

    // Create id boolean for needed models
    $bool_eval = [
      'saa'             => $eval === 'saa'          ? $model_id : false,
      'history'         => $eval === 'history'      ? $model_id : false,
      'cmspage'         => $eval === 'cmspage'      ? $model_id : false,
      'cmsblog'         => $eval === 'cmsblog'      ? $model_id : false,
      'cmscategory'     => $eval === 'cmscategory'  ? $model_id : false,
      'bondnumber'      => $eval === 'bondnumber'   ? $model_id : false,
      'user'            => $eval === 'user'         ? $model_id : false,
      'usergroup'       => $eval === 'usergroup'    ? $model_id : false,
      'errors'          => $eval === 'errors'       ? $model_id : false,
      'bondlibrary'     => $eval === 'bondlibrary'  ? $model_id : false,
      'obligee'         => $eval === 'obligee'      ? $model_id : false,
      'bondpolicy'      => $eval === 'bondpolicy'   ? $model_id : false,
    ];
    
    $returnArr = [
      'saa'           => self::saa($bool_eval['saa']),
      'history'       => self::history($bool_eval['history']),
      'cmspage'       => self::cmspage($bool_eval['cmspage']),
      'cmsblog'       => self::cmsblog($bool_eval['cmsblog']),
      'cmscategory'   => self::cmscategory($bool_eval['cmscategory']),
      'bondnumber'    => self::bondnumber($bool_eval['bondnumber']),
      'user'          => self::user($bool_eval['user']),
      'usergroup'     => self::usergroup($bool_eval['usergroup']),
      'errors'        => self::errors($bool_eval['errors']),
      'bondlibrary'   => self::bondlibrary($bool_eval['bondlibrary']),
      'obligee'       => self::obligee($bool_eval['obligee']),
    ];

    if($eval === 'bondpolicy' && $model_id) {
      $returnArr = array_merge($returnArr, BondPolicyHelper::model_data_email_pdf($model_id));
    }

    return $returnArr;
  }

  // BONDLIBRARY MAP
  public static function bondlibrary($id)
  {
    $bondlibrary  = \m_BondLibraries::find($id);

    return [
      'id'                            => $bondlibrary->id ?? '',
      'description'                   => $bondlibrary->description ?? '',
      'require_info'                  => $bondlibrary->require_info ?? '',
      'require_credit'                => $bondlibrary->require_credit ?? '',
      'auto_kickout'                  => $bondlibrary->auto_kickout ?? '',
      'require_location'              => $bondlibrary->require_location ?? '',
      'require_vehicle'               => $bondlibrary->require_vehicle ?? '',
      'require_erisa'                 => $bondlibrary->require_erisa ?? '',
      'is_generic'                    => $bondlibrary->is_generic ?? '',
      'require_dishonesty'            => $bondlibrary->require_dishonesty ?? '',
      'obligee'       => [
        'description'                 => $bondlibrary->description ?? '',
        'id'                          => $bondlibrary->obligee->id ?? '',
        'name'                        => $bondlibrary->obligee->name ?? '',
        'name_alternate'              => $bondlibrary->obligee->name_alternate ?? '',
        'name_alternate_2'            => $bondlibrary->obligee->name_alternate_2 ?? '',
        'address'                     => $bondlibrary->obligee->address ?? '',
        'address_2'                   => $bondlibrary->obligee->address_2 ?? '',
        'city'                        => $bondlibrary->obligee->city ?? '',
        'state'                       => $bondlibrary->obligee->state ?? '',
        'zip'                         => $bondlibrary->obligee->zip ?? '',
        'phone'                       => $bondlibrary->obligee->phone ?? '',
        'email'                       => $bondlibrary->obligee->email ?? '',
      ]
    ];
  }

  // OBLIGEE MAP
  public static function obligee($id)
  {
    $obligee = \m_BondLibraryObligee::find($id);

    return [
      'id'                    => $obligee->id ?? '',
      'name'                  => $obligee->name ?? '',
      'name_alternate'        => $obligee->name_alternate ?? '',
      'name_alternate_2'      => $obligee->name_alternate_2 ?? '',
      'phone'                 => $obligee ? $obligee->phone_number() : '',
      'address'               => $obligee->address ?? '',
      'address_2'             => $obligee->address_2 ?? '',
      'city'                  => $obligee->city ?? '',
      'state'                 => $obligee->state ?? '',
      'zip'                   => $obligee->zip ?? '',
    ];
  }

  // SAA MAP
  public static function saa($id)
  {
    $saa = \m_PolicySAA::find($id);

    return [
      'id'                => $saa->id             ?? '',
      'saa_code'          => $saa->saa_code       ?? '',
      'standard_rate'     => $saa->standard_rate  ?? '',
      'year_1_min'        => $saa->year_1_min     ?? '',
      'year_2_min'        => $saa->year_2_min     ?? '',
      'year_3_min'        => $saa->year_3_min     ?? '',
      'year_4_min'        => $saa->year_4_min     ?? '',
      'year_5_min'        => $saa->year_5_min     ?? '',
      'year_6_min'        => $saa->year_6_min     ?? '',
      'year_7_min'        => $saa->year_7_min     ?? '',
      'year_8_min'        => $saa->year_8_min     ?? '',
      'year_9_min'        => $saa->year_9_min     ?? '',
      'year_10_min'       => $saa->year_10_min    ?? '',
      'empty_data_struct' => $saa ? true : false
    ];
  }

  // HISTORY MAP
  public static function history($id)
  {
    $history = \m_PolicyHistory::find($id);
 
    return [
      'is_pinned'           => $history->is_pinned        ?? '',
      'is_claim'            => $history->is_claim         ?? '',
      'log'                 => $history->log              ?? '',
      'resolved_pin'        => $history->resolved_pin     ?? '',
      'user'                => $history->user->email      ?? '',
      'policy'              => $history->policy_id        ?? '',
    ];
  }

  // CMS PAGE MAP
  public static function cmspage($id)
  {
    $page = \m_CmsPage::find($id);
    if($page) {
      $user = \App\User::find($page->user_id);
    } else {
      $user = false;
    }

    return [
      "id"                        => $page->id ?? "",
      "url_slug"                  => $page->url_slug ?? "",
      "title"                     => $page->title ?? "",
      "meta_desc"                 => $page->meta_desc ?? "",
      "is_published"              => $page->is_published ?? "",
      "created_at"                => $page->created_at ?? "",
      "updated_at"                => $page->updated_at ?? "",
      "author"                    => $user ? $user->name_first . " " . $user->name_last : '' 
    ];
  }

  // CMS BLOG POST MAP
  public static function cmsblog($id)
  {
    $blog = \m_CmsBlogPost::find($id);
    if($blog) {
      $user = \App\User::find($blog->user_id);
    } else {
      $user = false;
    }

    return [
      'title'              => $blog->title ?? '',
      'posted_at'          => $blog->posted_at ?? '',
      'is_featured'        => $blog->is_featured ?? '',
      'is_published'       => $blog->is_published ?? '',
      'is_press_release'   => $blog->is_press_release ?? '',
      "author"             => $user ? $user->name_first . " " . $user->name_last : '' 
    ];
  }

  // CMS CATEGORY MAP
  public static function cmscategory($id)
  {
    $category = \m_CmsCategory::find($id);
    return [
      "id"                => $category->id ?? "",
      "type"              => $category->type ?? "",
      "name"              => $category->name ?? "",
      "description"       => $category->description ?? "",
      "slug"              => $category->slug ?? "",
      "url_prefix"        => $category->url_prefix ?? "",
    ];
  }

  // BONDNUMBERS MAP
  public static function bondnumber($id)
  {
    $bondnumber = \m_BondNumbers::find($id);

    return [
      'bond_number'       => $bondnumber->bond_number ?? '',
      'surety_code'       => $bondnumber->surety_code ?? '',
      'date_used'         => $bondnumber->date_used ?? '',
    ];
  }

  // USER MAP
  public static function user($id)
  {
    $user = \App\User::find($id);

    return [
        'id'                => $user->id ?? '',
        'email'             => $user->email ?? '',
        'name_first'        => $user->name_first ?? '',
        'name_last'         => $user->name_last ?? '',
        'name_full'         => $user->name_full ?? '',
        'phone_main'        => $user->phone_main ?? '',
        'address_street'    => $user->address_street ?? '',
        'address_street_2'  => $user->address_street_2 ?? '',
        'address_city'      => $user->address_city ?? '',
        'address_state'     => $user->address_state ?? '',
        'address_zip'       => $user->address_zip ?? '',
        'password_reset'    => $user->password_reset ?? '',
    ];
  }

  // USER MAP
  public static function usergroup($id)
  {
    $usergroup = \m_Usergroups::find($id);

    return [
        'id'                => $usergroup->id ?? "",
        'email'             => $usergroup->email ?? "",
        'name'              => $usergroup->name ?? "",
        'phone_main'        => $usergroup->phone_main ?? "",
        'address_street'    => $usergroup->address_street ?? "",
        'address_street_2'  => $usergroup->address_street_2 ?? "",
        'address_city'      => $usergroup->address_city ?? "",
        'address_state'     => $usergroup->address_state ?? "",
        'address_zip'       => $usergroup->address_zip ?? "",
        'users'             => $usergroup ? $usergroup->users : '',
    ];
  }


  // ERRORS MAP
  public static function errors($arr)
  {
    return [
      'message'           => $arr['errors']['message'] ?? ''
    ];
  }
}
