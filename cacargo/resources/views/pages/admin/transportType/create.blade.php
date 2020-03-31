@set('js', ['js/includes/transportTypeCtrl.js'])
@section('pageTitle', trans('transportType.create'))
@section('title', trans('transportType.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/typeTransports')}}" onclick="loadButton(this)" class="btn btn-default" data-toggle="tooltip" title="{{trans('transportType.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.transportType.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.transportType.form', [
        'path' => '/admin/typeTransports/new'
      ])
    </div>
  </div>
@stop
