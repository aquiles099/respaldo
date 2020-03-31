@set('js', ['js/includes/priceGroupCtrl.js'])
@section('pageTitle', trans('price_group.create'))
@section('title', trans('price_group.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/price_groups')}}" class="btn btn-default" title="{{trans('price_group.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.packages.price_group.messages')
  @include('sections.messages')
  @include('pages.admin.packages.price_group.form', [
    'path' => '/admin/price_group/new'
  ])
@stop
