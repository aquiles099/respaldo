@set('js', ['js/includes/packageCtrl.js'])
@section('pageTitle', trans('package.create'))
@section('title', trans('package.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a id="listwhr" href="{{asset('admin/package')}}" onclick="javascript:loadButtonWhr(this)" class="btn btn-primary" title="{{trans('package.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
  @include('pages.admin.package.form', [
    'path' => '/admin/package/new'
  ])
@stop
@section('onready')
  initSelect2();

@stop
