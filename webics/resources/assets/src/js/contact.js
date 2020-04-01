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
var contactDelete = function (element, from) {
  try {
    var contact = getItem(element) || getItemFromParent(element);
    if(contact != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/contacts/' + contact.id, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
