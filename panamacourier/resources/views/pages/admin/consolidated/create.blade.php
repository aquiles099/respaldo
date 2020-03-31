@set('js', ['js/includes/consolidatedCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('consolidated.create'))
@section('title', trans('consolidated.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/consolidated')}}" class="btn btn-primary" title="{{trans('consolidated.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.consolidated.messages')
  @include('sections.messages')
  @include('pages.admin.consolidated.form', [
    'path' => '/admin/consolidated/new'
  ])
@stop
@section('onready')
@stop
