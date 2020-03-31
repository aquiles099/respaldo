/**
*
*/
'use strict';

/**
 * TRANSLATE OBJECT DEFINITION ************************************************
 */
var translate = function() {
  if (messages.language == 'es') {
    return ({
      'wait' : 'Espere...'
    });
  }else {
    return({
      'wait' : 'Wait...'
    });
  }
}
/**
 * ****************************************************************************
 */
/**
*
*/
$(document).ready( function()
{
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
   var text = translate();
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+text.wait+"</button>");
 }
 function loadButton(element) {
    var text = translate();
    $(element).attr('disabled','true');
    $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + text.wait);
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
