@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <!--Primer Parrafo [Tipo de usuario creado]-->
    <p>
      El usuario <strong>{{$admin->name}}</strong> ha publicado la noticia con codigo <strong>{{$notice->code}}</strong>
    </p>
    <!--Link de la noticia-->
    <p style="text-align: center; padding-top: 5%;">
      <a href="{{asset("news/{$notice->slug}")}}" style="font-size: 16px; padding: 11px 19px; text-decoration: none; border-radius: 3px; background-color: #2e5179; color: white;">{{trans('messages.shownotice')}}</a>
    </p>
  </div>
@stop
