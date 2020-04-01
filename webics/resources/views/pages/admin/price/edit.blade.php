@set('js', ['src/js/price.js'])
@section('title-page', trans('prices.editprices'))
@section('admin-page-title', trans('prices.editprices'))
@extends('layouts.main.master')
@section('admin-actions')
<a href="{{asset('admin/prices')}}" class="btn btn-primary" title="{{trans('prices.prices')}}">
  <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
  {{trans('prices.prices')}}
</a>
@stop
@section('admin-body')
  @if ($prices->count() == 0)
    @include('sections.no-rows')
  @else
  @include('sections.messages')
  @include('pages.admin.price.messages')
  @include('pages.admin.price.form', [
    'path' => 'admin/prices/edit'
  ])
  @endif
@stop
