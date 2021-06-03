<?php

namespace Rapyd\Scaffold;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class PublicScaffold
{
  public static function getBladeData($passed_route = false)
  {
    // Creates an array of route paths after .com/admin_pub/
    // Ex. ['dashboard','settings']
    $url = $passed_route ? $passed_route : url()->current();

    $url_arr = explode("/", $url);
    if (!$passed_route) {
      $url_arr = array_slice($url_arr, 3);
    }

    // Get page id value to apply to the body of HTML
    $page_id = '';
    foreach ($url_arr as $idx => $label) {
      if ($idx === 0) {
        $page_id .= $label;
      } else {
        $page_id .= '_' . $label;
      }
    }

    // Get the Page Title for the Head tag in HTML and the blade template path
    foreach ($url_arr as $key => $value) {
      // BUILD PAGE TITLE FROM URL
      $temp_title = explode("-", $value);
      foreach ($temp_title as $key_inner => $val_inner) {
        if ($key_inner === 0) {
          $page_title = ucfirst($val_inner);
        } else {
          $page_title .= ' '.ucfirst($val_inner);
        }
      }

      // BUILD DIRECTORY LOOKUP FROM URL
      if ($key === 0) {
        $theme_val  = $value;
      } else {
        $theme_val  .= ".{$value}";
      }
    }

    $page_id   = $page_id !== '' ? $page_id : 'home';
    $fe_assets = self::getStaticAssets($page_id);

    return array(
      'url_path'    => join("/",$url_arr),
      'page_title'  => $page_title ?? 'Homepage',
      'page_id'     => $page_id,
      'blade_val'   => $theme_val ?? 'home',
      'data_params' => self::getUrlParams(),
      'js_asset'    => $fe_assets[1],
      'css_asset'   => $fe_assets[0]
    );
  }

  protected static function getUrlParams()
  {
    $url_params   = explode('&', str_replace('?', '', strstr(url()->full(), '?')));

    if ($url_params[0] === "") {
      $data_params = null;
    } else {
      $data_params = [];
      foreach ($url_params as $param) {
        $param = explode('=', $param);
        $data_params[$param[0]] = $param[1];
      }
    }

    return $data_params;
  }

  // Currently all sass is rendered to style css for the admin/public side
  protected static function getStaticAssets($page_id)
  {
    $asset_dir    = "/resources/public/css/page/{$page_id}";
    $asset_dir2   = "/resources/public/js/page/{$page_id}";
    $mix_manifest = json_decode(file_get_contents(base_path().'/public/mix-manifest.json'));
    $css_asset    = property_exists($mix_manifest, "{$asset_dir}.css") ? "{$asset_dir}.css" : false;
    $js_asset     = property_exists($mix_manifest, "{$asset_dir2}.js") ? "{$asset_dir2}.js" : false;

    return array(
      $css_asset,
      $js_asset
    );
  }

  public static function renderCompileJS($path, $id)
  {
    $asset_dir = '/public/resources/public/js/';
    // CHECK FOR FILE EXISTENCE FIRST
    if (File::exists(base_path().$asset_dir.$path.$id)) {
      $file_data = File::get(base_path().$asset_dir.$path.$id);
    }

    if (isset($file_data)) {
      if (Cache::has('pagescript_'.$id)) {
        $stylesheet = cache('pagescript_'.$id);

        $cur_time   = filemtime(base_path().$asset_dir.$path);
        $cache_time = cache('pagescript_mtime_'.$id);

        // IF FILE IS NEWER THAN CACHED OBJECT REPLACE CACHE
        if ($cur_time > $cache_time) {
          \Cache::forget('pagescript_'.$id);
          \Cache::forget('pagescript_mtime_'.$id);

          $stylesheet = '<script>' . $file_data . '</script>';
          \Cache::forever('pagescript_'.$id, $stylesheet);

          $cur_time   = filemtime(base_path().$asset_dir.$path);
          \Cache::forever('pagescript_mtime_'.$id, $cur_time);
        }
      } else {

        $stylesheet = '<script>' . $file_data . '</script>';
        \Cache::forever('pagescript_'.$id, $stylesheet);

        $cur_time   = filemtime(base_path().$asset_dir.$path);
        \Cache::forever('pagescript_mtime_'.$id, $cur_time);
      }

      return $stylesheet;
    }
  }

  public static function renderCompileCss($path, $id)
  {
    $asset_dir = '/public/resources/public/css/';
    // CHECK FOR FILE EXISTENCE FIRST
    if (File::exists(base_path().$asset_dir.$path.$id)) {
      $file_data = File::get(base_path().$asset_dir.$path.$id);
    }

    if (isset($file_data)) {
      if (Cache::has('pagestyle_'.$id)) {
        $stylesheet = cache('pagestyle_'.$id);

        $cur_time   = filemtime(base_path().$asset_dir.$path);
        $cache_time = cache('pagestyle_mtime_'.$id);

        // IF FILE IS NEWER THAN CACHED OBJECT REPLACE CACHE
        if ($cur_time > $cache_time) {
          \Cache::forget('pagestyle_'.$id);
          \Cache::forget('pagestyle_mtime_'.$id);

          $stylesheet = '<style>' . File::get(base_path().$asset_dir.$path) . '</style>';
          \Cache::forever('pagestyle_'.$id, $stylesheet);

          $cur_time   = filemtime(base_path().$asset_dir.$path);
          \Cache::forever('pagestyle_mtime_'.$id, $cur_time);
        }
      } else {
        $stylesheet = '<style>' . File::get(base_path().$asset_dir.$path) . '</style>';
        \Cache::forever('pagestyle_'.$id, $stylesheet);

        $cur_time   = filemtime(base_path().$asset_dir.$path);
        \Cache::forever('pagestyle_mtime_'.$id, $cur_time);
      }

      return $stylesheet;
    }
  }
}
