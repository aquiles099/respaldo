@set('js', ['src/js/routeCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('route.edit'))
@section('title', trans((!$readonly) ? 'route.edit' : 'route.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$routes->toInnerJson()}}">
    <a href="{{asset('admin/routes')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('route.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="routesDelete($(this), false)" onclick="loadButton(this)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.route.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.route.form', [
        'path' => "/admin/routes/{$route->id}"
      ])
    </div>
  </div>
@stop
