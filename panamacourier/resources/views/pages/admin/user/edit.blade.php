@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('user.edit'))
@section('title', trans((!$readonly) ? 'user.edit' : 'user.view'))
@extends('pages.page')
@section('toolbar-custom-pre')
<!---->
<li id="step1">
  <a href="{{asset('/')}}" id ="drdusr"><i class="fa fa-home"></i> {{trans('messages.home')}}</a>
</li>
<!---->
<li id="step2">
  <a href="{{asset('/admin/configuration')}}" id ="drdusr"><i class="fa fa-cog"></i> {{strtoupper(trans('menu.adjustments'))}}</a>
</li>
<!---->
<li id="">
  <a href="{{substr (asset('http://www.internationalcargosystem.com/payment/'.asset('/')), 0, strlen(asset('http://www.internationalcargosystem.com/payment/'.asset('/'))) - 1)}}" target="_blank" id ="drdusr"><i class="fa fa-credit-card"></i> {{strtoupper(trans('messages.pay'))}}</a>
</li>
<!---->
<li id="step3" class="dropdown" >
  <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-support"></i>
    {{strtoupper(trans('menu.help'))}}
    <i class="fa fa-caret-down"></i>
  </a>
  <ul class="dropdown-menu dropdown-user" style="right: -47px;">
    <li>
      <a href="{{asset('/admin/incidence/new')}}">
         <i class="fa fa-bullhorn"></i> {{trans('menu.incidence')}}
      </a>
    </li>
    <li style="cursor: pointer;" onclick="javascript:acercaDe()">
        <div class="" style="margin-left:20px;">
          <i class="fa fa-info-circle"></i>{{trans('menu.about')}}
        </div>
    </li>
  </ul>
</li>
<!---->
  @include('sections.toolbar')
<!---->
<li style="cursor: pointer;"id="tuto">
  <i class="fa fa-info-circle"></i> Tutorial
</li>
@stop
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$user->toInnerJson()}}">
    <a href="{{asset('admin/users')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('user.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="userDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.user.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.user.form', [
        'path' => "/admin/user/{$user->id}"
      ])
    </div>
  </div>
@stop
