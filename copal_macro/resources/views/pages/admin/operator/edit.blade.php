@set('js', ['js/includes/userCtrl.js'])
@section('pageTitle', trans('operator.edit'))
@section('title', trans((!$readonly) ? 'operator.edit' : 'operator.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$operator->toInnerJson()}}">
    <a href="{{asset('/admin/operators')}}" class="btn btn-default" title="{{trans('user.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="userDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.operator.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.operator.form', [
        'path' => "/admin/operator/{$operator->id}"
      ])
    </div>
  </div>
@stop
