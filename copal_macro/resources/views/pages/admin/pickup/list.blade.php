@set('js', ['js/includes/pickupCtrl.js'])
@section('pageTitle', trans('pickup.list'))
@section('title', trans('pickup.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<a href="{{asset('admin/pickup/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('pickup.create')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.pickup.messages')
  @include('sections.messages')
  <div class="panel panel-default showpack" id = "pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover table-responsive text-center" id="dtble">
      <thead>
        <tr>
           <th>{{trans('messages.estatus')}}</th>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.shipper')}}</th>
            <th>{{trans('messages.consigne')}}</th>
            <th>{{trans('messages.invoice')}}</th>
            <th>{{trans('messages.date')}}</th>
            <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody class="">
        @if(isset($pickup))
          @foreach($pickup as $key => $value)
            <tr item="{{$value}}">
               <td>
              @if($value->last_event == '1')
                <span class="label label-default">{{$value->getLastEvent['name']}}</span>
              @elseif($value->last_event == '2')
                <span class="label label-primary">{{$value->getLastEvent['name']}}</span>
              @elseif($value->last_event == '3')
                <span class="label label-info">{{$value->getLastEvent['name']}}</span>
              @elseif($value->last_event == '4')
                <span class="label label-info">{{$value->getLastEvent['name']}}</span>
              @elseif($value->last_event == '5')
                <span class="label label-warning">{{$value->getLastEvent['name']}}</span>
              @elseif($value->last_event == '6')
                <span class="label label-success">{{$value->getLastEvent['name']}}</span>
              @endif
              </td>
              <td><a class="infoRd" href="javascript:detailspickup({{$value->id}}, 'true')">{{$value->code}}</a></td>

              <td>{{(isset($value->to_client) ? $value->getToClient['code'] : $value->getToUser['code'])}} {{(isset($value->to_client) ? ucwords($value->getToClient['name'])." ".ucwords($value->getToClient['last_name']) : ucwords($value->getToUser['name'])." ".ucwords($value->getToUser['last_name']))}}</td>

              <td>{{(isset($value->to_client) ? $value->getToClient['code'] : $value->getToUser['code'])}} {{(isset($value->to_client) ? ucwords($value->getToClient['name'])." ".ucwords($value->getToClient['last_name']) : ucwords($value->getToUser['name'])." ".ucwords($value->getToUser['last_name']))}}</td>
              <td>@if($value->invoice == 0) <a href="javascript:upload({{$value->id}})"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: orange"></i></a>@else<i class="fa fa-check" aria-hidden="true" style="color: green"></i>@endif</td>
              <td>{{$value->created_at->format('d-M-Y')}}</td>
              <td style="text-align:-webkit-center">
                <ul class="table-actions">
                  <li><a href="{{asset("/admin/pickup/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <!--<li><a href="{{asset("/admin/pickup/{$value->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>-->
                  <li><a onclick="pickupDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a>
                  <li><a onclick="pickupadd({{$value->id}})" ><i class="fa fa-cog"  title="{{trans('messages.addwr')}}"></i></a></li>
                  <!--<li><a href="" target="_blank"><i class="fa fa-file-pdf-o" title="{{trans('pickup.pdf')}}"></i></a></li>
                  <li><a href="javascript:billoflading({{$value->id}})"><i class="fa fa-file-pdf-o" title="{{trans('pickup.bill')}}"></i></a></li>-->
                  <li>
                      <div class="dropdown" >
                        <a class="dropdown-toggle" type="button" data-toggle="dropdown">
                          <span data-toggle="tooltip" title="{{trans('booking.reports')}}">
                            <i class="fa fa-file-pdf-o"  aria-hidden="true"></i>
                          </span>
                        </a>
                        <ul class="dropdown-menu ics_dropdown_menu_action" id="ics_unordenated_list">
                          <li class="dropdown-header" style="display:block">{{trans('booking.reports')}}</li>
                          <!--<li><a href="javascript:billoflading({{$value->id}})">{{trans('pickup.bill')}}</a></li>-->
                          <li><a href="{{asset("admin/receiptpickup/{$value->id}")}}" target="_blank">{{trans('pickup.pdf')}}</a></li>
                        </ul>
                      </div>

                  </li>
                </ul>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>
@stop
