@set('js', ['js/includes/companyCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('company.create'))
@section('title', trans('company.create'))
@extends('pages.page')
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/company')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('company.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.company.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.company.form', [
        'path' => '/admin/company/new'
      ])
    </div>
  </div>
@stop
