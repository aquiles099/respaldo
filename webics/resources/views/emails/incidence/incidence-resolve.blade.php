@extends('layouts.email.master')
@section('mail-body')
<p>
  Estimado (a):
  <h2 style="text-transform: capitalize">{{$client->name}}</h2>
</p>
<!---->
<p>
  La incidencia <strong>{{$incidence->subject}}</strong> reportada el dia <strong>{{$incidence->created_at}}</strong> ha sido resuelta !!
</p>
<!---->
<p>
  Si posee alguna duda, escribanos de inmediato, saludos.
</p>
<!---->
<p>
  <strong>International Cargo System</strong>
</p>
@stop
