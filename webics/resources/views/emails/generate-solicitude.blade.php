@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <p>
      Estimado (a):
      <h2 style="text-transform: capitalize">{{$client->name}}</h2>
    </p>
    <p style="text-align: justify">
      Muchas gracias por la solicitud, le agradecemos el interes en nuestro trabajo y le invitamos a proveernos la informacion de su organzacion, a fin de continuar con el proceso.
    </p>
    <p style="text-align: justify">
      Para ello complete el formulario en el website de ICS haciendo click en el siguiente enlace:
      <strong>
        <a href="{{asset("/check?p={$client->remember_token}")}}" style="text-decoration: blink; font-size: 17px">(CLICK AQUI)</a>
      </strong>
      y le responderemos a la brevedad.
    </p>
    <p>
      <strong>International Cargo System</strong>
    </p>
  </div>
@stop
