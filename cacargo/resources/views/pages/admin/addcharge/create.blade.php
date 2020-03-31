@set('js', ['js/includes/addchargeCtrl.js'])
@section('pageTitle', trans('addcharge.create'))
@section('title', trans('addcharge.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/addcharge')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('office.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.addcharge.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.addcharge.form', [
      'path' => '/admin/addcharge/new'
      ])
    </div>
  </div>
@stop
