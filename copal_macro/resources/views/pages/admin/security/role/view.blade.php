<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="post" onsubmit="select(this); return true" id="formSerial">
      @if(isset($role))
          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('role.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('role.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($role) ? $role->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
      <!-- -->
        @include('sections.list.pick', [
          'label'    => trans('role.access'),
          'name'     => 'access',
          'data'     => $access,
          'selected' => isset($role) ? getIds($role->access()) : Input::get('access')
        ])
      </fieldset>
    </form>
  </div>
</div>
