@set('js', ['js/includes/countryCtrl.js'])
@section('pageTitle', trans('country.create'))
@section('title', trans('country.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/country')}}" class="btn btn-default" title="{{trans('country.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.country.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.country.form', [
        'path' => '/admin/country/new'
      ])
    </div>
  </div>
@stop
