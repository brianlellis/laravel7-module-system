<?php

namespace App\Rapyd\Modules\System\Commands;

use Illuminate\Console\Command;
use Validator;

/**
 *  CONTINUED READING FOR STRATEGIES IN CROSS OS STABILITY
 * https://github.com/symfony/process/blob/509ba166ae24c2227227c8ad54a3916bbd137422/Process.php#L1108
**/

class RapydTheme extends Command
{
  protected $signature    = 'rapyd:theme:install';
  protected $description  = 'Installs and/or configure Rapyd modules';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Check if directory exists or make one
    $DS   = DIRECTORY_SEPARATOR;
    $dir  = base_path().$DS.'resources';
    if (!\File::isDirectory($dir)) {
      \File::deleteDirectory($dir);
    }
    
    $config_data = [
      'suretypedia',
      'bondexchange',
      'jet'
    ];
    foreach ($config_data as $idx => $theme) {
      $this->line("[{$idx}] {$theme}");
    }

    $module_install_quest = self::prompt_question(
      'Which theme do you want to install?',
      'theme_number',
      ['required','integer','between:0,2']
    );

    $theme = $config_data[$module_install_quest];
    $url   = "git@github.com:jep-capital-devs/rapyd-theme-{$theme}.git";
    $this->info("\nFetching Theme: {$theme}\n");

    $git  = new \CzProject\GitPhp\Git;
    $repo = $git->cloneRepository($url, $dir);
  }

  protected function prompt_question($question, $field, $rules)
  {
    $value = $this->ask($question);
    if ($message = $this->validate_prompt($rules, $field, $value)) {
      $this->error($message);
      return $this->prompt_question($question, $field, $rules);
    }
    return intval($value);
  }

  protected function validate_prompt($rules, $fieldName, $value)
  {
    $validator = Validator::make(
      [$fieldName => $value],
      [$fieldName => $rules]
    );
    return $validator->fails() ? $validator->errors()->first($fieldName) : null;
  }
}
