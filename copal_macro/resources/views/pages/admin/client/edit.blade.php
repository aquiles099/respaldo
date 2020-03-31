@set('js', ['js/includes/clientCtrl.js'])
@section('pageTitle', trans('client.edit'))
@section('title', trans((!$readonly) ? 'client.edit' : 'client.view'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
  <div class="btn-group" role="group" item="{{$client->toInnerJson()}}">
    <a href="{{asset("admin/company/$client->company")}}/clients" class="btn btn-default" title="{{trans('client.list')}}">
      <i class="fa fa-list" aria-hidden="true"></i>
      {{trans('messages.list')}}
    </a>
    @if(!isset($readonly) || !$readonly)
      <a onclick="clientDelete($(this), false)"  class="btn btn-default" title="{{trans('messages.delete')}}">
        <i class="fa fa-times" aria-hidden="true"></i>
        {{trans('messages.delete')}}
      </a>
    @endif
  </div>
@stop
@section('body')
  @include('pages.admin.client.messages')
  @include('sections.messages')
  @include('pages.admin.client.form', [
    'path' => "/admin/company/{$client->company}/clients/{$client->id}"
  ])
@stop
