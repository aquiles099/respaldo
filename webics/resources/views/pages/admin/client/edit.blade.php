@set('js', ['src/js/client.js'])
@section('title-page', trans('client.edit'))
@section('admin-page-title', trans('client.edit'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/clients')}}" class="btn btn-primary" title="{{trans('client.list')}}">
  <i class="fa fa-list fa-fw" aria-hidden="true"></i>
  {{trans('client.list')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @include('pages.admin.client.form',[
    'path' => "admin/clients/{$client->id}"
  ])
@stop
