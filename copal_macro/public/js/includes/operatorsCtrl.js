
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
  $('#profile').select2();
 });
 /**
 *
 */
function searchOperator()
{
  try
  {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '')
    {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e)
  {

  }
}

/**
 *
 */
function operatorDelete(element, from){
  try {
    var operator = getItem(element) || getItemFromParent(element);
    if(operator != undefined){
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
         if(result) {
           doForm(`./admin/operators/${operator.id}`, 'delete', undefined, from === undefined ? true : from);
         }
      });
    }
  } catch (e)
  {
    log(e);
  }
}

/**
*
*/
var submitFormOperator = function ()
{
  $('#loadRecover').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
}
