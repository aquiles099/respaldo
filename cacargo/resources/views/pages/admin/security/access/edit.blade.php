@set('js', ['js/includes/accessCtrl.js'])
@section('pageTitle', trans('access.edit'))
@section('title', trans((!$readonly) ? 'access.edit' : 'access.view'))
@extends('pages.page')
@include('sections.translate')
@section('title-actions')
  <div class="btn-group" role="group" item="{{$access->toInnerJson()}}">
    <a href="{{asset('admin/security/access')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('access.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="accessDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.security.access.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.security.access.form', [
    'path' => "/admin/security/access/{$access->id}"
  ])
  </div>
</div>
@stop
