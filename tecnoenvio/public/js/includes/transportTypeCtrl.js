/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {
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
$('#ics_transport_type_transport').select2();

$('select').select2();
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
var icstransportTypeDelete = function(element, from) {
  try {
    var transport_type = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + transport_type.id;
    /**
    *
    */
    if(transport_type != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
    /**
    *
    */
  } catch (e) {
    log(e);
  }
}
