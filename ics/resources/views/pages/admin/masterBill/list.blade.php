@set('js', ['js/includes/cargoReleaseCtrl.js'])
@include('sections.translate')
@section('pageTitle', trans('cargoRelease.list'))
@section('title', trans('cargoRelease.list'))
@extends('pages.page')
@section('title-actions')
{{--
<div class="dropdown">
  <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
    <span class="text-muted">
      <i class="fa fa-eye" aria-hidden="true"></i>
      <span class="" id="ics_option_load"></span>
      {{trans('invoice.showReceipt')}} |
      <span id="ics_selected_option"></span>
      <span class="caret"></span>
    </span>
  </button>
  <ul class="dropdown-menu" id="">
    <li class="dropdown-header">{{trans('messages.show')}}</li>
    <li class="divider"></li>
    <li><a href="javascript:alert('inProcess 1')">{{trans('cargoRelease.all')}}</a></li>
    <li><a href="javascript:alert('inProcess 2')">{{trans('cargoRelease.WarehouseReceipts')}}</a></li>
    <li><a href="javascript:alert('inProcess 3')">{{trans('cargoRelease.PickupOrders')}}</a></li>
    <li><a href="javascript:alert('inProcess 4')">{{trans('cargoRelease.NumbersOfParts')}}</a></li>
  </ul>
</div>
--}}
<a href="{{asset('admin/cargoRelease/1/new')}}" class="btn btn-primary" data-toggle ="tooltip" title="{{trans('cargoRelease.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
@include('pages.admin.cargoRelease.messages')
@include('sections.messages')
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-striped table-hover table-bordeared table-responsive text-center" id="dtble">
        <thead>
          <th>{{trans('cargoRelease.status')}}</th>
          <th>{{trans('cargoRelease.code')}}</th>
          <th>{{trans('cargoRelease.releaseDate')}}</th>
          <th>{{trans('cargoRelease.releaseTime')}}</th>
          <th>{{trans('cargoRelease.releaseTo')}}</th>
          <th>{{trans('cargoRelease.pieces')}}</th>
          <th>{{trans('cargoRelease.weight')}}</th>
          <th>{{trans('cargoRelease.volume')}}</th>
          <th>{{trans('cargoRelease.actions')}}</th>
        </thead>
        <tbody>
          @foreach($cargo_release as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td>
                @if($value->last_event == '1')
                  <span class="label label-default">{{$value->getLastEvent->description}}</span>
                @elseif($value->last_event == '2')
                  <span class="label label-primary">{{$value->getLastEvent->description}}</span>
                @elseif($value->last_event == '3')
                  <span class="label label-info">{{$value->getLastEvent->description}}</span>
                @elseif($value->last_event == '4')
                  <span class="label label-info">{{$value->getLastEvent->description}}</span>
                @elseif($value->last_event == '5')
                  <span class="label label-warning">{{$value->getLastEvent->description}}</span>
                @elseif($value->last_event == '6')
                  <span class="label label-success">{{$value->getLastEvent->description}}</span>
                @endif
              </td>
              <td><a href="javascript:icsGetDetailCargoRelease({{$value->id}})" class="infoRd">{{$value->code}}</a></td>
              <td>{{$value->release_date}}</td>
              <td>{{$value->release_time}}</td>
              <td><a href="javascript:icsShowCargoContaInfo({{$value->getUser->id}})" class="infoRd">{{$value->contact_name}}</a></td>
              <td>{{$value->getCargoCount()}}</td>
              <td>{{0000}}</td>
              <td>{{0000}}</td>
              <td>
                <ul class="table-actions">
                  <li><a href=""><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a onclick="cargoReleaseDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="" ><i class="fa fa-file-pdf-o" title="{{trans('invoice.acrobat')}}"></i></a></li>
                  <li><a href="" ><i class="fa fa-file-pdf-o" title="{{trans('invoice.acrobat')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
