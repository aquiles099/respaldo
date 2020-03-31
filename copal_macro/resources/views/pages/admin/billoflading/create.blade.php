@set('js', ['js/includes/billofladingCtrl.js'])
@section('pageTitle', trans('billoflading.title'))
@section('title', trans('billoflading.title'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<div class="btn-group" role="group">
  <a href="{{asset('admin/package')}}" class="btn btn-default" title="{{trans('package.list')}}">
    <i class="fa fa-list" aria-hidden="true"></i>
    {{trans('messages.list')}}
  </a>
</div>
@stop
@section('body')
  @include('pages.admin.billoflading.messages')
  @include('sections.messages')
  @include('pages.admin.billoflading.form', [
    'path' => "/admin/pickup/newbill"
  ])
@stop
