<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Rapyd\Model\Redirectors;

class RapydRedirector
{
    public static function get_pages($order_by = 'id')
    {
        $data = Redirectors::orderBy($order_by)->paginate(25);
        return $data;
    }

    public static function check_existing_routes($entering_route) {
      $route = Redirectors::where('entering_route', $entering_route)->first();
      return $route ? $route : false;
    }

    public static function create_route(Request $request)
    {
        if(self::check_existing_routes($request->entering_route)) {
          return back()->with('error','Redirect route already exists');
        } else {
          $route = new Redirectors;

          $route->entering_route  = $request->entering_route;
          $route->target_route    = $request->target_route;
          $route->action          = $request->action;

          $route->save();

          return redirect(request()->getSchemeAndHttpHost().'/admin/redirectors/dashboard')->with('success','Redirect route successfully created');
        }
    }

    public static function update_route(Request $request)
    {
        $route = Redirectors::find($request->route_id);

        $route->entering_route  = $request->entering_route;
        $route->target_route    = $request->target_route;
        $route->action          = $request->action;

        $route->save();

        return back()->with('success','Redirect route successfully updated');
    }

    public static function delete_route($route_id)
    {
      Redirectors::destroy($route_id);
      return back()->with('success','Redirect route successfully removed');
    }
}
