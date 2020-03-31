@set('only')
<?php
use App\Helpers\HUserType;
  if ( Session::get('key-sesion')['type'] == HUserType::OPERATOR ) {
    unset( $only );
  }
?>
@set('js', [Session::get('key-sesion')['type'] == HUserType::OPERATOR ? 'js/includes/pickupCtrl.js' : 'dist/js/pickupClientCtrl.js' ])
@include('sections.translate')
@section('pageTitle', trans('pickup.create'))
  @if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
    @section('icon-title')
      <i aria-hidden="true" class="fa fa-truck"></i>
    @stop
  @endif
@section('title', trans('pickup.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{Session::get('key-sesion')['type'] == HUserType::OPERATOR ? asset('admin/pickup') : asset('account/prealert')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" title="{{trans('pickup.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.pickup.messages')
  @include('sections.messages')
    <div class="panel-body">
      @include('pages.admin.pickup.form', [
        'path' => Session::get('key-sesion')['type'] == HUserType::OPERATOR ? '/admin/pickup/new' : 'account/prealert/new'
      ])
    </div>
@stop
