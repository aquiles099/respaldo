@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <p>
      Estimado (a):
      <h2 style="text-transform: capitalize">{{$contact->name}}</h2>
    </p>
    <p style="text-align: justify">
      Gracias por contactarnos, pronto será atendido, lo invitamos a revisar nuestras redes sociales e informarse de todas nuestras bondades.
    </p>
    <p>
      <strong>International Cargo System</strong>
    </p>
  </div>
@stop
