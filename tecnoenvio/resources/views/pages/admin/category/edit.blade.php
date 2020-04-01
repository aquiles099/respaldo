@set('js', ['js/includes/categoryCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('category.edit'))
@section('title', trans((!$readonly) ? 'category.edit' : 'category.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$category->toInnerJson()}}">
    <a href="{{asset('admin/category')}}" onclick="loadButton(this)" class="btn btn-default" title="{{trans('category.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="categoryDelete($(this), false)" class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.category.messages')
  @include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      @include('pages.admin.category.form', [
        'path' => "/admin/category/{$category->id}"
      ])
    </div>
  </div>
@stop
