@section('title-page', trans('messages.prices'))
@section('keywords', trans('messages.priceskeywords'))
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.prices')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.prices')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/prices')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.prices')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.prices')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}} - {{trans('messages.prices')}}">
<meta name="twitter:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
  	<h4 style="margin-bottom: 25px">{{trans('messages.prices')}}</h4>
    <!---->
    <div class="row">
      <!--left text-->
      <div class="col-md-6">
        <div class="form" style="padding-bottom: 10%; padding-top: 10%">
          <h1 class="text-center icstitle">ICS Básico</h1>
          <p style="text-align: justify">
            Contrate la versión basica de ICS, dirigido a empresas del sector pequeño y mediano de la prestación de servicios de manejo y logística de envíos.
          </p>
          <p>
            ** Gratis configuración Link ICS en su página web
          </p>
          <p>
            NOTA: <span>Al solicitar el modo de pago 'Anual' se incluye un 10% de descuento en el costo</span>
          </p>
        </div>
      </div>
      <!--right image-->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-md-4 col-md-offset-4 ">
      				<div class="portfolio-item grid print photography">
      					<div class="portfolio icscircle">
      						<img  src="{{asset('dist/img/icon/micro.png')}}" alt="{{trans('messages.basicICS')}}" />
      					</div>
      				</div>
      			</div>
          </div>
          <table class="table table-hover table-responsive icstablecenter">
            <thead>
              <tr>
                <th>{{trans('prices.licence')}}</th>
                <th>{{trans('prices.monthly')}}</th>
                <th>{{trans('prices.annual')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($prices as $key => $value)
                @if($value->type == App\Helpers\HProfileType::BASIC)
                <tr>
                  <td>{{$value->years}} año/s {{$value->years == App\Helpers\HProfileType::BASIC ? '' : '**'}}</td>
                  <td>{{$value->monthly}} {{env('CURRENCY')}}</td>
                  <td>{{$value->annual}} {{env('CURRENCY')}}</td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!---->
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-md-4 col-md-offset-4 ">
      				<div class="portfolio-item grid print photography">
      					<div class="portfolio icscircle">
      						<img  src="{{asset('dist/img/icon/macro.png')}}" alt="{{trans('messages.profesionalICS')}}" />
      					</div>
      				</div>
      			</div>
          </div>
          <table class="table table-hover table-responsive icstablecenter">
            <thead>
              <tr>
                <th>{{trans('prices.licence')}}</th>
                <th>{{trans('prices.monthly')}}</th>
                <th>{{trans('prices.annual')}}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($prices as $key => $value)
                @if($value->type == App\Helpers\HProfileType::PROFESSIONAL)
                <tr>
                  <td>{{$value->years}} año/s {{$value->years == App\Helpers\HProfileType::BASIC ? '*' : '**'}}</td>
                  <td>{{$value->monthly}} {{env('CURRENCY')}}</td>
                  <td>{{$value->annual}} {{env('CURRENCY')}}</td>
                </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form" style="padding-bottom: 10%; padding-top: 10%">
          <h1 class="text-center icstitle">ICS Profesional</h1>
          <p style="text-align: justify" >
            Solicite la version profesional de ICS, adecuado a organizaciones de mayor envergadura, teniendo en cuenta su amplitud de operaciones, la versatilidad y diversidad de las mismas y por supuesto el volumen y alcance de ellas.
          </p>
          <p>
            ** Gratis configuración Link ICS en su página web
          </p>
          <p>
            NOTA: <span>Al solicitar el modo de pago 'Anual' se incluye un 10% de descuesto en el costo</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
