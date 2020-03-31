<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="" id ="formSerial">
      @if(isset($user))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('user.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'last_name'])">
          <label class="col-lg-3 control-label">{{trans('messages.last_name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.last_name')}}" name="last_name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->last_name : Input::get('last_name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'last_name'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
          <label class="col-lg-3 control-label">{{trans('messages.dni')}} <span class = "badge" data-toggle="tooltip" data-placement="top" title="{{trans('messages.indentToolTipText')}}"> ? </span></label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.dni')}}" name="dni" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->dni : Input::get('dni')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'dni'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'local_phone'])">
          <label class="col-lg-3 control-label">{{trans('messages.local_phone')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.local_phone')}}" name="local_phone" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->local_phone : Input::get('local_phone')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'local_phone'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'celular'])">
          <label class="col-lg-3 control-label">{{trans('messages.celular')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.celular')}}" name="celular" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->celular : Input::get('celular')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'celular'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
          <label class="col-lg-3 control-label">{{trans('user.password')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.password')}}" name="password" type="password" maxlength="25" min="5" @include('form.readonly')>
            @include('errors.field', ['field' => 'password'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
          <label class="col-lg-3 control-label">{{trans('user.repassword')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.repassword')}}" name="password_confirmation" type="password" maxlength="25" min="5" @include('form.readonly')>
            @include('errors.field', ['field' => 'password'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
          <label class="col-lg-3 control-label">{{trans('user.email')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.email')}}" name="email" type="email" maxlength="50" min="5" required="true" value="{{isset($user) ? $user->email : Input::get('email')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'email'])
          </div>
        </div>
        {{--id de la compañia--}}
      </fieldset>
    </form>
  </div>
</div>
