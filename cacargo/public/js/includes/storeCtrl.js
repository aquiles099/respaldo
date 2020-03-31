/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {
    $('#dtble').dataTable();
});
/**
* Borrar una tienda
*/
function icsStoreDelete(element, from) {
  try {
    var store = getItem(element) || getItemFromParent(element);
    if(store != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/store/${store.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }
  catch (e) {
    log(e);
  }
}
