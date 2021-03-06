@set('js', ['src/js/notice.js'])
@extends('layouts.main.master')
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
@section('admin-body')
<section id="contact" class="section gray" style="padding: 20px 0 80px;">
  <div class="container">
    <h4>{{trans('messages.news')}}</h4>
    <div class="col-md-12">
      <div class="icsjustify ">
        <div class="icsContainerBack">
            <div class="icsContainerFront">
              <!--Title-->
              <div>
                <h2 class="icstitlenotice" style="text-align: left; font-size:50px; margin-bottom: 0px;">{{$notice->title}}</h2>
              </div>
              <!-- Extracto -->
              <div class="">
                <h5 style="font-size: 22px;">{{$notice->extract}}</h5>
              </div>
              <!--Fecha de publicacion-->
              <span class="icsdatenew">
                Publicado: {{\Carbon\Carbon::parse($notice->created_at)->format('d')}} de {{translateMonth(\Carbon\Carbon::parse($notice->created_at)->format('m'))}} de {{\Carbon\Carbon::today()->format('Y')}}
              </span>
              <!--Social Buttons-->
              <div id="fb-root"></div>
              <div class="" style="padding-bottom: 1%; padding-top: 1%" >
                <!--Twitter-->
                <div class="" style="float: left; margin-right: 10px" >
                  <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                </div>
                <!--Pinterest-->
                <div class="" style="float: left; margin-right: 10px" >
                  <a data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url={{asset("news/{$notice->slug}")}}/&media={{asset('dist/img/favicon.png')}}&description={{trans('messages.ICS')}} - {{$notice->extract}}"></a>
                </div>
                <!--Facebook-->
                <div class="fb-share-button" data-href="{{asset("/news/$notice->slug")}}" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                  <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{asset("/news/{$notice->slug}")}}&amp;src=sdkpreparse">Compartir</a>
                </div>
                <!--Messenger-->
                <div style="float: left; margin-right: 10px" >
                  <div class="fb-send" data-href="{{asset("news/{$notice->slug}")}}"></div>
                </div>
              </div>
              <!--banner-->
              <div class="">
                <p style="height: 6px; background-color: #353635;">
                </p>
              </div>
              <!-- Descripcion -->
              <div class="icsjustify">
                {!!$notice->description!!}
              </div>
              @if(!is_null($notice->img))
              <!-- Imagen -->
              <div class="">
                <img id="icsImgNew" src="{{$notice->img}}" alt="{{trans('notice.icsNews')}}, {{$notice->extract}}"/>
              </div>
              @endif
              <!-- Pie de Noticia-->
              <div class="" style="height: 30px; background-color: #2e5179; ">
                <p class="icsFootNews">
                    Publicado por: {{isset($notice->getAdmin->name) ? strtoupper($notice->getAdmin->name) : trans('messages.ICS')}}
                </p>
              </div>
            </div>
        </div>
      </div>
  </div>
</div>
</section>
@stop
