@set('js', ['js/includes/packagecurriersCtrl.js'])
@section('pageTitle', trans('package.edit'))
@section('title', trans('package.edit'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$package->toInnerJson()}}">
    <a id="listwhr" href="{{asset('admin/package')}}" onclick="javascript:loadButton(this)" class="btn btn-default" title="{{trans('package.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a id="deletewhr" onclick="packageDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
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
    icsLoadTabsAndData('{{$package->id}}');
  });
  </script>
  @include('pages.admin.package.messages')
  @include('sections.messages')
  @include('pages.admin.packagecurriers.form', [
    'path' => "/admin/package/{$package->id}"
  ])
@stop
