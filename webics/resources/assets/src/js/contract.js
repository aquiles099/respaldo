/**
* Javascrip Code
*/
'use strict';
/**
*
*/
$(document).on('ready', function () {
  $('#cut_off_date').datepicker({
    format: 'yyyy-mm-dd'
  });
});
/**
*
*/
var contractDelete = function (element, from) {
  try {
    var contract = getItem(element) || getItemFromParent(element);
    if(contract != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/contracts/' + contract.id, 'delete', undefined, from === undefined ? true : from);
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
var showContract = function (contract) {
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#icsload').load(CURRENT_LOCATION + "/" + contract + "/view" , function () {
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
