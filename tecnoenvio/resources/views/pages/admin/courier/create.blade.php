@set('js', ['js/includes/courierCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('courier.create'))
@section('title', trans('courier.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/courier')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('courier.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.courier.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.courier.form', [
    'path' => '/admin/courier/new'
  ])
  </div>
</div>
@stop
