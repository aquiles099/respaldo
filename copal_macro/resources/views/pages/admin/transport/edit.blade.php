@set('js', ['dist/js/transportCtrl.js'])
@section('pageTitle', trans('courier.edit'))
@section('title', trans((!$readonly) ? 'transport.edit' : 'transport.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$transport->toInnerJson()}}">
    <a href="{{asset('admin/service')}}" class="btn btn-default" title="{{trans('transport.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="transportDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.transport.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.transport.form', [
        'path' => "/admin/transport/{$transport->id}"
      ])
    </div>
  </div>
@stop
