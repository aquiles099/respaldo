/**
* Javascrip Code
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
var incidenceDelete = function (element, from) {
  try {
    var incidence = getItem(element) || getItemFromParent(element);
    if(incidence != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/incidences/' + incidence.id, 'delete', undefined, from === undefined ? true : from);
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
var icsResolveIncidence = function (incidence, panel, contain) {
  bootbox.confirm(eval(msg(messages.resolve)), function(result) {
    if (result) {
      icsExcuteResolveIncidence(incidence, panel, contain);
    }
  });
}
/**
*
*/
var icsExcuteResolveIncidence = function (incidence, panel, contain) {
  $.ajax({
    url: CURRENT_LOCATION + "/" + incidence,
    type: 'PATCH',
    dataType: 'json',
    beforeSend: function () {
      icsGeneralLoad(panel);
      $('#' + contain).addClass('animated fadeOutUp');
    },
    success: function (json) {
      json.message === true ? icsAutoReload()  : icsShowErrorServer();
    },
    error: function () {
      icsShowErrorAjax();
    }
  });
}
/**
*
*/
var icsResolveBug = function (bug, panel, contain) {
  bootbox.confirm(eval(msg(messages.bugresolve)), function(result) {
    if (result) {
      icsExcuteResolveBug(bug, panel, contain);
    }
  });
}
/**
*
*/
var icsExcuteResolveBug = function (bug, panel, contain) {
  $.ajax({
    url: CURRENT_LOCATION + "/" + bug,
    type: 'PATCH',
    dataType: 'json',
    beforeSend: function () {
      icsGeneralLoad(panel);
      $('#' + contain).addClass('animated fadeOutUp');
    },
    success: function (json) {
      json.message === true ? icsAutoReload()  : icsShowErrorServer();
    },
    error: function () {
      icsShowErrorAjax();
    }
  });
}
/**
*
*/
var showIncidence =  function (incidence) {
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#icsload').load(CURRENT_LOCATION + "/" + incidence + "/view" , function () {
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
