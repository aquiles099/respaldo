@set('js', ['js/includes/roleCtrl.js'])
@section('pageTitle', trans('role.create'))
@section('title', trans('role.create'))
@extends('pages.page')
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/security/role')}}" class="btn btn-default" title="{{trans('role.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.security.role.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.security.role.form', [
        'path' => '/admin/security/role/new'
      ])
    </div>
  </div>
@stop
