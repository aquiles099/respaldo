@set('js', ['js/includes/suppliersCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('suppliers.list'))
@section('title', trans('suppliers.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/suppliers/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('service.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.suppliers.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble_suppliers">
        <thead>
          <tr>
            <th style="width:20%">{{trans('messages.code')}}</th>
            <th style="width:20%">{{trans('messages.name')}}</th>
            <th style="width:20%">{{trans('messages.identification')}}</th>
            <th style="width:20%">{{trans('messages.phone')}}($)</th>
            <th style="width:20%">{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($suppliers as $value)
            <tr item="{{$value}}">
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{ucwords($value->name)}}</td>
              <td>{{$value->identification}}</td>
              <td>{{$value->phone}}</td>
              <td>
                <ul class="table-actions" style="margin-left: 16%;">
                  <li><a onclick="supplierDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
