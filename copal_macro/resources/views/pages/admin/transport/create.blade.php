@set('js', ['dist/js/transportCtrl.js'])
@section('pageTitle', trans('transport.create'))
@section('title', trans('transport.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/transport')}}" class="btn btn-default" data-toggle="tooltip" title="{{trans('transport.list')}}">
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
        'path' => '/admin/transport/new'
      ])
    </div>
  </div>
@stop
