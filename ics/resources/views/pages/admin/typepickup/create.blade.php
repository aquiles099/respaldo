@set('js', ['js/includes/typepickupCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('typepickup.create'))
@section('title', trans('typepickup.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/tpickup')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('typepickup.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.typepickup.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.typepickup.form', [
        'path' => '/admin/tpickup/new'
      ])
    </div>
  </div>
@stop
