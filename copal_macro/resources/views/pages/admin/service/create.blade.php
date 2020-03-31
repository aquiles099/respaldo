@set('js', ['js/includes/serviceCtrl.js'])
@section('pageTitle', trans('service.create'))
@section('title', trans('service.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/service')}}" class="btn btn-default" title="{{trans('office.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.service.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.service.form', [
        'path' => '/admin/service/new'
      ])
    </div>
  </div>
@stop
