@set('js', ['js/includes/taxCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('tax.create'))
@section('title', trans('tax.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/tax')}}" class="btn btn-primary" title="{{trans('tax.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.tax.messages')
  @include('sections.messages')
 <div class="panel panel-default">
  <div class="panel-body">
 @include('pages.admin.tax.form', [
    'path' => '/admin/tax/new'
  ])
  </div>
</div>
@stop
