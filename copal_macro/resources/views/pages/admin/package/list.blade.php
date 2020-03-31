@set('js', ['js/includes/packageCtrl.js'])
@section('pageTitle', trans('package.packageswr'))
@section('title', trans('package.packageswr'))
@extends('pages.page')
@section('title-actions')
<a id="createButton" href="{{asset('admin/packagecurriers/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle ="tooltip" title="{{trans('package.createPackage')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('pre-title')
@stop
@section('body')
  @include('pages.admin.package.messages')
  @include('sections.messages')
  <div class="panel panel-default showpack" id="pnlin">
    <div class="panel-body">
      <table class="table table-striped table-border table-hover text-center" id="dtble4" >
        <thead>
          <tr>
            <th>{{trans('messages.estatus')}}</th>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.destination')}}</th>
            <th>{{trans('messages.consigne')}}</th>
            <th>{{trans('messages.invoice')}}</th>
            <th>{{trans('messages.date')}}</th>
            <th>{{trans('messages.actions')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $row)
            <tr item="{{$row->toInnerJson()}}">
              <td>
              @if($row->last_event == '1')
                <span class="label label-default">{{$row->getLastEvent['name']}}</span>
              @elseif($row->last_event == '2')
                <span class="label label-primary">{{$row->getLastEvent['name']}}</span>
              @elseif($row->last_event == '3')
                <span class="label label-info">{{$row->getLastEvent['name']}}</span>
              @elseif($row->last_event == '4')
                <span class="label label-info">{{$row->getLastEvent['name']}}</span>
              @elseif($row->last_event == '5')
                <span class="label label-warning">{{$row->getLastEvent['name']}}</span>
              @elseif($row->last_event == '6')
                <span class="label label-success">{{$row->getLastEvent['name']}}</span>
              @endif
              </td>
              <td><a class="infoRd" href="javascript:detailspackage({{$row->id}}, 'true')">{{$row->code}}</a></td>
              <td>{{(isset($row->to_client) ? $row->getToClient['code'] : $row->getToUser['code'])}} {{(isset($row->to_client) ? ucwords($row->getToClient['name']." ".$row->getToClient['last_name']) : ucwords($row->getToUser['name']." ".$row->getToUser['last_name']))}}</td>
              <td>{{(isset($row->consigner_user) ? $row->getToConsigneUser['code'] : $row->getToConsigneUser['code'])}} {{(isset($row->consigner_user) ? ucwords($row->getToConsigneUser['name']." ".$row->getToConsigneUser['last_name']) : ucwords($row->getToConsigneUser['name'])." ".ucwords($row->getToConsigneUser['last_name']))}}</td>
              <td>@if($row->invoice == 0) <a href="javascript:upload({{$row->id}})"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: orange"></i></a>@else<i class="fa fa-check" aria-hidden="true" style="color: green"></i>@endif</td>
              <td>{{$row->created_at->format('d-M-Y h:m')}}</td>

              <td>
                <ul class="table-actions">
                  <li><a href="{{asset("admin/package/{$row->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li><a href="{{asset("admin/package/{$row->id}")}}/print" target="_blank"><i class="fa fa-ticket" title="{{trans('messages.tickets')}}" ></i></a></li>
                  <li><a target="_blank" href="javascript:detailsreceipt({{$row->id}})" ><i class="fa fa-list" title="{{trans('messages.details')}}" ></i></a></li>
                  <li><a target="_blank" href="javascript:icsPrint({{$row->id}})" ><i class="fa fa-print" title="{{trans('print.print')}}" ></i></a></li>
                  <li>
                      <div class="dropdown" >
                        <a class="dropdown-toggle" type="button" data-toggle="dropdown">
                          <span data-toggle="tooltip" title="{{trans('booking.reports')}}">
                            <i class="fa fa-file-pdf-o"  aria-hidden="true"></i>
                          </span>
                        </a>
                        <ul class="dropdown-menu ics_dropdown_menu_action" id="ics_unordenated_list">
                          <li class="dropdown-header" style="display:block">{{trans('booking.reports')}}</li>
                          <li><a  href="javascript:billoflading({{$row->id}})" target="_blank" >{{trans('package.bill')}}</a></li>
                          <li><a href="{{asset("admin/billingid/{$row->id}")}}" target="_blank">{{trans('package.warereport')}}</a></li>
                          <li><a href="{{asset("admin/invoice/{$row->id}/warehouse")}}" target="_blank">{{trans('package.invoice')}}</a></li>
                        </ul>
                      </div>
                  </li>
                  <!--<li><a href="{{asset("admin/billingid/{$row->id}")}}" target="_blank"><i class="fa fa-file-pdf-o" title="{{trans('invoice.acrobat')}}"></i></a></li>-->
                  <li><a onclick="packageDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
                </ul>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop
