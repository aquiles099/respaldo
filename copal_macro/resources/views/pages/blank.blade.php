@include('sections.header')
<?php
use App\Models\Admin\Configuration;
    /**
    * Se asigna logo al sistema
    */
    $logo = Configuration::all()->last();
    /**
    *
    */
?>
<script type="text/javascript">
$('document').ready(function(){
  var intro = new Anno([{
        target: '#step1',
        position: 'left',
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step1').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#page-wrapper').css('margin-top','85px');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        content: "Bienvenido! aqui puedes ver tu dashboard",
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px');
              $('#page-wrapper').css('margin-top','0px'); $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step2',
        position:'left',
        content: "Entra aqui y configura tu logo, contraseña, cabecera de reportes y todos los datos de tu empresa",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step2').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step3',
        position:'left',
        content: "Comunicanos tus problemas e inquietudes, aqui podras escribirnos en caso de fallas",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step3').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#navbar').css('position','');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step4',
        position:'left',
        content: "Gestiona tus datos, administra tu cuenta o cierra sesion",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step4').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step5',
        position:'center-right',
        content: "Gestiona los paquetes, prealertas y controla sus estatus, ademas puedes generar facturas y administrar su informacion",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step5').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step6',
        position:'center-right',
        content: "Controla la informacion de los consolidados, sus estados y paquetes",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step6').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#navbar').css('position','');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step7',
        position:'center-right',
        content: "Genera facturas, configura las promociones y los cargos adicionales",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step7').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#navbar').css('position','');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step8',
        position:'center-right',
        content: "Gestiona toda la iformacion sobre consolidados y sus paquetes",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step8').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#navbar').css('position','');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step9',
        position:'center-right',
        content: "Gestiona toda la iformacion sobre empresas, paises, ciudades, Couriers; agrega servicios, crea y edita categorias y tipos de transporte. \n Ademas puedes configurar los datos de tu empresa, informacion de reportes, correo electronico, logo, entre otros detalles importantes",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step9').css('background','#eee');
          $('#side-menu>li>a').css('color','#555');
          $('#navbar').css('position','');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step10',
        position:'center-right',
        content: "Controla los usuarios que acceden al sistema, sus datos e informacion relevante, permisos, roles, etc.",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step10').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step11',
        position:'center-right',
        content: "Te ofrecemos una herramienta para controlar eficientemente las inquietudes de tus clientes, atraves de ella puedes acceder directamente a los datos de los paquetes, usuarios, promociones, impuestos y mucho mas",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step11').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step12',
        position:'center-right',
        content: "Te ofrecemos una herramienta para controlar eficientemente las inquietudes de tus clientes, atraves de ella puedes acceder directamente a los datos de los paquetes, usuarios, promociones, impuestos y mucho mas",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step12').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step13',
        position:'center-right',
        content: "Te ofrecemos una herramienta para controlar eficientemente las inquietudes de tus clientes, atraves de ella puedes acceder directamente a los datos de los paquetes, usuarios, promociones, impuestos y mucho mas",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step13').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step14',
        position:'center-right',
        content: "Te ofrecemos una herramienta para controlar eficientemente las inquietudes de tus clientes, atraves de ella puedes acceder directamente a los datos de los paquetes, usuarios, promociones, impuestos y mucho mas",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step14').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Siguiente',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainNext()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      },
      {
        target: '#step15',
        position:'center-right',
        content: "Te ofrecemos una herramienta para controlar eficientemente las inquietudes de tus clientes, atraves de ella puedes acceder directamente a los datos de los paquetes, usuarios, promociones, impuestos y mucho mas",
        onShow: function () {
          $('.anno-overlay').css('display','none');
          $('#step15').css('background','#eee');
          $('#navbar').css('position','');
          $('#side-menu>li>a').css('color','#555');
          $('#menu').css('background','rgba(0, 0, 0, 0.7)');
          $('.sidebar ul li').css('border-bottom','0px solid #4c4c4c');
          $('#navbar').addClass('navbar navbar-default navbar-static-top anno-overlay');
        },
        buttons: [
          {
            text: 'Anterior',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              this.switchToChainPrev()
            }
          },
          {
            text: 'Salir',
            click: function(anno, evt){
              $('#navbar').removeClass('anno-overlay');
              $('#menu').css('background','white');
              $('#side-menu>li>a').css('color','#337ab7');
              $('.sidebar ul li').css('border-bottom','1px solid #e7e7e7');
              $('#page-wrapper').css('margin-top','0px'); this.hide()
            }
          }
        ]
      }
    ])
    $('#tuto').click(function(){
      $('#navbar').removeClass('anno-overlay');
      $('#navbar').removeClass('navbar navbar-default navbar-static-top anno-overlay');
      intro.show();
    });
});
</script>
<div id="wrapper"  style="background-color:white">
  <nav id="navbar" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{asset('/')}}"><img class = "headerlogo" src="{{isset($logo) ? ($logo->logo_ics == '') ? asset('/dist/images/logo.jpg') : $logo->logo_ics : asset('/dist/images/logo.jpg')}}"/></a>
    </div>
    @if(!isset($user) || isset($toolbar))
      <ul class="nav navbar-top-links navbar-right">
        @section('toolbar-custom-pre')
          @if(!is_null(Session::get('key-sesion')))
            @if(!isset($user))
            <li id="step1">
              <a href="{{asset('/')}}" id ="drdusr"><i class="fa fa-home"></i> {{trans('messages.home')}}</a>
            </li>
            <li id="step2">
              <a href="{{asset('/admin/configuration')}}" id ="drdusr"><i class="fa fa-cog"></i> {{strtoupper(trans('menu.adjustments'))}}</a>
            </li>
            <li id="step3" class="dropdown" >
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id ="drdusr"><i class="fa fa-support"></i>
                AYUDA
                <i class="fa fa-caret-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-user" >
                <li>
                  <a href="{{asset('/account/notifications/settings')}}">
                     <i class="fa fa-bullhorn"></i> {{trans(' Reportar un error')}}
                  </a>
                </li>
                <li>
                  <a href="{{asset('/account/notifications/settings')}}">
                     <i class="fa fa-envelope"></i>{{trans(' Contactar a ICS')}}
                  </a>
                </li>
                <li>
                  <a href="{{asset('/account/notifications/settings')}}">
                     <i class="fa fa-info-circle"></i>{{trans(' Acerca de ICS')}}
                  </a>
                </li>
              </ul>
            </li>
              @include('sections.toolbar')
              <li style="cursor: pointer;"id="tuto">
                <i class="fa fa-info-circle"></i> Tutorial
              </li>
            @else
              @include('sections.toolbar.user')
            @endif
          @endif
        @show
        @yield('toolbar-custom-post')
      </ul>
    @endif
    @if(!isset($menu) && !isset($only))
      @include('sections.menu')
    @endif
  </nav>
  <div id="page-wrapper" class="{{isset($only) ? 'only' : ''}}">
    <div class="container-fluid {{isset($pageCSS) ? $pageCSS : ''}}">
      @yield('pre-title')
      @if(!isset($noTitle))
        <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header" style="color:#23527c">
                @yield('icon-title')
                @yield('title', 'Document Title') <!--<span id="rowLoad" style="font-size: 25px"><small><i class='fa fa-spin fa-spinner'></i> Cargando....</small></span>-->
                <div class="pull-right">@yield('title-actions')</div>
              </h1>
          </div>
        </div>
      @endif
      <div class="row" >
        <div class="col-lg-12">
          @section('body')
              Document body...
          @show
        </div>
      </div>
    </div>
  </div>
</div>
@include('sections.footer')
