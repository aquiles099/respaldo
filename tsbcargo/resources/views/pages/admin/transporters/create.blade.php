@set('js', ['js/includes/transportersCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('transporters.transportersCreate'))
@section('title', trans('transporters.transportersCreate'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/transporters')}}" onclick="loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('transporters.List')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('transporters.List')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.transporters.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.transporters.form',
      [
        'path' => '/admin/transporters/new'
      ])
    </div>
  </div>
@stop
