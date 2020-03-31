<form onsubmit="createLoad()" role="form" action="{{asset($path)}}" method="post">
  @if(isset($user))
    <input type="hidden" name="_method" value="patch">
  @endif
  <fieldset class="form">
    <!--name-->
    <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
      <label class="col-lg-3 control-label">{{trans('user.name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('user.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->name : Input::get('name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'name'])
      </div>
    </div>
    <!--apellidos-->
    <div class="form-group row @include('errors.field-class', ['field' => 'last_name'])">
      <label class="col-lg-3 control-label">{{trans('messages.last_name')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.last_name')}}" name="last_name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->last_name : Input::get('last_name')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'last_name'])
      </div>
    </div>
    <!--dni-->
    <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
      <label class="col-lg-3 control-label">{{trans('messages.dni')}} <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="{{strtoupper(trans('messages.indentToolTipText'))}}"></i></span></label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.dni')}}" name="dni" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->dni : Input::get('dni')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'dni'])
      </div>
    </div>
    <!--sex-->
    <div class="form-group row @include('errors.field-class', ['field' => 'sex'])">
      <label class="col-lg-3 control-label">{{trans('messages.sex')}}</label>
      <div class="col-lg-9">
        @if(!isset($readonly) || $readonly == false)
        <select class="form-control" name="sex" type="text"  required="true" id="ics_select_sex" @include('form.readonly')>
          <option>{{trans('messages.optionSelect')}}</option>
          @foreach($sex_user as $key => $value)
            <option {{isset($user) && $user->sex == $value['id'] ? 'selected' : Input::get('sex') }} value="{{$value['id']}}">{{$value['text']}}</option>
          @endforeach
        </select>
        @else
        <input class="form-control" placeholder="{{trans('messages.sex')}}" name="sex" type="text" value="@if(isset($user) && $user->sex == 'm') {{trans('messages.male')}} @elseif($user->sex == 'f') {{trans('messages.female')}} @else {{trans('prealert.unknown')}} @endif" @include('form.readonly')>
        @endif
        @include('errors.field', ['field' => 'sex'])
     </div>
    </div>
    <!--local_phone-->
    <div class="form-group row @include('errors.field-class', ['field' => 'local_phone'])">
      <label class="col-lg-3 control-label">{{trans('messages.local_phone')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.local_phone')}}" name="local_phone" type="text" autofocus maxlength="100" min="5" value="{{isset($user) ? $user->local_phone : Input::get('local_phone')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'local_phone'])
      </div>
    </div>
    <!--celular-->
    <div class="form-group row @include('errors.field-class', ['field' => 'celular'])">
      <label class="col-lg-3 control-label">{{trans('messages.celular')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.celular')}}" name="celular" type="text" autofocus maxlength="100" min="5" value="{{isset($user) ? $user->celular : Input::get('celular')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'celular'])
      </div>
    </div>
    <!--country-->
    <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
      <label class="col-lg-3 control-label">{{trans('messages.country')}}</label>
      <div class="col-lg-9">
        @if(!isset($readonly) || $readonly == false)
        <select class="form-control" name="country" placeholder="{{trans('messages.country')}}" required="true"  id="ics_select_country_register">
          <option>{{trans('messages.optionSelect')}}</option>
          @if(isset($countrys))
            @foreach($countrys as $country)
              <option {{isset($user) && $user->country == $country ? 'selected' : Input::get('country') }} value="{{$country}}">{{$country}}</option>
            @endforeach
          @endif
        </select>
        @else
        <input class="form-control" placeholder="{{trans('messages.country')}}" name="country" type="text" value="{{isset($user) ? $user->country : Input::get('country')}}"  required="true" @include('form.readonly')>
        @endif
        @include('errors.field', ['field' => 'country'])
      </div>
    </div>
    <!--region-->
    <div class="form-group row @include('errors.field-class', ['field' => 'region'])">
      <label class="col-lg-3 control-label">{{trans('messages.region')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.region')}}" name="region" type="text" value="{{isset($user) ? $user->region : Input::get('region')}}"  @include('form.readonly')>
        @include('errors.field', ['field' => 'region'])
      </div>
    </div>
    <!--address-->
    <div class="form-group row @include('errors.field-class', ['field' => 'address'])">
      <label class="col-lg-3 control-label">{{trans('messages.address')}}</label>
      <div class="col-lg-9">
        <textarea class="form-control" name="address" id="address" placeholder="{{trans('messages.address')}}"  @include('form.readonly')>{{isset($user) ? $user->address : Input::get('address')}}</textarea>
        @include('errors.field', ['field' => 'address'])
      </div>
    </div>
    <!--city-->
    <div class="form-group row  @include('errors.field-class', ['field' => 'city'])">
      <label class="col-lg-3 control-label">{{trans('messages.city')}}</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" name="city" id="city" placeholder="{{trans('messages.city')}}" value="{{isset($user) ? $user->city : Input::get('city')}}"  @include('form.readonly')>
        @include('errors.field', ['field' => 'city'])
      </div>
    </div>
    <!--postal_code-->
    <div class="form-group row @include('errors.field-class', ['field' => 'postal_code'])">
      <label class="col-lg-3 control-label">{{trans('messages.postal_code')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('messages.postal_code')}}" name="postal_code" type="text" value="{{isset($user) ? $user->postal_code : Input::get('postal_code')}}"  @include('form.readonly')>
        @include('errors.field', ['field' => 'postal_code'])
      </div>
    </div>
    <!--email-->
    <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
      <label class="col-lg-3 control-label">{{trans('user.email')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('user.email')}}" name="email" type="email" maxlength="50" min="5" required="true" value="{{isset($user) ? $user->email : Input::get('email')}}" @include('form.readonly')>
        @include('errors.field', ['field' => 'email'])
      </div>
    </div>
    <!--password-->
    <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
      <label class="col-lg-3 control-label">{{trans('user.password')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('user.password')}}" name="password" type="password" maxlength="25" min="5" @include('form.readonly')>
        @include('errors.field', ['field' => 'password'])
      </div>
    </div>
    <!--repassword-->
    <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
      <label class="col-lg-3 control-label">{{trans('user.repassword')}}</label>
      <div class="col-lg-9">
        <input class="form-control" placeholder="{{trans('user.repassword')}}" name="password_confirmation" type="password" maxlength="25" min="5" @include('form.readonly')>
        @include('errors.field', ['field' => 'password'])
      </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    @if(!isset($readonly) || !$readonly)
      <div class="col-lg-12 buttons" id="divButton">
        <div class="pull-left text-muted"></div>
        <button type="submit" class="btn btn-primary pull-right">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>
          {{trans(isset($user)?'messages.update' : 'messages.save')}}
        </button>
      </div>
    @endif
  </fieldset>
</form>
