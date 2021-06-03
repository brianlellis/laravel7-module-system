<?php

namespace App\Console\Commands\Tests;

use Carbon\Carbon;
use Illuminate\Console\Command;

class IssuePdf extends Command
{
  protected $signature   = 'rapyd:test:issuepdf';
  protected $description = 'Testing Harness For PDF Creations';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    \PolicyPdfHelper::issue_policy_pdf(197417,false,'NC-030');
  }
}