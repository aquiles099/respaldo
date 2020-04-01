@set('js', ['js/includes/categoryCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('category.create'))
@section('title', trans('category.create'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group">
    <a href="{{asset('admin/category')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('category.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
  </div>
@stop
@section('body')
  @include('pages.admin.category.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.category.form', [
        'path' => '/admin/category/new'
      ])
    </div>
  </div>
@stop
