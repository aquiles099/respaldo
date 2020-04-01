/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {

});
/**
*
*/
var mailDelete = function (element, from) {
  try {
    var mail = getItem(element) || getItemFromParent(element);
    if(mail != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/mails/' + mail.id, 'delete', undefined, from === undefined ? true : from);
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
var icsShowMail = function (mail) {
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#icsload').load(CURRENT_LOCATION + "/" + mail , function () {
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
