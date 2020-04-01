@section('title-page', trans('messages.faq'))
@section('keywords', trans('messages.newskeywords'))
<!--Meta Facebook-->
@section('meta-facebook')
<meta property="og:title" content="{{trans('messages.ICS')}} - {{trans('messages.faq')}}">
<meta property="og:description" content="{{trans('messages.slogan')}} - {{trans('messages.faq')}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{asset('/faq')}}">
<meta property="og:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
<meta property="og:site_name" content="{{trans('messages.ICS')}} - {{trans('messages.faq')}}">
@stop
<!--Meta Twitter-->
@section('meta-twitter')
<meta name="twitter:card"  content="summary">
<meta name="twitter:site"  content="{{env('ICS_TWITTER_URL')}}">
<meta name="twitter:title" content="{{trans('messages.ICS')}} - {{trans('messages.faq')}}">
<meta name="twitter:creator" content="{{env('ICS_SPS_URL')}}" />
<meta name="twitter:description" content="{{trans('messages.slogan')}} - {{trans('messages.faq')}}">
<meta name="twitter:image" content="{{asset('dist/img/favicon.png')}}">
<meta property="og:image:width" content="250">
<meta property="og:image:height" content="250">
@stop
@extends('layouts.main.master')
@section('body')
<section id="contact" class="section gray">
  <div class="container">
    <div class="blankdivider30"></div>
    <h4>{{trans('messages.faq')}}</h4>
    <div class="row">
      <div class="span12">
        <div class="tabbable">
            <ul class="nav nav-tabs nav-justified">
              <li class="active flyLeft animated fadeInLeftBig">
                <a href="#one" data-toggle="tab">
                <i class="fa fa-user fa-fw"></i>
                  Registro del Usuario Final
                </a>
              </li>
              <li class="flyLeft animated fadeInLeftBig">
                <a href="#two" data-toggle="tab">
                  <i class="fa fa-table fa-fw"></i>
                  Panel de control del Cliente
                </a>
              </li>
              <li class="flyLeft animated fadeInLeftBig">
                <a href="#three" data-toggle="tab">
                  <i class="fa fa-cubes fa-fw"></i>
                  Módulo de Warehouse
                </a>
              </li>
              <li class="flyLeft animated fadeInLeftBig">
                <a href="#four" data-toggle="tab">
                  <i class="fa fa-phone fa-fw"></i>
                  Atención al Cliente
                </a>
              </li>
              <li class="flyLeft animated fadeInLeftBig">
                <a href="#five" data-toggle="tab">
                  <i class="fa fa-rocket fa-fw"></i>
                    Módulo Administrativo
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane flyRight animated fadeInRightBig active" id="one">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <i class="fa fa-user fa-fw"></i>
                    Registro del Usuario Final
                  </div>
                  <div class="panel-body">
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema envía un Email automático al cliente luego del registro?</strong>
                      </p>
                      <p>
                        Si, nuestro sistema genera una notificación inmediata y automática para informar que el proceso de registro se ha hecho satisfactoriamente
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Se puede editar el Email automático?</strong>
                      </p>
                      <p>
                        SI, accediendo a los ajustes se pueden personalizar los parámetros del mismo.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema asigna algún número de suite y/o casillero cuando se completa el registro?</strong>
                      </p>
                      <p>
                        SI, con el fin de identificar de manera fija a cada usuario.
                      </p>
                    </div>
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Es posible modificar el formato o número del casillero?</strong>
                      </p>
                      <p>
                        No, este es un código único siempre asignado al cliente.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Es posible incluir nuevas variables a la planilla de registro?</strong>
                      </p>
                      <p>
                        NO, por no considerarse necesario.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane flyRight animated fadeInRightBig" id="two">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i>
                    Panel de control del Cliente
                  </div>
                  <div class="panel-body">
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Puede el cliente generar PREALERTAS de sus compras? </strong>
                      </p>
                      <p>
                        SI, tenemos un segmento de prealertas donde pueden generarse e identificarse con códigos, número de orden de servicio, proveedor, transportista, fecha estimada de arribo y más.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Puede El Cliente adjuntar su factura comercial luego de que su paquete esté recibido en el Depósito? </strong>
                      </p>
                      <p>
                        SI, tiene la opción de documentar su paquete con su factura comercial, nota de entrega, etc.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema asigna algún número de suite y/o casillero al momento del registro? </strong>
                      </p>
                      <p>
                        SI, se asigna inmediatamente un código de control e identificación
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Puede El cliente solicitar "ASEGURAR" su envío mediante el pago de un porcentaje del monto por asegurar? </strong>
                      </p>
                      <p>
                        El cliente final NO, pero el usuario de ICS SI, de manera que puede el usuario final solicitarlo cuando así lo requiera.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>EL cliente puede saber el estatus operativo del paquete? </strong>
                      </p>
                      <p>
                        SI, el cliente puede monitorear el estatus de su paquete cuando lo desee.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Puede El Cliente pagar los servicios de su envío mediante tarjeta de crédito y/o cuenta PayPal?</strong>
                      </p>
                      <p>
                        SI, nuestra plataforma de pago permite las transacciones mediante estos instrumentos, tarjeta de crédito y PayPal.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane flyRight animated fadeInRightBig" id="three">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <i class="fa fa-cubes fa-fw"></i>
                    Módulo de Warehouse
                  </div>
                  <div class="panel-body">
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Se puede registrar el tracking de varios paquetes al momento de su arribo al Depósito?</strong>
                      </p>
                      <p>
                        SI, mediante la asignación de un tracking para cada paquete.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Emite el sistema un documento de recepción por paquete?</strong>
                      </p>
                      <p>
                        SI, un documento que hace constar dicha recepción que es generado individualmente a cada paquete, el Warehouse Receipt.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema notifica vía email automático por cada paquete procesado (WR)?</strong>
                      </p>
                      <p>
                        SI, nuestro sistema notifica automáticamente cuando cada paquete es procesado.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Se identifica a cada paquete recibido con una etiqueta?</strong>
                      </p>
                      <p>
                        SI, ICS genera a cada paquete su etiqueta correspondiente que contiene los datos pertinentes de identificación como el remitente, destinatario, dirección, teléfonos, fechas, lugares, etc.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Informa el Sistema cuales son los paquetes que están listos para ser consolidados?</strong>
                      </p>
                      <p>
                        SI, con el fin principal de automatizar todo lo posible, se notifica este estatus para activar la logística que permita seguir el proceso con prontitud
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Genera el Sistema un reporte de manifiesto de carga?</strong>
                      </p>
                      <p>
                        SI, es el reporte que declara y detalla la salida de una carga, aportando información sobre el medio de transporte, el tipo de mercancía, la cantidad, la unidad de medida, número de bultos, peso, así como los datos del importador o exportador, todos, datos requeridos por la normativa internacional de comercio. CARGO MANIFEST.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema genera un reporte de despacho con información para realizar la entrega final?</strong>
                      </p>
                      <p>
                        Si, entrega un reporte de carga o despacho acreditando los datos del destinatario, la carga, el transportista autorizado, etc. BILL OF LADING (BL)
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane flyRight animated fadeInRightBig" id="four">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <i class="fa fa-phone fa-fw"></i>
                    Atención al Cliente
                  </div>
                  <div class="panel-body">
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Permite el Sistema realizar búsqueda de paquetes por número de WR, SH y/o tracking number dentro de su plataforma?</strong>
                      </p>
                      <p>
                        SI, permite hacer búsquedas según estos parámetros o identificadores.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Permite el Sistema la actualización del estatus de la paquetería?</strong>
                      </p>
                      <p>
                        SI, es un atributo central de ICS el actualizar el estatus de la paquetería para el monitoreo preciso de la misma.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Permite el Sistema gestionar los requerimientos de los clientes bajo el concepto de "tickets"?</strong>
                      </p>
                      <p>
                        SI, para registrar y procesar los mismos, así como para dar al cliente una identificación de su requerimiento para su seguimiento.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema permite mantener en “hold" paquetes que no tengan documentación comercial?</strong>
                      </p>
                      <p>
                      NO, pero puede mantener el estatus que sea necesario y el tiempo que desee.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane flyRight animated fadeInRightBig" id="five">
                <div class="panel panel-default">
                  <div class="panel-heading">
                   <i class="fa fa-rocket fa-fw"></i>
                    Módulo Administrativo
                  </div>
                  <div class="panel-body">
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Genera el Sistema automáticamente una factura por cada envío realizado? </strong>
                      </p>
                      <p>
                        SI, como parte del proceso de automatización general, ICS proporciona factura a cada envío un reporte de costos e importe de los servicios (FACTURA)
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>El sistema permite controlar la cobranza por cada uno de los envíos facturados? </strong>
                      </p>
                      <p>
                        SI, para llevar registro y control de vencimiento, cuentas por cobrar, etc.
                      </p>
                    </div>
                    <!---->
                    <div class="">
                      <p>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <strong>Permite el Sistema agregar en la factura nuevos items distintos al valor del envío?</strong>
                      </p>
                      <p>
                        SI, se pueden incluir variables de costo como impuestos, seguros, descuentos, promociones; si aplicasen.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!--Img-->
        <div class="">
          <h1 style="text-align:right">
            <img style=" width: 5%" src="{{asset('dist/img/favicon.png')}}" alt="" />
          </h1>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
