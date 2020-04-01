@set('js', ['src/js/bookingCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('booking.edit'))
@section('title', trans((!$readonly) ? 'booking.edit' : 'booking.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$booking->toInnerJson()}}">
    <a href="{{asset('admin/bookings')}}" onclick="javasctipt:loadButton(this)" class="btn btn-default" title="{{trans('booking.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="containerDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  <script type="text/javascript">
  $(document).ready( function() {
    icsLoadTabsAndData('{{$booking->id}}');
  });
  </script>
  @include('pages.admin.booking.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <!--form-->
      @include('pages.admin.booking.form',['path' => "/admin/bookings/{$booking->id}",'edit' => true])
      <!--Attachment-->
    </div>
  </div>
@stop
