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
   var wait = (messages.language == 'es') ? 'Espere...':'Wait...';
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+wait+"</button>");
 }
 function loadButton(element) {
   var wait = (messages.language == 'es') ? 'Espere...':'Wait...';

  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+wait);
 }
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
