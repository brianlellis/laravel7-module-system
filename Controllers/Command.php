<?php

namespace Rapyd\System;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Illuminate\Console\Application as Artisan;

class Command {
  private static $text_colors = [
    'black'         => '0;30',
    'dark_gray'     => '1;30',
    'blue'          => '0;34',
    'light_blue'    => '1;34',
    'green'         => '0;32',
    'light_green'   => '1;32',
    'cyan'          => '0;36',
    'light_cyan'    => '1;36',
    'red'           => '0;31',
    'light_red'     => '1;31',
    'purple'        => '0;35',
    'light_purple'  => '1;35',
    'brown'         => '0;33',
    'yellow'        => '1;33',
    'light_gray'    => '0;37',
    'white'         => '1;37'
  ];
  private static $bg_colors = [
    'black'       => '40',
    'red'         => '41',
    'green'       => '42',
    'yellow'      => '43',
    'blue'        => '44',
    'magenta'     => '45',
    'cyan'        => '46',
    'light_gray'  => '47'
  ];

  public static function output($string, $fore_color = null, $bg_color = null) {
    $colored_string = "";

    if (isset(self::$text_colors[$fore_color])) {
      $colored_string .= "\033[" . self::$text_colors[$fore_color] . "m";
    }
    if (isset(self::$bg_colors[$bg_color])) {
      $colored_string .= "\033[" . self::$bg_colors[$bg_color] . "m";
    }

    $colored_string .= "\n{$string}\033[0m";
    echo $colored_string;
  }

  public static function aggregate_module_commands()
  {
    $path = base_path() . '/app/Rapyd/Modules/';
    $module_folders = array_map(function ($dir) {
      return basename($dir);
    }, glob($path.'*', GLOB_ONLYDIR));

    foreach($module_folders as $folder) {
      if (\File::isDirectory($path.$folder.'/Commands')) {
        self::custom_load($path.$folder.'/Commands', $folder);
      }
    }
  }

  protected static function custom_load($paths,$module)
  {
    $paths = array_unique(Arr::wrap($paths));
    $paths = array_filter($paths, function ($path) { return is_dir($path); });
    if (empty($paths)) { return; }

    $namespace = 'App\\';

    foreach ((new Finder)->in($paths)->files() as $command) {
      $command = $namespace.str_replace(
        ['/', '.php'],
        ['\\', ''],
        Str::after($command->getPathname(), realpath(app_path()).DIRECTORY_SEPARATOR)
      );

      if (
        $is_subclass = is_subclass_of($command, \Illuminate\Console\Command::class) &&
        ! (new \ReflectionClass($command))->isAbstract()
      ) {
        Artisan::starting(function ($artisan) use ($command) {
            $artisan->resolve($command);
        });
      }
    }
  }
}