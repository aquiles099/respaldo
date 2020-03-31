/**
 *
 */
'use strict';
/**
*
*/
 $(document).ready( function() {
   $('#dtble').DataTable({
     "order": [
       [ 0, "desc" ]
     ]
   });
  $('select').select2();

 });
/**
 *
 */
var serviceDelete = function(element, from) {
  try {
    var service = getItem(element) || getItemFromParent(element);
    if(service != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/service/${service.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
