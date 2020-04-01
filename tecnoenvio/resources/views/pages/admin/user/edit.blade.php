@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('user.edit'))
@section('title', trans((!$readonly) ? 'user.edit' : 'user.view'))
@extends('pages.page')
@section('toolbar-custom-pre')
<li>
  <a href="{{asset('/')}}" id ="drdusr"><i class="fa fa-home"></i> {{trans('messages.home')}}</a>
</li>
<li>
  <a href="{{asset('/admin/configuration')}}" id ="drdusr"><i class="fa fa-cog"></i> {{strtoupper(trans('menu.adjustments'))}}</a>
</li>
@include('sections.toolbar')
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
