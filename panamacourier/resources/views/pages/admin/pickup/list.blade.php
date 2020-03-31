@set('only')
<?php
use App\Helpers\HUserType;
use App\Models\Admin\User;
  if (Session::get('key-sesion')['type'] == HUserType::OPERATOR) {
    unset($only);
  }
?>
@set('js', [Session::get('key-sesion')['type'] == HUserType::OPERATOR ? 'js/includes/pickupCtrl.js' : 'dist/js/pickupClientCtrl.js' ])
@include('sections.translate')
@section('pageTitle', trans('pickup.list'))
@if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
  @section('icon-title')
    <i aria-hidden="true" class="fa fa-truck"></i>
  @stop
@endif
@section('title', trans('pickup.list'))
@extends('pages.page')
@section('pre-title')
@stop
@section('title-actions')
<div class="btn-group" role="group">
    <a href="{{Session::get('key-sesion')['type'] == HUserType::OPERATOR ? asset('admin/pickup/new') : asset('account/prealert/new')}}" onclick="javascript:loadButton(this)" class="btn btn-primary" data-toggle="tooltip" title="{{trans('pickup.create')}}">
      <i class="fa fa-plus" aria-hidden="true"></i>
      {{trans('messages.create')}}
    </a>
  @if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
    <a href="{{isset($filter) ? asset('account/prealert') : '#section' }}" class="btn btn-primary" @if(!isset($filter)) data-toggle="collapse" @endif>
      <span><i class="{{isset($filter) ? 'fa fa-list' : 'fa fa-filter' }}"></i></span>
      {{isset($filter) ? trans('messages.list') : trans('messages.filter')}}
    </a>
  @endif
</div>
@stop
@section('body')
  {{-- Mensajes JavaScript --}}
  @include('pages.admin.pickup.messages')
  {{-- Formularo de Filtrado --}}
  @include('pages.user.filter', [
    'path'  => 'account/prealert'
  ])
  {{-- Mensaje de Session --}}
  @include('sections.messages')
  <div class="panel panel-default showpack" id="pnlin">
  <div class="panel-body">
    <table class="table table-striped table-hover table-responsive text-center" id="dtble">
      <thead>
        <tr>
            @if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
             <th>Item</th>
            @endif
           <th>{{trans('messages.estatus')}}</th>
            <th>{{trans('messages.code')}}</th>
            <th>{{trans('messages.shipper')}}</th>
            <th>{{trans('messages.consigne')}}</th>
            <th>{{trans('messages.date')}}</th>
            <th>{{trans('messages.price')}}</th>
            <th>{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody class="">
        @if(isset($pickup))
          @foreach($pickup as $key => $value)
            <tr item="{{$value}}">
              @if(Session::get('key-sesion')['type'] == HUserType::NATURAL_PERSON)
              <td> {{$key + 1}}</td>
              @endif
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
              <?php if ($value->consigner_user) {
                # code...
                $user = User::find($value->consigner_user);
              }?>
              <td>{{(isset($user) ? ucwords($user->name).' '.ucwords($user->last_name) : 'nada')}}</td>

              <td>{{(isset($value->to_user)&&($value->to_user != 0) ? $value->getToClient['code'] : $value->destin_name)}} {{(isset($value->to_client)&&($value->to_client != 0) ? ucwords($value->getToClient['name'])." ".ucwords($value->getToClient['last_name']) : ucwords($value->getToUser['name'])." ".ucwords($value->getToUser['last_name']))}}</td>
              <!--<td>@if($value->invoice == 0) <a href="javascript:upload({{$value->id}})"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: orange"></i></a>@else<i class="fa fa-check" aria-hidden="true" style="color: green"></i>@endif</td>-->
              <td>{{$value->created_at->format('d-M-Y')}}</td>
              <td>{{(($value->price != '')&&($value->price)) ? $value->price.env('ICS_CURRENCY') : 'Por calcular'}}</td>
              <td style="text-align:-webkit-center">
                <ul class="table-actions">
                  <li><a href="{{Session::get('key-sesion')['type'] == HUserType::OPERATOR ? asset("/admin/pickup/{$value->id}") : asset("/account/prealert/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                  <li style={{(($value->price != '')&&($value->price)&&(Session::get('key-sesion')['type'] != HUserType::OPERATOR)) ? "" : "display:none !important;"}}>
                    <a href="{{Session::get('key-sesion')['type'] == HUserType::OPERATOR ? asset("/admin/pickup/{$value->id}") : "javascript:preparePayment($value->id)" }}"><i class="fa fa-paypal" title="Pay Now"></i></a></li>
                  <!--<li><a href="{{asset("/admin/pickup/{$value->id}")}}/read"><i class="fa fa-eye" title="{{trans('messages.details')}}"></i></a></li>-->
                  @if(Session::get('key-sesion')['type'] == HUserType::OPERATOR)
                  <li><a onclick="pickupDelete({{$value->id}})" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a>
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
                  @endif
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
