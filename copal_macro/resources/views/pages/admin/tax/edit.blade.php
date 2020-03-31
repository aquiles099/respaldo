@set('js', ['js/includes/taxCtrl.js'])
@section('pageTitle', trans('tax.edit'))
@section('title', trans((!$readonly) ? 'tax.edit' : 'tax.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$tax->toInnerJson()}}">
    <a href="{{asset('admin/tax')}}" class="btn btn-default" title="{{trans('tax.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="taxDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.tax.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.tax.form', [
        'path' => "/admin/tax/{$tax->id}"
      ])
    </div>
  </div>
@stop
