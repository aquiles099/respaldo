@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <p>
      Estimado (a):
      <h2 style="text-transform: capitalize">{{$client->name}}</h2>
    </p>
    <p style="text-align: justify; text-transform: none">
      Hemos recibido su información, estamos procesando la misma a fin de dar continuación y respuesta a su solicitud, y atendiendo a la misma le responderemos a la brevedad posible.
      Muchísimas gracias por su paciencia.
    </p>
    <p>
      <strong>International Cargo System</strong>
    </p>
  </div>
@stop
