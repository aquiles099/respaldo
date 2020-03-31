@set('js', ['js/includes/prealertCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('prealert.list'))
@section('title', trans('prealert.list'))
@extends('pages.page')
@section('title-actions')
@stop
@section('pre-title')
@stop
@section('body')
  @include('pages.admin.package.prealert.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-border table-hover" id="dtble" >
        <thead>
          <tr>
            <th class="text-center">{{trans('prealert.code')}}</th>
            <th class="text-center">{{trans('prealert.user')}}</th>
            <th class="text-center">{{trans('prealert.service_order')}}</th>
            <th class="text-center">{{trans('prealert.package')}}</th>
            <th class="text-center">{{trans('prealert.date_arrived')}}</th>
            <th class="text-center">{{trans('prealert.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($prealerts as $key => $prealert)
            <tr item="{{$prealert->toInnerJson()}}">
              <td><a class="infoRd" href="javascript:icsViewPrelert({{$prealert->id}})">{{$prealert->code}}</a></td>
              <td>{{$prealert->getUser->code}} {{$prealert->getUser->name}} {{$prealert->getUSer->last_name}}</td>
              <td>{{isset($prealert->order_service) ? $prealert->order_service : trans('prealert.unknown')}}</td>
              <td>@if(isset($prealert->getPackage)) <a class="infoRd" href="javascript:icsDetailsPackage({{$prealert->getPackage->id}}, false)">{{$prealert->getPackage->code}}</a> @else {{trans('prealert.unknown')}} @endif</td>
              <td>
                <span @if($prealert->date_arrived == date('Y-m-d')) class="label label-success" style="font-size: 13px" @endif>
                  {{$prealert->date_arrived}}
                </span>
              </td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icsPrealertDelete($(this))" ><i class="fa fa-trash"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/prealert/{$prealert->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
