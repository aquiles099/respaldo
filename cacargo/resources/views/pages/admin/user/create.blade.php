@set('js', ['js/includes/userCtrl.js'])
@section('pageTitle', trans('user.create'))
@section('title', trans('user.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/users')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('user.list')}}">
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
  @include('pages.admin.user.form', [
    'path' => '/admin/user/new'
  ])
  </div>
</div>
@stop
