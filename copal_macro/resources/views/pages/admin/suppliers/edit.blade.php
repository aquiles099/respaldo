@set('js', ['js/includes/suppliersCtrl.js'])
@section('pageTitle', trans('office.edit'))
@section('title', trans((!$readonly) ? 'office.edit' : 'office.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$office->toInnerJson()}}">
    <a href="{{asset('admin/office')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('office.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="officeDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.office.messages')
  @include('sections.messages')
  @include('pages.admin.office.form', [
    'path' => "/admin/office/{$office->id}"
  ])
@stop
