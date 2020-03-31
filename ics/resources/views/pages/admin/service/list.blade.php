@set('js', ['js/includes/serviceCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('service.services'))
@section('title', trans('service.services'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/service/new')}}" onclick="loadButton(this)" class="btn btn-primary" title="{{trans('service.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.service.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover text-center" id="dtble_service">
        <thead>
          <tr>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.name')}}</th>
            <th>{{trans('messages.transport')}}</th>
            <th>{{trans('messages.description')}}</th>
            <th>{{trans('messages.value')}}($)</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($services as $service)
            <tr item="{{$service}}">
              <td><a class="infoRd" href="javascript:details({{$service->id}})">{{$service->code}}</a></td>
              <td>{{ucwords($service->name)}}</td>
              <td>{{ucwords($service->getTransport->spanish)}}</td>
              <td>{{ucwords($service->description)}}</td>
              <td>{{ucwords($service->value)}}</td>
              <td sty>
                <ul class="table-actions">
                  <li><a onclick="serviceDelete($(this))" ><i class="fa fa-trash-o" title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
