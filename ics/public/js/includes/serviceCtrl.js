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
      'delete' : 'Eliminar'

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
      'delete' : 'Delete'
    });
  }
}
/**
 * ****************************************************************************
 */
/**
*
*/
 $(document).ready( function() {
    
  $('select').select2();

 });
/**
 *
 */
 var createLoad = function ()
 {
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+translate().wait+"</button>");
 }
 function loadButton(element) {
  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+ translate().wait);
 }
var serviceDelete = function(element, from) {
  try {
    var service = getItem(element) || getItemFromParent(element);
    if(service != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/service/${service.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
