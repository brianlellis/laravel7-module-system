<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
  protected $table        = 'settings_site';
  protected $guarded      = [];
  public $timestamps      = false;
}
