@set('js', ['src/js/notice.js'])
@section('title-page', trans('solicitude.newsolicitude'))
@section('admin-page-title', trans('solicitude.newsolicitude'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/solicitudes')}}" class="btn btn-primary" title="{{trans('solicitude.list')}}">
  <i class="fa fa-list fa-fw" aria-hidden="true"></i>
  {{trans('solicitude.list')}}
</a>
@stop
@section('admin-body')
  @include('pages.admin.solicitude.form', [
    'path' => 'admin/solicitudes/new'
  ])
@stop
