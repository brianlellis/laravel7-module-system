<?php

namespace Rapyd\Model;

use Illuminate\Database\Eloquent\Model;

class ModelViews extends Model {
  protected $connection = 'service_users';
  protected $table      = 'model_views';
  protected $guarded    = [];
  public $timestamps    = false;

  public static function get_top_viewed($model,$limit = 10)
  {
    $records  = self::where('model',$model)
                  ->orderBy('view_count','DESC')
                  ->limit($limit)->get();

    $data_arr = [];
    foreach ($records as $record) {
      $data_arr[] = $model::find($record->model_id);
    }
    return $data_arr;
  }
}