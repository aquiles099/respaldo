@set('js', ['js/includes/promotionsCtrl.js'])
@section('pageTitle', trans('promotion.create'))
@section('title', trans('promotion.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/promotions')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('promotion.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.promotions.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.promotions.form', [
    'path' => '/admin/promotions/new'
  ])
  </div>
</div>
@stop
