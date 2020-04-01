/**
* Javascrip Code
*/
'use strict';
/**
* verficar la carga de todo el documento
*/
$(document).on('ready', function() {

});
/**
* Eliminar una solicitud
*/
var solicitudeDelete = function (element, from) {
  try {
    var solicitude = getItem(element) || getItemFromParent(element);
    if(solicitude != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/solicitudes/' + solicitude.id, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
* Validar la actualizacion de una solicitud
*/
var icsUpdateSolicitude = function (solicitude) {

  var status = $("#status option:selected").val();
  var subdomain = $('#sub').val();

  if (icsValidateSubDomain(subdomain)) {
    icsExecuteUpdateSolicitude(solicitude);
  }
  else {
    if (subdomain !== undefined) {
      if (status === DENIED_STATUS) {
        icsExecuteUpdateSolicitude(solicitude);
      } else {
        $('#sub').addClass('shake animated');
        bootbox.confirm('<strong>ATENCION:</strong> Verifique el Subdominio a Registrar', function (result) {
          $('#sub').removeClass('shake animated');
        });
      }
    } else {
      icsExecuteUpdateSolicitude(solicitude);
    }
  }
}
/**
* Pasar una prueba a contrato
*/
var icsDoContract = function (element, from) {
  try {
    var solicitude = getItem(element) || getItemFromParent(element);
    if(solicitude != undefined) {
      bootbox.confirm(eval(msg(messages.test)), function(result) {
        if(result) {
          doForm('./admin/solicitudes/' + solicitude.id, 'post', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
* Validate Patter[subdomain]
*/
var icsValidateSubDomain = function (url) {
  var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
  return pattern.test(url);
}
/**
* Ejecutar la actualizacion de una solictud
*/
var icsExecuteUpdateSolicitude = function (solicitude) {
  var dataString = $('#icsserializeform').serialize();
  $.ajax({
      url: CURRENT_LOCATION + "/" + solicitude,
      type: 'PATCH',
      dataType: 'json',
      data: dataString,
      beforeSend: function () {
        icsGeneralLoad('sendButton');
      },
      success: function (json) {
        json.message === true ? icsDetails(solicitude, true)  : icsShowErrorServer();
      },
      error: function () {
        icsShowErrorAjax();
      }
    });
}
/**
* Ver datos del cliente solicitante en el modal
*/
var icsViewInfoApplicant = function (solicitude, client) {
  $('#icsArrowBack').html('<a onclick="icsDetails('+ solicitude +', true)" class="icslinkdetails"><i class="fa fa-chevron-left" aria-hidden="true"></i></a> ');
  $('#icsload').load(CURRENT_LOCATION + "/" + solicitude + "/viewClient", function (response, status, xhr) {
    if ( status == "error" ) {
      $( "#icsload" ).html('<strong>Error</strong><div class="alert alert-danger" role="alert"> "Se ha encontrado un error en el Servidor: <strong>'  + xhr.status + " " + xhr.statusText  + '"</strong></div>');

    }
  });
}
