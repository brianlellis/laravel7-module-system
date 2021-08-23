<?php

namespace App\Rapyd\Modules\System\Commands\Tests;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Console\Command;
use Rapyd\RapydEventEmailModel;
class Email extends Command
{
  protected $signature   = 'rapyd:test:email {--action=list} {--event=}';
  protected $description = 'Testing Harness For Email Sending Events';
  protected static $exempt_mails = [
    'parent' => ['generic-application']
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    if($this->option('action') == 'list') {
      self::list_mail_events();
    } elseif($this->option('action') == 'templates') {
      $templates = self::theme_emails(true);
      $this->table(['Parent','Template'],$templates);
    } elseif($this->option('action') == 'send') {
      self::send_system_email($this->option(('event')));
    }
  }

  protected function list_mail_events()
  {
    // Cant use eloquent as id is not an integer
    $events = \RapydEvents::get_events();
    $db_cols = [
      'id',
      'mail_temp_name',
      'group_label'
    ];
    $db_val = json_decode(json_encode(\DB::table('rapyd_events')->get($db_cols)),true);
    $this->table($db_cols,$db_val);
  }

  protected function send_system_email($event_name = null)
  {
    $has_attachment = false;
    $events_query = \DB::table('rapyd_events')
                        ->where('mail_temp_name', '!=', '')
                        ->whereNotNull('mail_temp_name');

    if ($event_name) {
      $events_query->where('id', $event_name);
    }
    $events = $events_query->get();
    $blade_data       = self::format_data();
    $event_count     = count($events);
    $progress_bar     = $this->output->createProgressBar($event_count);
    $this->info("\nSending test emails for {$event_count} email templates");
    $progress_bar->start();
    foreach ($events as $event) {
      // Required to avoid code 550 too many emails per second
      sleep(2);
      $this->info(" Event ID:" . $event->id);
      $this->info(" Template:" . $event->mail_temp_name);
      $event->to_email = 'test@test.com';
      // $blade_data['event_mail_subject'] = "Test for event {$event->id}";
      \RapydMail::build_system_email_template(
        $event,
        $blade_data,
        $has_attachment
      );

      $progress_bar->advance();
    }
    $progress_bar->finish();
  }

  protected function theme_emails($return_all = false)
  {
    $return_arr = [];
    $app_root   = base_path();
    $theme_mail_parents = array_map(function ($dir) {
      return basename($dir);
    }, glob($app_root . '/resources/Mailer/templates/*', GLOB_ONLYDIR));

    foreach ($theme_mail_parents as $parent) {
      $theme_mail_templates = array_map(function ($dir) {
          return basename($dir);
      }, glob($app_root . '/resources/Mailer/templates/'.$parent.'/*.{php}', GLOB_BRACE));

      foreach ($theme_mail_templates as $template) {
        $template = str_replace('.blade.php', '', $template);
        if (
          $return_all ||
          !isset(self::$exempt_mails[$parent]) ||
          (
            isset(self::$exempt_mails[$parent])  &&
            !in_array($template, self::$exempt_mails[$parent])
          )
        ) {
          $return_arr[] = [$parent,$template];
        }
      }
    }
    return $return_arr;
  }

  protected static function format_data()
  {
    $faker = Factory::create();
    
    $event_models = RapydEventEmailModel::sanitized_models();

    $a = \BondPolicyHelper::model_data_email_pdf(
      false,
      false,
      [],
      1
    );

    $mappedArr = array_merge($a, $event_models);

    foreach($mappedArr as $key => $value) {
      if(!is_array($value)) {
        $mappedArr[$key] = $faker->word;
      } else {
        foreach($value as $arrKey => $val) {
          if(!is_array($val)) {
            $mappedArr[$key][$arrKey] = $faker->word;
          }
        }
      }
    }

    return $mappedArr;
  }
}
