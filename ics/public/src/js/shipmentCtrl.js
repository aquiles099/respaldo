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
      'maxWeight' : 'Maximun file size is 8mb',
      'type' : 'Type',
      'maritime_selected' : 'Maritime selected'
    });
  }
}
var aux;
/**
*
*/
$(document).ready(function() {
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_shipper_select') {
      setShipperData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_entityToNotify_select') {
      setentityToNotifyData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')'));
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_cargoAgent_select') {
      setcargoAgentData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')'));
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_consigneer_select') {
      setconsigneerData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')'));
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_intermediate_select') {
      setintermediateData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')'));
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_destinyAgent_select') {
      setdestinyAgentData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')'));
    }
  });
  /**
  *
  */
  $('#realizationDate_shipment').datepicker({
      dateFormat:    "yy-mm-dd",
  });
  /**
  *
  */
  $('#realizationHour_shipment').datetimepicker({
      format: 'HH:mm:ss'
  });
  /**
  *
  */
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
  $('#dtble2').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  if (messages.language == 'en') {
    $('#dataTableSearch').attr('placeholder','Search...');
    $('#dtble2_next').html('Next');
    $('#dtble2_previous').html('Previous');
    $('.dataTables_empty').html('No data to show...');
  }
  /**
  *
  */
  $('#dtble3').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  if (messages.language == 'en') {
    $('#dataTableSearch').attr('placeholder','Search...');
    $('#dtble3_next').html('Next');
    $('#dtble3_previous').html('Previous');
    $('.dataTables_empty').html('No data to show...');
  }
  /**
  *
  */
  aux  = $('#ics_Hd_Count_Cargo').val() == '' ? 0 : $('#ics_Hd_Count_Cargo').val();
  aux  = parseInt(aux);
  /**
  *
  */
  initDropzone();
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
var initDropzone = function() {
  Dropzone.options.myDropzone = {
    autoProcessQueue: false,
    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 8,
    addRemoveLinks: true,
    dictRemoveFile: 'eliminar',
    dictFileTooBig: 'Image is bigger than 8MB',
    init: function() {
      var submitButton = document.querySelector("#submit-all");
      var myDropzone = this;
      /**
      *
      */
      submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        myDropzone.processQueue();
        $("#ics_shipmen_form").submit();
      });
      /**
      *
      */
      this.on("addedfile", function() {
      });
      /**
      *
      */
      this.on("complete", function(file) {
        myDropzone.removeFile(file);
      });
      /**
      *
      */
      this.on("success",
        myDropzone.processQueue.bind(myDropzone)
      );
      /**
      *
      */
      myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("filesize", file.size);
      });
    }
  };
}
/**
*
*/

function initSelect2() {
  if ($('#containerized').val()==1) {
    $('#container_name').css('display', 'none');
  }else {
    $('#container_name').css('display', 'block');
  }
  $('select').select2(
    {
      width: '100%'
      //placeholder: "Select a client",
      //allowClear: true
    }).on('select2:select', function(e) //seleccionar cualquier opcion del select
    {
      var el = $(e.currentTarget);
      if (el.attr('id') == 'containerized') {
        //CONTAINER
        if ($('#containerized').val()==0) {
          $('#container_name').toggle('true');
        }else
        if ($('#containerized').val()==1) {
          $('#container_name').css('display', 'none');
        }
      }
      if (el.attr('id') == 'aduana') {
      //ADUANA
      if ($('#aduana').val()==0) {
        $('#aduana_name').toggle('true');
      }else
        if ($('#aduana').val()==1) {
          $('#aduana_name').css('display', 'none');
        }
      }
    });

}

var icsChangeStatusShipment = function (shipment) {
  var status      = $('#ics_shipment_status').val();
  var observation = $('#observation').val();
  var url    = window.location.origin + window.location.pathname + '/' + shipment + '/read';
  $.ajax({
    url: url,
    method: 'POST',
    dataType:'json',
    data: {
      'status'      : status,
      'observation' : observation
    },
    beforeSend: function () {

    },
    success: function (json) {
      if (json.message == true) {
        $('#load').load(url, function () {
          $('select').select2();
        });
      }
    },
    error: function (e) {
      bootbox.alert('Error: ' + e.message );
    }
  });
}
/**
*
*/
var icsSetTypeShipment = function (id, edit, shipment) {
  var root = `${window.location.origin}`;
  if(root=='http://localhost'){
    root = `${window.location.origin}`+"/ics-app-version-2.0/public";
  }
  var url = (edit == false) ? root +'/admin/shipments/new/' + id + '/type/shipment/' + shipment : root +'/admin/shipments/new/'+ id + '/type/shipment/' + shipment;
  var text = translate();
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: id,
    beforeSend: function () {
      $('#ics_load').html("<i class='fa fa-spin fa-spinner'></i> "+text.loading);
    },
    success: function (json) {
      /**
      * Cargando formulario de informacion general
      */
      $('#ics_complentary_info').load(json.generalInfo ,function() {
        /**
        *
        */
        if(id == 1) {
          /**
          *
          */
          $('#since_departure_maritime').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          /**
          *
          */
          $('#since_arrived_maritime').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          /**
          *
          */
          $('#hour_arrived_maritime').datetimepicker({
             format: 'HH:mm:ss'
          });
          /**
          *
          */
          $('#hour_departure_maritime').datetimepicker({
             format: 'HH:mm:ss'
          });
          /**
          *
          */
          $('#ics_selected_item').html(eval(msg(messages.maritime_selected)));
        }
        /**
        *
        */
        if(id == 2) {

          $('#since_departure_maritime').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          $('#hour_departure_maritime').datetimepicker({
             format: 'HH:mm:ss'
          });
          $('#carrier_aerial').select2();
          /**
          *
          */
          $('#ics_selected_item').html(eval(msg(messages.aerial_selected)));
        }
        /**
        *
        */
        if(id == 3) {
          /**
          *
          */
          $('#ics_selected_item').html(text.maritime_selected);
        }
      });
      /**
      * Cargando informacion de rutas
      */
      $('#ics_fielset_load_routes_info').load(json.routesInfo, function() {
        if(id == 1) {
          /**
          *
          */
          $('select').select2().on('select2:select', function(e) {

            if ($(e.currentTarget).attr('id') == 'vesselMaritime_shipment')
            {
              setVesselData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
            }
          });
        }
        /**
        *
        */
        if(id== 2) {
          /**
          *
          */
          $('#departureDateAerial_shipment').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          /**
          *
          */
          $('#arrivedDateAerial_shipment').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          /**
          *
          */
          $('#hourDepeartureAerial_shipment').datetimepicker({
             format: 'HH:mm:ss'
          });
          /**
          *
          */
          $('#hourArrivedAerial_shipment').datetimepicker({
             format: 'HH:mm:ss'
          });
          /**
          *
          */
          $('select').select2();
        }
        /**
        *
        */
        if(id == 3) {
          /**
          *
          */
          $('#fromDateGround_shipment').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          /**
          *
          */
          $('#toDateGround_shipment').datepicker({
          dateFormat:    "yy-mm-dd",
          });
          /**
          *
          */
          $('#fromHourGround_shipment').datetimepicker({
             format: 'HH:mm:ss'
          });
          /**
          *
          */
          $('#toHourGround_shipment').datetimepicker({
             format: 'HH:mm:ss'
          });
          /**
          *
          */
          $('select').select2();
        }
      });
    },
    error: function () {
      log('no se ha cargado' + url);
    },
    complete: function () {
        $('#ics_load').html("");
    }
  });
  /**
  * set shipment type to hidden field
  */
  $('#ics_Hd_Type_Shipment').val(id);

}
/**
*
*/
var icsShipmentDelete = function(element, from) {
  try {
    var shipment = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + shipment.id;
    /**
    *
    */
    if(shipment != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
    /**
    *
    */
  } catch (e) {
    log(e);
  }
}
/**
* se asigna bandera del buque
*/
var setVesselData = function (item) {
  if (item)
  {
    $('#vesselFlagMaritime_shipment').val(item.flag);
    $('#vesselFlagMaritime_shipment').attr('readonly', true);
  }
  else
  {
    $('#vesselFlagMaritime_shipment').val('');
    $('#vesselFlagMaritime_shipment').attr('readonly', false);
  }
}
/**
*
*/
var setShipperData = function (item)
{
  if (item)
  {
    $('#ics_shipper_name').val(item.name);
    $('#ics_shipper_address').val(item.address);
    $('#ics_shipper_name').attr('readonly', true);
    $('#ics_shipper_address').attr('readonly', true);
  }
  else
  {
    $('#ics_shipper_name').val('');
    $('#ics_shipper_address').val('');
    $('#ics_shipper_name').attr('readonly', false);
    $('#ics_shipper_address').attr('readonly', false);
  }
}
/**
*
*/
var setentityToNotifyData = function (item) {
  if (item)
  {
    $('#ics_entityToNotify_name').val(item.name);
    $('#ics_entityToNotify_address').val(item.address);
    $('#ics_entityToNotify_name').attr('readonly', true);
    $('#ics_entityToNotify_address').attr('readonly', true);
  }
  else
  {
    $('#ics_entityToNotify_name').val('');
    $('#ics_entityToNotify_address').val('');
    $('#ics_entityToNotify_name').attr('readonly', false);
    $('#ics_entityToNotify_address').attr('readonly', false);
  }
}
/**
*
*/
var setcargoAgentData = function (item) {
  if (item)
  {
    $('#ics_cargoAgent_name').val(item.name);
    $('#ics_cargoAgent_address').val(item.address);
    $('#ics_cargoAgent_name').attr('readonly', true);
    $('#ics_cargoAgent_address').attr('readonly', true);
  }
  else
  {
    $('#ics_cargoAgent_name').val('');
    $('#ics_cargoAgent_address').val('');
    $('#ics_cargoAgent_name').attr('readonly', false);
    $('#ics_cargoAgent_address').attr('readonly', false);
  }
}
/**
*
*/
var setconsigneerData = function (item) {
  if (item)
  {
    $('#ics_consigneer_name').val(item.name);
    $('#ics_consigneer_address').val(item.address);
    $('#ics_consigneer_name').attr('readonly', true);
    $('#ics_consigneer_address').attr('readonly', true);
  }
  else
  {
    $('#ics_consigneer_name').val('');
    $('#ics_consigneer_address').val('');
    $('#ics_consigneer_name').attr('readonly', false);
    $('#ics_consigneer_address').attr('readonly', false);
  }
}
/**
*
*/
var setintermediateData = function (item) {
  if (item)
  {
    $('#ics_intermediate_name').val(item.name);
    $('#ics_intermediate_address').val(item.address);
    $('#ics_intermediate_name').attr('readonly', true);
    $('#ics_intermediate_address').attr('readonly', true);
  }
  else
  {
    $('#ics_intermediate_name').val('');
    $('#ics_intermediate_address').val('');
    $('#ics_intermediate_name').attr('readonly', false);
    $('#ics_intermediate_address').attr('readonly', false);
  }
}
/**
*
*/
var setdestinyAgentData = function (item) {
  if (item)
  {
    $('#ics_destinyAgent_name').val(item.name);
    $('#ics_destinyAgent_address').val(item.address);
    $('#ics_destinyAgent_name').attr('readonly', true);
    $('#ics_destinyAgent_address').attr('readonly', true);
  }
  else
  {
    $('#ics_destinyAgent_name').val('');
    $('#ics_destinyAgent_address').val('');
    $('#ics_destinyAgent_name').attr('readonly', false);
    $('#ics_destinyAgent_address').attr('readonly', false);
  }
}


var countimg=0;
function preview_image()
{
 var res=countimg+1;
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
   var text = translate();
  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>"+text.delete+"</a>");
 }
}

function remove_preview(id){
  $('#'+id).remove();
}
