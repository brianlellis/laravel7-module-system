<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class SitemapSettings extends Model
{
    protected $table = 'sitemap_settings';

    protected $guarded = [];

    public $timestamps = false;
}
