@set('js', ['js/includes/containerCtrl.js'])
@section('pageTitle', trans('container.create'))
@section('title', trans('container.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/containers')}}" class="btn btn-primary" title="{{trans('container.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.container.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.container.form', [
        'path' => '/admin/containers/new'
      ])
    </div>
  </div>
@stop
