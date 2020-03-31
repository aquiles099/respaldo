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
   $('select').select2();
 });
/**
 *
 */
function searchOffice() {
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
function officeDelete(element, from) {
  try {
    var office = getItem(element) || getItemFromParent(element);
    if(office != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/office/${office.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
