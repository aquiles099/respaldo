@set('js', ['js/includes/pickupCtrl.js'])
@section('pageTitle', trans('pickup.edit'))
@section('title', trans((!$readonly) ? 'pickup.edit' : 'pickup.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$numberparts}}">
    <a href="{{asset('admin/pickup')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('containers.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="numberpartDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop


@section('body')
  <script type="text/javascript">
  $(document).ready( function()
  {
    icsLoadTabsAndData('{{$pickup->id}}');
  });
  </script>
  @include('pages.admin.pickup.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.pickup.form',
      [
        'path' => "/admin/pickup/{$pickup->id}"
      ])
    </div>
  </div>
@stop
