<?php

namespace Rapyd\Scaffold;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class AdminScaffold
{
  public static function getBladeData()
  {
    // Creates an array of route paths after .com/admin_pub/
    // Ex. ['dashboard','settings']
    $url_arr    = explode("/", url()->current());
    $url_arr    = array_slice($url_arr, 4);

    // Get page id value to apply to the body of HTML
    $page_id    = '';
    $page_title = '';
    $theme_val  = '';
    // Get the Page Title for the Head tag in HTML and the blade template path
    foreach ($url_arr as $key => $value) {
      $page_id    .= $key === 0 ? $value : "_{$value}";
      $theme_val  .= $key === 0 ? $value : ".{$value}";
      $page_title .= $key === 0 ? $value : ' '.$value;
    }
    // Ensure any hyphens are aught in $page_title
    $page_title = ucwords(str_replace("-", " ", $page_title));

    $fe_assets = self::getStaticAssets($page_id);
    return array(
      'page_title'  => $page_title ?? 'Homepage',
      'page_id'     => $page_id ?? 'homepage',
      'blade_val'   => $theme_val ?? null,
      'js_asset'    => $fe_assets[1],
      'css_asset'   => $fe_assets[0]
    );
  }

  /*
   * TODO
   * THIS STILL NEEDS A LOT OF WORK!
   * SHOULD ONLY COME BACK FALSE AT THE MOMENT
   * REASON BEING IS THE ASSETS WILL NEED TO BE PULLED
   * FOR PRESENT MODULES NOT THE ACTUAL PAGE
   */
  protected static function getStaticAssets($page_id)
  {
    $mix_manifest = json_decode(file_get_contents(base_path().'/public/mix-manifest.json'));
    $css_asset    = property_exists($mix_manifest, "/admin_pub/module/{$page_id}.css") ? "page/{$page_id}.css" : false;
    $js_asset     = property_exists($mix_manifest, "/admin_pub/module/{$page_id}.js") ? "page/{$page_id}.js" : false;

    return array(
      $css_asset,
      $js_asset
    );
  }

  public static function renderCompileJS($path, $id)
  {
    $asset_dir  = '/public/admin_resources/admin/js/';
    $asset_dir2 = '/public/resources/admin/js/';
    // CHECK FOR FILE EXISTENCE FIRST
    if (File::exists(base_path().$asset_dir.$path.$id)) {
      $file_data = File::get(base_path().$asset_dir.$path.$id);
    } elseif (File::exists(base_path().$asset_dir2.$path.$id)) {
      $asset_dir = $asset_dir2;
      $file_data = File::get(base_path().$asset_dir.$path.$id);
    }

    if (isset($file_data)) {
      if (Cache::has('pagescript_'.$id)) {
        $stylesheet = cache('pagescript_'.$id);

        $cur_time   = filemtime(base_path().'/public/admin_pub/'.$path);
        $cache_time = cache('pagescript_mtime_'.$id);

        // IF FILE IS NEWER THAN CACHED OBJECT REPLACE CACHE
        if ($cur_time > $cache_time) {
          \Cache::forget('pagescript_'.$id);
          \Cache::forget('pagescript_mtime_'.$id);

          $stylesheet = '<script>' . File::get(base_path().'/public/admin_pub/'.$path) . '</script>';
          \Cache::forever('pagescript_'.$id, $stylesheet);

          $cur_time   = filemtime(base_path().'/public/admin_pub/'.$path);
          \Cache::forever('pagescript_mtime_'.$id, $cur_time);
        }
      } else {
        $stylesheet = '<script>' . File::get(base_path().'/public/admin_pub/'.$path) . '</script>';
        \Cache::forever('pagescript_'.$id, $stylesheet);

        $cur_time   = filemtime(base_path().'/public/admin_pub/'.$path);
        \Cache::forever('pagescript_mtime_'.$id, $cur_time);
      }

      return $stylesheet;
    }
  }

  public static function renderCompileCss($path, $id)
  {
    $asset_dir  = '/public/admin_resources/admin/css/';
    $asset_dir2 = '/public/resources/admin/css/';
    // CHECK FOR FILE EXISTENCE FIRST
    if (File::exists(base_path().$asset_dir.$path.$id)) {
      $file_data = File::get(base_path().$asset_dir.$path.$id);
    } elseif (File::exists(base_path().$asset_dir2.$path.$id)) {
      $asset_dir = $asset_dir2;
      $file_data = File::get(base_path().$asset_dir.$path.$id);
    }

    if (isset($file_data)) {
      if (Cache::has('pagestyle_'.$id)) {
        $stylesheet = cache('pagestyle_'.$id);

        $cur_time   = filemtime(base_path().'/public/admin_pub/'.$path);
        $cache_time = cache('pagestyle_mtime_'.$id);

        // IF FILE IS NEWER THAN CACHED OBJECT REPLACE CACHE
        if ($cur_time > $cache_time) {
          \Cache::forget('pagestyle_'.$id);
          \Cache::forget('pagestyle_mtime_'.$id);

          $stylesheet = '<style>' . File::get(base_path().'/public/admin_pub/'.$path) . '</style>';
          \Cache::forever('pagestyle_'.$id, $stylesheet);

          $cur_time   = filemtime(base_path().'/public/admin_pub/'.$path);
          \Cache::forever('pagestyle_mtime_'.$id, $cur_time);
        }
      } else {
        $stylesheet = '<style>' . File::get(base_path().'/public/admin_pub/'.$path) . '</style>';
        \Cache::forever('pagestyle_'.$id, $stylesheet);

        $cur_time   = filemtime(base_path().'/public/admin_pub/'.$path);
        \Cache::forever('pagestyle_mtime_'.$id, $cur_time);
      }

      return $stylesheet;
    }
  }
}
