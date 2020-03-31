/**
*
*/
'use strict';
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
  $('select').select2();
  /**
  *
  */
});


/**
 *
 */

 var createLoad = function ()
 {
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
 }
 function loadButton(element) {
  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
 }
var tpickupDelete =  function (element, from)
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
          doForm(`./admin/tpickup/${container.id}`, 'delete', undefined, from === undefined ? true : from);

}      });
    }

  } catch (e)
  {
    log(e);
  }
}
