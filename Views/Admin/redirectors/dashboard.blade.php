@php
  if($search_term = Request::get('search')) {
    $search = new \Swis\Laravel\Fulltext\Search();
    $data = $search->runForClass($search_term, \Rapyd\Model\Redirectors::class);
    $paginate_links = '';
  } else {
    $data = \RapydRedirector::get_pages();
    $paginate_links = $data->render();
  }
@endphp

@can('sys-admin-redirectors')
  @dashboard_table_header('
    Redirect,
    /admin/redirectors/create,
    redirectors
  ')

  @dashboard_table('Entering, Target, Type,Action,'{!! $paginate_links !!})
    @foreach($data as $route)
      @if ($search_term)
        @php
          $route = $route->indexable;
        @endphp
      @endif
      <tr>
        <form method="POST" action="{{route('sys.redirectors.update')}}">
          @csrf
          <input type="hidden" name="route_id" value="{{$route->id}}" />
          <td style="width:40%"><input style="width: 90%" name="entering_route" value="{{ $route->entering_route }}"></td>
          <td style="width:40%"><input style="width: 90%" name="target_route" value="{{ $route->target_route }}"></td>
          <td style="width:10%">
            <select name='action'>
              <option value="301" @if($route->action == '301') selected @endif>301</option>
              <option value="302" @if($route->action == '302') selected @endif>302</option>
            </select>
          </td>
          <td style="width:10%">
            <button class="btn btn-sm btn-primrary">Update</button>
            <a href="@url('/api/redirectors/delete/'){{$route->id}}" title="History" class="btn btn-sm btn-danger">Remove</a>
          </td>
        </form>
      </tr>
    @endforeach
  @end_dashboard_table({!! $paginate_links !!})
@endcan
