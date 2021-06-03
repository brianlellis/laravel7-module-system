<?php

Route::name('rapyd.system.')->prefix('/api/system/')->group(function() {
  Route::post('contact/submit', '\Rapyd\Core@send_contact_form')->name('contact.submit');
  Route::post('agent/review',   '\Rapyd\Core@send_contact_agent')->name('agent.contact');
});

// AJAXING THE VIEW RENDERER
Route::prefix('/api/ajaxview/')->group(function() {
  Route::post('render',   '\AjaxView@renderView');
  Route::get('gettoken',  '\AjaxView@getViewToken');
});

// REDIRECTORS
Route::name('sys.redirectors.')->prefix('/api/redirectors/')
->middleware(['auth','verified','permission:sys-admin-redirectors'])->group(function () {
  Route::post('create',           '\RapydRedirector@create_route')->name('create');
  Route::post('update',           '\RapydRedirector@update_route')->name('update');
  Route::get('delete/{route_id}', '\RapydRedirector@delete_route')->name('delete');
});

// SITEMAP
Route::prefix('/api/core-sitemap/')
->middleware(['auth','verified','permission:sys-admin-site-settings'])->group(function () {
  Route::get('build',             '\RapydSitemap@createSitemap');
  Route::resource('setting/save', '\RapydSitemap');
});

// MENU SAVE
Route::post('/api/systemMenu/save', '\Rapyd\Core\Menu@save');

// EVENTS
Route::post('/api/system/event/theme', '\Rapyd\RapydEvents@eval_theme_event')->name('system.events.theme');
Route::post('/api/system/event/update', '\Rapyd\RapydEvents@update_event')->name('rapyd.events.update');
Route::get('/api/system/event/persist/files', '\Rapyd\RapydEvents@persist_events')->name('rapyd.events.persist.files');

// SITE SETTINGS
Route::name('rapyd.settings.')->prefix('/api/')
->middleware(['auth','verified','permission:sys-admin-site-settings'])->group(function () {
  //Route::post('admin/settings/colors',  '\Rapyd\AdminSettings@colors')->name('admin.colors');
  Route::post('settings/site/update',   '\Rapyd\SettingsSite@store_site_settings')->name('site.update');
  Route::get('admin/clear-view',        '\Rapyd\SettingsSite@clearView')->name('site.clear.view');
  Route::get('admin/clear-data',        '\Rapyd\SettingsSite@clearData')->name('site.clear.data');
});

// EXTERNAL API CONSUMPTION
Route::group(['middleware' => 'client_credentials'], function() {
  Route::post('/external-api/policy/store-policy-quote', "\BondPolicyHelper@store_policy_and_quote");
  Route::get('/external-api/policy/quote/fetch/{policy_id}', '\PolicyPricingHelper@fetch_policy_quotes');
  // Route::get('logout', 'AuthController@logout');
  // Route::get('user', 'AuthController@user');
});

// WIDGETS
Route::get('/api/rapyd/social/widgets/{user_id}/{version}', '\RapydWidgets@get_profile_widget');