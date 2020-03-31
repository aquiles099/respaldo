/**
 *
 */
 /**
  * TRANSLATE OBJECT DEFINITION ************************************************
  */
 var translate = function() {
   console.log('entra');
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
       'settedDate' : 'Cantidad de paquetes en la fecha esatblecida',
       'sureDelete' : '¿Esta seguro que desea eliminar este Cargo?'

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
       'settedDate' : 'Packages in the indicated date',
       'sureDelete' : 'Are you sure want to delete this charge'
     });
   }
 }
 /**
  * ****************************************************************************
  */

 $(document).ready( function() {
  //  $('#dtble').DataTable({
  //    "order": [
  //      [ 0, "desc" ]
  //    ]
  //  });
  //  if (messages.language == 'en') {
  //    $('#dataTableSearch').attr('placeholder','Search...');
  //    $('#dtble_next').html('Next');
  //    $('#dtble_previous').html('Previous');
  //    $('.dataTables_empty').html('No data to show...');
  //  }
 });
/**
 *
 */
 var icsAddChargesDelete = function (element) {
   var text = translate();
   try {
     var charge = element;
     if(charge != undefined) {
       bootbox.confirm(text.sureDelete, function(result) {
         if(result) {
           doForm(`./admin/addcharge/`+charge, 'delete', undefined, true);
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
function searchOffice() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e) {

  }
}
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
 *
 */
function officeDelete(element, from) {
  try {
    var office = getItem(element) || getItemFromParent(element);
    if(office != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/office/${office.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
