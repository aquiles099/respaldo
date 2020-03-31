/**
 *
 */
 $(document).ready( function()
 {
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
  $('#country').select2();
 });
/**
 *
 */
function userDelete(element, from) {
  try {
    var user = getItem(element) || getItemFromParent(element);
    if(user != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/user/${user.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
