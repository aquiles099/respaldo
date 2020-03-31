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
        content: "Genera un listado de todos tus consolidados y tus paquetes",
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

    $
});
var loadTestData = function (data) {
  var url      = "http://www.internationalcargosystem.com/api/test/client/" + window.location.origin;
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
            bootbox.confirm({
              title: "PERIODO DE PRUEBA CADUCADO",
              backdrop: true,
              message: "<p style='text-align:justify;margin: 0 10 10px;'> Usted ha sobrepasado el tiempo de prueba gratuita, por lo cual sus datos estaran accesibles para usted en modo <b>SOLO LECTURA</b>, si desea obtener mas informacion contactenos en <a href='http://www.internationalcargosystem.com' target='blank'>www.internationalcargosystem.com</a> o escribanos una solicitud a traves del menu de ayuda en la aplicacion.</p>",
              buttons: {
                  cancel: {
                      label: '<i class="fa fa-times"></i> Cancelar'
                  },
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
            "<p style='text-align:center;margin: 0 10 10px;'> Perfil: Micro,  Version: 2.0</p>"+
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
