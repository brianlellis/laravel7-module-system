<?php

namespace App\Console\Commands\Tests;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Pdf extends Command
{
  protected $signature   = 'rapyd:test:pdf {--action=list} {--use_issue=} {--attorney=}';
  protected $description = 'Testing Harness For PDF Creations';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    if($this->option('action') == 'list') {
      dd(self::list_pdfs());
    } elseif($this->option('action') == 'create') {
      self::create();
    }
  }

  protected function list_pdfs()
  {
    $return_arr = [];
    $app_root   = base_path();

    if ($this->option('attorney') == 'true') {
      $pdf_path   = '/app/Rapyd/System/Blade/Admin/pdf/power-attorney/*.{blade.php}';
      $pdf_prefix = 'power-attorney.';
    } else {
      $pdf_path   = '/app/Rapyd/System/Blade/Admin/pdf/*.{blade.php}';
      $pdf_prefix = '';
    }
    $pdfs = array_map(function ($dir) {
        return basename($dir);
    }, glob($app_root . $pdf_path, GLOB_BRACE));

    foreach ($pdfs as $pdf) {
      if((!$this->option('use_issue') && strpos($pdf, 'issue') !== false)) {
        continue;
      }
      $str          = str_replace('.blade.php', '', $pdf);
      $return_arr[] = $pdf_prefix.$str;
    }
    return $return_arr;
  }

  protected function create() 
  {
    $pdfs         = self::list_pdfs();
    $pdf_count    = count($pdfs);
    $progress_bar = $this->output->createProgressBar($pdf_count);
    $this->info("\nCreating {$pdf_count} known PDFs in system");
    $progress_bar->start();

    foreach ($pdfs as $pdf) {
      if(strrpos($pdf, 'application') !== false) {
        for ($i=0; $i < 2; $i++) { 
          $test_data = [
            'esign'           => $i, //boolean
            'is_agent'        => $i, //boolean
            'is_bill_agent'   => false, //boolean
            'is_installment'  => false, //boolean
            'pdf_title'       => $pdf, //string
            'authnet'         => false, //boolean|arr
            'quotes'          => [], //arr
            'principals'      => ['name_first'=>'Dora','name_last'=>'Carol']  //arr
          ];
          $blade_data  = self::format_data($test_data);
          $created_pdf = \PdfDom::loadView("rapyd_admin::pdf.{$pdf}", $blade_data);
          $created_pdf->setPaper('letter');
          $created_pdf->save(base_path()."/app/Console/Commands/Tests/PDFs/{$i}_{$pdf}.pdf");
        }
      } elseif(strrpos($pdf, 'invoice') !== false) {
        for ($i=0; $i < 2; $i++) { 
          $test_data = [
            'esign'           => false, //boolean
            'is_agent'        => $i, //boolean
            'is_bill_agent'   => false, //boolean
            'is_installment'  => false, //boolean
            'pdf_title'       => $pdf, //string
            'authnet'         => false, //boolean|arr
            'quotes'          => [], //arr
            'principals'      => ['name_first'=>'Dora','name_last'=>'Carol']  //arr
          ];
          $blade_data  = self::format_data($test_data);
          $created_pdf = \PdfDom::loadView("rapyd_admin::pdf.{$pdf}", $blade_data);
          $created_pdf->setPaper('letter');
          $created_pdf->save(base_path()."/app/Console/Commands/Tests/PDFs/{$i}_{$pdf}.pdf");
        }
      } elseif(strrpos($pdf, 'payment-plan') !== false) {
        $test_data = [
          'esign'           => false, //boolean
          'is_agent'        => false, //boolean
          'is_bill_agent'   => false, //boolean
          'is_installment'  => false, //boolean
          'pdf_title'       => $pdf, //string
          'authnet'         => false, //boolean|arr
          'quotes'          => [], //arr
          'principals'      => ['name_first'=>'Dora','name_last'=>'Carol'] //arr
        ];
        $blade_data  = self::format_data($test_data);
        $created_pdf = \PdfDom::loadView("rapyd_admin::pdf.{$pdf}", $blade_data);
        $created_pdf->setPaper('letter');
        $created_pdf->save(base_path()."/app/Console/Commands/Tests/PDFs/{$pdf}.pdf");
      } elseif(strrpos($pdf, 'payment-receipt') !== false) {
        $test_data = [
          'esign'           => false, //boolean
          'is_agent'        => false, //boolean
          'is_bill_agent'   => false, //boolean
          'is_installment'  => false, //boolean
          'pdf_title'       => $pdf, //string
          'authnet'         => false, //boolean|arr
          'quotes'          => [], //arr
          'principals'      => [] //arr
        ];
        $blade_data  = self::format_data($test_data);
        $created_pdf = \PdfDom::loadView("rapyd_admin::pdf.{$pdf}", $blade_data);
        $created_pdf->setPaper('letter');
        $created_pdf->save(base_path()."/app/Console/Commands/Tests/PDFs/{$pdf}.pdf");
      } else {
        // $surety['corp_seal']
        $blade_data  = self::format_data();
        $created_pdf = \PdfDom::loadView("rapyd_admin::pdf.{$pdf}", $blade_data);
        $created_pdf->setPaper('letter');
        $created_pdf->save(base_path()."/app/Console/Commands/Tests/PDFs/{$pdf}.pdf");
      }
      $progress_bar->advance();
    }
    $progress_bar->finish();
  }

  protected static function format_data($test_data = null)
  {
    $cancellation = collect();
    $cancellation->date_cancel = now();
    $cancellation->created_at  = now();
    $cancellation->rider_description = 'THIS IS MY RIDER DESCRIPTION';
    $reinstate    = $cancellation;
    $adjustment   = $cancellation;

    $data = [
      'id'                => 999,
      'ip_address'        => '127.0.0.1',
      'timestamp'         => now(),
      'is_agent'          => $test_data['is_agent'] ?? null,
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
      'is_esign'          => $test_data['esign'] ?? null,
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
        'id'                        => 'test_policy1234',
        'bond_number'               => 'TST45XXX12',
        'date_issue'                => now(),
        'date_effective'            => now(),
        'date_expire'               => now(),
        'date_cancel'               => now(),
        'date_reinstate'            => now(),
        'state_initial'             => 'NC',
        'bond_description'          => 'TestBondDescription',
        'days_left'                 => 99,
        'quotes'                    => $test_data['quotes'] ?? null,
        'address_delivery_street'   => '2199 Test Blvd.',
        'address_delivery_street_2' => 'STE 302',
        'address_delivery_city'     => 'Test City',
        'address_delivery_state'    => 'CA',
        'address_delivery_zip'      => '95993',
        'phone_main'                => '(555) 555 - 4455',
        'rider_description'         => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id nibh a libero tempus laoreet vel sit amet augue. Sed sem leo, condimentum sed blandit id, pharetra sit amet libero. Sed in justo in leo vehicula vulputate. Proin tincidunt velit eu fermentum dapibus. Nulla mollis lacus ac lacus tempus tempus. Ut pellentesque fringilla imperdiet. In nec est sapien. Suspendisse in tempus risus. Maecenas erat nunc, mattis at dolor eleifend, sollicitudin varius sem.'
      ],
      'surety' => [
        'name'              => 'BrianSURETYCO',
        'address_street'    => '504 Canal Dr.',
        'address_street_2'  => 'STE 304',
        'address_city'      => 'Charlotte',
        'address_state'     => 'NC',
        'address_zip'       => '28432',
        'corp_seal'         => null
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
      'principals'        => [$test_data['principals'] ?? null],
      // Accounting
      'accounting'        => [
        'is_bill_agent'       => $test_data['is_bill_agent'] ?? null,
        'is_installment'      => $test_data['is_installment'] ?? null,
        'pay_in_full'         => 999,
        'fee_system'          => 99,
        'fee_surety'          => 99,
        'fee_broker'          => 99,
        'fee_delivery'        => 99,
        'fee_total'           => 99,
        'tax'                 => 99,
        'total_with_fees'     => 198,
        'owed_by_agent'       => 300,
        'commission_agent'    => 25,
        'collect_by_agent'    => 300,
        'compensation_agent'  => 125,
        'collect_at_issue'    => 99,
        'collect_by_system'   => 99,
        'install_down'        => 125,
        'install_months'      => 10,
        'install_monthly'     => 46.67,
        'install_final'       => 43.33,
        'install_monthly_total' => 333,
        'premium_revenue'     => 999.99,
        'commission_agent'    => 25.73,
        'comm_rate_agent'     => 20,
        'payment'             => [
          'payee_name'          => 'Dora Carol',
          'date_paid'           => '5/5/5555',
          'authnet'             => $test_data['authnet'] ?? null,
          'method'              => 'Cash',
          'amount'              => 333.33,
          'balance_original'    => 1099,
          'balance_prior'       => 1099,
          'balance_current'     => 765.67,
        ]
      ],
      // PDF Specific Attributes
      'pdf'               => [
        'title'             => $test_data['pdf_title'] ?? 'TestPDFTITLE',
        'app_date'          => now()->format('m/d/Y')
      ],
      'system'            => \SettingsSite::get(),
      'cancellation'      => $cancellation,
      'reinstate'         => $reinstate,
      'adjustment'        => $adjustment
    ];
    return $data;
  }
}