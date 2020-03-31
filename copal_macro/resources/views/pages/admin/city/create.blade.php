@set('js', ['src/js/cityCtrl.js'])
@section('pageTitle', trans('city.create'))
@section('title', trans('city.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/cities')}}" class="btn btn-default" data-toggle="tooltip" title="{{trans('city.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.city.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.city.form', [
        'path' => '/admin/cities/new'
      ])
    </div>
  </div>
@stop
