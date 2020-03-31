<form role="form" action="{{asset($path)}}" method="post" onsubmit="createLoad(this); select(this); return true">
  @if(isset($role))
    <input type="hidden" name="_method" value="patch">
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
    @include('sections.list.pick', [
      'label' => trans('role.access'),
      'name'  => 'access',
      'data'  => $access,
      'selected' => isset($role) ? getIds($role->access()) : Input::get('access')
    ])
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($role)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
