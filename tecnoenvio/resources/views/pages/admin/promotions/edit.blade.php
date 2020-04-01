@set('js', ['js/includes/promotionsCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('promotion.edit'))
@section('title', trans((!$readonly) ? 'promotion.edit' : 'promotion.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$promotions->toInnerJson()}}">
    <a href="{{asset('admin/promotions')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('promotion.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="promotionsDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.promotions.messages')
  @include('sections.messages')
<div class="panel panel-default">
  <div class="panel-body">
  @include('pages.admin.promotions.form', [
    'path' => "/admin/promotions/{$promotions->id}"
  ])
  </div>
</div>
@stop
