@set('js', ['js/includes/packagecurriersCtrl.js'])
@section('pageTitle', trans('package.createwr'))
@section('title', trans('package.createwr'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a id="listwhr" href="{{asset('admin/package')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('package.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
  @include('pages.admin.packagecurriers.form', [
    'path' => '/admin/packagecurriers/new'
  ])
@stop
@section('onready')


@stop
