@set('js', ['js/includes/consolidatedCtrl.js'])
@section('pageTitle', trans('consolidated.create'))
@section('title', trans('consolidated.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/consolidated')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('consolidated.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.consolidated.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.consolidated.form', [
        'path' => '/admin/consolidated/new'
      ])
    </div>
  </div>
@stop
@section('onready')
@stop
