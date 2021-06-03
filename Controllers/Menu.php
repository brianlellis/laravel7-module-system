<?php

namespace Rapyd\Core;

use Illuminate\Http\Request;

class Menu
{
  public static function save(REQUEST $request)
  {
    $menu_data = array_values(json_decode($request->menu_data, true));

    foreach ($menu_data as $value) {
      if(isset($value['title']) || isset($value['url'])) {
        if (!isset($value['id'])) {
          \DB::table('menu_items')->insert($value);
        } else {
          \DB::table('menu_items')->where('id',$value['id'])->update($value);
        }
      } elseif (isset($value['remove_id'])) {
        \DB::table('menu_items')->where('id',$value['remove_id'])->delete();
      }
    }

    \Cache::forget('admin_menu');
  }
}
