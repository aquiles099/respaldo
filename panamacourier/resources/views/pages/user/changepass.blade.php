@set('only')
<?php
  use App\Helpers\HUserType;
  if(isset($package) && !is_null($package->getLastEvent)) {
    $position = $package->getLastEvent->step;
  }
  else {
    $position = -1;
  }
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('messages.changepassword'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-lock"></i>
@stop
@section('title', trans('messages.changepassword'))
@extends('pages.page')
@section('title-actions')
@stop
@section('body')
<div class="panel panel-default">
  <div class="panel-heading text-center">
    <span class="text-muted">
      <i class="fa fa-lock" aria-hidden="true"></i>
      {{trans('messages.changepassword')}}
    </span>
  </div>
  <div class="panel-body">
    @include('sections.messages')
    <fieldset>
      <form onsubmit="submitForm()" role="form" action="{{asset($path)}}" method="post" data-toggle="validator">
        @if(isset($user))
          <input type="hidden" name="_method" value="patch">
        @endif
        <fieldset>
          <!--Old Pass-->
          <div class="form-group row @include('errors.field-class', ['field' => 'old'])">
            <div class="col-md-3">
              <label for="old">{{trans('messages.currentpassword')}}</label>
            </div>
            <div class="col-md-9">
              <input class="form-control" placeholder="{{trans('messages.currentpassword')}}" name="old" type="password" id="old" data-minlength="1"  required="true">
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'old'])
            </div>
          </div>
          <!--New Pass-->
          <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
            <div class="col-md-3">
              <label for="password">{{trans('messages.newpass')}}</label>
            </div>
            <div class="col-md-9">
              <input class="form-control" placeholder="{{trans('messages.newpass')}}" name="password" type="password" id="password" data-minlength="8"  required="true">
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'password'])
            </div>
          </div>
          <!--Confirm Pass-->
          <div class="form-group row @include('errors.field-class', ['field' => 'password'])">
            <div class="col-md-3">
              <label for="password_confirmation">{{trans('messages.repassword')}}</label>
            </div>
            <div class="col-md-9">
              <input class="form-control" placeholder="{{trans('messages.repassword')}}" name="password_confirmation" id="password_confirmation" type="password" data-match="#password"  @if(!isset($user))required="true"@endif>
              @include('sections.errors', ['errors' =>  $errors, 'name' => 'password_confirmation'])
            </div>
          </div>
          <!-- Change this to a button or input when using this as a form -->
          <div class="pull-left text-muted" id="loadRecover"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{trans('messages.mailNotify')}}</div>
          <button type="submit" class="btn btn-primary pull-right">{{trans('messages.send')}}</button>
        </fieldset>
      </form>
    </fieldset>
  </div>
</div>
@stop
