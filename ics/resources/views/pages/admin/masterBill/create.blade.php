@set('js', ['js/includes/cargoReleaseCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('cargoRelease.cargoReleaseCreate'))
@section('title', trans('cargoRelease.cargoReleaseCreate'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/cargoRelease')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('cargoRelease.List')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('cargoRelease.List')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.cargoRelease.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.cargoRelease.form',
      [
        'path' => "/admin/cargoRelease/{$type}/new"
      ])
    </div>
  </div>
@stop
