@set('js', ['js/includes/packageCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('package.edit'))
@section('title', trans((!$readonly) ? 'package.edit' : 'package.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$package->toInnerJson()}}">
    <a href="{{asset('admin/package')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('package.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="packageDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.package.form', [
    'path' => "/admin/package/{$package->id}"
  ])
  </div>
</div>
@stop
@section('onready')
  initSelect2();

@stop
