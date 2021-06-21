<?php

namespace Rapyd;

use App\User;
use Illuminate\Http\Request;
use Rapyd\Model\Events;

class RapydEvents {
  public static function get_all_sys_event_files()
  {
    $app_root = base_path();
    $system_events_arr = [];

    // REQUIRE ALL RAPYD SYSTEM CONTROLLER EVENTS
    $event_files = array_map(function ($dir) {
        return basename($dir);
    }, glob($app_root . '/app/Rapyd/System/Events/*.{php}', GLOB_BRACE));

    foreach ($event_files as $event_file) {
        $system_events_arr[str_replace('.php','',$event_file)] = include($app_root . '/app/Rapyd/System/Events/'.$event_file);
    }

    // For nested events
    $sys_folders = array_map(function ($dir) {
        return basename($dir);
    }, glob($app_root . '/app/Rapyd/System/Events/*', GLOB_ONLYDIR));

    foreach ($sys_folders as $folder) {
        // load event files
        $event_files = array_map(function ($dir) {
            return basename($dir);
        }, glob($app_root . '/app/Rapyd/System/Events/'.$folder.'/events_*.{php}', GLOB_BRACE));

        foreach ($event_files as $event_file) {
          $system_events_arr[str_replace('.php','',$event_file)] = include($app_root . '/app/Rapyd/System/Events/'.$folder.'/'.$event_file);
        }
    }

    // ALLOW THEME TO OVERWRITE
    $theme_event_files = array_map(function ($dir) {
        return basename($dir);
    }, glob($app_root . '/resources/Events/*.{php}', GLOB_BRACE));

    foreach ($theme_event_files as $event_file) {
        $system_events_arr[str_replace('.php','',$event_file)] = include($app_root . '/resources/Events/'.$event_file);
    }

    return $system_events_arr;
  }

  public static function persist_events()
  {
    $system_events_arr = self::get_all_sys_event_files();

    // HACK:: THIS NEEDS TO BE CHANGED TO CHECK ALL MODULE EVENTS
    // $theme_events_arr  = self::get_all_theme_event_files();

    foreach ($system_events_arr as $event_parent => $event_parent_data) {
      foreach ($event_parent_data as $event_name => $event_data) {
        // NOTE: FOR NOW DO NOT LET THIS OVERWRITE IF A SETTINGS CHECK HAS TO OCCUR
        // NOTE: WILL CONSIDER BEHAVIOR FURTHUR IN THE FUTURE
        if (!Events::find($event_name)){
          Events::updateOrCreate(
            ['id' => $event_name],
            [
              'group_label'      => $event_data['group_label'] ?? $event_parent,
              'mail_temp_name'   => $event_data['mail_temp_name'] ?? '',
              'to_email'         => $event_data['to_email'] ?? '',
              'to_name'          => $event_data['to_name'] ?? ''
            ]
          );
        }
      }
    }

    self::purge_old_events($system_events_arr);

    return back()->with('success','All event files in systems scanned');
  }

  /*
   * THIS FUNCTION MAKES SURE TO REMOVE EVENTS FROM SYSTEM IF NOT PRESENT IN ANY
   * FILES ANYMORE
   */
  public static function purge_old_events($system_events_arr)
  {
    // NOTE: I use DB here because eloquent will only return 0 if the id col of the table is varchar
    $all_db_events = \DB::table('rapyd_events')->get();

    foreach ($all_db_events as $db_event) {
      $is_present = false;
      foreach ($system_events_arr as $event_parent => $event_parent_data) {
        foreach ($event_parent_data as $event_name => $event_data) {
          if ($db_event->id === $event_name){
            $is_present = true;
            break;
          }
        }
        if ($is_present) {
          break;
        }
      }

      if (!$is_present) {
        \DB::table('rapyd_events')->where('id',$db_event->id)->delete();
      }
    }
  }

  public static function send_mail($event_id, $passed_data=null) {
    $rapyd_event  = \DB::table('rapyd_events')->where('id',$event_id)->first();

    if ($rapyd_event->mail_temp_name ?? false) {
      \RapydMail::build_system_email_template($rapyd_event,$passed_data);
      if($rapyd_event->mail_temp_to_user_name ?? false) {
        \RapydMail::build_email_template($rapyd_event,$passed_data);
      }
    }
  }

  public static function get_events($event = false)
  {
    if ($event) {
      return Events::find($event);
    }
    // NOTE: I use DB here because eloquent will only return 0 if the id col of the table is varchar
    return \DB::table('rapyd_events')->get();
  }

  public static function get_event_cats()
  {
    return Events::groupBy('group_label')->get();
  }

  public static function update_event(Request $request)
  {
    $data = $request->except('_token','event_id');
    Events::find($request->event_id)->update($data);
    return back()->with('success', 'Event succesfully updated');
  }
}
