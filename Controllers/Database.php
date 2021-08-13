<?php

namespace Rapyd\System;

class Database 
{
  public static function aggregate_module_connections(&$sys_db_config)
  {
    $app_root = base_path();

    // COLLECT MODULES USING DaaS (Database as a Service)
    $module_folders = array_map(function ($dir) {
      return basename($dir);
    }, glob($app_root . '/app/Rapyd/Modules/*', GLOB_ONLYDIR));

    foreach ($module_folders as $folder) {
      $filepath = $app_root. '/app/Rapyd/Modules/'.$folder.'/db_service.php';
      if (file_exists($filepath)) {
        $db_service = include($filepath);

        if (isset($db_service['is_active'])) {
          if ($db_service['is_active']) {
            $sys_db_config['connections'][$db_service['db_label']] = $db_service['details'];
          }
        } elseif (isset($db_service[0])) {
          foreach ($db_service as $service) {
            if ($service['is_active']) {
              $sys_db_config['connections'][$service['db_label']] = $service['details'];
            }
          }
        }
      }
    }
  }
}