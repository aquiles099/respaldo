@set('js', ['js/includes/clientCtrl.js'])
@section('pageTitle', trans('client.create'))
@section('title', trans('client.create'))
@extends('pages.page')
@include('sections.translate')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset("admin/company/$company->id")}}/clients" class="btn btn-primary" title="{{trans('client.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.client.messages')
  @include('sections.messages')
  @include('pages.admin.client.form', [
    'path' => "/admin/company/{$company->id}/clients/new"
  ])
@stop
