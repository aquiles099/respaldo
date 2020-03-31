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
  $('select').select2();
  /**
  *
  */
});


/**
 *
 */
var containerDelete =  function (element, from)
{
  try
  {
    var container = getItem(element) || getItemFromParent(element);
    /**
    *
    */
    if(container != undefined)
    {
      bootbox.confirm(eval(msg(messages.delete)), function(result)
      {
        if(result)
        {
          doForm(`./admin/containers/${container.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }

  } catch (e)
  {
    log(e);
  }
}
