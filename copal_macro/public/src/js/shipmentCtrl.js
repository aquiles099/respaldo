/**
*
*/
'use strict';
/**
*
*/
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
  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  /**
  *
  */
  $('#dtble2').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  /**
  *
  */
  $('#dtble3').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
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
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
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

  var url = (edit == false) ? window.location.origin + window.location.pathname + '/' + id + '/type/shipment/' + shipment : window.location.origin + AUX_PATH + '/admin/shipments/new/'+ id + '/type/shipment/' + shipment ;
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: id,
    beforeSend: function () {
      $('#ics_load').html("<i class='fa fa-spin fa-spinner'></i> Cargando...");
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
          $('#ics_selected_item').html('(Maritimo Seleccionado)');
        }
        /**
        *
        */
        if(id == 2) {
          $('#carrier_aerial').select2();
          /**
          *
          */
          $('#ics_selected_item').html('(Aereo Seleccionado)');
        }
        /**
        *
        */
        if(id == 3) {
          /**
          *
          */
          $('#ics_selected_item').html('(Terrestre Seleccionado)');
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

  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>Eliminar</a>");
 }
}

function remove_preview(id){
  console.log
  $('#'+id).remove();
}
