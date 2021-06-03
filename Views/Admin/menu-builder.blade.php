@php
  $menu_top_levels = DB::table('menus')->get();
  $menu_parents   = DB::table('menu_items')->whereNull('parent_id')->get()->all();
@endphp

<script>
  var menu_builder_json = {};
</script>

<div class="panel-group">
  <div class="panel panel-default mt-2">
    <div class="row">
      {{-- Parents --}}
      <div class="col-md-2">
        <div class="form-group">
          <label for="parent_id">Parent</label>
          <select class="form-control" id="add_new_menu_item_parent">
            <option value=""></option>
            @foreach ($menu_parents as $item)
                <option value="{{$item->menu_id}}-{{$item->id}}">{{ $item->title }}</option>
            @endforeach
          </select>
        </div>
      </div>
      {{-- Title --}}
      <div class="col-md-3">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="add_new_menu_item_title">
        </div>
      </div>
      {{-- Url --}}
      <div class="col-md-3">
        <div class="form-group">
          <label for="url">Url</label>
          <input type="text" class="form-control" id="add_new_menu_item_url">
        </div>
      </div>
      <div class="col-md-2 form-group">
        <label></label>
        <button class="btn btn-primary form-control mt-1" id="add_new_menu_item">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div id="menu_builder_wrap">
    @foreach ($menu_top_levels as $top_level)
      <div class="panel-group" id="accordion-{{$top_level->id}}" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default mt-2">
          <div class="panel-heading" id="heading-{{preg_replace('/\s+/','',$top_level->name)}}">
            <h4 class="panel-title">
              <a 
                class="collapsed" role="button" data-toggle="collapse" 
                data-parent="#accordion" 
                href="#collapse-{{preg_replace('/\s+/','',$top_level->name)}}" 
                aria-expanded="false" 
                aria-controls="collapse-{{preg_replace('/\s+/','',$top_level->name)}}"
                data-dbmenuid="{{$top_level->id}}"
                data-dbmenuparent=0
                data-dbmenuismenu=1
              >
                Menu Name: <strong>{{$top_level->name}}</strong>
              </a>
              <script>
                menu_builder_json['{{$top_level->name}}'] = {};
              </script>
            </h4>
          </div>

          <div 
            id="collapse-{{preg_replace('/\s+/','',$top_level->name)}}" 
            class="panel-collapse collapse toplevel-menu" 
            role="tabpanel" 
            aria-labelledby="heading-{{preg_replace('/\s+/','',$top_level->name)}}"
          >
            <div class="panel-body top-sortable">
              @php
                $parent_idx = 0;
                $menu_parents = DB::table('menu_items')->where('menu_id', $top_level->id)->where('parent_id',NULL)->orderBy('order')->get();
              @endphp

              @foreach ($menu_parents as $parent)
                <script>
                  menu_builder_json[{{$parent->id}}] = {
                    id: {{$parent->id}},
                    order: {{$parent->order}},
                    title: '{{$parent->title}}',
                    url: '{{$parent->url}}',
                    parent_id: null
                  };
                </script>

                @php
                  $menu_items = DB::table('menu_items')->where('parent_id', $parent->id)->orderBy('order')->get();
                @endphp

                <div class="panel panel-default mt-2">
                  <div class="panel-heading" id="heading-{{preg_replace('/\s+/','',$parent->title)}}">
                    <h4 class="panel-title">
                      <div 
                        class="list-group-item collapsed parent-menu @if(count($menu_items)) has-children @endif" 
                        role="button" data-toggle="collapse" 
                        data-parent="#accordion-{{$top_level->id}}" 
                        href="#collapse-{{preg_replace('/\s+/','',$parent->title)}}" 
                        aria-expanded="false" 
                        aria-controls="collapse-{{preg_replace('/\s+/','',$parent->title)}}"
                        data-dbmenuid="{{$parent->id}}"
                        data-dbmenuparent=0
                        data-dbmenuismenu=0
                        data-dbmenuorder={{$parent_idx}}
                      >
                        Menu Parent Name: 
                        {{-- <input class="menu-builder-input name" value="{{$parent->title}}" /> --}}
                        <strong>{{$parent->title}}</strong>
                      </div>
                    </h4>
                  </div>

                  @if(count($menu_items))
                    @php
                      $children_idx = 0;
                    @endphp
                    <div 
                      id="collapse-{{preg_replace('/\s+/','',$parent->title)}}" 
                      class="panel-collapse collapse children-menu" 
                      role="tabpanel" 
                      aria-labelledby="heading-{{preg_replace('/\s+/','',$parent->title)}}"
                    >
                      <div class="panel-body nested-sortable">
                        @foreach ($menu_items as $item)
                          <script>
                            menu_builder_json[{{$item->id}}] = {
                              id: {{$item->id}},
                              order: {{$item->order}},
                              title: '{{$item->title}}',
                              url: '{{$item->url}}',
                              parent_id: {{$item->parent_id}}
                            };
                          </script>
                          <div 
                            class="list-group-item"
                            data-dbmenuid="{{$item->id}}"
                            data-dbmenuparent="{{$parent->id}}"
                            data-dbmenuismenu=0
                            data-dbmenuorder={{$children_idx}}
                          >
                            Name: 
                            <input class="menu-builder-input name" value="{{$item->title}}" />
                            Url: 
                            <input class="menu-builder-input url" value="{{$item->url}}" />

                            <div class="remove_child_menu_item btn btn-sm btn-danger" data-menu_id={{$item->id}}>
                              Remove Item
                            </div>
                          </div>

                          @php
                            $children_idx++;
                          @endphp
                        @endforeach
                      </div>
                    </div>
                  @endif
                </div>
                @php
                  $parent_idx++;
                @endphp
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- SUBMIT BUTTON --}}
  <div class="form-group mt-6">
    <button class="btn btn-success" id="send_menu_to_db">Save Menu Info</button>
  </div>
</div>

@section('page_bottom_scripts')
  <script>
    var topSortables = [].slice.call(document.querySelectorAll('.top-sortable')),
        nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));

    // Loop through each top and nested sortable element
    for (var i = 0; i < topSortables.length; i++) {
        new Sortable(topSortables[i], {
            // group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function (/**Event*/ evt) {
              $('.toplevel-menu').each(function(idx) {
                $(this).find('.parent-menu').each(function(idx2) {
                  var parent_menu_id = parseInt($(this).data('dbmenuid'));
                  menu_builder_json[parent_menu_id]['order'] = idx2;

                  $(this).parent().parent().next().find('.list-group-item').each(function(idx3) {
                    var child_menu_id = parseInt($(this).data('dbmenuid'));
                    menu_builder_json[child_menu_id]['order'] = idx3;
                  });
                });
              });   
            }
        });
    }

    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            // group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function (/**Event*/ evt) {
              $('.toplevel-menu').each(function(idx) {
                $(this).find('.parent-menu').each(function(idx2) {
                  var parent_menu_id = parseInt($(this).data('dbmenuid'));
                  menu_builder_json[parent_menu_id]['order'] = idx2;
                  //$(this).data('dbmenuorder', idx2);

                  $(this).parent().parent().next().find('.list-group-item').each(function(idx3) {
                    var child_menu_id = parseInt($(this).data('dbmenuid'));
                    menu_builder_json[child_menu_id]['order'] = idx3;
                    //$(this).data('dbmenuorder', idx3);
                  });
                });
              });
            }
        });
    }

    // Remove menu item
    $('.remove_child_menu_item').click(function() {
      menu_builder_json[$(this).data('menu_id')] = {
        remove_id: $(this).data('menu_id')
      };

      $(this).parent().remove();
    });

    // Add new menu item 
    $('#add_new_menu_item').click(function() {
      var parent_val = $('#add_new_menu_item_parent').val().split('-');
          parent_id  = parseInt(parent_val[1]),
          menu_id    = parseInt(parent_val[0]),
          menu_title = $('#add_new_menu_item_title').val(),
          menu_url   = $('#add_new_menu_item_url').val();

      menu_builder_json[menu_title] = {
        menu_id: menu_id,
        order: 9999,
        title: menu_title,
        url:   menu_url,
        parent_id: parent_id
      };

      $('#add_new_menu_item_parent').val('');
      $('#add_new_menu_item_title').val('');
      $('#add_new_menu_item_url').val('');

      // DOM ADDITION
      var dom_ele = `
        <div 
          class="list-group-item"
          data-dbmenuid="${menu_title}"
          data-dbmenuparent="${parent_id}"
          data-dbmenuismenu=0
          data-dbmenuorder=9999
        >
          Name: 
          <input class="menu-builder-input name" value="${menu_title}" />
          Url: 
          <input class="menu-builder-input url" value="${menu_url}" />

          <div class="remove_child_menu_item btn btn-sm btn-danger" data-menu_id=${menu_title}>
            Remove Item
          </div>
        </div>
      `;

      $(`.parent-menu[data-dbmenuid=${parent_id}]`).parent().parent().next().find('.nested-sortable').append(dom_ele);
    });

    // Menu input changes
    $('.menu-builder-input').change(function() {
      var menu_id = $(this).parent().data('dbmenuid');

      if ($(this).hasClass('name')) {
        menu_builder_json[menu_id]['title'] = $(this).val();
      } else if ($(this).hasClass('url')) {
        menu_builder_json[menu_id]['url']   = $(this).val();
      }
    });

    // PERSIST TO DB
    $('#send_menu_to_db').click(function() {
      let form_data = new FormData();

      fetch("/api/ajaxview/gettoken")
        .then(response => response.text())
        .then(token_data => {
          form_data.append("menu_data", JSON.stringify(menu_builder_json));

          fetch("/api/systemMenu/save", {
              method: "post",
              headers: {
                "X-CSRF-TOKEN": token_data
              },
              body: form_data
            })
            .then(response => response.text())
            .then(menu_data => {
              window.location.reload();
            });
        });
    }); 
  </script>
@endsection
