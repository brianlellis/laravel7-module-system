<?php

namespace Rapyd;

class Tours
{
  public static function first_visit()
  { 
    $first_visit = \DB::table('user_page_visits')
                    ->where('user_id',\Auth::user()->id)->where('page',request()->path())->first();

    if(!$first_visit) {
      \DB::table('user_page_visits')->insert([
        'user_id' => \Auth::user()->id,
        'page'    => request()->path()
      ]);
      return true;
    }
    return false;
  }
}