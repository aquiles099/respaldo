@set('js', ['src/js/routeCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('route.create'))
@section('title', trans('route.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/routes')}}" onclick="loadButton(this)" class="btn btn-default" data-toggle="tooltip" title="{{trans('route.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.route.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.route.form', [
        'path' => '/admin/routes/new'
      ])
    </div>
  </div>
@stop
