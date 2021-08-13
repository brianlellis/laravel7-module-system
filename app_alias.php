<?php

return [
  //---------- CONTROLLERS
  'AdminScaffold'       => Rapyd\Scaffold\AdminScaffold::class,
  'Excel'               => Maatwebsite\Excel\Facades\Excel::class,
  'FullText'            => Rapyd\FullText::class,
  'LegacyDataMigrator'  => Rapyd\LegacyDataMigrator::class,
  'PublicScaffold'      => Rapyd\Scaffold\PublicScaffold::class,
  'RapydCommand'        => Rapyd\System\Command::class,
  'RapydCore'           => Rapyd\Core::class,
  'RapydEvents'         => Rapyd\RapydEvents::class,
  'RapydRedirector'     => Rapyd\RapydRedirector::class,
  'RapydWidgets'        => Rapyd\Widgets::class,
  'RapydDatabase'       => Rapyd\System\Database::class,
  'SettingsSite'        => Rapyd\SettingsSite::class,
  'ui_AdminDashboard'   => Rapyd\UI\AdminDashboards::class,

  //---------- MODELS
  'm_ModelViews'        => Rapyd\Model\ModelViews::class,
  'm_RapydEvents'       => Rapyd\Model\Events::class
];