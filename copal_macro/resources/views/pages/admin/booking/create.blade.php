@set('js', ['src/js/bookingCtrl.js'])
@section('pageTitle', trans('booking.bookingCreate'))
@section('title', trans('booking.bookingCreate'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/bookings')}}" onclick="javasctipt:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('booking.List')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('booking.List')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.booking.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <!--form-->
      @include('pages.admin.booking.form',['path' => '/admin/bookings/new','edit' => false])
    </div>
  </div>
@stop
