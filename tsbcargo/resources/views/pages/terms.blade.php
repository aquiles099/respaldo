@set('buttonPadding', 20)
@set('user')
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@section('pageTitle', trans('messages.terms'))
@section('title', trans('messages.register'))
@if(!isset($session) || $session == null)
@section('toolbar-custom-pre')
  <li><a href="{{asset('/register')}}" id ="drdusr"><i class="fa fa-user" aria-hidden="true"></i> {{trans('messages.register')}}</a></li>
@stop
@endif
@section('body')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
        <div class="text-center text-muted">
            <i class="fa fa-thumb-tack" aria-hidden="true"></i>
            {{trans('messages.terms')}}
        </div>
      </div>
      <div class="panel-body" id="terms">
          <!--{{isset($terms) ? ($terms == '' ) ? trans('configuration.noTerms') : $terms : trans('configuration.noTerms')}}-->
          <object data="{{asset('tmpreport/terms.pdf')}}" type="application/pdf" width="100%" height="800px"></object> 
      </div>
    </div>
  </div>
</div>
@stop
