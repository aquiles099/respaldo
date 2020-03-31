<div class="panel panel-default" id="pnlft">
  <div class="panel-body">
    <form role="form" action="" method="" id ="formSerial">
      @if(isset($user))
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      @endif
      <fieldset class="form">
        <!--name -->
        <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
          <label class="col-lg-3 control-label">{{trans('user.name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.name')}}" name="name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->name : Input::get('name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'name'])
          </div>
        </div>
        <!--last_name -->
        <div class="form-group row @include('errors.field-class', ['field' => 'last_name'])">
          <label class="col-lg-3 control-label">{{trans('messages.last_name')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.last_name')}}" name="last_name" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->last_name : Input::get('last_name')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'last_name'])
          </div>
        </div>
        <!--dni -->
        <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
          <label class="col-lg-3 control-label">{{trans('messages.dni')}} <span class = "badge" data-toggle="tooltip" data-placement="top" title="{{trans('messages.indentToolTipText')}}"> ? </span></label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.dni')}}" name="dni" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->dni : Input::get('dni')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'dni'])
          </div>
        </div>
        <!--country-->
        <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
          <label class="col-lg-3 control-label">{{trans('messages.country')}}</label>
          <div class="col-lg-9">
            @if(!isset($readonly) || $readonly == false)
              <select class="form-control" name="country" placeholder="{{trans('messages.country')}}" required="true" value="{{isset($user) ? $user->country : Input::get('country')}}" @include('form.readonly')>
                @if(isset($countrys))
                  @foreach($countrys as $country)
                    <option value="{{$country}}">{{$country}}</option>
                  @endforeach
                @endif
              </select>
            @else
             <input class="form-control" placeholder="{{trans('messages.country')}}" name="country" type="text" value="{{isset($user) ? $user->country : Input::get('country') }}"  required="true" @include('form.readonly')>
            @endif
            @include('sections.errors', ['errors' =>  $errors, 'name' => 'country'])
          </div>
        </div>
        <!--region-->
        <div class="form-group row @include('errors.field-class', ['field' => 'region'])">
          <label class="col-lg-3 control-label">{{trans('messages.region')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.region')}}" name="region" type="text" value="{{isset($user) ? $user->region : Input::get('region') }}"  required="true" @include('form.readonly')>
            @include('sections.errors', ['errors' =>  $errors, 'name' => 'region'])
          </div>
        </div>
        <!--city-->
        <div class="form-group row @include('errors.field-class', ['field' => 'city'])">
          <label class="col-lg-3 control-label">{{trans('messages.city')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.city')}}" name="city" type="text" value="{{isset($user) ? $user->city : Input::get('city') }}"  required="true" @include('form.readonly')>
            @include('sections.errors', ['errors' =>  $errors, 'name' => 'city'])
          </div>
        </div>
        <!--address-->
        <div class="form-group row @include('errors.field-class', ['field' => 'address'])">
          <label class="col-lg-3 control-label">{{trans('messages.address')}}</label>
          <div class="col-lg-9">
            <textarea class="form-control" name="address" id="address" required="true" placeholder="{{trans('messages.address')}}" value="{{isset($user) ? $user->address : Input::get('address') }}" required="true" @include('form.readonly')>{{isset($user) ? $user->address : ''}}</textarea>
            @include('sections.errors', ['errors' =>  $errors, 'name' => 'address'])
          </div>
        </div>
        <!--postal_code-->
        <div class="form-group row @include('errors.field-class', ['field' => 'postal_code'])">
          <label class="col-lg-3 control-label">{{trans('messages.postal_code')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.postal_code')}}" name="postal_code" type="text" value="{{isset($user) ? $user->postal_code : Input::get('postal_code') }}"  required="true" @include('form.readonly')>
            @include('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'])
          </div>
        </div>

        <!--local_phone -->
        <div class="form-group row @include('errors.field-class', ['field' => 'local_phone'])">
          <label class="col-lg-3 control-label">{{trans('messages.local_phone')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.local_phone')}}" name="local_phone" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->local_phone : Input::get('local_phone')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'local_phone'])
          </div>
        </div>
        <!--celular -->
        <div class="form-group row @include('errors.field-class', ['field' => 'celular'])">
          <label class="col-lg-3 control-label">{{trans('messages.celular')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('messages.celular')}}" name="celular" type="text" autofocus maxlength="100" min="5" required="true" value="{{isset($user) ? $user->celular : Input::get('celular')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'celular'])
          </div>
        </div>

        <!--password -->
        <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
          <label class="col-lg-3 control-label">{{trans('user.password')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.password')}}" name="password" type="password" maxlength="25" min="5" @include('form.readonly')>
            @include('errors.field', ['field' => 'password'])
          </div>
        </div>
        <!--repass -->
        <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
          <label class="col-lg-3 control-label">{{trans('user.repassword')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.repassword')}}" name="password_confirmation" type="password" maxlength="25" min="5" @include('form.readonly')>
            @include('errors.field', ['field' => 'password'])
          </div>
        </div>
        <!--email -->
        <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
          <label class="col-lg-3 control-label">{{trans('user.email')}}</label>
          <div class="col-lg-9">
            <input class="form-control" placeholder="{{trans('user.email')}}" name="email" type="email" maxlength="50" min="5" required="true" value="{{isset($user) ? $user->email : Input::get('email')}}" @include('form.readonly')>
            @include('errors.field', ['field' => 'email'])
          </div>
        </div>
        {{--id de la compañia--}}
        <input type="hidden" name="company" value="{{$company->id}}">
      </fieldset>
    </form>
  </div>
</div>
