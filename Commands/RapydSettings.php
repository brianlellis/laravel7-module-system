<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class RapydSettings extends Command
{
  protected $signature   = 'rapyd:settings:site {--action=none} {--setting=none} {--value=none}';
  protected $description = 'Command to show sitewide settings';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    if ($this->option('action') == 'none') {
      $db_cols = \Schema::getColumnListing('settings_site');
      $db_val = json_decode(json_encode(\DB::table('settings_site')->get($db_cols)),true);
      $this->table($db_cols,$db_val);
    } elseif ($this->option('action') == 'update') {
      self::update();
    }
  }

  protected function update()
  {
    \DB::table('settings_site')
      ->where('id',$this->option('setting'))
      ->update(['value' => $this->option('value')]);
    $this->info("{$this->option('setting')} successfuly updated");
  }
}