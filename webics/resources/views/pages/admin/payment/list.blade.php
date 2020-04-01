@set('js', ['src/js/payment.js'])
@section('title-page', trans('payment.payments'))
@section('admin-page-title', trans('payment.payments'))
@extends('layouts.main.master')
@section('admin-actions')

@stop
@section('admin-body')
  @include('sections.messages')
  @if ($payments->count() == 0)
    @include('sections.no-rows')
  @else
    @include('pages.admin.payment.messages')
    <table class="table table-striped table-hover table-responsive" name="icstable" id="icstable">
      <thead>
        <tr>
          <th style="text-align: center">{{trans('payment.code')}}</th>
          <th style="text-align: center">{{trans('payment.status')}}</th>
          <th style="text-align: center">{{trans('payment.type')}}</th>
          <th style="text-align: center">{{trans('payment.client')}}</th>
          <th style="text-align: center">{{trans('payment.concept')}}</th>
          <th style="text-align: center">{{trans('payment.years')}}</th>
          <th style="text-align: center">{{trans('messages.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payments as $key => $value)
          <tr item="{{$value->toJson()}}">
            <td style="text-align: center">
              <a class="icslinkdetails" onclick="icsDetails({{$value->id}}, false)">{{$value->code}}</a>
            </td>
            <td style="text-align: center">
              <span class="label @if($value->status == App\Helpers\HPayment::HOLD) label-default @elseif($value->status == App\Helpers\HPayment::DENIED) label-danger @else label-success @endif">
                @if($value->status == App\Helpers\HPayment::HOLD) {{trans('payment.hold')}} @endif
                @if($value->status == App\Helpers\HPayment::DENIED) {{trans('payment.denied')}} @endif
                @if($value->status == App\Helpers\HPayment::APROVED) {{trans('payment.aproved')}} @endif
              </span>
            </td>
            <td style="text-align: center">{{$value->type}}</td>
            <td style="text-align: center">{{isset($value->getSolicitude->getClient) ? $value->getSolicitude->getClient->email : trans('messages.unknown')}}</td>
            <td style="text-align: center">{{$value->concept}}</td>
            <td style="text-align: center">{{$value->years}}</td>
            <td style="text-align: center">
              <ul class="table-actions">
                <li><a onclick="paymentDelete($(this))" ><i class="fa fa-times"  title="{{trans('messages.delete')}}"></i></a></li>
                <li><a href="{{asset("admin/payments/{$value->id}")}}/mail"><i class="fa fa-envelope-o" aria-hidden="true" title="{{trans('messages.email')}}"></i></a></li>
                @if($value->status == App\Helpers\HPayment::APROVED)
                <li><a target="_blank" href="{{asset("admin/payments/{$value->id}")}}/invoice"><i class="fa fa-file-pdf-o" aria-hidden="true" title="{{trans('messages.invoice')}}"></i></a></li>
                @endif
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@stop
