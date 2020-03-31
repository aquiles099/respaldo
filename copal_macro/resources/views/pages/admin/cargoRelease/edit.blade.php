@set('js', ['src/js/cargoReleaseCtrl.js'])
@section('pageTitle', trans('cargoRelease.edit'))
@section('title', trans((!$readonly) ? 'cargoRelease.edit' : 'cargoRelease.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$cargoRelease->toInnerJson()}}">
    <a href="{{asset('admin/cargoRelease')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('cargoRelease.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="cargoReleaseDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.cargoRelease.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <!--form-->
      @include('pages.admin.cargoRelease.form', ['path' => "/admin/cargoRelease/{$cargoRelease->id}"])
    </div>
  </div>
@stop
