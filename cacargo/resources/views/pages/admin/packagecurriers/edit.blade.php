@set('js', ['js/includes/packagecurriersCtrl.js'])
@section('pageTitle', trans('package.editco'))
@section('title', trans((!$readonly) ? 'package.editco' : 'package.view'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$package->toInnerJson()}}">
    <a href="{{asset('admin/packagelist')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('package.list')}}">
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
  @include('pages.admin.packagecurriers.form', [
    'path' => "/admin/packagecurriers/{$package->id}"
  ])
  </div>
</div>
@stop
@section('onready')


@stop
