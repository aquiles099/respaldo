@set('js', ['js/includes/storeCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('store.list'))
@section('title', trans('store.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/store/new')}}" class="btn btn-primary" data-toggle="tooltip" title="{{trans('store.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.store.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover" id="dtble_serv">
        <thead>
          <tr>
            <th style="text-align: center">{{trans('messages.code')}}</th>
            <th style="text-align: center">{{trans('store.name')}}</th>
            <th style="text-align: center">{{trans('store.created_at')}}</th>
            <th style="text-align: center">{{trans('store.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($stores as $store)
            <tr item="{{$store->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:details({{$store->id}})">{{$store->code}}</a></td>
              <td>{{$store->name}}</td>
              <td>{{$store->created_at->format('Y-m-d')}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icsStoreDelete($(this))"><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
