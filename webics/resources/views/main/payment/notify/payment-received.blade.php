@section('title-page', trans('messages.paymentreceived'))
@section('keywords', trans('messages.newskeywords'))
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
      @include('sections.messages')
  	<h4>{{trans('messages.paymentreceived')}}</h4>
  	<div class="row">
  		<div class="span12">
        <div class="row">
          <div class="col-md-9">
            <p>
              <h5 class="icstitle" style="text-align: justify">
                Estimado (a): <strong>{{strtoupper($client->name)}}</strong>, Gracias por enviarnos su pago, lo hemos recibido de manera exitosa, en estos momentos nos encontramos procesando el mismo, le rogamos que tenga paciencia, pronto le atenderemos.
              </h5>
            </p>
            <p>
              <h5>
                <strong>Atentamente el equipo de ICS ©</strong>
              </h5>
            </p>
          </div>
          <div class="col-md-3">
              <div class="icsspacerequest">
                <div class="icsbg flipInX animated">
                  <img class="icsspace2" src="{{asset('dist/img/icon/ic7.png')}}" alt="" />
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
