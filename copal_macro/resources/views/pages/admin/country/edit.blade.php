@set('js', ['js/includes/countryCtrl.js'])
@section('pageTitle', trans('country.edit'))
@section('title', trans((!$readonly) ? 'country.edit' : 'country.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$country->toInnerJson()}}">
    <a href="{{asset('admin/country')}}" class="btn btn-default" title="{{trans('country.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="countryDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
    <!--<a href="{{asset('admin/country')}}" class="btn btn-default" title="{{trans('country.clients')}}">
      <i class="fa fa-users" aria-hidden="true"></i>
      {{trans('messages.clients')}}
    </a> -->
  </div>
@stop
@section('body')
  @include('pages.admin.country.messages')
  @include('sections.messages')
  @include('pages.admin.country.form', [
    'path' => "/admin/country/{$country->id}"
  ])
@stop
