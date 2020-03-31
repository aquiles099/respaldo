@set('js', ['js/includes/packagecurriersCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('package.createcurriers'))
@section('title', trans('package.createcurriers'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/packagelist')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('package.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.packagecurriers.form', [
    'path' => '/admin/packagecurriers/new'
  ])
  </div>
</div>
@stop
@section('onready')


@stop
