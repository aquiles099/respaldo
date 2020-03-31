/**
*
*/
'use strict';
/**
 *
 */

 /**
  * TRANSLATE OBJECT DEFINITION ************************************************
  */
 var translate = function() {
   if (messages.language == 'es') {
     return ({
       'mailNotification' : 'Notificando al correo',
       'loading' : 'Cargando...',
       'info' : 'Información',
       'back' : 'Atras',
       'receivedOfficeUsa' : 'Recibido en oficina (USA)',
       'receivedOfficePa'  : 'Recibido en oficina (PA)',
       'edit' : 'Editar',
       'processed' : 'Procesado satisfactoriamente',
       'newClient' : 'Nuevo cliente',
       'errorFound' : 'Se Encontraron los siguientes errores: ',
       'errorTry' : 'Ha ocurrido un error, intentelo de nuevo',
       'typePackage' : 'Tipos de paquetes recibidos del mes',
       'psckagesInvoice': 'Paquetes Con y sin Factura del mes actual',
       'chooseMonth' : 'Seleccione el mes',
       'noAsync' : 'no se ha podido procesar la solicitud asíncrona',
       'chooseDay' : 'Seleccione el dia',
       'monthNames' : [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
       'dayNamesMin' : [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
       'cancel' : 'Cancelar',
       'accept' : 'Aceptar',
       'serverError' : 'Ha ocurrido un error en el servidor',
       'wait' : 'Espere...',
       'loadInvoice' : 'Cargar Factura',
       'saving' : 'Guardando datos...',
       'completed' : 'Completado',
       'chooseClient': 'Seleccione el cliente',
       'chooseRoute': 'Seleccione la ruta',
       'receipt' : 'Recibo',
       'stateName' : 'Nombre del estado',
       'description' : 'Descripción',
       'alert' : 'Alerta!!',
       'deleteMessage' : '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.',
       'withoutRoute' : 'Sin rutas para el servicio seleccionado',
       'noNotify': 'No notificar',
       'notifyBoth': 'Ambos correos',
       'client' : 'Client',
       'portAirport' : 'Puerto o Aeropuertos',
       'pieces' : 'Piezas',
       'value' : 'Valor',
       'prealert' : 'Prealerta',
       'chooseOption' : 'Seleccione una opcion',
       'courier' : 'Courier',
       'large' : 'Largo',
       'width' : 'Ancho',
       'height' : 'Alto',
       'weight' : 'Peso',
       'unregistered' : 'No se encuentra Registrado',
       'delete' : 'Eliminar',
       'settedDate' : 'Cantidad de paquetes en la fecha esatblecida'

     });
   }else {
     return({
       'mailNotification' : 'Notifying to user email',
       'loading' : 'Loading...',
       'info' : 'Details',
       'back' : 'Previous',
       'receivedOfficeUsa' : 'Received in office (USA)',
       'receivedOfficePa'  : 'Received in office (PA)',
       'edit' : 'Edit',
       'processed' : 'Processed success',
       'newClient' : 'New Client',
       'errorFound' : 'Error found: ',
       'errorTry' : 'Error, try again',
       'typePackage' : 'Type of packages arrived on the month',
       'psckagesInvoice': 'Packages with or without invoice',
       'chooseMonth' : 'Choose a Month',
       'noAsync' : 'Could\'t process async request',
       'chooseDay' : 'Choose a day',
       'monthNames' : [ "January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December" ],
       'dayNamesMin' : [ "Su", "Mo", "Th", "We", "Thr", "Fr", "Sa" ],
       'cancel' : 'Cancel',
       'accept' : 'Accept',
       'serverError' : 'Something went wrong in the server',
       'wait' : 'Wait...',
       'loadInvoice' : 'Load Invoice',
       'saving' : 'Saving data...',
       'completed' : 'Complete',
       'chooseClient' : 'Choose a client',
       'chooseRoute': 'Choose Route',
       'receipt' : 'Receipt',
       'stateName' : 'State Name',
       'description' : 'Description',
       'alert' : 'Warning!!',
       'deleteMessage' : 'Are you sure want to delete this status, this may cause problem whit packages that use it!',
       'withoutRoute' : 'Don\'nt are routes for service choosen',
       'noNotify': 'No nofication',
       'notifyBoth': 'Both e-mails',
       'client' : 'Cliente',
       'portAirport' : 'Port or Airport',
       'pieces' : 'Pieces',
       'value' : 'Value',
       'prealert' : 'Prealert',
       'chooseOption' : 'Choose an Option',
       'courier' : 'Courier',
       'large' : 'Large',
       'width' : 'Width',
       'height' : 'Height',
       'weight' : 'Weight',
       'unregistered' : 'Not registered',
       'delete' : 'Delete',
       'settedDate' : 'Packages in the indicated date'
     });
   }
 }
 /**
  * ****************************************************************************
  */

function log(msg) {
  console.log(msg);
}
/**
 *
 */
function getItem(element) {
  try {
    return eval('(' + element.parent().parent().parent().parent().attr('item') + ')');
  } catch(e) {
    return undefined;
  }
}

/**
 *
 */
function getItemFromParent(element) {
  try {
    return eval('(' + element.parent().attr('item') + ')');
  } catch(e) {
    return undefined;
  }
}

/**
 *
 */
function msg(msg) {
  return '`' + msg + '`';
}

/**
 *
 */
function search() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = window.location.origin + window.location.pathname + '?search=' + search;
    }
  } catch(e) {

  }
}

/**
 *
 */
function doForm(path, method, parameters, from) {
  var form = $('<form></form>');
  form.attr("method", "post");
  form.attr("action", path || './');
  form.attr("target", '_self');
  parameters = parameters || {};
  if(from) {
    parameters.from = window.location.href;
  }
  parameters._method = method || "post";
  $.each(parameters, function(key, value) {
    var field = $('<input></input>');
    field.attr("type", "hidden");
    field.attr("name", key);
    field.attr("value", value);
    form.append(field);
  });
  $(document.body).append(form);
  form.submit();
}

/**
 *
 */
function select(form) {
  try {
    $(form).find('select.pick-selected option').prop('selected', true);
  } catch(e) {
    log(e);
  }
}
/**
* ToolTip messages (VS)
*/

$(document).ready(function() {
  /**
  *
  */
  $('[data-toggle="tooltip"]').tooltip();
  /**
  *
  */
  generalLoad();
  /**
  * hide alert on process past 2 seconds
  */
  /***setTimeout(function() {
    $("#alertOnProcess").slideUp( 300 ).delay( 800 );
  }, 2000);
  /****
  /**
  *
  */
  $('#rowLoad').hide();
  /**
  *
  */
  $('#ics_select_country_register').select2();
  $('#ics_select_sex').select2();
  var iterable = [
    'dtble_pickup',
    'dtble_pickup_tytpe',
    'dtble_numberparts',
    'dtble_prealert',
    'dtble_service',
    'dtble_promotion',
    'dtble_addcharge',
    'dtble_booking',
    'dtble_suppliers',
    'dtble_route',
    'dtble_carrier',
    'dtble_typetransport',
    'dtble_company',
    'dtble_users',
    'dtble_operator',
    'dtble_country',
    'dtble_state',
    'dtble_city',
    'dtble_office',
    'dtble_vessel',
    'dtble_category',
    'dtble_container',
    'dtble_permission',
    'dtble_role',
    'dtble_profile',
    'dtble_cat',
    'dtble_pack',
    'dtble_usr',
    'dtble_promo',
    'dtble_tax',
    'dtble_serv',
    'dtble_comp',
    'dtble_rep',
    'dtble_billing_invoice',
    'dtble_billing_invoice_pay',
    'dtble_billing_invoice_debt',
    'dtble_billing_received',
    'dtble_billing_in_transit',
    'dtble_billing_in_route',
    'dtble_user_packages',
    'dtble_notifications'
  ];


  if (messages.language == 'en') {
    for (var element of iterable) {
      $('#'+element).DataTable({
        "language": {
          "sEmptyTable":     "No data available in table",
          "sInfo":           "Showing _START_ to _END_ of _TOTAL_ entries",
          "sInfoEmpty":      "Showing 0 to 0 of 0 entries",
          "sInfoFiltered":   "(filtered from _MAX_ total entries)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ",",
          "sLengthMenu":     "Show _MENU_ entries",
          "sLoadingRecords": "Loading...",
          "sProcessing":     "Processing...",
          "sZeroRecords":    "No matching records found",
          "oPaginate": {
            "sFirst":    "First",
            "sLast":     "Last",
            "sNext":     "Next",
            "sPrevious": "Previous"
          },
          "oAria": {
            "sSortAscending":  ": activate to sort column ascending",
            "sSortDescending": ": activate to sort column descending"
          }
         }
      });
      $('#dataTableSearch').attr('placeholder','Search');
    }
  }else {
    $('#'+element).DataTable({
      "order": [
        [ 0, "desc" ]
      ]
    });
  }
  if (messages.language == 'en') {
      $('#dtble').DataTable({
        "language": {
          "sEmptyTable":     "No data available in table",
          "sInfo":           "Showing _START_ to _END_ of _TOTAL_ entries",
          "sInfoEmpty":      "Showing 0 to 0 of 0 entries",
          "sInfoFiltered":   "(filtered from _MAX_ total entries)",
          "sInfoPostFix":    "",
          "sInfoThousands":  ",",
          "sLengthMenu":     "Show _MENU_ entries",
          "sLoadingRecords": "Loading...",
          "sProcessing":     "Processing...",
          "sZeroRecords":    "No matching records found",
          "oPaginate": {
            "sFirst":    "First",
            "sLast":     "Last",
            "sNext":     "Next",
            "sPrevious": "Previous"
          },
          "oAria": {
            "sSortAscending":  ": activate to sort column ascending",
            "sSortDescending": ": activate to sort column descending"
          }
         }
      });
      $('#dataTableSearch').attr('placeholder','Search');
  }else {
    $('#dtble').DataTable({
      "order": [
        [ 0, "desc" ]
      ]
    });
  }

  /**
  *
  */
  /**
  *if (document.layers){
  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown = clickNS;
  } else {
  document.onmouseup = clickNS;
  document.oncontextmenu = clickIE;
  }
  document.oncontextmenu = new Function("return false");

  //Disable right click script III- By Renigade (renigade@mediaone.net)
  //For full source code, visit http://www.dynamicdrive.com
  var message = "";

  function clickIE(){
  if (document.all){
  (message);
  return false;
  }
  }

  function clickNS(e){
  if (document.layers || (document.getElementById && !document.all)){
  if (e.which == 2 || e.which == 3){
  (message);
  return false;
  }
  }
  }
  */
});

/**
*
*/
var generalLoad = function () {
  var text = translate();
  $("#pnlin").append("<div id = 'load' class = 'load '><p class='ics-load-onModal'><i class='fa fa-spin fa-spinner'></i> "+text.loading+"</p><input id='reload' type='hidden' value='false'>");
}

/**
* submit load on form
*/
var submitForm = function () {
  var text = translate();
  $('#loadRecover').html('<i class="fa fa-spin fa-spinner"></i> ' + text.mailNotification);
}
/**
* AUX_PATH
*/
const AUX_PATH = '/ics-app-version-2.0/public/';
/**
* Show info modal (VS)
*/
var details = function (id) {
  var path  = window.location.origin + window.location.pathname;
  var sw    = 0;
  var alert = false;
  var nuser = false;
  var url ;
  var text = translate();
  /**
  *  verify tracking user
  */
  if ($('#pnlin').hasClass( "usrtrck" )) { /** show in the modal details of package**/
    var text = translate();

   $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
    bootbox.dialog
    ({
      title: "<span id='tltgnif'>"+text.info+"</span>",
      message: $('#load').load(path + "/" + id, function ()
      {
          $('[data-toggle="tooltip"]').tooltip();
          $('#dtble2').DataTable({
            "order": [
              [ 0, "desc" ]
            ]
          });
          if (messages.language == 'en') {
            $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
            $('#dtble2_next').html('Next');
            $('#dtble2_previous').html('Previous');
            $('.dataTables_empty').html('No data to show...');
          }
      }),
      size: "large",
      backdrop: true,
      onEscape: function() { },
    })
    .on('shown.bs.modal', function ()
    {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
      $('#load').hide().appendTo('body');
      refreshData();
    })
    .modal('show');
  }
  else /** show in the modal general views**/
  {
    /**
    * change status package
    */
    if ($('#pnlin').hasClass( "showpack" )) {
      var text = translate();

      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+taxt.loading+'</p>');
      bootbox.dialog({
        title: "<a href='' id='bckic' title='"+text.back+"' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.info+"</span>",
        message: $('#load').load(path + "/showpackage/" + id, function() {
          $('[data-toggle="tooltip"]').tooltip();
          $('select').select2();
          $('#dtble2').DataTable({
            "order": [
              [ 0, "desc" ]
            ]
          });
          if (messages.language == 'en') {
            $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
            $('#dtble2_next').html('Next');
            $('#dtble2_previous').html('Previous');
            $('.dataTables_empty').html('No data to show...');
          }
        }),
        size:"large",
        backdrop: true,
        onEscape: function() { },
      }).on('shown.bs.modal', function ()
    {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
     refreshData();
    }
    else {
      /**
      * List todayPackage on DashBoard
      */
      if($('#pnlin').hasClass( "dash" )) {
        var text = translate();

        url = path + "admin/package/" + id + "/dash";
        var title = text.info;

        if (id == 1) {
          title = "<a href='javascript:loadBackpackage("+ id +")' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.receivedOfficeUsa+"</span>";
        }
        if (id == 4) {
          title = "<a href='javascript:loadBackpackage("+ id +")' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.receivedOfficePa+"</span>";
        }
        /**
        *
        */
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> "'+text.loading+'"</p>');
        bootbox.dialog({
          title: title,
          message: $('#load').load(url, function() {
            $('#dtble').DataTable({
              "order": [
                [ 0, "desc" ]
              ]
            });
            if (messages.language == 'en') {
              $('#dataTableSearch').attr('placeholder','Search...');
              $('#dtble_next').html('Next');
              $('#dtble_previous').html('Previous');
              $('.dataTables_empty').html('No data to show...');
            }
            $('[data-toggle="tooltip"]').tooltip();
            $('#dtble2').DataTable({
              "order": [
                [ 0, "desc" ]
              ]
            });
            if (messages.language == 'en') {
              $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
              $('#dtble2_next').html('Next');
              $('#dtble2_previous').html('Previous');
              $('.dataTables_empty').html('No data to show...');
            }
          }),
          size: "large",
          backdrop: true,
          onEscape: function() { },
        })
        .on('shown.bs.modal', function ()
        {
          $('#load').show();
        })
        .on('hide.bs.modal', function (e)
        {
          $('#load').hide().appendTo('body');
          refreshData();
        })
        .modal('show');
      }
      else {
        /**
        * Show modal on the general options
        */
        var text = translate();

        var text = translate();
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
        bootbox.dialog({
          title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='"+text.back+"' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.info+"</span>",
          message: $('#load').load(path + "/" + id + "/read", function () {
            /**
            * Se verifica si estamos en presencia de una compañia para mostrar el listado de clientes asociados
            */
            if($('#pnlin').hasClass( "cp" )) {
              $('#load').addClass('cl');
              $('#pnlft').css('padding-bottom','10px');
              $('#pnlft').addClass('col-md-5');
              $('#load').append("<div class='col-md-1'></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> "+text.loading+"</p></div><input type='hidden' id='cpldcl' value = "+id+">");

               if(id != 1) /** Se muestra listado de clientes de la empresa asociada **/
               {
                 $('#cl').load(path + '/' + id + '/clients', function () {
                   $('#dtble2').DataTable({
                     "order": [
                       [ 0, "desc" ]
                     ]
                   });
                   if (messages.language == 'en') {
                     $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
                     $('#dtble2_next').html('Next');
                     $('#dtble2_previous').html('Previous');
                     $('.dataTables_empty').html('No data to show...');
                   }
                   $('[data-toggle="tooltip"]').tooltip();
                 });
               }
               else /** Se muestra listado de usuarios de ICS **/
               {
                 var url   = window.location.origin + AUX_PATH + '/admin/user/view';
                  $('#cl').load(url, function () {
                    $('#dtble2').DataTable({
                      "order": [
                        [ 0, "desc" ]
                      ]
                    });
                    if (messages.language == 'en') {
                      $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
                      $('#dtble2_next').html('Next');
                      $('#dtble2_previous').html('Previous');
                      $('.dataTables_empty').html('No data to show...');
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                  });
                  nuser = true; /** Switch para añadir nuevo usuario **/
               }
              $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" data-toggle="tooltip" title="'+text.edit+'"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +', '+ nuser +')" id="adcl"><span class="badge" data-toggle="tooltip" title="'+text.newClient+'"><span class="glyphicon glyphicon-plus"></span></span></a></div>');
              $('#adcl').show();
            }
            else /** en esta validacion se oculta la opcion de crear clientes **/
            {
              $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" data-toggle="tooltip" title="'+text.edit+'"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +', '+ nuser +')" id="adcl"><span class="badge" data-toggle="tooltip" title="'+text.newClient+'"><span class="glyphicon glyphicon-plus"></span></span></a></div>');
              $('select').select2();
              $('[data-toggle="tooltip"]').tooltip();
            }
          }),
          size: "large",
          backdrop: true,
          onEscape: function() { },
        })
        .on('shown.bs.modal', function ()
        {
          $('#load').show();
        })
        .on('hide.bs.modal', function (e)
        {
          $('#load').hide().appendTo('body');
          refreshData();
        })
        .modal('show');
      }
    }
  }
}

/**
* Return back view (VS)
*/
var loadBack = function (alert , id) {
  var path    = window.location.origin + window.location.pathname;
  var sw      = 0;
  var company = $('#cpldcl').val();
  var url     = ((company != 'undefined') ? (company != '1') ? path + "/" + company + "/read" : path + "/1/read"  : path + "/" + id + "/read") /** se configura el url tomando en cuenta que se debe evaluar el id de la compañia **/
  var nuser   = ((company != '1') ? false : true) /** se establece un switch para usuarios y clientes **/
  var text = translate();
  /**
  *
  */
  $('#bckic').hide();
  $('#tltgnif').html('Información');
  $('#load').load(url, function ()
   {
     $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+ id +')"><span class="badge" data-toggle="tooltip" title="'+text.edit+'"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +','+ nuser +')" id="adcl"><span class="badge" data-toggle="tooltip" title="'+text.newClient+'"><span class="glyphicon glyphicon-plus"></span></span></a></div>');
     /**
     *
     */
     if ($('#pnlin').hasClass( "cp" )) /** si el contenedor posee la clase cp se cargan los clientes en el **/
     {
       $('#adcl').show();
       $('#load').addClass('cl');
       $('#pnlft').css('padding-bottom','10px');
       $('#pnlft').addClass('col-md-5');
       $('#load').append("<div class = 'col-md-1'></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> "+text.loading+"</p></div><input type='hidden' id='cpldcl' value = "+ company +"><input type = 'hidden' id='edtcl' value = 'false'>");
       /**
       *
       */
       if (company == '1') /** carga de usuarios ICS **/
       {
         $('#cl').load(window.location.origin + AUX_PATH + '/admin/user/view', function () /** se ejecuta la carga de usuarios **/
         {
            $('[data-toggle="tooltip"]').tooltip();
            $('#swcl').val('0');
            (($('#bckic').attr('name') == '1') ? $("#load").scrollTop(540) : '')
            $('#bckic').attr('name', '0');
            $('#dtble2').DataTable({
              "order": [
                [ 0, "desc" ]
              ]
            });
            if (messages.language == 'en') {
              $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
              $('#dtble2_next').html('Next');
              $('#dtble2_previous').html('Previous');
              $('.dataTables_empty').html('No data to show...');
            }
         });
       }
       else /** carga de clientes  **/
       {
         $('#cl').load(path+'/'+ company +'/clients', function () /** se ejecuta la carga de clientes **/
         {
           $('[data-toggle="tooltip"]').tooltip();
           $('#swcl').val('0');
           (($('#bckic').attr('name') == '1') ? $("#load").scrollTop(540) : '')
           $('#bckic').attr('name', '0');
           $('#dtble2').DataTable({
             "order": [
               [ 0, "desc" ]
             ]
           });
           if (messages.language == 'en') {
             $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
             $('#dtble2_next').html('Next');
             $('#dtble2_previous').html('Previous');
             $('.dataTables_empty').html('No data to show...');
           }
         });
       }
     }
   });
  showAlertInLoadBack(alert); /** show succes alert callback **/
}
/**
* Load the edit view (VS)
*/
var loadEditview = function (swcl, id)
{
  var path    = window.location.origin + window.location.pathname;
  var company = $('#cpldcl').val();
  var url ;
  var onedit;
  var hidd;
  var gen   = 'false';
  if ((swcl == '1'))
  {
    url = path + "/"+ company +"/clients/"+ id +"/edit"; /** Carga la vsta par editar clientes **/
    hidd    = 'true';
    onedit  =  '0';
    $('#swcl').val(onedit);
  }
  else
  {
    if (swcl == 3) /** cargar la vista para editar un usuario **/
    {
      path  = window.location.origin + AUX_PATH + '/admin/user/' + id +'/viewEdit';
      url   = path;
      swcl  = 3;
      gen   = 'false'; /** true para ejecutar edicion de usuario **/
    }
    else
    {
      url = path + "/" + id + "/edit"; /** carga la vista para una edicion general **/
      hidd    = 'false';
      onedit  =  '2';
      $('#swcl').val(onedit);
      /**
      *
      */
    }
  }
  $('#tltgnif').html(translate().edit);
  $('#load').load(url, function()
  {
    $('#load').removeClass('cl');
    $('#pnlft').append('<div class="panel-footer" id="pft2"><span class="label label-danger pull-left" id="uplbdgr"></span><a href="javascript:saveOnEdit('+ swcl +','+ id +','+ gen +')"><span class="badge" data-toggle="tooltip" title="guardar"><span class="glyphicon glyphicon-ok"></span></span></a></div><input type="hidden" id="cpldcl" value = '+ company +'><input type = "hidden" id="edtcl" value = "'+hidd+'">');
    $('#bckic').show();
    $('#hdprovs').css("display","none");
    $('select').select2();
    $('[data-toggle="tooltip"]').tooltip();
    /**
    * Aplica en promociones
    */
    $('#dtps').datepicker({
        dateFormat:    "yy-mm-dd",
    });
    /**
    *
    */
    $('#dtpe').datepicker({
        dateFormat:    "yy-mm-dd",
    });
  });
}
/**
* Eval json message (VS)
*/
var evalJson = function (json)
{
  /**
  * validate visibility of error container
  */
  var text = translate();
  if (!$('#error').length)
  {
    $('#load').append('<div class = "alert alert-danger"  id="ics-alert-danger"><b>Se '+text.errorFound+' </b><button class = "close" data-dismiss = "alert"><span>&times;</span></button><ol id= "error"></ol></div>');
    /**
    * loop for show error
    */
    $.each(json, function(i, item)
    {
        $('#error').append('<li><i>'+ json[i] +' : <b>('+ i +')</b></i></li>');
    });
  }
  else
  {
    /**
    * delete the info of container
    */
    $('#error').html('');
    /**
    * loop for show error
    */
    $.each(json, function(i, item)
    {
        $('#error').append('<li><i>'+ json[i] +' : <b>('+ i +')</b></i></li>');
    });
  }
}
/**
* Save on edit (VS)
*/
var saveOnEdit = function (swcl , id, nuew) {
  var path       = window.location.origin + window.location.pathname;
  var company    = $('#cpldcl').val();
  var token      = $('#token').val();
  var edit       = $('#edtcl').val();
  var dataString = $('#formSerial').serialize();
  var alert      = false;
  var method;
  var url;


  if ( edit == 'false' && swcl == '2' ) /** Agregar un cliente nuevo **/
  {
      url    = path + "/" + company + "/clients/new";
      method = 'POST';
      alert  = true;
  }
  else
  {
    if (edit == 'true' && swcl == '1' && $('#swcl').val() == '0') /** Editar el cliente de una compaña**/
    {
      url    = path + "/" + company + "/clients/" + id + "/save";
      method = 'PUT';
      alert  = true;
    }
    else
    {
      if ( swcl == '3') /** Editar o Añadir usuario **/
      {
          if(nuew == true) /** Añadimos usuario **/
          {
            url    = window.location.origin + AUX_PATH + '/admin/user/viewNew';
            method = 'POST';
            alert  = true;
          }
          else /** Modificamos usuario **/
          {
            url    = window.location.origin + AUX_PATH + '/admin/user/' + id + '/view';
            method = 'PATCH';
            alert  = true;
          }
      }
      else /** Editar de manera general **/
      {
        url    = path + "/" + id + "/save";
        method = 'PUT';
        alert  = true;
      }
    }
  }
  /**
  * Send data
  */
  var text = translate();
  $.ajax({
    url: url,
    headers: {'X-CSRF-TOKEN': token},
    type: method,
    dataType: 'json',
    data: dataString,
    success: function (json)
    {
      ((json.message == 'true') ? loadBack (alert , id) : evalJson (json.alert))
    },
    error: function ()
    {
      bootbox.alert(text.errorTry);
    }
  });
  /**
  *
  */
  $('#load').append('<input type = "hidden" id="reload" value="true">');
  }

/**
* Charts for shipping type
*/
var chartType = function (a, b)
{
  var text = translate();
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart()
  {
    var data = google.visualization.arrayToDataTable([
      ['Tipos', 'Cantidad'],
      ["Maritimo", a],
      ["Aereo",    b]
    ])
    var options = {
      title: text.typePackage,
      pieHole: 0.4,
      is3D: true,
    };
    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
    chart.draw(data, options);
  }
}

/**
* Bar chart (Big)
*/
var chartNums = function (a, b, c, d, e, f)
{
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart()
  {
  var data = google.visualization.arrayToDataTable([
    ["Paquetes", "Cantidad", { role: "style" } ],
    ["Recibidos",   a, "#337ab7"],
    ["Enviados",    b, "#5cb85c"],
    ["Transito",    c, "#f0ad4e"],
    ["Destino",     d, "#189085"],
    ["Sin Factura", e, "#d9534f"],
    ["Entregado",   f, "#003492"]
  ]);
  var view = new google.visualization.DataView(data);
  view.setColumns(
    [0, 1,
     { calc: "stringify",
       sourceColumn: 1,
       type: "string",
       role: "annotation"
     },2]);

  var options =
  {
      title: text.settedDate,
      orientation: 'vertical',
      hAxis: {
        format: "#",
        ticks: (a < 3) ? [0, 0, 0, 0, 1] : ''
      },
      bar:
      {
        groupWidth: "97%"
      },
      tooltip:
      {
        isHtml: true
      },
      legend:
      {
        position: "none"
      },
    };
    var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
    chart.draw(view, options);
  }
  $('#ics-breadcrumb-datePackage').html('Paquetes de ' + $('#selected_date').text());
}

/**
* Chart For Invoice
*/
var mainChart = function (a, b)
{
  var text = translate();
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart()
  {
    var data = google.visualization.arrayToDataTable([
      ['Task', text.packagesInvoice],
      ['Con Factura', a],
      ['Sin Factura',  b]
    ]);

    var options =
    {
      title: text.packagesInvoice,
      pieHole: 0.4,
      is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('mainchart'));
    chart.draw(data, options);
  }
}

/**
* config date on DashBoard
*/
 var showDateDashboard = function (value)
 {
   var path = window.location.origin + window.location.pathname;
   var url  = path + '1/day/' + value;
   var text = translate();
   /**
   *
   */
   if (value > 2 && value < 5) /** in case select month of day**/
   {
     if (value == 3) /** Select month and year  **/
     {
       $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
       bootbox.confirm(
       {
         title : text.chooseMonth,
         message: "<div class='form-group'><div class='input-group'><input class='form-control' id='dtpmy' placeholder ='"+text.chooseMonth+"'><span class='input-group-addon'><i class='fa fa-calendar-o' aria-hidden='true'></i></span></div></div>",
         buttons:
         {
          cancel:
          {
              label: text.cancel
          },
          confirm:
          {
              label: text.accept
          }
        },
        callback: function (result)
        {
          if (result && $('#dtpmy').val() != '')
          {
            var url  = path + "3/month/" + $('#dtpmy').val();
            /**
            *
            */
            $.ajax
            ({
              url: url,
              type: 'GET',
              beforeSend: function ()
              {
                $('#dateload').html('<i class="fa fa-spin fa-spinner"></i> '+text.loading);
              },
              success: function (json)
              {
                ((json.message == 'true') ? location.reload() : bootbox.alert(json.message + json.data))
              },
              error: function ()
              {
                alert(text.noAsync);
              }
            });
          }
        }
       }).on("shown.bs.modal", function(e) {
         /**
         * Configurate datepicker for specific selection (mont)
         */
         $('#dtpmy').datepicker({
           dayNamesMin: text.dayNamesMin,
           dateFormat: 'yy-mm',
           changeMonth: true,
           changeYear: true,
           showWeek: true,
           monthNames: text.monthNames,
           showButtonPanel: true,
           onClose: function(dateText, inst)
           {
             var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
             var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
             $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
           },
           beforeShowDay: function (day) {
            var day = day.getDay();
            if (day > 0 || day < 7)
            {
              return [false, "somecssclass"]
            }
            else
            {
              return [true, "someothercssclass"]
            }
          }
        });
        $('#dtpmy').focus();
      });
     }
     if (value == 4) /** Select especific day   **/
     {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
       bootbox.confirm(
       {
         title : text.chooseDay,
         message: "<div class='form-group'><div class='input-group'><input class='form-control' id='dtpm' placeholder ='"+text.chooseDay+"'><span class='input-group-addon'><i class='fa fa-calendar' aria-hidden='true'></i></span></div></div>",
         buttons:
         {
            cancel:
            {
                label: text.cancel
            },
            confirm:
            {
                label: text.accept
            }
        },
        callback: function (result)
        {
          if (result && $('#dtpm').val() != '')
          {
            var url  = path + "4/date/" + $('#dtpm').val();
            /**
            *
            */
            $.ajax
            ({
              url: url,
              type: 'GET',
              beforeSend: function ()
              {
                $('#dateload').html('<i class="fa fa-spin fa-spinner"></i> '+text.loading);
              },
              success: function (json)
              {
                ((json.message == 'true') ? location.reload() : bootbox.alert(text.serverError))
              },
              error: function ()
              {
                alert(text.noAsync);
              }
            });
          }
        }
      }).on("shown.bs.modal", function(e) {
        /**
        * Configurate datepicker for specific selection (day)
        */
        $('#dtpm').datepicker({
          dateFormat:    "yy-mm-dd",
          showButtonPanel: true,
          showWeek: true,
          changeMonth: true,
          changeYear: true,
          dayNamesMin: text.dayNamesMin,
          monthNames:  text.monthNames
        });
        $('#dtpm').focus();
      });
     }
   }
   else
   {
     /**
     * Select today or yesterday or all
     */
     $.ajax
     ({
       url: url,
       type: 'GET',
       beforeSend: function ()
       {
         $('#dateload').html('<i class="fa fa-spin fa-spinner"></i> '+text.loading);
       },
       success: function (json)
       {
         ((json.message == 'true') ? location.reload() : bootbox.alert(text.serverError))
       },
       error: function ()
       {
         alert(text.noAsync);
       }
     });
   }
 }

/**
* show alert on success
*/
var showAlertInLoadBack = function (alert)
{
  var text = translate();
  if (alert == true)
  {
    $('#tltgnif').append('<div id="success" style="height: 45px"><div><div class = "alert alert-success"><b>'+text.processed+'</b> <span><i class="fa fa-check-circle-o" aria-hidden="true"></i></span></div></div>');
    setTimeout(function()
    {
      $( "#success" ).slideUp( 300 ).delay( 800 );
    }, 1500);

    $('#reload').val(alert);
  }
}

/**
* refresh data before update
*/
var refreshData = function ()
{
  if($('#reload').val() == 'true')
  {
    var text = translate();
    $('#pnlin').html('<i class="fa fa-spin fa-spinner"></i> '+text.loading);
    location.reload();
  }
}


var detailspackagedash = function (id) {
  var path  = window.location.origin + window.location.pathname;
  var text = translate();
  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
  /**
  *
  */
  $('#load').load(path + "admin/package/"+id+"/receipt", function ()
  {
    $('#bckic').show();
  });
}


var loadBackpackage = function (id)
{
  var path    = window.location.origin + window.location.pathname;
  var url     = path + "admin/package/" + id + "/dash";
  var text = translate();

  $('#bckic').hide();
  $('#tltgnif').html('Detalles');
  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'.</p>');
  /**
  *
  */
  $('#load').load(url, function ()
   {
     $('#dtble2').DataTable({
       "order": [
         [ 0, "desc" ]
       ]
     });
     if (messages.language == 'en') {
       $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
       $('#dtble2_next').html('Next');
       $('#dtble2_previous').html('Previous');
       $('.dataTables_empty').html('No data to show...');
     }

   });
  showAlertInLoadBack(false); /** show succes alert callback **/
}

/**
*
*/
var disableElement = function ()
{
  if(!($("#check:checked").val()==1))
  {
      $("#submitBnt").attr('disabled', 'disabled');
  }
  else
  {
      $("#submitBnt").removeAttr("disabled");
  }
}
