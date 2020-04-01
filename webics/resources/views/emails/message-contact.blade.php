@extends('layouts.email.master')
@section('mail-body')
<!--Salutation-->
<div class="">
  <p>
    Estimado (a):
    <h2 style="text-transform: capitalize"> {{isset($contact->name) ? $contact->name : $response['name'] }}</h2>
  </p>
</div>
<!--Body Message-->
<div class="">
  {!! $response['message'] !!}
</div>
<!--Footer[Mail Send]-->
<div class="">
  <p>
    <strong>International Cargo System</strong>
  </p>
</div>
@stop
