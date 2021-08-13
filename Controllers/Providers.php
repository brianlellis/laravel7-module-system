<?php

namespace Rapyd\System;

class Providers 
{
  public static function aggregate_module_providers(&$sys_providers_config)
  {
    $app_root = base_path();

    // Consider removal based on if psr-4 autoload mechanism is reimplemented
    $module_folders = array_map(function ($dir) {
      return basename($dir);
    }, glob($app_root . '/app/Rapyd/Modules/*', GLOB_ONLYDIR));

    foreach ($module_folders as $folder) {
      $filepath = $app_root. '/app/Rapyd/Modules/'.$folder.'/ServiceProvider.php';
      if (file_exists($filepath)) {
        // https://stackoverflow.com/questions/7131295/dynamic-class-names-in-php
        // https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class
        include $filepath;
        $class_str      = '\\Rapyd\\'.$folder.'ServiceProvider';
        $sys_providers_config[] = $class_str;
      }
    }
  }

  public static function aggregate_module_aliases(&$sys_aliases_config)
  {
    $app_root = base_path();

    $module_folders = array_map(function ($dir) {
      return basename($dir);
    }, glob($app_root . '/app/Rapyd/Modules/*', GLOB_ONLYDIR));

    foreach ($module_folders as $folder) {
      $filepath = $app_root. '/app/Rapyd/Modules/'.$folder.'/app_alias.php';
      if (file_exists($filepath)) {
        $temp_arr = include($filepath);
        if (is_array($temp_arr)) {
          $sys_aliases_config = array_merge($sys_aliases_config, $temp_arr);
        }
      }
    }
  }
}