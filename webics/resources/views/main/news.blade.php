@section('title-page', trans('messages.news'))
@section('keywords', trans('messages.newskeywords'))
@extends('layouts.main.master')
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.news')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.news')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/news')}}">
<meta property="og:image" content="{{asset('dist/img/news.jpg')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.news')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.news')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}} - {{trans('messages.news')}}">
<meta name="twitter:image" content="{{asset('dist/img/news.jpg')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
<?php
  function translateMonth ($month) {
    if ($month === '01') {
      return trans('contract.january');
    }
    if ($month === '02') {
      return trans('contract.february');
    }
    if ($month === '03') {
      return trans('contract.march');
    }
    if ($month === '04') {
      return trans('contract.april');
    }
    if ($month === '05') {
      return trans('contract.may');
    }
    if ($month === '06') {
      return trans('contract.june');
    }
    if ($month === '07') {
      return trans('contract.july');
    }
    if ($month === '08') {
      return trans('contract.august');
    }
    if ($month === '09') {
      return trans('contract.september');
    }
    if ($month === '10') {
      return trans('contract.october');
    }
    if ($month === '11') {
      return trans('contract.november');
    }
    if ($month === '12') {
      return trans('contract.december');
    }
  }
 ?>
@section('body')
  @if($notices->count() == 0)
  <section id="contact" class="section gray">
    <div class="container">
      <div class="blankdivider30"></div>
      <h4>{{trans('messages.news')}}</h4>
      <div class="row">
        @include('sections.no-rows')
      </div>
    </div>
  </section>
  @else
  <section id="contact" class="section gray">
    <div class="container">
    	<div class="blankdivider30"></div>
    	<h4>{{trans('messages.news')}}</h4>
    	<div class="row">
        <div class="col-md-12">
          @foreach($notices as $key => $value)
            <div class="panel panel-default icsbordernew">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="col-md-12">
                      <p>
                        <a href="{{asset("news/{$value->slug}")}}" class="icstitlenotice">
                          <img src="{{is_null($value->img) ? asset('dist/img/logo.png') : $value->img}}" class="img-responsive img-thumbnail icsImgRender" alt="{!!$value->extract!!}" >
                        </a>
                      </p>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="container">
                      <!--Titulo-->
                      <p>
                        <h2>
                          <a href="{{asset("news/{$value->slug}")}}" class="icstitlenotice">{{$value->title}}</a>
                        </h2>
                      </p>
                      <!--Extracto-->
                      <p>
                        {!!$value->extract!!}
                      </p>
                      <!--Redactor-->
                      <p>
                        Publicado: {{\Carbon\Carbon::parse($value->created_at)->format('d')}} de {{translateMonth(\Carbon\Carbon::parse($value->created_at)->format('m'))}} de {{\Carbon\Carbon::today()->format('Y')}}.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
  	</div>
  </section>
  @endif
@stop
