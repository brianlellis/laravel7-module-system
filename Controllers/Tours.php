<?php

namespace Rapyd;

class Tours
{
  public static function first_visit()
  { 
    $first_visit = \m_UserPageVisits::where('user_id',\Auth::user()->id)
                      ->where('page',request()->path())->first();

    if(!$first_visit) {
      \m_UserPageVisits::insert([
        'user_id' => \Auth::user()->id,
        'page'    => request()->path()
      ]);
      return true;
    }
    return false;
  }
}