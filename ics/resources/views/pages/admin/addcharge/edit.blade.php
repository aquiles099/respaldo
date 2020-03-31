@set('js', ['js/includes/addchargeCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('addcharge.edit'))
@section('title', trans((!$readonly) ? 'addcharge.edit' : 'addcharge.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$addcharge}}">
    <a href="{{asset('admin/addcharge')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('addcharge.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="icsAddChargesDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.addcharge.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.addcharge.form', [
        'path' => "/admin/addcharge/{$addcharge->id}"
      ])
    </div>
  </div>
@stop
