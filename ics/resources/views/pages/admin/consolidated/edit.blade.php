@set('js', ['js/includes/consolidatedCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('consolidated.edit'))
@section('title', trans((!$readonly) ? 'consolidated.edit' : 'consolidated.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$consolidated->toInnerJson()}}">
    <a href="{{asset('admin/consolidated')}}" class="btn btn-default" title="{{trans('consolidated.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="consolidatedDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.consolidated.messages')
  @include('sections.messages')
  @include('pages.admin.consolidated.form', [
    'path' => "/admin/consolidated/{$consolidated->id}"
  ])
@stop
@section('onready')
  $('#divTracking,#packageTitle, #divPackageObservation, #divStatus, #tableHeader').attr('style', '{{is_null($consolidated->id) ? 'display:none' : 'display:block'}}');
  @if($consolidated->status == 1)
    $('#tracking, #packageObservation,#divButton, #button, #observation, #status').attr('disabled', false);
  @else
    $('#tracking, #packageObservation, #divButton, #button, #observation').attr('disabled', true);
  @endif
@stop
