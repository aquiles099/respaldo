@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('user.create'))
@section('title', trans('user.create'))
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
  <div class="btn-group" role="group">
    <a href="{{asset('admin/users')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('user.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.user.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.user.import_xls', [
        'path' => '/admin/user/xls'
      ])
    </div>
  </div>
@stop
