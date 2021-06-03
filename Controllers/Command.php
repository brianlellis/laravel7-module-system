<?php

namespace Rapyd\System;

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
}