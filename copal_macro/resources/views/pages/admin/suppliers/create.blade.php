@set('js', ['js/includes/suppliersCtrl.js'])
@section('pageTitle', trans('suppliers.create'))
@section('title', trans('suppliers.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/suppliers')}}" onclick="loadButton(this)"  class="btn btn-default" title="{{trans('office.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.suppliers.messages')
  @include('sections.messages')
  @include('pages.admin.suppliers.form', [
    'path' => '/admin/suppliers/new'
  ])
@stop
