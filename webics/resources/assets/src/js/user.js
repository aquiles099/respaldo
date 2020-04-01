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
var userDelete = function (element, from) {
  try {
    var user = getItem(element) || getItemFromParent(element);
    if(user != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/users/' + user.id, 'delete', undefined, from === undefined ? true : from);
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
var icsShowUser = function (user) {
  $('#icsload').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
   bootbox.dialog({
     title: "<span id='tltgnif'>Información</span>",
     message: $('#icsload').load(CURRENT_LOCATION + "/" + user + "/view", function () {
       $('select').select2();
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
