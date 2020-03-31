@set('buttonPadding', 20)
@set('user')
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@section('pageTitle', trans('messages.recoverPassword'))
@section('title', trans('messages.recoverPassword'))
@section('toolbar-custom-pre')
  <li><a href="{{asset('/login')}}" id ="drdusr"><i class="fa fa-sign-in" aria-hidden="true"></i> {{trans('messages.logIn')}}</a></li>
@stop
@section('body')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    @include('sections.messages')
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
        <div class="text-center text-muted">
          <i aria-hidden="true" class="fa fa-lock"></i>
            {{trans('messages.recoverPassword')}}
        </div>
      </div>
      <div class="panel-body">
        <form onsubmit="submitForm()" role="form" method="post" action="{{asset('/recover-password')}}">
          <fieldset>
            <!---->
            {{csrf_field()}}
            <div class="form-group @include('errors.field-class', ['field' => 'email'])" >
                <input class="form-control" placeholder="{{trans('messages.email')}}" name="email" id="email" type="email" required="true" autofocus value="{{Input::get('email')}}">
                @include('errors.field', ['field' => 'email'])
            </div>
            <!-- Change this to a button or input when using this as a form -->
            <div class="pull-left text-muted" id="loadRecover"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{trans('messages.mailNotify')}}</div>
            <button type="submit" class="btn btn-primary pull-right">{{trans('messages.send')}}</button>
            <a href="{{asset('/help')}}" target="blank" class="btn pull-right" style="margin-right:10px">{{trans('messages.help')}}</a>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
