<?php

use Illuminate\Http\Request;

class AjaxView
{
  public function renderView(Request $request)
  {
    return view($request->view_path, ['view_data' => (array)json_decode($request->view_data)]);
  }

  public function getViewToken()
  {
    return csrf_token();
  }
}
