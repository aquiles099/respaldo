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
  /**
  *
  */
 });
 /**
 *
 */
function searchTax() {
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
function taxDelete(element, from) {
  try {
    var tax = getItem(element) || getItemFromParent(element);
    if(tax != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/tax/${tax.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
