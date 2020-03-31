@set('js', ['js/includes/transportCtrl.js'])
@section('pageTitle', trans('transport.create'))
@section('title', trans('transport.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/service')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('transport.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.transport.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.transport.form', [
    'path' => "/admin/service/new"
  ])
  </div>
</div>
@stop
