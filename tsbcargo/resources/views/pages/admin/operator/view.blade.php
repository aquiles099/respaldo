@include('sections.translate')
<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form onsubmit="submitFormOperator()" role="form" action="" method="post" id="formSerial">
      @if(isset($operator))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'username'])">
          <label class="col-lg-3 control-label">{{trans('messages.user')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.user')}}" name="username" type="text" autofocus maxlength="15" min="5" required="true" value="{{isset($operator) ? $operator->username : Input::get('username')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'username'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('operator.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('operator.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($operator) ? $operator->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'lastname'])">
          <label class="col-lg-3 control-label">{{trans('messages.last_name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.last_name')}}" name="lastname" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($operator) ? $operator->lastname : Input::get('lastname')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'lastname'])
          </div>
        </div>
        <!-- -->
        <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
          <label class="col-lg-3 control-label">{{trans('user.email')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.email')}}" name="email" type="email" maxlength="50" min="5" required="true" value="{{isset($operator) ? $operator->email : Input::get('email')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'email'])
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
        <div class="form-group row @include('errors.field-class', ['field' => 'profile'])">
          <label class="col-lg-3 control-label">{{trans('operator.profile')}}</label>
          <div class="col-lg-9">
            @if(!isset($readonly) || $readonly == false)
              <select style="width:100%;" class="form-control" placeholder="{{trans('operator.profile')}}" id="profile" name="profile" required="true" @include('form.readonly')>
                <option value="">{{trans('operator.profile')}}</option>
                @foreach ($profiles as $profile)
                  <option value="{{$profile->id}}" @if((isset($operator) ? $operator->profile : Input::get('profile')) == $profile->id) selected="true"@endif>{{$profile->name}}</option>
                @endforeach
              </select>
            @else
              <input class="form-control" type="text" name="profile" value="{{isset($operator) ? $operator->getProfile->name : ''}}" @include('form.readonly')>
            @endif
            @include('errors.field', ['field' => 'profile'])
          </div>
        </div>
    </form>
  </div>
</div>
