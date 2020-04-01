@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <p>
      Saludos Administrador (a):
      <h2 style="text-transform: capitalize">{{$user->name}}</h2>
    </p>
    <p style="text-align: justify">
      Su contraseña es: <strong>{{\Crypt::decrypt($user->password)}}</strong>
    </p>
    <p>
      <strong>International Cargo System</strong>
    </p>
  </div>
@stop
