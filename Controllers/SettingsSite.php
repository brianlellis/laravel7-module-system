<?php

namespace Rapyd;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Rapyd\Model\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsSite
{

  public function colors(REQUEST $request)
  {
    $data      = $request->all();
    $file_path = base_path() . '/public/admin_pub/dashboard/css/style.css';
    $contents  = file_get_contents($file_path);

    foreach ($request->all() as $key => $color) {
      if ($key !== '_token' && strpos($key, 'Original') === false && $color !== null) {
        $orig_color = $data["{$key}Original"];
        $contents = str_replace($orig_color, $color, $contents);
      }
    }

    file_put_contents($file_path, $contents);
    return back()->with('success', 'Color change successful');
  }

  public function store_site_settings(Request $request)
  {
    $data = $request->except('_token');

    $setting_keys = \DB::table('settings_site')->pluck('value','id')->toArray();
    foreach ($setting_keys as $key => $value) {
      // Check for images or persist old one if present
      if (
        isset($data[$key]) && 
        (
          $key === 'sitewide_favicon'     || $key === 'sitewide_logo_large' || 
          $key === 'sitewide_logo_small'  || $key === 'default_user_avatar' || 
          $key === 'pdf_site_signature'   || $key === 'pdf_witness_1_signature_file' ||
          $key === 'pdf_witness_2_signature_file' || $key === 'pdf_notary_signature_image' ||
          $key === 'pdf_notary_seal_image'        || $key === 'sitewide_producer_agreement'
        )
      ) {
        $data[$key] = self::store_file($request->file($key));
      } elseif(isset($data['old_'.$key])) {
        $data[$key] = $data['old_'.$key];
      } elseif ($key === 'ecommerce_sandbox_mode') {
        if ($data[$key] === 'on') {
          $data[$key] = 1;
        } else {
          $data[$key] = 0;
        }
      }

      if ($key ==='system_policy_default_agent') {
        $default_group  = \App\User::find($data[$key]);

        $setting        = Settings::find('system_policy_default_agent');
        $setting->value = $data[$key] ?? null;
        $setting->save();

        $setting_two        = Settings::find('system_policy_default_usergroup');
        $setting_two->value = $default_group ? $default_group->agency()->id : null;
        $setting_two->save();
      } elseif ($key !== 'system_policy_default_usergroup') {
        $setting = Settings::find($key);
        $setting->value = $data[$key] ?? null;
        $setting->save();
      }
    }

    return back()->with(['success' => 'Site Settings Updated']);
  }

  public function clearView()
  {
    Artisan::call('view:clear');
    Log::info('php artisan view:clear was called from the admin panel');
    return back()->with('success', 'View cache was successfully cleared');
  }

  public function clearData()
  {
    Artisan::call('cache:clear');
    Log::info('php artisan cache:clear was called from the admin panel');
    return back()->with('success', 'Data (DB) cache was successfully cleared');
  }

  public function store_file($file)
  {
    $file->move(public_path('images/site'), $file->getClientOriginalName());
    return 'images/site/' . $file->getClientOriginalName();
  }

  // Static Functions
  public static function get($setting = false)
  {
    // NOTE: I use DB here because eloquent will only return 0 if the id col of the table is varchar
    if ($setting) {
      return \DB::table('settings_site')->find($setting)->value;
    }
    return \DB::table('settings_site')->pluck('value', 'id')->toArray();
  }
}
