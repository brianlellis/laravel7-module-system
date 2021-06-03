<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
  protected $table = 'rapyd_events';
  protected $guarded = [];
  public $timestamps = false;
}
