/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {
/**
*
*/
$('#dtble').DataTable({
  "order": [
    [ 0, "desc" ]
  ]
});
/**
*
*/
$('#ics_transport_type_transport').select2();
});
/**
*
*/
var icstransportTypeDelete = function(element, from) {
  try {
    var transport_type = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + transport_type.id;
    /**
    *
    */
    if(transport_type != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
    /**
    *
    */
  } catch (e) {
    log(e);
  }
}
