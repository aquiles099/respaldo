'use strict';

$('document').ready(function(){
  loadUserData();
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
        content: "Bienvenido! Iniciamos este recorrido con tu dashboard.",
        buttons: [
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
        content: "Aquí podrás configurar todos los datos de tu empresa, tu logo, contraseña, cabecera de reportes y mas.",
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
        content: "Ponemos a tu disposición un canal de comunicación directo con nosotros, a través de él puedes presentarnos tus sugerencias, inquietudes o requerimientos.",
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
        content: "Gestiona los paquetes y prealertas, controla sus estatus; además genera facturas y administra su informacion",
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
        content: "Genera facturas de tus servicios y gestiona descuentos, promociones y cargos adionales.",
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
        content: "Gestiona y controla los registros de reservas a tus clientes",
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
        content: "Controla toda la informacion sobre tus embarques.",
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
        content: "Mantén a tu alcance una base de datos de tus proveedores y toda su informacion.",
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
        content: "Establece todas las politicas de operacion de tus medios de trasporte, crea y gestiona rutas, resgistra y controla transportistas y sus datos.",
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
        content: "Añade y controla los datos de usuarios, empresas y operadores.",
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
        content: "Gestiona toda la iformacion sobre empresas, paises, ciudades, Couriers; agrega servicios, crea y edita categorias y tipos de transporte. \n Ademas puedes configurar los datos de tu empresa, informacion de reportes, correo electronico, logo, entre otros detalles importantes",
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
        content: "Controla los usuarios que acceden al sistema, sus datos e informacion relevante, permisos, roles, etc.",
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
        content: "Te ofrecemos una herramienta para controlar eficientemente las inquietudes de tus clientes, atraves de ella puedes acceder directamente a los datos de los paquetes, usuarios, promociones, impuestos y mucho mas.",
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
        content: "Accede al historial de tus reportes y consulta facturas pagadas y pendientes, envios recibidos y en transito.",
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
var loadTestData = function (data) {
  var url      = "http://www.internationalcargosystem.com/api/test/client/" + window.location.origin;
  //var url = "http://192.168.1.4/Docs/Local/webics/public/api/test/client/smithvictor.1990@gmail.com";
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        beforeSend: function ()
        {

        },
        success: function (json)
        {
         if((json.message)==true){
           var url      = asset('operator')+"/statusoperator";
             $.ajax({
                 url: url,
                 type: 'POST',
                 data: json,
                 beforeSend: function ()
                 {

                 },
                 success: function (json)
                 {
                   //console.log('estatus cambiado');
                 }
             });
         }
        }
      });
}

var  loadTestStatus = function () {
  var url      = asset('login')+"/loadtest";
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function ()
        {

        },
        success: function (json)
        {
          loadTestData(json.operator);
        }
      });
}

var  loadUserData = function () {
  loadTestStatus();
  var url      = asset('login')+"/load";
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        beforeSend: function ()
        {

        },
        success: function (json)
        {
          if (json.message == 'false') {
            console.log('message: '+json.message);
            bootbox.dialog({
              title: "PERIODO DE PRUEBA CADUCADO",
              backdrop: true,
              message: "<p style='text-align:justify;margin-left: 20px;margin-right: 20px;'> Usted ha sobrepasado el tiempo de prueba gratuita, por lo cual sus datos estaran accesibles para usted en modo <b>SOLO LECTURA</b>, si desea obtener mas informacion contactenos en <a href='http://www.internationalcargosystem.com' target='blank'>www.internationalcargosystem.com</a> o escribanos una solicitud a traves del menu de ayuda en la aplicacion.</p>",
              buttons: {
                  confirm: {
                      label: '<i class="fa fa-check"></i> Aceptar'
                  }
              },
              callback: function (result) {
              }
            });
          }else {

          }

        }
      });
}

function acercaDe (){
  bootbox.dialog({
            closeButton: false,
            title: "Acerca de ICS",
            message:
            "<p style='text-align:center;margin: 0 10 10px;'> International Cargo System (ICS)</p>"+
            "<p style='text-align:center;margin: 0 10 10px;'> Perfil: Macro,  Version: 2.0</p>"+
            "<p style='text-align:center;margin: 0 10 10px;'> Av. Balboa, PH Bay Mall, Piso 3 Oficina 304</p>"+
            "<p style='text-align:center;margin: 0 10 10px;'> Ciudad de Panamá, Panamá.</p>"+
            "<p style='text-align:center;margin: 0 10 10px;'> <a href='http://www.internationalcargosystem.com' target='blank'>www.internationalcargosystem.com</a></p>",
            buttons: {
                success:{
                    label: '<i class="fa fa-check"></i> Aceptar'
                }
            }
        });
}
