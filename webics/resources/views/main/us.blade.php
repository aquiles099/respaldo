@section('title-page', trans('messages.us'))
@section('keywords', trans('messages.uskeywords'))
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.us')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.us')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/us')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.us')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.us')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}}  - {{trans('messages.us')}}">
<meta name="twitter:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
  	<div class="blankdivider30"></div>
    <h4>{{trans('messages.us')}}</h4>
  	<div class="row">
  		<div class="span12">
          <div class="" style="color: black">
            <!---->
            <p class="icsjustify flyLeft animated fadeInLeftBig">
              International Cargo System nace de la inquietud de satisfacer necesidades en crecimiento de las pequeñas, medianas y grandes empresas de manejo y control de cargas a nivel mundial. En <strong>SOLID PROJECT SOLUTIONS</strong> como empresa al frente del diseño y desarrollo de ICS, nos proyectamos el objetivo de convertirnos en un aliado empresarial sólido de nuestros clientes con el ofrecimiento de ayudarles en sus procesos hasta automatizar y optimizar en la máxima medida posible todos los aspectos inherentes al funcionamiento general y especifico de los mismos.
            </p>
            <!---->
            <p class="icsjustify flyRight animated fadeInRightBig">
              Con una idea, un diseño y un clic inicial ejecutados en agosto del 2016, <strong>SOLID PROJECT SOLUTIONS</strong> se volcó a la tarea de dar forma y efecto a ese proyecto que es hoy ya un producto firme llamado <strong>ICS</strong>, encontrando y enfrentando desafíos importantes en el trayecto que han permitido un resultado satisfactorio y prometedor de muchas más herramientas que beneficiarán a nuestros aliados.
            </p>
            <!---->
            <p class="icsjustify flyLeft animated fadeInLeftBig">
              <strong>ICS</strong> promete y cumple con la entrega de atributos eficaces para el cumplimiento de los objetivos que dan sin duda alguna una oportunidad innegable a los usuarios de generar y proveer un mejor y más amplio servicio a sus clientes, de proyectar una imagen corporativa y empresarial más robusta y de abrirse paso en su mercado sobresaliendo por la efectividad, eficacia y celeridad a la hora de la prestación de sus servicios.
            </p>
            <!---->
            <p class="icsjustify flyRight animated fadeInRightBig">
            Con <strong>SOLID PROJECT SOLUTIONS</strong> ponemos en el desarrollo y evolución de ICS una parte importante de nuestros  recursos materiales e intelectuales con la firme convicción de desarrollar un producto completo en sus características, atributos, alcances y bondades; que incluso puede evolucionar junto con nuestros aliados comerciales y sus proyectos pues <strong>ICS</strong> tiene plataformas adaptables a toda clase de exigencias, desde las más sencillas y expeditas hasta las más demandantes y complejas.
            </p>
            <!---->
            <p class="icsjustify flyLeft animated fadeInLeftBig">
              Es nuestro objetivo desplegar todo nuestro esfuerzo y trabajo garantizando una amplia aplicabilidad y versatilidad a los usuarios de ICS que determinen una relación con ellos de total fidelidad, confianza y durabilidad.
            </p>
            <!---->
            <p class="icsjustify flyRight animated fadeInRightBig">
              Hasta el lanzamiento de <strong>ICS</strong>, son muchísimas las horas hombre invertidas, muchísimas herramientas utilizadas y muchos mas recursos aplicados para llegar a este punto. Nos sentimos entusiasmados y confiados del aporte que hacemos a esta rama de la industria, por lo que en adelante dejamos que sea <strong>ICS</strong> el que hable mas por NOSOTROS.
            </p>
            <!---->
            <p class="icsjustify flyLeft animated fadeInLeftBig">
              Que <strong>ICS</strong> les ayude en su camino al éxito será nuestra mayor satisfacción como empresa, como desarrolladores y como humanos.
            </p>
          </div>
          <div class="container text-center">
					  <img src="{{asset('dist/img/logo.png')}}" style="height: 100px;">
          </div>
  		</div>
  	</div>
  </div>
</section>
@stop
