@set('js', ['src/js/user.js'])
@section('title-page', trans('user.newuser'))
@section('admin-page-title', trans('user.newuser'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/users')}}" class="btn btn-primary" title="{{trans('user.list')}}">
  <i class="fa fa-list fa-fw" aria-hidden="true"></i>
  {{trans('user.listuser')}}
</a>
@stop
@section('admin-body')
  @include('pages.admin.user.form',[
    'path' => 'admin/users/new'
  ])
@stop
