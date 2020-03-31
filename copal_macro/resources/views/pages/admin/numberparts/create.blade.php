@set('js', ['js/includes/numberpartsCtrl.js'])
@section('pageTitle', trans('numberparts.create'))
@section('title', trans('numberparts.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/numberparts')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('numberparts.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.numberparts.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.numberparts.form', [
        'path' => '/admin/numberparts/new'
      ])
    </div>
  </div>
@stop
