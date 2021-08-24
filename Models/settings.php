<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  protected $table        = 'settings_site';
  protected $guarded      = [];
  public $timestamps      = false;

  public static function excluded_bonds() {
    $return_arr = [
      'forms'  => []
      'states' => [],
      'types'  => []
    ];

    foreach (explode(',', $this->site_bond_exclude_forms) as $value) {
      $return_arr['forms'][]  = $value;
    }
    foreach (explode(',', $this->site_bond_exclude_states) as $value) {
      $return_arr['states'][] = $value;
    }
    foreach (explode(',', $this->site_bond_exclude_type) as $value) {
      $return_arr['types'][]  = $value;
    }

    return $return_arr;
  }
}
