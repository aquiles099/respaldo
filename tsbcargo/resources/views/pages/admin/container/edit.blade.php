@set('js', ['js/includes/containerCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('container.edit'))
@section('title', trans((!$readonly) ? 'container.edit' : 'container.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$container->toInnerJson()}}">
    <a href="{{asset('admin/containers')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('containers.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="containerDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.container.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.container.form',
      [
        'path' => "/admin/containers/{$container->id}"
      ])
    </div>
  </div>
@stop
