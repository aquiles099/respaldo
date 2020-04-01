@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <!--Primer Parrafo [Tipo de usuario creado]-->
    <p>
      Se ha creado una notica de manera exitosa por el usario <strong>{{$admin->name}}</strong> con los siguientes detalles:
    </p>
    <!--Titulo de la noticia-->
    <p>
      <h1 style="text-transform: uppercase; color: #2E5179">{{$notice->title}}</h1>
    </p>
    <!--Extracto-->
    <p>
      <h4 style="color: #2E5179; text-transform: capitalize">{{$notice->extract}}</h4>
    </p>
    <!---->
    <p style="height: 6px; background-color: #353635;"></p>
    <!--Descripcion-->
    <div style="text-align: justify">
      {!!$notice->description!!}
    </div>
    <!--Imagen-->
    <p>
      <img src="{{$notice->img}}" alt="{{$notice->extract}}" style="max-width: 630px"/>
    </p>
    <!-- Pie de Noticia-->
    <div class="" style="height: 30px; background-color: #2e5179; ">
      <p style="font-style: italic; color: white; padding-top: 5px; text-align: right">
          Publicado por: {{isset($notice->getAdmin->name) ? strtoupper($notice->getAdmin->name) : trans('messages.ICS')}}
      </p>
    </div>
    <!--Link de la noticia-->
    @if($notice->published == true)
    <p style="text-align: center; padding-top: 5%;">
      <a href="{{asset("news/{$notice->slug}")}}" style="font-size: 16px; padding: 11px 19px; border-radius: 3px; text-decoration: none; background-color: #2e5179; color: white;">{{trans('messages.shownotice')}}</a>
    </p>
    @endif
  </div>
@stop
