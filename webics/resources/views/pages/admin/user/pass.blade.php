@set('js', ['src/js/user.js'])
@section('title-page', trans('user.newuser'))
@section('admin-page-title', trans('user.newuser'))
@extends('layouts.main.master')
@section('admin-actions')
@stop
@section('admin-body')
  @include('pages.admin.user.pass-form',[
    'path' => '/change-password'
  ])
@stop
