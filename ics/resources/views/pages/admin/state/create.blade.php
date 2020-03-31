@set('js', ['dist/js/stateCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('state.create'))
@section('title', trans('state.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/cities')}}" onclick="loadButton(this)" class="btn btn-default" data-toggle="tooltip" title="{{trans('city.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.state.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.state.form', [
        'path' => '/admin/state/new'
      ])
    </div>
  </div>
@stop
