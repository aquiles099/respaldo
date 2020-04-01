<?php
use App\Helpers\HUserType;
?>
@include('sections.translate')

@if(isset($removable) && $removable == false)
  @set('only')
@endif
<?php
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@if(isset($removable) && $removable == false)
  @set('js', ['js/includes/resellerCtrl.js'])
  @set('js', ['js/includes/prealertCtrl.js'])
  @section('pageTitle', trans('prealert.edit'))
@else
  @section('pageTitle', trans('prealert.edition'))
  @set('js', ['js/includes/prealertCtrl.js'])
@endif
@section('icon-title')
  @if(isset($removable) && $removable == false)
  <i aria-hidden="true" class="fa fa-flag"></i>
  @endif
@stop
@if(isset($removable) && $removable == false)
  @section('title', trans('prealert.edit'))
@else
  @section('title', trans('prealert.edition'))
@endif
@extends('pages.page')
@section('title-actions')
<a onclick="loadButton(this)" @if(isset($removable) && $removable == false) href="{{asset('account/prealert')}}" @else href="{{asset('admin/package/prealert')}}" @endif class="btn btn-primary" data-toggle="tooltip" title="{{trans('messages.listprealert')}}">
  <i class="fa fa-list" aria-hidden="true"></i>
  {{trans('messages.list')}}
</a>
@stop
@section('body')
  @include('sections.messages')
  <div class="panel panel-default">
    @if(isset($removable) && $removable == false)
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i class="fa fa-flag" aria-hidden="true"></i>
        {{trans('prealert.edit')}}
      </span>
    </div>
    @endif
    <div class="panel-body">
      @include('pages.user.prealert.form',[
        'path' => isset($removable) && $removable == false ? "/account/prealert/{$prealert->id}" : "/admin/package/prealert/{$prealert->id}"
      ])
    </div>
  </div>
@stop
