<?php

namespace App\Rapyd\Modules\System\Commands\Tests;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Email extends Command
{
  protected $signature   = 'rapyd:test:email {--action=list}';
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
      self::send_system_email();
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

  protected function send_system_email() 
  {
    $is_contact_form  = false;
    $has_attachment   = false;
    $mailers          = self::theme_emails();
    $blade_data       = self::format_data();
    $mailer_count     = count($mailers);
    $progress_bar     = $this->output->createProgressBar($mailer_count);
    $this->info("\nSending test emails for {$mailer_count} email templates");
    $progress_bar->start();
    foreach ($mailers as $record) {
      // Required to avoid code 550 too many emails per second
      sleep(2);

      $blade_data['event_mail_subject'] = "Test for {$record[0]} {$record[1]}";
      \RapydMail::build_system_email_template(
        $record[0], 
        $record[1], 
        $blade_data, 
        $is_contact_form, 
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

  protected static function format_data($test_data=null)
  {
    $data = [
      'id'                => 999,
      'ip_address'        => '127.0.0.1',
      'timestamp'         => now(),
      'is_agent'          => $test_data['is_agent'] ?? false,
      'name'              => 'Test User',
      'name_first'        => 'John',
      'name_last'         => 'Doe',
      'group_name'        => 'TestCo',
      'id'                => 1,
      'address_street'    => '2199 Test Blvd',
      'address_street_2'  => '',
      'address_city'      => 'Test City',
      'address_state'     => 'CA',
      'address_zip'       => '95993',
      'phone_main'        => '(555) 555 - 5555',
      'phone'             => '(555) 555 - 4455',
      'hash_key'          => '#asddfssdfDoe',
      'email'             => 'johndoe@test.com',
      'bond_quotes'       => false,
      'href'              => 'http://nothing.test',
      'application_name'  => 'Application Name',
      'is_esign'          => $test_data['esign'] ?? false,
      'message'           => 'Content for message',
      'subject'           => 'Content for subject',
      'bond_id'           => 1,
      'agent'             => [
        'id'                => 999,
        'name_first'        => 'Jane',
        'name_last'         => 'Smith',
        'name_full'         => 'Jane Smith',
        'address_full'      => '2199 Test Blvd. Test City, CA 95933',
        'address_street'    => '2199 Test Blvd.',
        'address_street_2'  => 'STE 302',
        'address_city'      => 'Test City',
        'address_state'     => 'CA',
        'address_zip'       => '95993',
        'phone_main'        => '(555) 555 - 4455',
        'email'             => 'janesmith@test.com',
      ],
      'agency'            => [
        'name'              => 'TestAgency',
        'address_full'      => '2199 Test Blvd. Test City, CA 95933',
        'address_street'    => '2199 Test Blvd.',
        'address_street_2'  => 'STE 302',
        'address_city'      => 'Test City',
        'address_state'     => 'CA',
        'address_zip'       => '95993',
        'phone_main'        => '(555) 555 - 4455',
        'license'           => 'TEST_LICENSE',
        'email'             => 'janesmith@test.com'
      ],
      'obligee'            => [
        'name'              => 'TestObligee',
        'address_full'      => '2199 Test Blvd. Test City, CA 95933',
        'address_street'    => '2199 Test Blvd.',
        'address_street_2'  => 'STE 302',
        'address_city'      => 'Test City',
        'address_state'     => 'CA',
        'address_zip'       => '95993',
        'phone_main'        => '(555) 555 - 4455',
      ],
      'policy'            => [
        'id'                => 'test_policy1234',
        'bond_number'       => 'TST45XXX12',
        'date_issue'        => '9/99/9999',
        'date_effective'    => '8/88/8888',
        'date_expire'       => '7/77/7777',
        'state_initial'     => 'NC',
        'bond_description'  => 'TestBondDescription',
        'days_left'         => 99,
        'quotes'            => $test_data['quotes'] ?? [],
        'address_delivery_street'   => '2199 Test Blvd.',
        'address_delivery_street_2' => 'STE 302',
        'address_delivery_city'     => 'Test City',
        'address_delivery_state'    => 'CA',
        'address_delivery_zip'      => '95993'
      ],
      'business'          => [
        'id'                => 999,
        'name'              => 'TestBusiness',
        'entity'            => 'Sole Proprietorship',
        'address_full'      => '2199 Test Blvd. Test City, CA 95933',
        'address_street'    => '2199 Test Blvd.',
        'address_street_2'  => 'STE 302',
        'address_city'      => 'Test City',
        'address_state'     => 'CA',
        'address_zip'       => '95993',
        'phone_main'        => '(555) 555 - 4455',
        'email'             => 'janesmith@test.com',
      ],
      'bond'              => [
        'description'       => 'TestBondDescription',
        'limit'             => 5000,
        'state_initial'     => 'NC',
        'state_full'        => 'North Carolina',
      ],
      'surety'            => [
        'name'              => 'TestSuretyCo'
      ],
      'principals'        => [$test_data['principals'] ?? []],
      // Accounting
      'accounting'        => [
        'is_bill_agent'     => $test_data['is_bill_agent'] ?? false,
        'is_installment'    => $test_data['is_installment'] ?? false,
        'pay_in_full'       => 999,
        'fee_total'         => 99,
        'total_with_fees'   => 198,
        'commission_agent'  => 25,
        'install_down'      => 125,
        'install_months'    => 10,
        'install_monthly'   => 46.67,
        'install_final'     => 43.33,
        'payment'           => [
          'payee_name'        => 'Dora Carol',
          'date_paid'         => '5/5/5555',
          'authnet'           => $test_data['authnet'] ?? false,
          'method'            => 'Cash',
          'amount'            => 333.33,
          'balance_original'  => 1099,
          'balance_prior'     => 1099,
          'balance_current'   => 765.67,
        ]

      ],
      // PDF Specific Attributes
      'pdf'               => [
        'title'             => $test_data['pdf_title'] ?? false,
        'app_date'          => now()->format('m/d/Y')
      ],
      'authnet_response'  => 'AUTHNET ERROR REPSONSE TEST',
      'experian_response' => 'EXPERIAN ERROR RESPONSE TEST',
      'surety_code'       => 'HAN',
      'quote_issues'      => 'QUOTE ISSUES HERE'
    ];
    return $data;
  }
}