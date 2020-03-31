@set('js', ['js/includes/companyCtrl.js'])
@section('pageTitle', trans('company.edit'))
@section('title', trans((!$readonly) ? 'company.edit' : 'company.view'))
@extends('pages.page')
@include('sections.translate')
@section('title-actions')
  <div class="btn-group" role="group" item="{{$company->toInnerJson()}}">
    <a href="{{asset('admin/company')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('company.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="companyDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
    <a href="{{asset("admin/company/{$company->id}/clients")}}" class="btn btn-default" title="{{trans('company.clients')}}">
      <i class="fa fa-users" aria-hidden="true"></i>
      {{trans('messages.clients')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.company.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.company.form', [
        'path' => "/admin/company/{$company->id}"
      ])
    </div>
  </div>
@stop
