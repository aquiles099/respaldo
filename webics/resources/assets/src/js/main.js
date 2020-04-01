/**
* Javascrip Code
*/
'use strict';
/**
*
*/
var CURRENT_LOCATION = window.location.origin + window.location.pathname;
var DENIED_STATUS = '12';
/**
*
*/
$(document).on('ready', function() {
  /**
  * Se inicializa dataTable
  */
  $('#icstable').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  /**
  *
  */
   $("body").append("<div id='icsload' class='icsload'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Cargando...</p></div>");
   /**
   *
   */
   $('select').select2();
   /**
   *
   */
   $('#years').select2().on('select2:select', function(e) {
      var elemento=eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
      icsSetPaymentAmount(elemento);
    });
});
/**
 *
 */
function log(msg) {
  console.log(msg);
}
/**
 *s
 */
function msg(msg) {
  return '`' + msg + '`';
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
var icsSetPaymentAmount = function (data) {
  if (data) {
      $('#total').val(data.annual);
      $('#debt').html(data.annual);
  } else {
      $('#total').val('');
      $('#total').html('');
  }
}
/**
* asigna el formulario para el tipo de pago [paypal-deposito bancario-transferencia]
*/
var icsSetPaymentMode = function (type) {
  if (type !== '0') {
    var p = $('#icsp').val();
    $('#icsbannerpayment').html('<div class="icsinnerpayment" id="icsinnerpayment" fadeInUp animated"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Espere...</div>');
    setTimeout(function() {
      $('#icsbannerpayment').load(CURRENT_LOCATION + '/' + type, {'p': p});
    }, 1000);
  }
}
/**
*
*/
var icsOthersPayment = function () {
  var p = $('#p').val();
  bootbox.dialog({
    title: "<span id='tltgnif'>Pagar ICS</span>",
    message: $('#icsload').load(CURRENT_LOCATION + "/other",{'p':p} , function () {

    }),
    size: "large",
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
/**
*
*/
var icsDetails = function (id, open) {
  if (open === false) {
    $('#icsload').html('<p><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Cargando...</p>');
     bootbox.dialog({
       title: "<span id='icsArrowBack'></span><span id='tltgnif'>Información</span>",
       message: $('#icsload').load(CURRENT_LOCATION + "/" + id, function () {

       }),
       size: "large",
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
  } else {
    $('#icsload').load(CURRENT_LOCATION + "/" + id, function () {
      if ($('#icsArrowBack') !== undefined) {
        $('#icsArrowBack').html('');
      }
    });
  }
}
/**
*
*/
var modalTable = function (id, url, open) {
  if (open === false) {
    $('#icsload').html('<p><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Cargando...</p>');
     bootbox.dialog({
       title: "<span id='icsArrowBack'></span><span id='tltgnif'>Solicitudes</span>",
       message: $('#icsload').load(CURRENT_LOCATION + "/" + id + "/" + url, function () {
         $('#solicitudeTable').DataTable({
           "order": [
             [ 0, "desc" ]
           ]
         });
         $('#solicitudeTable_length').hide();
       }),
       size: "large",
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
  } else {
    $('#icsload').load(CURRENT_LOCATION + "/" + id + "/" + url, function () {
      if ($('#icsArrowBack') !== undefined) {
        $('#icsArrowBack').html('');
      }
    });
  }
}
/**
*
*/
var icsReadNew = function (notice) {
  $.ajax({
      url: CURRENT_LOCATION + "/" + notice,
      type: 'GET',
      dataType: 'json',
      data: notice,
      beforeSend: function () {
        $('#icsTitleNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
        $('#icsExtractNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
        $('#icsDescriptionNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
        $('#icsPrgImgNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
      },
      success: function (json) {
        json.message === true ? icsSetDataNotice(json.notice)  : icsShowErrorServer();
      },
      error: function () {
        icsShowErrorAjax();
      }
    });
}
/**
*
*/
var icsSetDataNotice = function (notice) {
  $('#icsTitleNew').html(notice.title);
  $('#icsExtractNew').html(notice.extract);
  $('#icsDescriptionNew').html(notice.description);
  $('#icsPrgImgNew').html(notice.img !== null ? "<img src="+ notice.img +" alt = 'ICS NOTICIAS "+ notice.extract +"'>" : '' );
}
/**
*
*/
var icsShowErrorServer = function () {
  bootbox.alert('ERROR: No se pudo realizar la accion..!!');
}
/**
*
*/
var icsShowErrorAjax = function () {
  bootbox.alert('ERROR: No se pudo completar la solicitud asincrona');
}
/**
*
*/
var icsGeneralLoad = function (element) {
  $('#' + element).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Espere...');
  $('#' + element).prop('disabled', true);
}
/**
*
*/
var icsAutoReload = function () {
  location.reload();
}
/**
*
*/
var icsReloadSection = function (url, section) {
  $('#' + section).load(url, function () {

  })
}
/**
*
*/
var icsAutoBack = function () {
  return history.back();
}
/**
*
*/
var icsBackOnModal = function (path) {
  $('#icsload').load(path, function () {

  });
}
/**
*
*/
var icsDisableElement = function (element) {
    $('#' + element).prop('disabled', true);
}
