/**
*
*/
'use strict';

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
      'monthNames' : [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
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
      'seePrealert' : 'Ver prealerta'

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
      'seePrealert' : 'View prealert'
    });
  }
}
/**
 * ****************************************************************************
 */
/**
*
*/
$(document).ready(function () {
  /**
  *
  */
  $('#country').select2();
  /**
  *
  */
  $('#courierSelect').select2();
  /**
  *
  */
  $('#type').select2();
  /**
  *
  */
  $('#origin').select2();
  /**
  *
  */
  $('#arrivedate').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: translate().dayNamesMin,
    monthNames:  translate().monthNames
  });
  /**
  *
  */
  $('#since_date').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: translate().dayNamesMin,
    monthNames:  translate().monthNames
  });
  /**
  *
  */
  $('#until_date').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: translate().dayNamesMin,
    monthNames:  translate().monthNames
  });
  /**
  *
  */
});
/**
*
*/
function pesovol(){
   var larg=$("#large").val();
   var anch=$("#width").val();
   var alto=$("#height1").val();
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;
   $("#volumetricweightm1").val((resultm.toFixed(2)).toString());
   $("#volumetricweighta1").val((resulta.toFixed(2)).toString());
}
/*
*
*/
var icsDetailsPackage = function (packag, reload) {
  var url = window.location.origin + AUX_PATH + '/admin/package/showpackage/' + packag;
  var text = translate();
  /**
  *
  */
  icsValidateSession(url);
  /**
  *
  */
  if (reload == false) {
    $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
     bootbox.dialog({
       title: "<span id='tltgnif'>"+text.info+"</span>",
       message: $('#load').load(url, function () {
           $('#dtble2').DataTable();
           $('select').select2({
             width: '100%'
           });
       }),
       size: "large",
       backdrop: true,
       onEscape: function() { },
     })
     .on('shown.bs.modal', function () {
       $('#load').show();
     })
     .on('hide.bs.modal', function (e) {
       $('#load').hide().appendTo('body');
       refreshData();
     })
     .modal('show');
  }
  else {
    $('#load').load(url, function () {
      $('#dtble2').DataTable();
      $('#event').select2({
        width:'100%'
      });
    });
  }
}
/**
*
*/
var changestatuspackage = function (packag) {
  var url = window.location.origin + AUX_PATH + '/admin/package/showpackage/' + packag;
  var dataString = {'event':$('#event').val(), 'observation':$('#observation').val()};
  var text = translate();
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: dataString,
    beforeSend: function () {
      $('#cl').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
    },
    success: function (json) {
      ((json.message == 'true') ? icsDetailsPackage(packag, 'false'): evalJson (json.alert))
    },
    complete: function () {

    }
  });
}
/**
*
*/
var icsPrealertDelete = function (element, from) {
  try {
    var prealert = getItem(element) || getItemFromParent(element);
    if(prealert != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/package/prealert/${prealert.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }
  catch (e) {
    log(e);
  }
}
/**
*
*/
var icsViewPrelert = function (prealert) {
  var root = window.location.origin;
  if(root == 'http://localhost'){
    root += AUX_PATH;
  }
  var url =root + '/account/prealert/' + prealert +'/view';
  var text = translate();

  /**
  * validar session
  */
  //icsValidateSession(url);
  /**
  *
  */
    $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
   bootbox.dialog ({
     title: "<span id='tltgnif'><i class='fa fa-flag' aria-hidden='true'></i> "+text.seePrealert+"</span>",
     message: $('#load').load(url, function() {
         $('[data-toggle="tooltip"]').tooltip();
     }),
     size: "medium",
     backdrop: true,
     onEscape: function() { },
   }).on('shown.bs.modal', function () {
     $('#load').show();
   }).on('hide.bs.modal', function (e) {
     $('#load').hide().appendTo('body');
     refreshData();
   }).modal('show');
}
/**
*
*/
var countimg = 0;
function preview_image()  {
  var text = translate();
 var res = countimg + 1;
 var total_file = document.getElementById("upload_file").files.length;
 for(var i = 0; i < 1; i++) {
  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp img-responsive img-rounded' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')><i class='fa fa-trash-o'></i> "+text.delete+"</a>");
 }
}
/**
*
*/
function remove_preview(id){
  $('#' + id).remove();
}
