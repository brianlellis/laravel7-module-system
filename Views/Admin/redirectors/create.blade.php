@can('sys-admin-redirectors')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{route('sys.redirectors.create')}}">
        @csrf

        <div class="row">
          <div class="col-md-4">
            <input class="form-control" name="entering_route" placeholder='Entering Route' required>
          </div>
          <div class="col-md-4">
            <input class="form-control" name="target_route" placeholder='Target Route' required>
          </div>
          <div class="col-md-4">
            <select class="form-control" name='action'>
              <option value="301" selected>301</option>
              <option value="302">302</option>
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-top: 20px">
          <a href="/admin/redirectors/dashboard" class="btn btn-danger" type="submit">Cancel</a>
          <button class="btn btn-success">Create</button>
        </div>
      </form>
    </div>
  </div>
@endcan
