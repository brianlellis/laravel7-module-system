<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class ModelViews extends Model {
  protected $connection = 'service_users';
  protected $table      = 'model_views';
  protected $guarded    = [];
  public $timestamps    = false;

  public static function get_top_viewed($model,$limit = 10, $app=false)
  {
    $records  = self::where('model',$model)
                  ->orderBy('view_count','DESC')
                  ->limit($limit * 3)->get();

    $data_arr = [];
    foreach ($records as $record) {
      $value = $model::find($record->model_id);

      if ($app == 'suretypedia') {
        if (
          $value->obligee->name != 'No Obligee' &&
          $value->obligee->name != 'Generic Obligee'
        ) {
          $data_arr[] = $value;
        }
      } else {
        $data_arr[] = $value;
      }
      if (count($data_arr) == $limit) {
        break;
      }
    }
    return $data_arr;
  }
}