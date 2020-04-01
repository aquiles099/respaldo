@set('js', ['js/includes/packageCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('showpackage.title'))
@section('title', trans('showpackage.title'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<div class="btn-group" role="group">
  <a href="{{asset('admin/package')}}" class="btn btn-primary" title="{{trans('package.list')}}">
    <i class="fa fa-list" aria-hidden="true"></i>
    {{trans('messages.list')}}
  </a>
</div>
@stop
@section('body')
  @include('pages.admin.showpackage.messages')
  @include('sections.messages')
  @include('pages.admin.showpackage.form', [
    'path' => "/admin/showpackage/{$package->id}"
  ])
@stop
