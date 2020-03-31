<?php
use App\Helpers\HUserType;
?>
@set('only')
<?php
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@section('pageTitle', trans('messages.newprealert'))
@section('icon-title')
  <i aria-hidden="true" class="fa fa-flag"></i>
@stop
@section('title', trans('messages.newprealert'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('account/prealert')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('messages.listprealert')}}">
  <i class="fa fa-list" aria-hidden="true"></i>
  {{trans('messages.list')}}
</a>
@stop
@section('body')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-heading text-center">
      <span class="text-muted">
        <i class="fa fa-flag" aria-hidden="true"></i>
        {{trans('messages.newprealert')}}
      </span>
    </div>
    <div class="panel-body">
      @include('pages.user.prealert.form',[
        'path' => '/account/prealert/new'
      ])
    </div>
  </div>
@stop
