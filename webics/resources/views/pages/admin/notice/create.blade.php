@set('js', ['src/js/notice.js'])
@section('title-page', trans('notice.newnotice'))
@section('admin-page-title', trans('notice.newnotice'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/notices')}}" class="btn btn-primary" title="{{trans('notice.list')}}">
  <i class="fa fa-list fa-fw" aria-hidden="true"></i>
  {{trans('notice.list')}}
</a>
@stop
@section('admin-body')
  @include('pages.admin.notice.form', [
    'path' => 'admin/notices/new'
  ])
@stop
