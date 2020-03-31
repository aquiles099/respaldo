@set('js', ['js/includes/pickupCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('pickup.create'))
@section('title', trans('pickup.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/pickup')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('pickup.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.numberparts.messages')
  @include('sections.messages')
    <div class="panel-body">
      @include('pages.admin.pickup.form', [
        'path' => '/admin/pickup/new'
      ])
    </div>

@stop
