@set('js', ['js/includes/operatorsCtrl.js'])
@set('js', ['js/includes/userCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('operator.creating'))
@section('title', trans('operator.creating'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/operators')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('user.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.operator.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.operator.form', [
    'path' => '/admin/operator/new'
  ])
  </div>
</div>
@stop
