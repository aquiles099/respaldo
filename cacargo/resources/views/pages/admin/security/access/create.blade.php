@set('js', ['js/includes/accessCtrl.js'])
@section('pageTitle', trans('access.create'))
@section('title', trans('access.create'))
@extends('pages.page')
@include('sections.translate')
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/security/access')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('access.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.security.access.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.security.access.form', [
    'path' => '/admin/security/access/new'
  ])
  </div>
</div>
@stop
