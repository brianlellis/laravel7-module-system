@php
  $event_cats = RapydEvents::get_event_cats();
  $events     = RapydEvents::get_events();
  $templates  = \m_RapydMailTemplates::select('*')->get();
@endphp

<h3 style="text-align: center">
  Developers Do Not Forget to Pass User ID or User Model as 2nd Param<br />
  <strong>Example: RapydEvents::send_mail('event_id', 1);</strong>
</h3>

<a style="margin-bottom: 20px;" class="btn btn-primary" href="{{route('rapyd.events.persist.files')}}">Check All Event Files</a>

@foreach ($event_cats as $category)
  <div class="card">
    <div class="card-header">
        <h3 class="card-title">{{$category->group_label}}</h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-down"></i></a>
        </div>
    </div>

    <div class="card-body">
      @dashboard_table('event_id , Sys_Email_Template,To_User_Template, Sys_To_Email(S), Actions,')
        @foreach($events as $event)
          @if($event->group_label === $category->group_label)
            <tr>
              <form method="POST" action="{{route('rapyd.events.update')}}">
                <input name="event_id" value="{{$event->id}}" type="hidden">
                @csrf
                <td style="width: 20%">{{$event->id}}</td>
                <td style="width: 20%">
                  <select class="form-control" name="mail_temp_name">
                    <option value>Select Email Template</option>
                    @foreach($templates as $design)
                      <option 
                        value="{{$design->name}}"
                        @if($design->name == $event->mail_temp_name)
                          selected
                        @endif
                      >
                        {{$design->name}}
                      </option>
                    @endforeach
                  </select>
                </td>
                <td style="width: 20%">
                  <select class="form-control" name="mail_temp_to_user_name">
                    <option value>Select Email Template</option>
                    @foreach($templates as $design)
                      <option 
                        value="{{$design->name}}"
                        @if($design->name == $event->mail_temp_to_user_name)
                          selected
                        @endif
                      >
                        {{$design->name}}
                      </option>
                    @endforeach
                  </select>
                </td>
                <td style="width: 35%"><input class="form-control" name="to_email" value="{{$event->to_email}}"></td>
                <td style="width: 5%"><button type="submit" class="btn-primary btn btn-sm">Update</button></td>
              </form>
            </tr>
          @endif
        @endforeach
      @end_dashboard_table
    </div>
  </div>
@endforeach
