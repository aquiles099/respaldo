@section('title-page', trans('messages.demo'))
@section('keywords', trans('messages.demokeywords'))
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.demo')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.demo')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/demo')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.demo')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.demo')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}} - {{trans('messages.demo')}}">
<meta name="twitter:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
  	<h4 style="margin-bottom: 25px">{{trans('messages.demo')}}</h4>
    <!---->
    <div class="">
      <h2 style="font-weight:900; text-align: center">
        Solicita tu prueba gratis
        <span>
          <a href="{{asset('solicitude')}}" class="btn btn-default" style="color: white">
            <strong>Aqui</strong>
          </a>
        </span>
      </h2>
    </div>
    <!---->
  	<div class="row">
  		<div class="span12">
        <!---->
        <div class="row ">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
          	<img class="img-thumbnail" src="{{asset('dist/img/ics11.png')}}">
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <h1 class="icstitle" style="padding-top: 25%; text-align: center">
               Inicia Sesion.
            </h1>
            <p class="justify">
              Comienza tu experiencia con ICS accesando al mismo por medio del inicio de sesión, un
              menú amigable, sencillo y cómodo.
            </p>
          </div>
        </div>
        <!---->
        <div class="row">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
            <h1 class="icstitle" style="padding-top: 45%; text-align: center">
               Gestiona tu Empresa.
            </h1>
            <p class="icsjustify">
              Encuentra tu Dashboard con un resumen completo de todos los estados de cada uno de los procesos que necesitas controlar, controla y monitorea tus envíos, consulta sus detalles, registra información pertinente de ellos, y mucho mas.
            </p>
            <p class="icsjustify">
              Tu Dashboard es tu modulo inicial desde donde rediriges y accedes a todo lo que necesitas de tus procesos y todo lo que ICS ofrece para ti.
            </p>
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
          	<img class="img-thumbnail" src="{{asset('dist/img/ics12.png')}}">
          </div>
        </div>
        <!---->
        <div class="row ">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
          	<img class="img-thumbnail" src="{{asset('dist/img/ics13.png')}}">
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <h1 class="icstitle" style="padding-top: 10%; text-align: center">
               Informa tus Clientes.
            </h1>
            <p class="icsjustify">
              ICS tiene te asiste en el proceso de mantener a tus clientes siempre informados en referencia al servicio que les prestas, envía notificaciones de los estatus de sus envíos, confirma prealertas, establece itinerarios, envía facturas y reportes; y mucha información más que ayuda a garantizar que tu cliente está al tanto de todo lo que ocurre con sus envíos y todos los procesos inherentes a los mismos.
              Esto da una valiosa sensación de seguridad, confiablidad y tranquilidad al clientes que necesariamente se traduce en una imagen positiva consistente de tu empresa en la que proyectas solidez, responsabilidad y eficacia.
            </p>
          </div>
        </div>
        <!---->
        <div class="row">
          <div class="col-md-6  ">
            <h1 class="icstitle" style="padding-top: 15%; text-align: center">
               Atención Al Cliente.
            </h1>
            <p class="icsjustify">
              En este modulo ICS te presenta un detallado resumen de todas las acciones y datos que se han procesado y registrado relacionados a un proceso principal en específico, como un paquete, consolidado o embarque. Se trata de una guía desde donde accedes a cualquier dato del mismo.
            </p>
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <img class="img-thumbnail" src="{{asset('dist/img/demo/image17.png')}}">
          </div>
        </div>
        <!---->
        <div class="row ">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
            <img class="img-thumbnail" src="{{asset('dist/img/demo/image16.png')}}">
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <h1 class="icstitle" style="padding-top: 5%; text-align: center">
               Privacidad/Seguridad.
            </h1>
            <p class="icsjustify">
              En este segmento controlas y gestionas todo lo referente a los temas y factores de
              seguridad y accesibilidad, es aquí donde das forma a todas las características principales
              de los perfiles de usuarios, así como sus roles y permisos que les son asignados a cada uno
              de ellos. Es la configuración de las funciones de cada uno de los perfiles que dan ejecución
              a las tareas en proceso y emergentes en cada estado así como las limitaciones a esas
              funciones que permiten la restricción de usuarios a ciertos segmentos por razones de
              pertinencia, seguridad y/o confidencialidad.
            </p>
          </div>
        </div>
        <!---->
        <div class="row">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
            <h1 class="icstitle" style="padding-top: 15%; text-align: center">
               Información General.
            </h1>
            <p class="icsjustify">
              Gestiona toda la información sobre empresas, países, ciudades,
              Couriers; agrega servicios, crea y edita categorías y tipos de
              transporte. Además puedes configurar los datos de tu empresa,
              información de reportes, correo electrónico, logo, entre otros
              detalles importantes.
            </p>
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <img class="img-thumbnail" src="{{asset('dist/img/demo/image11.png')}}">
          </div>
        </div>
        <!---->
        <div class="row ">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
            <img class="img-thumbnail" src="{{asset('dist/img/demo/image12.png')}}">
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <h1 class="icstitle" style="padding-top: 5%; text-align: center">
               Reportes.
            </h1>
            <p class="icsjustify">
              Conocemos la importancia de llevare registros de desempeño,
              historiales de acciones, estadísticas generales y específicas;
              relacionados con clientes, envíos, facturas, embarques,
              documentos, bookings, prealertas y todos los procesos que
              manejas con ICS, por ello tienes una gran herramienta que se
              encarga de otorgarte reportes de estas acciones y darte acceso
              inmediato a la misma cuando lo requieras.
            </p>
          </div>
        </div>
        <!---->
        <div class="row">
          <div class="col-md-6 flyLeft animated fadeInLeftBig">
            <h1 class="icstitle" style="padding-top: 15%; text-align: center">
               Controla Envios.
            </h1>
            <p class="icsjustify">
              ICS te proporciona herramientas sólidas para controlar,
              gestionar y monitorear envíos, paquetes y consolidados
              (MICRO), embarques (MACRO); otorgándote la confiabilidad y
              seguridad que requieres para proporcionar a tus clientes un
              servicio consistente en calidad, efectividad y rapidez.
            </p>
          </div>
          <div class="col-md-6 flyRight animated fadeInRightBig">
            <img class="img-thumbnail" src="{{asset('dist/img/demo/image8.png')}}">
          </div>
        </div>
  		</div>
  	</div>
  </div>
</section>
@stop
