@set('js', ['src/js/shipmentCtrl.js'])
@section('pageTitle', trans('shipment.shipments'))
@section('title', trans('shipment.shipments'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/shipments/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('shipment.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.shipment.messages')
  @include('sections.messages')
  <div class="panel panel-default" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive text-center" id="dtble3">
        <thead>
          <tr>
            <th>{{trans('shipment.status')}}</th>
            <th>{{trans('shipment.code')}}</th>
            <th>{{trans('shipment.type')}}</th>
            <th>{{trans('shipment.carrier')}}</th>
            <th>{{trans('shipment.reservation')}}</th>
            <th>{{trans('shipment.guide')}}</th>
            <th>{{trans('shipment.Shipper')}}</th>
            <th>{{trans('shipment.consigneer')}}</th>
            <th>{{trans('shipment.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($shipments as $key => $value)
            <tr item="{{$value->toInnerJson()}}">
              <td>
                @if($value->last_event == '1')
                  <span class="label label-default">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '2')
                  <span class="label label-primary">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '3')
                  <span class="label label-info">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '4')
                  <span class="label label-info">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '5')
                  <span class="label label-warning">{{$value->getLastEvent->name}}</span>
                @elseif($value->last_event == '6')
                  <span class="label label-success">{{$value->getLastEvent->name}}</span>
                @endif
              </td>
              <td><a class="infoRd" href="javascript:details({{$value->id}})">{{$value->code}}</a></td>
              <td>{{isset($value->getTransport) ? ucwords($value->getTransport->spanish) : ''}}</td>
              <td>{{ucwords($value->getTransporter['name'])}}</td>
              <td>{{$value->number_reservation}}</td>
              <td>{{$value->number_guide}}</td>
              <td>{{isset($value->getShipper) ? $value->getShipper->code : ''}} {{isset($value->getShipper) ? ucwords($value->getShipper->name) : ''}}</td>
              <td>{{isset($value->getConsigner) ? $value->getConsigner->code : ''}} {{isset($value->getConsigner) ? ucwords($value->getConsigner->name) : ''}}</td>
              <td>
                <ul class="table-actions">
                  <li><a onclick="icsShipmentDelete($(this))"><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                  <li><a href="{{asset("admin/shipments/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                   <li>
                      <div class="dropdown" >
                        <a class="dropdown-toggle" type="button" data-toggle="dropdown">
                          <span data-toggle="tooltip" title="{{trans('shipment.reports')}}">
                            <i class="fa fa-file-pdf-o"  aria-hidden="true"></i>
                          </span>
                        </a>
                        <ul class="dropdown-menu ics_dropdown_menu_action" id="ics_unordenated_list">
                          <li class="dropdown-header" style="display:block">{{trans('shipment.reports')}}</li>
                          <li><a href="{{asset("admin/shipments/{$value->id}/masterbill")}}" target="_blank" >{{trans('shipment.masterbill')}}</a></li>
                          <li><a href="{{asset("admin/shipments/{$value->id}/cargomanifest")}}" target="_blank">{{trans('shipment.cargomanifest')}}</a></li>
                        </ul>
                      </div>
                  </li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
