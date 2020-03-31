@set('js', ['js/includes/typepickupCtrl.js'])
@section('pageTitle', trans('typepickup.edit'))
@section('title', trans((!$readonly) ? 'typepickup.edit' : 'typepickup.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$typepickup}}">
    <a href="{{asset('admin/tpickup')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('containers.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="tpickupDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.typepickup.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.typepickup.form',
      [
        'path' => "/admin/tpickup/{$typepickup->id}"
      ])
    </div>
  </div>
@stop
