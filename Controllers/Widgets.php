<?php

namespace Rapyd;

use Illuminate\Http\Request;

class Widgets
{
  public static function get_profile_widget($user_id, $snippet_version)
  {
    $user_info = \RapydUser::show($user_id);
    return self::code_snippets($user_info, $snippet_version);
  }

  public static function code_snippets($user, $passed_idx)
  {
    $avatar         = \RapydUser::get_avatar($user->id);
    $host           = request()->getSchemeAndHttpHost();
    $slugOrId       = $user->page_url_slug ?? $user->id;
    $profile        = $host.'/agent/profile/'.$slugOrId;

    $code_snippets = [];
    $files = \File::allFiles(base_path() . '/app/Rapyd/System/Blade/Admin/widgets');
    foreach($files as $file) {
      $name = explode('/', $file);
      $name = str_replace('.blade.php', '', end($name));
      if($name !== 'shareable-wrapper') {
        $code_snippets[] = view("rapyd_admin::widgets.{$name}", [
            'is_ajax'   => true, 
            'user'      => $user, 
            'avatar'    => $avatar, 
            'profile'   => $profile
          ])->render();
      }
    }

    return $code_snippets[$passed_idx];
  }
}
