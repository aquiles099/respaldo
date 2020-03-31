@set('js', ['js/includes/typepickupCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('numberparts.edit'))
@section('title', trans((!$readonly) ? 'numberparts.edit' : 'numberparts.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$numberparts}}">
    <a href="{{asset('admin/numberparts')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('containers.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="numberpartDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.numberparts.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.numberparts.form',
      [
        'path' => "/admin/numberparts/{$numberparts->id}"
      ])
    </div>
  </div>
@stop
