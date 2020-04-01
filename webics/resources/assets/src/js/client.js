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
var clientDelete = function (element, from) {
  try {
    var client = getItem(element) || getItemFromParent(element);
    if(client != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/clients/' + client.id, 'delete', undefined, from === undefined ? true : from);
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
var icsShowClient = function (client) {
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#icsload').load(CURRENT_LOCATION + "/" + client + "/view", function () {
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
