/**
* Javascript Code
*/
'use strict';
/**
*
*/
$(document).on('ready', function() {

});
/**
*
*/
var paymentDelete = function (element, from) {
  try {
    var payment = getItem(element) || getItemFromParent(element);
    if(payment != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if (result) {
          doForm('./admin/payments/' + payment.id, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
*  Cambiar estado de un pago
*/
var icsChangeStatusPayment = function (payment) {

  if ($("#description").val() === "" || $("#description").val() === null || $("#description").val()  === undefined) {
    $('#description').addClass('shake animated');
    bootbox.confirm('<strong>ATENCION:</strong> Agregue una descripcion', function (result) {
      $('#description').removeClass('shake animated');
    });
  } else {
    var data = $('#icsFormSerialize').serialize();
    $.ajax({
        url: CURRENT_LOCATION + "/" + payment ,
        type: 'PATCH',
        dataType: 'json',
        data: data,
        beforeSend: function () {
          icsGeneralLoad('sendButton');
        },
        success: function (json) {
          json.message === true ? icsDetails(payment, true) : icsShowErrorServer();
        },
        error: function () {
          icsShowErrorAjax();
        }
      });
  }
}
