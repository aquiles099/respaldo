@set('js', ['src/js/vesselCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('vessel.create'))
@section('title', trans('vessel.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/vessels')}}" onclick="loadButton(this)" class="btn btn-default" data-toggle="tooltip" title="{{trans('vessel.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.vessel.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.vessel.form', [
        'path' => '/admin/vessels/new'
      ])
    </div>
  </div>
@stop
