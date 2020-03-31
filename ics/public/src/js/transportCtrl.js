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
      'info' : 'Informacion',
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
      'maxWeight' : 'el peso del archivo debe ser menor a 8MB',
      'type' : 'Tipo',
      'maritime_selected' : 'Maritimo seleccionado'
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
      'deleteMessage' : 'Are you sure want to delete this register?',
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
      'maxWeight' : 'Maximun file size is 8mb',
      'type' : 'Type',
      'maritime_selected' : 'Maritime selected'
    });
  }
}
/**
 * ****************************************************************************
 */

$(document).ready(function () {
  // $('#dtble').DataTable({
  //   "order": [
  //     [ 0, "desc" ]
  //   ]
  // });
  // if (messages.language == 'en') {
  //   $('#dataTableSearch').attr('placeholder','Search...');
  //   $('#dtble_next').html('Next');
  //   $('#dtble_previous').html('Previous');
  //   $('.dataTables_empty').html('No data to show...');
  // }
  /**
  *
  */
});
/**
 *
 */
var createLoad = function ()
{
  var text = translate();
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+text.wait+"</button>");
}
function loadButton(element) {
  var text = translate();
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+text.wait);
}
/**
 * Eliminar Transport
 */
var transportDelete = function (element, from) {
  try {

    var transport = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + "/" + transport.id;

    if(transport != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
*
*/
var detailstransport = function (id, open) {
  var path  = window.location.origin + window.location.pathname + "/" + id + "/read";

  if (open == 'true') {
    var sw    = 0;
    var alert = false;

    bootbox.dialog({
    title: "<a href='javascript:icsLoadBackPort(false,"+id+")' id='bckic' title='"+translate().back+"' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>"+translate().info+"</span>",
    message: $('#load').load(path, function() {
        $('#dtble2').dataTable();
        if (messages.language == 'en') {
          $('#dtble2_filter #dataTableSearch').attr('placeholder','Search...');
          $('#dtble2_next').html('Next');
          $('#dtble2_previous').html('Previous');
          $('.dataTables_empty').html('No data to show...');
        }
        $('[data-toggle="tooltip"]').tooltip();
    }),
    size:"large",
    backdrop: true,
    onEscape: function() { },
    }).on('shown.bs.modal', function () {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e) {
    $('#load').hide().appendTo('body');
    })
    .modal('show');
  }
  else {
     $('#load').load(path, function() {});
  }
}
/**
* Se carga el formulario para crear un nuevo puerto asociado a un tipo de transporte
*/
var icsLoadPortForm = function (transport) {
  var path  = window.location.origin + window.location.pathname + "/" + transport + "/edit";
  $('#tltgnif').html('Nuevo');

  $('#load').load(path, function () {
      $('#bckic').show();
      $('[data-toggle="tooltip"]').tooltip();
  });
}
/**
*
*/
var icsViewPort = function (port, readonly) {
  var path = readonly == true ? window.location.origin + window.location.pathname + "/" + port + "/editPortRead" : window.location.origin + window.location.pathname + "/" + port + "/editPort";
  var data =  $('#formSerial').serialize();
  $('#tltgnif').html(translate().edit);
  /**
  * se carga vista en readonly o para editar
  */
  $('#load').load(path, function () {
      $('#bckic').show();
      $('[data-toggle="tooltip"]').tooltip();
  });
}
/**
* Enviar datos del puerto que se desea crear
*/
var icsAddPort = function (transport) {
  var path = window.location.origin + window.location.pathname + "/" + transport + "/edit";
  var data =  $('#formSerial').serialize();

  $.ajax({
    url: path,
    type: 'POST',
    dataType: 'json',
    data: data,
    beforeSend: function () {

    },
    success: function (json) {
      json.message == 'true' ? icsLoadBackPort (alert = true, transport) : evalJson (json.alert)
    },
    error:function (e){
      bootbox.alert('Ha ocurrido un error');
    }
  });
}
/**
* Volver atras luego de editar o crear un registro
*/
var icsLoadBackPort = function (alert, transport) {
  var path  = window.location.origin + window.location.pathname + "/" + transport + "/read";
  $('#tltgnif').html('Informacion');

  $('#load').load(path, function () {
      $('#bckic').hide();
      $('[data-toggle="tooltip"]').tooltip();
      $('#dtble2').dataTable();
      showAlertInLoadBack(alert);
  });
}
/**
* ELiminar puerto
*/
var icsPortDelete = function (port, transport) {

  var path = window.location.origin + window.location.pathname + "/" + port + "/deletePort";

  bootbox.confirm({
    message: translate().deleteMessage,
    buttons: {
        confirm: {
            label: translate().accept,
            className: 'btn-primary'
        },
        cancel: {
            label: translate().cancel,
            className: 'btn-default'
        }
    },
    callback: function (confirmed) {
      if (confirmed) {
        $.ajax({
          url: path,
          type: 'DELETE',
          dataType: 'json',
          data: port,
          beforeSend: function () {

          },
          success: function (json) {
            json.message == 'true' ? icsLoadBackPort (alert = true , transport) : evalJson (json.alert)
          },
          error: function () {
            bootbox.alert(translate().errorTry);
          }
        });
      }
    }
  });
}
/**
*
*/
var icsEditPort = function (port, transport) {

  var path = window.location.origin + window.location.pathname + "/" + port + "/editPort";
  var data =  $('#formSerial').serialize();
  /**
  *
  */
  $.ajax({
    url: path,
    type: 'PUT',
    dataType: 'json',
    data: data,
    beforeSend: function () {

    },
    success: function (json) {
      json.message == 'true' ? icsLoadBackPort (alert = true , transport) : evalJson (json.alert)
    },
    error: function () {
      bootbox.alert(translate().errorTry);
    }
  });
}
/**
*
*/
var icsEditTransport = function(transport, readonly) {
  var path   = window.location.origin + window.location.pathname + "/" + transport + "/viewTransport";
  var data =  $('#formSerial').serialize();

  if (readonly == false) {
    $('#load').load(path, function () {
      $('#bckic').show();
      $('[data-toggle="tooltip"]').tooltip();
    });
  }
  else {
    $.ajax({
      url: path,
      type: 'PUT',
      dataType: 'json',
      data: data,
      beforeSend: function () {

      },
      success: function (json) {
        json.message == 'true' ? icsLoadBackPort (alert = true , transport) : evalJson (json.alert)
      },
      error: function () {
        bootbox.alert(translate().errorTry);
      }
    });
  }

}
