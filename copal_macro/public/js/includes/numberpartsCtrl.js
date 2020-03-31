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
  $('select').select2().on('select2:select', function(e)  {
        var el = $(e.currentTarget);
        if (el.attr('id') == 'from'){

        }
     });
  /**
  *
  */




});

var createLoad = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}

function pesovol(){
   var larg=$("#large").val();
   var anch=$("#width").val();
   var alto=$("#height").val();
   console.log(larg);
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;
   $("#volumetricweightm").val(Math.round(resultm).toString());
   $("#volumetricweighta").val(Math.round(resulta).toString());
}

function valselect(id){
  alert(id);
}




/**
 *
 */
var numberpartDelete =  function (element, from)
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
          doForm(`./admin/numberparts/${container.id}`, 'delete', undefined, from === undefined ? true : from);

}      });
    }

  } catch (e)
  {
    log(e);
  }
}
