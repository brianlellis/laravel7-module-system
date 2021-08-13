<?php

namespace App\Rapyd\Modules\System\Commands;

use Illuminate\Console\Command;
use Validator;

/**
 *  CONTINUED READING FOR STRATEGIES IN CROSS OS STABILITY
 * https://github.com/symfony/process/blob/509ba166ae24c2227227c8ad54a3916bbd137422/Process.php#L1108
**/

class RapydModule extends Command
{
  protected $signature    = 'rapyd:module {mod_mode=install}';
  protected $description  = 'Installs and/or configure Rapyd modules';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    if ($this->argument('mod_mode') === 'install') {
      // Check if directory exists or make one
      $dir = base_path().'/app/Rapyd/Modules';
      if (!\File::isDirectory($dir)) {
        \File::makeDirectory($dir, 0755, true);
      }
      self::cd_to_module_base();
    } else {
      $this->error(' Argument passed not valid for rapyd:module ');
    }
  }

  /**
   * COMMAND ARGUMENT MODES
   */
  protected function eval_install_mode()
  {
    $config_data   = self::parse_rapyd_config();
    $mod_reinstall = $this->confirm('Reinstall all modules?');

    if ($mod_reinstall) {
      $progress_bar = $this->output->createProgressBar(count($config_data));
      $progress_bar->start();

      foreach ($config_data as $module_install) {
        self::git_clone_or_pull_branch($module_install, $progress_bar);
      }
      $progress_bar->finish();
    } else {
      self::output_module_list($config_data);

      $module_install_quest = self::prompt_question(
        'Which module do you want to reinstall?',
        'module_number',
        ['required','integer','between:0,'.array_key_last($config_data)]
      );

      self::git_clone_or_pull_branch($config_data[$module_install_quest]);
    }
  }

  /**
   * Artisan Ask Validation Behaviors
   */
  protected function prompt_question($question, $field, $rules)
  {
    $value = $this->ask($question);
    if ($message = $this->validate_prompt($rules, $field, $value)) {
      $this->error($message);
      return $this->prompt_question($question, $field, $rules);
    }
    return $value;
  }


  protected function validate_prompt($rules, $fieldName, $value)
  {
    $validator = Validator::make(
      [$fieldName => $value],
      [$fieldName => $rules]
    );
    return $validator->fails() ? $validator->errors()->first($fieldName) : null;
  }

  /**
   * RAPYD MODULE BEHAVIORS
   */

  // Parse the rapyd config file
  protected function parse_rapyd_config()
  {
    $file_data  = array();
    $lines      = file(base_path()."/resources/rapyd.config");

    // Loop through our array of file lines
    foreach ($lines as $line_num => $line) {
      // Skip lines starting with # as those are comments
      if (substr($line, 0, 1) != '#') {
        $line         = explode(' ', $line);
        $mod_name     = preg_replace('/\s/', '', $line[0]);
        $mod_branch   = array_key_exists(1, $line) ? 
                          preg_replace('/\s/', '', $line[1]) : 
                          'master';
        $file_data[]  = [$mod_name, $mod_branch];
      }
    }
    return $file_data;
  }

  // Output an array selector of all available modules
  protected function output_module_list($config_data)
  {
    foreach ($config_data as $idx => $module_install) {
      $this->line("[{$idx}] {$vendor_name}/{$module_name}");
    }
  }

  protected function cd_to_module_base()
  {
    $DS       = DIRECTORY_SEPARATOR;
    $path     = base_path() . "{$DS}app{$DS}Rapyd{$DS}Modules";
    $process  = new \Symfony\Component\Process\Process(['dir']);
    $process  = $process->setWorkingDirectory($path);
    $process->run(self::eval_install_mode());
  }

  protected function eval_module_present($mod_name)
  {
    $DS       = DIRECTORY_SEPARATOR;
    $path     = base_path() . "{$DS}app{$DS}Rapyd{$DS}Modules{$DS}{$mod_name}";
    return \File::isDirectory($path) ? true : false;
  }

  protected function git_clone_or_pull_branch($mod_info = false, $progress_bar = false)
  {
    $DS   = DIRECTORY_SEPARATOR;
    $git  = new \CzProject\GitPhp\Git;
    $url  = "git@github.com:jep-capital-devs/rapyd-module-".$mod_info[0].".git";
    $path = base_path() . "{$DS}app{$DS}Rapyd{$DS}Modules{$DS}{$mod_info[0]}";

    if (self::eval_module_present($mod_info[0])) {
      $this->info(" Updating Module: ".$mod_info[0]."\n");
      $repo = $git->open($path);
    } else {
      $this->info(" Fetching Module: ".$mod_info[0]."\n");
      $repo = $git->cloneRepository($url, $path);
    }

    $repo->checkout($mod_info[1]);
    $repo->pull('origin',[$mod_info[1]]);
    $progress_bar->advance();
  }
}
