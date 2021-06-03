<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class Redirectors extends Model
{
    protected $table = 'redirectors';

    protected $guarded = [];

    public $timestamps = false;
}
