@set('buttonPadding', 20)
@set('user')
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@section('pageTitle', trans('messages.logIn'))
@section('title', trans('messages.logIn'))
@section('toolbar-custom-pre')
  <li><a href="{{asset('/register')}}" id ="drdusr"><i class="fa fa-user" aria-hidden="true"></i> {{trans('messages.register')}}</a></li>
@stop
<script type="text/javascript">
function loadButton() {
 $('#loginButton').attr('disabled','true');
 $('#loginButton').html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}
</script>
@section('body')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    @include('sections.messages')
    <div class="login-panel panel panel-default shadow">
      <div class="panel-heading">
        <div class="text-center text-muted">
          <i aria-hidden="true" class="fa fa-sign-in"></i>
            {{trans('messages.logIn')}}
        </div>
      </div>
      <div class="panel-body">
        <form onsubmit="loadButton()" role="form" action="{{asset('/login')}}" method="post">
          <fieldset>
            <div class="form-group @include('errors.field-class', ['field' => 'username'])">
              <input class="form-control" placeholder="{{trans('messages.email')}}" name="username" type="text" autofocus maxlength="40" min="5" required="true" value="copal@internationalcargosystem.com" value="{{Input::get('username')}}">
              @include('errors.field', ['field' => 'username'])
            </div>
            <div class="form-group @include('errors.field-class', ['field' => 'password'])">
              <input class="form-control" placeholder="{{trans('messages.password')}}" name="password" type="password" value="12345678" maxlength="20" min="5" required="true">
              @include('errors.field', ['field' => 'password'])
            </div>
            <!-- Change this to a button or input when using this as a form -->
            <a href="{{asset('/recover-password')}}" class="btn text-red">{{trans('messages.lostPassword')}}</a>
            <button id="loginButton" type="submit" class="btn btn-primary pull-right">{{trans('messages.doLogIn')}}</button>
            <a href="{{asset('/help')}}" target="blank" class="btn pull-right" style="margin-right:10px">{{trans('messages.help')}}</a>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
