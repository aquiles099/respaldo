@extends('layouts.email.master')
@section('mail-body')
<div class="">
  <!--Cliente-->
  <p>
    Estimado (a):
    <h2 style="text-transform: capitalize">{{$client->name}}</h2>
  </p>
  <!--Header-->
  <p style="text-align: justify">
    Su pago realizado en la fecha {{$payment->created_at->format('Y-m-d')}}
    ha sido {{$payment->status == App\Helpers\HPayment::DENIED ? 'NEGADO' : 'APROBADO,'}}
    @if ($payment->status == App\Helpers\HPayment::DENIED)
      @if (!is_null($payment->description))
        por el siguiente motivo: <strong>{{$payment->description}}</strong>,
      @endif
    @endif
    le recordamos que el detalle del mismo es el siguiente:
  </p>
  <!--Tiempo del contrato-->
  <p style="text-align: justify">
    <strong>{{trans('payment.contracttime')}}: </strong> {{$payment->years}} año/s
  </p>
  <!--Tipo de pago-->
  <p style="text-align: justify">
    <strong>{{trans('payment.paymenttype')}}: </strong> {{$payment->type}}
  </p>
  <!--Transaccion-->
  <p style="text-align: justify">
    <strong>{{trans('payment.transaction')}}: </strong> {{$payment->transaction}}
  </p>
  <!--Banco-->
  <p style="text-align: justify">
    <strong>{{trans('payment.bankname')}}: </strong> {{$payment->bank}}
  </p>
  <!--Monto-->
  <p style="text-align: justify">
    <strong>{{trans('payment.amount')}}: </strong> {{$payment->amount}} {{env('CURRENCY')}}
  </p>
  <!--Observacion [opcional]-->
  @if(isset($payment->observation))
  <p style="text-align: justify">
    <strong>{{trans('payment.observation')}}: </strong> {{$payment->observation}}
  </p>
  @endif
  <!--footer-->
  <p>
    <strong>International Cargo System</strong>
  </p>
</div>
@stop
