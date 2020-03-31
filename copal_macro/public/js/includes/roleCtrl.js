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
function searchRole() {
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
function roleDelete(element, from) {
  try {
    var role = getItem(element) || getItemFromParent(element);
    if(role != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/security/role/${role.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
