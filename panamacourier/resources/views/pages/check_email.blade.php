@set('buttonPadding', 20)
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@section('pageTitle', trans('messages.check_email'))
@section('title', trans('messages.check_email'))
@section('body')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="login-panel panel panel-default shadow" >
      <div class="panel-heading">
        <div class="text-center text-muted">
          <i aria-hidden="true" class="fa fa-search"></i>
            {{trans('messages.check_email')}}
        </div>
      </div>
      <div class="panel-body">
        <div class="panel panel-default" >
          <div class="panel-body">
            <h1 class="text-center">
              <i class="fa fa-envelope-o" aria-hidden="true"></i>
            </h1>
            <div style="padding: 15%">
              <div class="text-center">
                  {!! trans('messages.check_email_legend' , [
                    'email'   => $user->email,
                    'company' => $configuration->name_company
                    ])
                  !!}
              </div>
              <div class="col-md-5"></div>
              <a style="font-size:14px;" href="{{asset('/login')}}"><br><div class="col-md-4">

              </div>{{trans('messages.logIn')}}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
