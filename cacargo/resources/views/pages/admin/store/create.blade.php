@set('js', ['js/includes/storeCtrl.js'])
@section('pageTitle', trans('store.create'))
@section('title', trans('store.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/store')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('store.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.store.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
    @include('pages.admin.store.form', [
      'path' => '/admin/store/new'
    ])
    </div>
  </div>
@stop
