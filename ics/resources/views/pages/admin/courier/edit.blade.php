@set('js', ['js/includes/courierCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('courier.edit'))
@section('title', trans((!$readonly) ? 'courier.edit' : 'courier.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$courier->toInnerJson()}}">
    <a href="{{asset('admin/courier')}}" class="btn btn-default" title="{{trans('courier.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="courierDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.courier.messages')
  @include('sections.messages')
  @include('pages.admin.courier.form', [
    'path' => "/admin/courier/{$courier->id}"
  ])
@stop
