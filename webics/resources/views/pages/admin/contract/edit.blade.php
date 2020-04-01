@set('js', ['src/js/contract.js'])
@section('title-page', trans('contract.edit'))
@section('admin-page-title', trans('contract.edit'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/contracts')}}" class="btn btn-primary" title="{{trans('client.list')}}">
  <i class="fa fa-list fa-fw" aria-hidden="true"></i>
  {{trans('client.list')}}
</a>
@stop
@section('admin-body')
  @include('sections.messages')
  @include('pages.admin.contract.form',[
    'path' => "admin/contracts/{$contract->id}"
  ])
@stop
