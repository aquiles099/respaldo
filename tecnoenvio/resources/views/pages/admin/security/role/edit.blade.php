@set('js', ['js/includes/roleCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('role.edit'))
@section('title', trans((!$readonly) ? 'role.edit' : 'role.view'))
@extends('pages.page')
@section('title-actions')
  <div class="btn-group" role="group" item="{{$role->toInnerJson()}}">
    <a href="{{asset('admin/security/role')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('role.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="roleDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.security.role.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.security.role.form', [
    'path' => "/admin/security/role/{$role->id}"
  ])
  </div>
</div>
@stop
