/**
*
*/
'use strict';
/**
*
*/
$(document).ready( function() {
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
$('#ics_city_country').select2();
/**
*
*/
});
/**
*
*/
var icsCityDelete = function(element, from) {
  try {
    var city = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + state.id;
    /**
    *
    */
    if(city != undefined) {
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
