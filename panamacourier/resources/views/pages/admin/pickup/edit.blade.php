@set('only')
<?php
use App\Helpers\HUserType;
  if (Session::get('key-sesion')['type'] == HUserType::OPERATOR) {
    unset($only);
  }
?>
@set('js', [Session::get('key-sesion')['type'] == HUserType::OPERATOR ? 'js/includes/pickupCtrl.js' : 'dist/js/pickupClientCtrl.js' ])
@include('sections.translate')
@section('pageTitle', trans('pickup.edit'))
@if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
  @section('icon-title')
    <i aria-hidden="true" class="fa fa-truck"></i>
  @stop
@endif
@section('title', trans((!$readonly) ? 'pickup.edit' : 'pickup.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$numberparts}}">
    <a href="{{Session::get('key-sesion')['type'] == HUserType::OPERATOR ? asset('admin/pickup') : asset('account/prealert')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('containers.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(Session::get('key-sesion')['type'] == HUserType::OPERATOR)
      @if(!isset($readonly) || !$readonly)
        <a onclick="pickupDelete({{$pickup->id}}, false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
          <i class="fa fa-times" aria-hidden="true"></i>
          {{trans('messages.delete')}}
        </a>
      @endif
    @endif
  </div>
@stop
@section('body')
  <script type="text/javascript">
  $(document).ready( function() {
    icsLoadTabsAndData();
  });
  </script>
  @include('pages.admin.pickup.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.pickup.form', [
        'path' => Session::get('key-sesion')['type'] == HUserType::OPERATOR ? "/admin/pickup/{$pickup->id}" : "/account/prealert/{$pickup->id}"
      ])
    </div>
  </div>
@stop
