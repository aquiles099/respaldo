@set('js', ['js/includes/profileCtrl.js'])
@section('pageTitle', trans('profile.edit'))
@section('title', trans((!$readonly) ? 'profile.edit' : 'profile.view'))
@extends('pages.page')
@section('title-actions')
  <div class="btn-group" profile="group" item="{{$profile->toInnerJson()}}">
    <a href="{{asset('admin/security/profile')}}" class="btn btn-default" title="{{trans('profile.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="profileDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.security.profile.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.security.profile.form', [
        'path' => "/admin/security/profile/{$profile->id}"
      ])
    </div>
  </div>
@stop
