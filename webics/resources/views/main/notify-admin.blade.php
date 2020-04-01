@if(isset($solicitude))
  @section('title-page', trans('messages.sendrequest'))
@else
  @section('title-page', trans('messages.senddata'))
@endif
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
    @if(isset($solicitude))
  	 <h4>{{trans('messages.sendrequest')}}</h4>
    @else
      <h4>{{trans('messages.senddata')}}</h4>
    @endif
  	<div class="row">
  		<div class="span12">
       <div class="row">
        <div class="col-md-9">
          @if(isset($solicitude))
            <p>
              <h5 class="icstitle">
                Estimado (a): <strong>{{strtoupper($client->name)}}</strong>, Gracias por contactárnos, hemos enviado a su correo una notificacion con un enlace, por favor, reviselo cuanto antes.
              </h5>
            </p>
            <p>
              <h5 class="icstitle">
                Código de solicitud: <strong>{{$solicitude->code}}</strong>
              </h5>
            </p>
          @else
          <p>
            <h5 class="icstitle">
              Estimado <strong>{{$client->name}}</strong>, sus datos se han enviado de manera exitósa, está a un paso de completar su solicitud, en breve le atenderemos.
            </h5>
          </p>
          @endif
          <p>
            <h5>
              <strong>Atentamente el equipo de ICS ©</strong>
            </h5>
          </p>
          <hr>
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
