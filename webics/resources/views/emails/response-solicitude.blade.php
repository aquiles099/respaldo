@extends('layouts.email.master')
@section('mail-body')
  <div class="">
    <p>
      Estimado (a):
      <h2 style="text-transform: capitalize">{{$client->name}}</h2>
    </p>
    <!-- Solicitud Aprobada -->
    @if(isset($response) && $response['status'] == App\Helpers\HStatus::APROVED)
    <p style="text-align: justify; text-transform: none">
      Felicitaciones!!, su solicitud de acceso a ICS ha sido aprobada, aseguramos una provechosa experiencia que seguramente se traducirá en una mejora significativa en la administración y gestión de sus procesos, No dude en contactarnos por cualquier inquietud u observación.
    </p>
    <p style="text-align: justify; text-transform: none">
      Para empezar a usar ICS ahora mismo <a href="{{asset("sub-domain?p={$client->remember_token}")}}">Haga Click Aqui</a>
    </p>
    <p style="text-align: justify; text-transform: none">
      Sus credenciales de Acceso por defecto son:
    </p>
    <p style="text-align: justify; text-transform: none">
      Usuario: <strong>{{$client->email}}</strong>
    </p style="text-align: justify; text-transform: none">
    <p>
      Password: <strong>12345678</strong>
    </p>
    <p style="text-align: justify; text-transform: none">
      Rogamos una vez iniciada sesión con estas credenciales cambiarlas inmediatamente en el menú de ajustes.
    </p>
    <!-- Solicitud Negada -->
    @else
    <p style="text-align: justify; text-transform: none">
      Hemos decidido restringir su acceso a ICS al negar su solicitud del mismo por presentar inconsistencias en sus datos que no nos permite determinar con certeza la procedencia de su solicitud asi como la intención de uso y destino de nuestro software.
    </p>
    <p style="text-align: justify; text-transform: none">
      Le invitamos a hacer una nueva solicitud con datos reales y verificables que nos permitan hallar en usted la intención de uso y destino de ICS y asi poder dar acceso al mismo a su organización.
      Nos disculpamos por las molestias ocasionadas y deseamos que pueda enmendar esta situación y asi poder tener acceso a todas las bondades y herramientas de nuestro sistema.
    </p>
    <p style="text-align: justify; text-transform: none">
       Gracias por el contacto
    </p>
    @endif
    <p>
      <strong>International Cargo System</strong>
    </p>
  </div>
@stop
