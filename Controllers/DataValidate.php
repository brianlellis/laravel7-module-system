<?php

namespace Rapyd\System;

class DataValidate
{
  /**
   * FIND OUT THE SOURCE THREAD OF DATA
   * EVAL IF USABLE BASED ON TRUTHY
   * 
   * STILL ALLOW REFERENCE TO THE VARIABLE
   * 
   * ON MANUAL USAGE DON'T ALLOW FALSY VARIABLE
   * 
   * CONSIDER JUST SHOWING VARIABLE IN RED WHEN 
   * MANUAL TEMPLATE SHOWN FOR ONE OFF USAGE
  **/
  protected static function null_or_empty($value)
  {
    if (is_null($value) || $value == '' || $value == false) {
      return false;
    }
    return true;
  } 

  protected static function eval_object($object)
  {
    $return_arr = [];

    // Get schema of table to determine all possible
    // loop through schema and check 
    // $schema->$prop = self::null_or_empty($schema->$prop ?? false)
  } 
}