@set('js', ['js/includes/officeCtrl.js'])
@section('pageTitle', trans('office.create'))
@section('title', trans('office.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/office')}}" class="btn btn-default" title="{{trans('office.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.office.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.office.form', [
        'path' => '/admin/office/new'
      ])
      </div>
  </div>
@stop
