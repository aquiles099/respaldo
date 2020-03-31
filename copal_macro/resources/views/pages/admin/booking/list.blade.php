<?php
  /**
  * Retorna la suma del volumen maritimo de cada uno de los items de un booking
  */
  function getMaritimeVolume($id) {
    $maritime_volume = DB::table('booking_detail')->where('booking','=',$id)->sum('maritime_volume');
    return $maritime_volume;
  }
  /**
  * Retorna la suma del volumen aereo de cada uno de los items de un booking
  */
  function getAerialVolume($id) {
    $aerial_volume = DB::table('booking_detail')->where('booking','=',$id)->sum('aerial_volume');
    return $aerial_volume;
  }
?>
@set('js', ['src/js/bookingCtrl.js'])
@section('pageTitle', trans('booking.list'))
@section('title', trans('booking.list'))
@extends('pages.page')
@section('title-actions')
<a href="{{asset('admin/bookings/new')}}" onclick="javasctipt:loadButton(this)" class="btn btn-primary" data-toggle ="tooltip" title="{{trans('booking.createBooking')}}">
  <i class="fa fa-plus" aria-hidden="true"></i>
  {{trans('messages.create')}}
</a>
@stop
@section('body')
  @include('pages.admin.booking.messages')
  @include('sections.messages')
  <div class="panel panel-default" id = "pnlin">
    <div class="panel-body">
      <table class="table table-striped table-hover table-responsive" id="dtble">
        <thead>
          <th>{{trans('booking.status')}}</th>
          <th>{{trans('booking.code')}}</th>
          <th>{{trans('booking.stimatedDeparture')}}</th>
          <th>{{trans('booking.stimatedArrive')}}</th>
          <th>{{trans('booking.originPort')}}</th>
          <th>{{trans('booking.destinationPort')}}</th>
          <th>{{trans('booking.maritimeVolume')}}</th>
          <th>{{trans('booking.aerialVolume')}}</th>
          <th>{{trans('booking.actions')}}</th>
        </thead>
          <tbody>
          @if(isset($booking))
            @foreach($booking as $key => $value)
              <tr class="text-center" item="{{$value->toInnerJson()}}">
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
                <td><a class="infoRd" href="javascript:icsShowDetailsOfBooking('{{$value->id}}', false)">{{$value->code}}</a></td>
                <td>{{$value->since_departure_date}}</td>
                <td>{{$value->until_departure_date}}</td>
                <td>{{$value->getFromCountry->name}}</td>
                <td>{{$value->getToCountry->name}}</td>
                <td>{{getMaritimeVolume($value->id)}}</td>
                <td>{{getAerialVolume($value->id)}}</td>
                <td>
                  <ul class="table-actions">
                    <li><a href="{{asset("/admin/bookings/{$value->id}")}}"><i class="fa fa-pencil" title="{{trans('messages.edit')}}"></i></a></li>
                    <li><a onclick="icsBookingDelete($(this))" ><i class="fa fa-trash-o"  title="{{trans('messages.delete')}}"></i></a></li>
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
