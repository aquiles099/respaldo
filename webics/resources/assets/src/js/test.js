/**
* Javascrip Code
*/
'use strict';
/**
*
*/
$(document).on('ready', function() {
    icsGetAllTests();
});
/**
*
*/
var testDelete = function (element, from) {
  try {
    var test = getItem(element) || getItemFromParent(element);
    if(test != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/tests/' + test.id, 'delete', undefined, from === undefined ? true : from);
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
var icsChangeStatusTest = function (test) {
  var dataString = $('#icsserializeform').serialize();
  $.ajax({
      url: CURRENT_LOCATION + "/" + test,
      type: 'PATCH',
      dataType: 'json',
      data: dataString,
      beforeSend: function () {
        icsGeneralLoad('sendButton');
      },
      success: function (json) {
        json.message === true ? icsDetails(test, true)  : icsShowErrorServer();
      },
      error: function () {
        icsShowErrorAjax();
      }
    });
}
/**
*
*/
var icsTestDoContract = function (element, from) {
  try {
    var test = getItem(element) || getItemFromParent(element);
    if(test != undefined) {
      bootbox.confirm(eval(msg(messages.contract)), function(result) {
        if(result) {
          doForm('./admin/tests/' + test.id, 'post', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
* 1) se consume el servicio de ics-app se recibe el url[compuesto por el subdominio del usuario + id de la prueba]
* 2) una vez procesada la consulta en la aplicacion se recibe 'true' cuando se haya encontrado la prueba y los terminos y condiciones sean aceptados | 'false' cuando los mismos no se hayan aceptado
* 3) en dado caso que se hayan aceptado los términos y condiciones se recibe la fecha de aceptacion de los mismos
* 4) se recibe el id de la prueba[enviado mediante la funcion icsLoopTests] para hacer el llamado a la funcion que escribe el status y la fecha de aceptacion de los terminos y condiciones[icsSetStatusTest]
*/
var icsGetExternalUrl = function (path, test) {
  $.ajax({
    url: path,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {
      $('#icsLoadExternal').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Verificando Pruebas...')
    },
    success: function (json) {
      $('#icsLoadExternal').html('');
      icsSetStatusTest(json.message, json.terms_date, json.operators, json.clients, test);
    },
    error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    }
  });
}
/**
* 1) se obtienen todas las pruebas encontradas en la base de datos de webics
* 2) una vez recibidas las pruebas se hace un llamado a la funcion que procesa la iteracion[icsLoopTests]
*/
var icsGetAllTests = function () {
  $.ajax({
    url: CURRENT_LOCATION + '/ajax/all',
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {

    },
    success: function (json) {
      icsLoopTests(json.tests);
    },
    error: function(xhr, status, error) {
      bootbox.alert('Error obteniendo listado de prueba' + error);
    }
  });
}
/**
* 1) se comienza la iteracion de cada prueba
* 2) para consolidar este proceso se concatena el subdominio que fue creado al momento de registrar la prueba + la url definina en la app[/admin/api/operator/] +  el correo de la empresa a la cual se le asigno dicho subdominio
* 3) se envia a la funcion que consume la url[icsGetExternalUrl] el id de la prueba
*/
var icsLoopTests = function (json) {
  $.each(json, function(i, item) {
    icsGetExternalUrl(json[i].sub_domain + "/admin/api/operator/" + json[i].email, json[i].id);
  });
}
/**
* 1) se recibe 'status' que indica el valor de los terminos y condiciones[verdadero|falso], 'date' lo cual contiena la fecha de aceptacion de los terminos y condiciones, y por ultimo 'test' que indica el id de la prueba
* 2) los parametros recibidos se envian al servidor para ser procesados por el sistema
*/
var icsSetStatusTest = function (status, date, operators, clients, test) {
  $.ajax({
    url: CURRENT_LOCATION + "/" + test + "/review",
    type: 'PATCH',
    dataType: 'json',
    data : {
      'status': status,
      'date': date,
      'operators': operators,
      'clients': clients
    },
    beforeSend: function () {

    },
    success: function (json) {
      log(json);
    },
    error: function(xhr, status, error) {
      bootbox.alert('Error asignando estatus de prueba' + error);
    }
  });
}
/**
* Se muestra la fecha de los terminos y condiciones
*/
var icsShowTerms = function (test) {
  $.ajax({
    url: CURRENT_LOCATION + "/" + test + "/terms",
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {

    },
    success: function (json) {
      if (json.message == true ) {
        bootbox.dialog({
          title: "<span id='tltgnif'>Información</span>",
          message:"<p><strong>Fecha de Aceptacion: </strong></p>" + json.terms ,
          size: "small",
          backdrop: true,
          onEscape: function() {},
        })
        .on('shown.bs.modal', function () {
          $('#icsload').show();
        })
        .on('hide.bs.modal', function (e) {
          $('#icsload').hide().appendTo('body');
        })
        .modal('show');
      }
    },
    error: function(xhr, status, error) {
      bootbox.alert('Error asignando estatus de prueba' + error);
    }
  });
}
