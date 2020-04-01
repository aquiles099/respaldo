@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <!--Primer Parrafo [Tipo de usuario creado]-->
    <p>
      Se ha creado de manera exitosa un usario tipo <strong>{{$user->getType->name}}</strong>, el cual se describe como <strong>{{$user->getType->description}}</strong>.
    </p>
    <!--Segundo Parrafo [Detalles del usuario creado-->
    <p>
      Los datos de la cuenta son los siguientes:
    </p>
    <!--Nombre-->
    <p>
      <strong>{{trans('user.name')}}: </strong> {{$user->name}}
    </p>
    <!--Telefono-->
    <p>
      <strong>{{trans('user.phone')}}</strong> {{$user->phone}}
    </p>
    <!--Correo-->
    <p>
      <strong>{{trans('user.email')}}: </strong> {{$user->email}}
    </p>
    <!--Codigo-->
    <p>
      <strong>{{trans('user.code')}}: </strong> {{$user->code}}
    </p>
  </div>
@stop
