/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {
  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  /**
  *
  */
});
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
    title: "<a href='javascript:icsLoadBackPort(false,"+id+")' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>Información</span>",
    message: $('#load').load(path, function() {
        $('#dtble2').dataTable();
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
  $('#tltgnif').html('Editar');
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
    message: "Seguro que desea eliminar este registro?",
    buttons: {
        confirm: {
            label: 'Aceptar',
            className: 'btn-primary'
        },
        cancel: {
            label: 'Cancelar',
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
            bootbox.alert('Ha ocurrido un error');
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
      bootbox.alert('Ha ocurrido un error');
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
        bootbox.alert('Ha ocurrido un error');
      }
    });
  }

}
