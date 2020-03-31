@set('buttonPadding', 20)
@set('user')
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@section('pageTitle', trans('messages.userRegister'))
@section('title', trans('messages.register'))
@section('footer')
@stop
@section('toolbar-custom-pre')
  <li><a href="{{asset('/login')}}" id ="drdusr"><i class="fa fa-sign-in" aria-hidden="true"></i> {{trans('messages.logIn')}}</a></li>
@stop
@section('body')
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default shadow" style="margin-top:0px">
      <div class="panel-heading text-center">
        <span class="text-muted"><i class="fa fa-user" aria-hidden="true"></i> {{trans('messages.signIn')}}</span>
      </div>
      <div class="panel-body">
        <div class="panel panel-default">
          <div class="panel-body">
            <form onsubmit="submitForm()" role="form" id="registerForm" method="post" data-toggle="validator">
              {{csrf_field()}}
              <fieldset>
                <!--name-->
                <div class="form-group @include('errors.field-class', ['field' => 'name'])">
                  <label class="col-lg-3 control-label">{{trans('messages.name')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.name')}}" name="name" type="text" value="{{ Input::get('name') }}" required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'name'])
                  </div>
                </div>
                <!--last_name-->
                <div class="form-group @include('errors.field-class', ['field' => 'last_name'])">
                 <label class="col-lg-3 control-label">{{trans('messages.last_name')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.last_name')}}" name="last_name" type="text" value="{{ Input::get('last_name') }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'last_name'])
                 </div>
                </div>
                <!--dni-->
                <div class="form-group @include('errors.field-class', ['field' => 'dni'])">
                  <label class="col-lg-3 control-label">{{trans('messages.dni')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.dni')}}" name="dni" type="text" value="{{ Input::get('dni') }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'dni'])
                 </div>
                </div>
                <!--sex-->
                <div class="form-group @include('errors.field-class', ['field' => 'sex'])">
                  <label class="col-lg-3 control-label">{{trans('messages.sex')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" name="sex" type="text"  required="true" id="ics_select_sex">
                      <option>{{trans('messages.optionSelect')}}</option>
                      @foreach($sex_user as $key => $value)
                        <option {{(Input::get('sex')) == $value['id'] ? 'selected' : '' }} value="{{$value['id']}}">{{$value['text']}}</option>
                      @endforeach
                    </select>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'sex'])
                 </div>
                </div>
                <!--country-->
                <div class="form-group @include('errors.field-class', ['field' => 'country'])">
                  <label class="col-lg-3 control-label">{{trans('messages.country')}}</label>
                  <div class="col-lg-9">
                    <select class="form-control" name="country" placeholder="{{trans('messages.country')}}" required="true" value="{{Input::get('country')}}" id="ics_select_country_register">
                      <option value="0">Seleccione su País</option>
                      @if(isset($countrys))
                        @foreach($countrys as $country)
                          <option {{(Input::get('country')) == $country ? 'selected' : '' }} value="{{$country}}">{{$country}}</option>
                        @endforeach
                      @endif
                    </select>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'country'])
                  </div>
                </div>
                <!--region-->
                <div class="form-group @include('errors.field-class', ['field' => 'region'])">
                  <label class="col-lg-3 control-label">{{trans('messages.region')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.region')}}" name="region" type="text" value="{{ Input::get('region') }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'region'])
                  </div>
                </div>
                <!--address-->
                <div class="form-group @include('errors.field-class', ['field' => 'address'])">
                  <label class="col-lg-3 control-label">{{trans('messages.address')}}</label>
                  <div class="col-lg-9">
                    <textarea class="form-control" name="address" id="address" required="true" placeholder="{{trans('messages.address')}}" value="{{ Input::get('address') }}" required="true">{{ Input::get('address') }}</textarea>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'address'])
                  </div>
                </div>
                <!--city-->
                <div class="form-group @include('errors.field-class', ['field' => 'city'])">
                  <label class="col-lg-3 control-label">{{trans('messages.city')}}</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="city" id="city" required="true" placeholder="{{trans('messages.city')}}" value="{{ Input::get('city') }}" required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'city'])
                  </div>
                </div>
                <!--postal_code-->
                <div class="form-group @include('errors.field-class', ['field' => 'postal_code'])">
                  <label class="col-lg-3 control-label">{{trans('messages.postal_code')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.postal_code')}}" name="postal_code" type="text" value="{{ Input::get('postal_code') }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'])
                  </div>
                </div>
                <!--local_phone-->
                <div class="form-group @include('errors.field-class', ['field' => 'local_phone'])">
                  <label class="col-lg-3 control-label">{{trans('messages.local_phone')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.local_phone')}}" name="local_phone" type="text" value="{{ Input::get('local_phone') }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'local_phone'])
                  </div>
                </div>
                <!--celular-->
                <div class="form-group @include('errors.field-class', ['field' => 'celular'])">
                  <label class="col-lg-3 control-label">{{trans('messages.celular')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.celular')}}" name="celular" type="text" value="{{ Input::get('celular') }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'celular'])
                  </div>
                </div>
                <!--email-->
                <div class="form-group @include('errors.field-class', ['field' => 'email'])">
                  <label class="col-lg-3 control-label">{{trans('messages.email')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.email')}}" name="email" type="email" required value="{{ Input::get('email') }}" required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'email'])
                  </div>
                </div>
                <!--Other email-->
                <div class="form-group @include('errors.field-class', ['field' => 'alt_email'])">
                  <label class="col-lg-3 control-label">{{trans('Correo alternativo')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('Correo alternativo')}}" name="alt_email" type="email" value="{{ Input::get('alt_email') }}" >
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'alt_email'])
                  </div>
                </div>
                <!--password-->
                <div class="form-group @include('errors.field-class', ['field' => 'password'])">
                  <label class="col-lg-3 control-label">{{trans('messages.password')}}</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.password')}}" name="password" type="password" id="password" data-minlength="8"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'password'])
                  </div>
                </div>
                <!--password_confirmation-->
                <div class="form-group  @include('errors.field-class', ['field' => 'password'])">
                  <label class="col-lg-3 control-label">{{trans('messages.password')}}*</label>
                  <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.repassword')}}" name="password_confirmation" type="password" data-match="#password"  @if(!isset($user))required="true"@endif>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'password_confirmation'])
                  </div>
                </div>
                <!--accept-->
                <div class="css-right">
                  <a href="{{asset('/terms')}}" target="blank" class="btn btn-xs">{{trans('messages.terms')}}</a>
                    <span class="text-muted"><input name="accept" type="checkbox" id="check" value="1" onclick="disableElement()"> <label for="check">{{trans('messages.confirmTerms')}}</label> </span>
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'accept'])
                </div>
                <!-- Change this to a button or input when using this as a form -->
                <div class="pull-left text-muted" id="loadRecover"></div>
                <button type="submit" class="btn btn-primary pull-right" id="submitBnt" disabled=disabled>{{trans('messages.send')}}</button>
                <a href="{{asset('/help')}}" target="blank" class="btn pull-right" style="margin-right:10px">{{trans('messages.help')}}</a>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
