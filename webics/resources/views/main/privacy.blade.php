@section('title-page', trans('messages.privacy'))
@section('keywords', trans('messages.privacykeywords'))
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.privacy')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.privacy')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/privacy')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.privacy')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.privacy')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}} - {{trans('messages.privacy')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
  	<h4>{{trans('messages.privacy')}}</h4>
  	<div class="row">
      <div class="span12" style="color: black">
        <!--Logo-->
        <h1 style="text-align: center">
          <img src="{{asset('dist/img/logo.png')}}" style="height: 100px;">
        </h1>
        <!---->
        <div class="">
          <p class="icstextterms">
            Por favor lea detenidamente nuestra política de privacidad y si tiene alguna duda puede consultarnos a través del correo electrónico info@internationalcargosystem.com.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            <strong>www.internationalcargosystem.com</strong> es un sitio Web que permite al usuario, mediante una sesión personalizada y privada; acceder al software ICS para la gestión, control y manejo de todos los procesos de su empresa de carga,. www.internationalcargosystem.com e ICS son propiedad de SOLID PROJECT SOLUTIONS CORP.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            El uso de este software, del sitio Web y todos los contenidos están regulados por estas políticas de privacidad, al utilizar los servicios de este sitio web y de ICS, los usuarios reconocen que han leído y aceptado nuestras políticas de privacidad. SOLID PROJECT SOLUTIONS CORP se reserva el derecho a modificarlas, sin ninguna obligación de notificar los cambios realizados, por lo que es responsabilidad de los usuarios revisar de forma periódica nuestras políticas de privacidad.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            <strong>ICS</strong>  es un software web al que puede acceder cualquier persona pero su contenido está dirigido a mayores de 18 años con capacidad legal para contratar. Cualquier información falsa o manipulada que sea suministrada por los Usuarios de este Sitio Web es responsabilidad de los Usuarios o de ser el caso, de los padres o representantes de los Usuarios.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            Cuando usted se registra en ICS suministra información la cual puede ser almacenada para que usted pueda ser identificado, dentro de esta información esta su nombre, dirección de correo electrónico, número de identificación, documento nacional de identidad, número de teléfono, así como los datos de su tarjeta de crédito; usted puede escoger no suministrar cierta información pero lo más seguro es que si usted decide no hacerlo, no pueda completar la compra y el posterior acceso a ICS.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            SOLID PROJECT SOLUTIONS CORP <strong>NO</strong> suministrará su información de contacto ni su información empresarial, ni coordenadas geográficas, ni datos bancarios y/o financieros que haya usted confiado a ICS, de igual forma SOLID PROJECT SOLUTIONS CORP. solo suministrará la información de su tarjeta de crédito a las plataformas procesadoras de pago con la finalidad de que los pagos sean realizados y pueda disfrutar plenamente de ICS.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            SOLID PROJECT SOLUTIONS CORP <strong>NO</strong> vende, alquila o comparte la información personal de los Usuarios. Sin embargo, dicha información puede ser utilizada por SOLID PROJECT SOLUTIONS CORP con el fin de mejorar los servicios prestados a través del Sitio Web.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            SOLID PROJECT SOLUTIONS CORP puede conocer y monitorear las actividades, tareas y usuarios que usted registre en su sesión privada de ICS pero solo de manera estadística; de forma que ésta información solo sirve para evaluación del sistema y sus prestaciones a fin de continuar en el constante desarrollo de mejoras y nuevas herramientas a las que haya lugar según necesidades y requerimientos del ejercicio comercial controlado por usted a través de ICS.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            SOLID PROJECT SOLUTIONS CORP ha tomado las medidas de seguridad necesarias para la protección de la información de los Usuarios con el fin de evitar el acceso no autorizado a dicha información, el uso indebido o manipulación; no obstante, usted como usuario acepta que estas medidas podrían no ser suficientes ante la pérdida accidental de la información, acceso no autorizado o Hackeo del sitio web, por lo que su información podría ser expuesta de forma no voluntaria.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            Esta política de privacidad es solo válida para los enlaces dentro del dominio <strong>www.internationalcargosystem.com</strong>, las páginas de proveedores o terceros pueden contener políticas de privacidad diferentes por lo que es responsabilidad del usuario revisar las políticas de privacidad de las páginas externas que pudieran estar enlazadas desde este sitio web.
          </p>
        </div>
        <!---->
        <div class="">
          <p class="icstextterms">
            ICS enviara boletines con información relevante sobre actualizaciones, mejoras o nuevas herramientas de ICS que hayamos dispuesto desarrollar. 
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
