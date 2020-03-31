@set('js', ['js/includes/profileCtrl.js'])
@section('pageTitle', trans('profile.create'))
@section('title', trans('profile.create'))
@extends('pages.page')
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/security/profile')}}" class="btn btn-default" title="{{trans('profile.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.security.profile.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.security.profile.form', [
        'path' => '/admin/security/profile/new'
      ])
    </div>
  </div>
@stop
