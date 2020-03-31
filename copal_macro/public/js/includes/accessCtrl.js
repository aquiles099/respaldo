/**
 *
 */

 $(document).ready( function() {
   $('#dtble').DataTable({
     "order": [
       [ 0, "desc" ]
     ]
   });
 });
/**
 *
 */
function searchAccess() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e) {

  }
}

/**
 *
 */
function accessDelete(element, from) {
  try {
    var access = getItem(element) || getItemFromParent(element);
    if(access != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/security/access/${access.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
