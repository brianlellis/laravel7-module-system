<?php

namespace App\Rapyd\Modules\System\Commands\Tests;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Rapyd\Model\BondPolicies;

use Illuminate\Database\Eloquent\Builder;

class Accounting extends Command
{

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'rapyd:test:accounting {--scope=basic} {--start=0}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Testing Harness For Zeroing Out and Evaling Accounting';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    if ($this->option('scope') == 'basic') {
      self::parse_policies(); 
    } elseif ($this->option('scope') == 'cancel') {
      self::parse_cancellations();
    } elseif ($this->option('scope') == 'adjust') {
      self::parse_adjustments();
    } elseif ($this->option('scope') == 'reinstate') {
      self::parse_reinstatements();
    }
  }

  public function parse_policies()
  {
    // BASIC POLICIES
    $policies = BondPolicies::setEagerLoads([])
                ->with('invoice')
                ->has('invoice')
                ->doesntHave('cancellation')
                ->doesntHave('adjustment')
                ->doesntHave('reinstatement')
                ->skip((int)$this->option('start'))
                ->take(10000)
                ->get();

    $broke_cnt = 0;
    $pass_cnt  = 0;
    $fail_str  = '';
    $progress_bar = $this->output->createProgressBar($policies->count());
    foreach ($policies as $policy) {
      $record = \PolicyAccountBalances::eval_summary_bal($policy);
      if($record != 0) {
        $broke_cnt++;
        $fail_str .= $policy->id.', ';
      } else {
        $pass_cnt++;
      }

      $progress_bar->clear(); //remove progress bar from display
      $this->info('Last ID: '.$policy->id.' Broke Count: '.$broke_cnt.' FAIL_IDs: ['.$fail_str.']');
      $progress_bar->display();
      $progress_bar->advance();
    }
    $progress_bar->finish();

    $this->info('Could not zero out '.$broke_cnt.' out of '.$policies->count());
  }

  public function parse_cancellations()
  {
    // CANCELLATION POLICIES
    $policies = BondPolicies::setEagerLoads([])
                ->with('invoice')
                ->has('cancellation')
                ->orderBy('id')
                ->get();

    $progress_bar     = $this->output->createProgressBar($policies->count());
    $broke_cnt        = 0;
    $pass_cnt         = 0;
    $fail_str         = '';
    $cancellation_cnt = 0;

    foreach ($policies as $policy) {
      if($policy->latest_policy_action() == 'cancellation') {
        $cancellation_cnt++;

        $record = \PolicyAccountBalances::eval_summary_bal($policy);
        if($record != 0) {
          $broke_cnt++;
          $fail_str .= "{$policy->id}, ";
        } else {
          $pass_cnt++;
        }

        $progress_bar->clear(); //remove progress bar from display
        $this->info('Last ID: '.$policy->id.' Broke Count: '.$broke_cnt.' FAIL_IDs: ['.$fail_str.']');
        $progress_bar->display();
        $progress_bar->advance();
      }
    }

    $progress_bar->finish();
    $this->info('Could not zero out '.$broke_cnt.' out of '.$cancellation_cnt);
  }

  public function parse_adjustments()
  {
    // CANCELLATION POLICIES
    $policies = BondPolicies::setEagerLoads([])
                ->with('invoice')
                ->has('adjustment')
                ->get();

    $broke_cnt = 0;
    $pass_cnt  = 0;
    $fail_str  = '';
    $progress_bar = $this->output->createProgressBar($policies->count());
    foreach ($policies as $policy) {
      $latest_action = $policy->latest_policy_action();

      if($latest_action == 'adjustment') {
        $broke_cnt++;
        $fail_str .= "{$policy->id}, ";
      } else {
        $pass_cnt++;
      }

      $progress_bar->clear(); //remove progress bar from display
      $this->info('Last ID: '.$policy->id.' Broke Count: '.$broke_cnt.' FAIL_IDs: ['.$fail_str.']');
      $progress_bar->display();
      $progress_bar->advance();
    }
    $progress_bar->finish();

    $this->info('Could not zero out '.$broke_cnt.' out of '.$policies->count());
  }

  public function parse_reinstatements()
  {
    // CANCELLATION POLICIES
    $policies = BondPolicies::setEagerLoads([])
                ->with('invoice')
                ->has('reinstatement')
                ->get();

    $broke_cnt = 0;
    $pass_cnt  = 0;
    $fail_str  = '';
    $progress_bar = $this->output->createProgressBar($policies->count());
    foreach ($policies as $policy) {
      $latest_action = $policy->latest_policy_action();
      $adjustment    = $policy->adjustment;
      $reinstatement = $policy->reinstatement; 
      $cancellation  = $policy->cancellation;

      // Use latest adjustment as zero out value
      if ($latest_action == 'adjustment') {
        if($adjustment->accnt_eval_summary_bal() != 0) {
          $broke_cnt++;
          $fail_str .= "{$policy->id}, ";
        } else {
          $pass_cnt++;
        }
      } 
      // Use cancellation info to zero out
      elseif ($latest_action == 'cancellation') {
        if($policy->cancel_calc_accnt_eval_summary_bal() != 0) {
          $broke_cnt++;
          $fail_str .= "{$policy->id}, ";
        } else {
          $pass_cnt++;
        }
      } 
      // Use reinstatement info to zero out
      else {
        if($reinstatement->accnt_eval_summary_bal() != 0) {
          $broke_cnt++;
          $fail_str .= "{$policy->id}, ";
        } else {
          $pass_cnt++;
        }
      }

      $progress_bar->clear(); //remove progress bar from display
      $this->info('Last ID: '.$policy->id.' Broke Count: '.$broke_cnt.' FAIL_IDs: ['.$fail_str.']');
      $progress_bar->display();
      $progress_bar->advance();
    }
    $progress_bar->finish();

    $this->info('Could not zero out '.$broke_cnt.' out of '.$policies->count());
  }
}