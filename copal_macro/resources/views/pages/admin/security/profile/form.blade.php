<form profile="form" action="{{asset($path)}}" method="post" onsubmit="select(this); return true">
  @if(isset($profile))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!-- -->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('profile.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('profile.name')}}" name="name" type="text" autofocus maxlength="100" min="3" required="true" value="{{isset($profile) ? $profile->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    @include('sections.list.pick', [
      'label' => trans('profile.roles'),
      'name'  => 'roles',
      'data'  => $roles,
      'selected' => isset($profile) ? getIds($profile->roles()) : Input::get('roles')
    ])
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($profile)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
