@section('title-page', trans('messages.home'))
@extends('layouts.main.master')
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.slogan')}}">
<meta property="og:description" content="{{trans('messages.slogan')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}}">
<meta name="twitter:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
<!--Body-->
@section('body')
<!-- header-->
<div id="header-wrapper" class="header-slider">
	<header class="clearfix">
		<div class=" flyRight animated fadeInRightBig">
			<div class="col-md-6" style="background-color: rgba(37, 36, 36, 0.7);margin-top: 8%; padding: 15px;">
				<h2 style="font-weight:900">PRUEBA NUESTRO</h2>
				<h2 style="font-weight:900">SOFTWARE </h2>
				<a href="{{asset('/solicitude')}}" class="btn" style="font-weight: 900;" > GRATIS</a>
			</div>
		</div>
	</header>
</div>
<!-- spacer section -->
<section class="spacer grey">
	<div class="container">
		<div class="row" style="margin-top: 15px">
			<div class="col-md-4 text-center flyIn animated fadeInUp">
				<img class="img-thumbnail" src="{{asset('dist/img/10.jpg')}}">
				<h6><strong>{{trans('messages.managecargo')}}</strong> </h6>
					<div class="icstoptitleitems">
						<p>{{trans('messages.managecargoinfo')}}</p>
					</div>
				{{--<a class="btn-gradien icsborderbtn" href="#">{{trans('messages.readmore')}}</a>--}}
			</div>
			<div class="col-md-4 text-center flyIn animated fadeInUp">
				<img class="img-thumbnail" src="{{asset('dist/img/ics3.jpg')}}">
				<h6> <strong>{{trans('messages.documentation')}}</strong></h6>
					<div class="icstoptitleitems">
						<p class="icstitle">{{trans('messages.documentationinfo')}}</p>
					</div>
				{{--<a class="btn-gradien icsborderbtn" href="#">{{trans('messages.readmore')}}</a>--}}
			</div>
			<div class="col-md-4 text-center flyIn animated fadeInUp">
				<img class="img-thumbnail" src="{{asset('dist/img/ics2.jpg')}}">
				<h6> <strong>{{trans('messages.informyoucustomers')}}</strong></h6>
				<div class="icstoptitleitems">
					<p>{{trans('messages.informyoucustomersinfo')}}</p>
				</div>
			 {{--<a class="btn-gradien icsborderbtn" href="#">{{trans('messages.readmore')}}</a>--}}
			</div>
		</div>
	</div>
</section>
<!-- spacer section -->
<section class="spacer grey">
	<div class="row">
		<div class="col-md-9 currentsection" >
			<div class="container ">
				<div class="row" style="margin-bottom: 0px!important;">
					<div class="col-md-3">
						<div class="icsspace">
							<div class="icsbg">
								<img class="icsspace2" src="{{asset('dist/img/icon/ic6.png')}}" alt="" />
							</div>
						</div>
					</div>
					<div class="col-md-5 icsjustify">
						<h3 style="color:#fff"><strong>¿QUE ES ICS?</strong></h3>
						<p>ICS es una poderosa herramienta diseñada para fortalecer sus procesos de manejo y control de carga, otorgándole una gran ventaja en la administración, logística, almacenamiento, documentación y muchas areas más. </p>
					</div>
				</div>
				<div class="row" style="margin-bottom: 0px!important;">
					<div class="col-md-3">
						<div class="icsspace">
							<div class="icsbg">
								<img class="icsspace2" src="{{asset('dist/img/icon/micro.png')}}" alt="" />
							</div>
						</div>
					</div>
					<div class="col-md-5 icsjustify">
						<h3 style="color:#fff"><strong>BASICO</strong></h3>
						<p> Dirigido a empresas del sector pequeño y mediano de la prestación de servicios de manejo y logística de envíos, adaptando así a los requerimientos de estas en su marco, su forma y su fondo, tanto organizacional como comercialmente. </p>
					</div>
				</div>
				<div class="row " style="margin-bottom: 0px!important;">
					<div class="col-md-3">
						<div class="icsspace">
							<div class="icsbg">
								<img class="icsspace2" src="{{asset('dist/img/icon/macro.png')}}" alt="" />
							</div>
						</div>
					</div>
					<div class="col-md-5 icsjustify">
						<h3 style="color:#fff"> <strong>PROFESIONAL</strong></h3>
						<p>Adecuado a organizaciones de mayor envergadura, teniendo en cuenta su amplitud de operaciones, la versatilidad y diversidad de las mismas y por supuesto el volumen y alcance de ellas; empresas a las que se les ofrecen atributos y herramientas mas poderosas y robustas, desarrolladas para cubrir las necesidades mas demandante que este tipo de empresas enfrentan. </p>
					</div>
				</div>
			</div>
		</div>
		<div id="icsleftimg">
			<img src="{{asset('dist/img/ics4.jpg')}}">
		</div>
	</div>
</section>
<!-- section[services] -->
<section id="works" class="spacer grey">
	<div class="container clearfix">
		<div class="row">
			<div class="col-md-3 ">
				<!-- portfolio item -->
				<div class="portfolio-item grid print photography">
					<div class="portfolio icscircle">
						<a href="{{asset('dist/img/b1.png')}}" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
						<img  src="{{asset('dist/img/icon/ic1.png')}}" alt="" />
						<div class="portfolio-overlay">
							<div class="thumb-info">
								<h5>{{trans('messages.seemore')}}</h5>
								<i class="fa fa-eye fa-fw icon-2x"></i>
							</div>
						</div>
						</a>
					</div>
					<div style="text-align: center">
						<h2 class="icstitle" style="font-size: 28px" >Controla y Organiza</h2>
						<h5 class="icstitle">{{trans('messages.airtrack')}}</h5>
					</div>
				</div>
				<!-- end portfolio item -->
			</div>
			<div class="col-md-3">
				<!-- portfolio item -->
				<div class="portfolio-item grid print design web">
					<div class="portfolio icscircle">
						<a href="{{asset('dist/img/b2.png')}}" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
						<img src="{{asset('dist/img/icon/ic4.png')}}" alt="" />
						<div class="portfolio-overlay">
							<div class="thumb-info">
								<h5>{{trans('messages.seemore')}}</h5>
								<i class="fa fa-eye fa-fw icon-2x"></i>
							</div>
						</div>
						</a>
					</div>
					<div class="icstitle" style="text-align: center">
						<h2 class="icstitle" style="font-size: 28px">Gestiona y Monitorea</h2>
						<h5 class="icstitle">{{trans('messages.seatrack')}}</h5>
					</div>
				</div>
				<!-- end portfolio item -->
			</div>
			<div class="col-md-3">
				<!-- portfolio item -->
				<div class="portfolio-item grid print design">
					<div class="portfolio icscircle">
						<a href="{{asset('dist/img/b3.png')}}" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
						<img src="{{asset('dist/img/icon/ic2.png')}}" alt="" />
						<div class="portfolio-overlay">
							<div class="thumb-info">
								<h5>{{trans('messages.seemore')}}</h5>
								<i class="fa fa-eye fa-fw icon-2x"></i>
							</div>
						</div>
						</a>
					</div>
					<div class="icstitle" style="text-align: center">
						<h2 class="icstitle" style="font-size: 28px">Planifica y Ordena</h2>
						<h5 class="icstitle">Almacén</h5>
					</div>
				</div>
				<!-- end portfolio item -->
			</div>
			<div class="col-md-3">
				<!-- portfolio item -->
				<div class="portfolio-item grid photography web">
					<div class="portfolio icscircle">
						<a href="{{asset('dist/img/b4.png')}}" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
						<img src="{{asset('dist/img/icon/ic3.png')}}" alt="" />
						<div class="portfolio-overlay">
							<div class="thumb-info">
								<h5>{{trans('messages.seemore')}}</h5>
								<i class="fa fa-eye fa-fw icon-2x"></i>
							</div>
						</div>
						</a>
					</div>
					<div class="icstitle" style="text-align: center">
						<h2 class="icstitle" style="font-size: 28px">Documenta y Apoya</h2>
						<h5 class="icstitle">{{trans('messages.import')}}/{{trans('messages.export')}}</h5>
					</div>
				</div>
				<!-- end portfolio item -->
			</div>
		</div>
	</div>
</section>
@stop
