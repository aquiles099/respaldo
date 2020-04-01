<?php
if(isset($package) && !is_null($package->getLastEvent)) {
  $position = $package->getLastEvent->step;
}
else {
  $position = -1;
}
?>
@set('only')
<?php
use App\Helpers\HUserType;
  if(Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@section('pageTitle', trans('messages.account'))
@set('js',['js/includes/resellerCtrl.js'])
@include('sections.translate')
@section('icon-title')
  <i aria-hidden="true" class="fa fa-user"></i>
@stop
@section('title', trans('messages.myAccount'))
@extends('pages.page')
@section('title-actions')
@stop
@section('body')
  @include('sections.messages')
<div class="panel panel-default" id="pnlin">
  <div class="panel-heading">
    <div class="row">
      {{--
        <div class="col-md-1 col-lg-1 col-sm-1">
          <a href="javascript:icsViewPicProfile()">
            <img src="{{asset('/dist/images/user.jpg')}}" style="height: 50px" data-toggle="tooltip" title="{{$user->name}} {{$user->last_name }}" class="img-responsive img-circle"/>
          </a>
        </div>
        --}}
      <div class="col-md-5 col-lg-5 col-sm-5 col-xs-5 text-center text-muted" style="margin-top: 15px">
        {{trans('messages.created')}}: {{$user->created_at}}
      </div>
      <div class="col-md-5 col-lg-5 col-sm-5 col-xs-5 text-center text-muted" style="margin-top: 15px">
        {{trans('messages.updated')}}: {{$user->updated_at}}
      </div>
    </div>
  </div>
  <div class="panel-body" >
    <form role="form" action="{{asset($path)}}" onsubmit="updateUserLoad()" method="post" data-toggle="validator">
        @if(isset($user))
          <input type="hidden" name="_method" value="patch">
        @endif
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                <span class="text-muted">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  {{trans('messages.personaldata')}}
                </span>
              </div>
              <div class="panel-body">
                <fieldset>
                  <!--name-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'name'])">
                    <label class="col-lg-3 control-label" for="content" id="label">{{trans('messages.name')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.name')}}" name="name" type="text" autofocus value="{{$user->name}}" required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'name'])
                    </div>
                  </div>
                  <!--last_name-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'last_name'])">
                    <label class="col-lg-3 control-label" for="content" id="label">{{trans('messages.last_name')}}</label>
                    <div class="col-lg-9">
                    <input class="form-control" placeholder="{{trans('messages.last_name')}}" name="last_name" type="text" value="{{$user->last_name }}"  required="true">
                    @include('sections.errors', ['errors' =>  $errors, 'name' => 'last_name'])
                   </div>
                  </div>
                  <!--dni-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'dni'])">
                    <label class="col-lg-3 control-label" for="content" id="label">{{trans('messages.dni')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.dni')}}" name="dni" type="text" value="{{$user->dni }}"  required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'dni'])
                    </div>
                  </div>
                  <!--sex-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'sex'])">
                    <label class="col-lg-3 control-label">{{trans('messages.sex')}}</label>
                    <div class="col-lg-9">
                      <select class="form-control" name="sex" type="text"  required="true" id="ics_select_sex">
                        <option>{{trans('messages.optionSelect')}}</option>
                        @foreach($sex_user as $key => $value)
                          <option {{isset($user) && $user->sex == $value['id'] ? 'selected' : '' }} value="{{$value['id']}}">{{$value['text']}}</option>
                        @endforeach
                      </select>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'sex'])
                   </div>
                  </div>
                  <!--celular-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'celular'])">
                    <label class="col-lg-3 control-label" for="content" id="label">{{trans('messages.celular')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.celular')}}" name="celular" type="text" value="{{$user->celular}}"  required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'celular'])
                    </div>
                  </div>
                  <!--email-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'email'])">
                    <label class="col-lg-3 control-label" for="content" id="label">{{trans('messages.email')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.email')}}" name="email" type="email" required value="{{$user->email}}" required="true" readonly=true>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'email'])
                    </div>
                  </div>
                  <!--password-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
                    <label class="col-lg-3 control-label" for="content" id="label">
                        {{trans('messages.password')}}
                        <span class="pull-right">
                          <a class="infoRd" href="{{asset('/account/user/pass')}}" data-toggle="tooltip" title="{{trans('messages.changepassword')}}"><i aria-hidden="true" class="fa fa-refresh"></i></a>
                        </span>
                    </label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.password')}}" type="password"  data-minlength="8"  required="true" value="{{$user->password}}" readonly=true>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'password'])
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading text-center">
                  <span class="text-muted">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    {{trans('messages.billingdelivery')}}
                  </span>
              </div>
              <div class="panel-body" style="margin-bottom: 24px">
                <fieldset>
                  <!--country-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'country'])">
                    <label class="col-lg-3 control-label" for="country" id="label">{{trans('messages.country')}}</label>
                    <div class="col-lg-9">
                      <select class="form-control" id="country" name="country" required="true" >
                        <option>{{trans('messages.optionSelect')}}</option>
                        @foreach($country as $key => $value)
                          <option {{$user->country == $value ? 'selected':''}}>{{$value}}</option>
                        @endforeach
                      </select>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'country'])
                    </div>
                  </div>
                  <!--region-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'region'])">
                    <label class="col-lg-3 control-label" for="region" id="label">{{trans('messages.region')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.region')}}" name="region" type="text" autofocus value="{{$user->region}}" required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'region'])
                    </div>
                  </div>
                  <!--city-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'city'])">
                    <label class="col-lg-3 control-label" for="region" id="label">{{trans('messages.city')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.city')}}" name="city" type="text" autofocus value="{{$user->city}}" required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'city'])
                    </div>
                  </div>
                  <!--local_phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'local_phone'])">
                    <label class="col-lg-3 control-label" for="local_phone" id="label">{{trans('messages.local_phone')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.local_phone')}}" name="local_phone" type="text" autofocus value="{{$user->local_phone}}" required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'local_phone'])
                    </div>
                  </div>
                  <!--local_phone-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'postal_code'])">
                    <label class="col-lg-3 control-label" for="postal_code" id="label">{{trans('messages.postal_code')}}</label>
                    <div class="col-lg-9">
                      <input class="form-control" placeholder="{{trans('messages.postal_code')}}" name="postal_code" type="text" autofocus value="{{$user->postal_code}}" required="true">
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'postal_code'])
                    </div>
                  </div>
                  <!--address-->
                  <div class="form-group row @include('errors.field-class', ['field' => 'address'])">
                    <label class="col-lg-3 control-label" for="postal_code" id="label">{{trans('messages.address')}}</label>
                    <div class="col-lg-9">
                      <textarea class="form-control" placeholder="{{trans('messages.address')}}" name="address" value="{{$user->address}}" required="true" >{{$user->address}}</textarea>
                      @include('sections.errors', ['errors' =>  $errors, 'name' => 'address'])
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
        <!-- Change this to a button or input when using this as a form -->
        <div class="pull-right" style="padding-right: 2%">
            <span class="text-muted"><input type="checkbox" id="check" value="1" onclick="disableElement()" /> <label for="check">{{trans('messages.confirmchange')}}</label></span>
            <button type="submit" class="btn btn-primary" id="submitBnt" disabled=disabled>{{trans('messages.send')}}</button>
        </div>
    </form>
  </div>
</div>
@stop
