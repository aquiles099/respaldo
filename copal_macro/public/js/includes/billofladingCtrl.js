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
var billoflading = function (id)
{
  console.log(id);
  var url = `${window.location.origin}${window.location.pathname}/newbill/`+id;
  console.log(url);

  bootbox.dialog
  ({
    title: "<span id=''>Creacion del Bill of Lading</span>",
    message: $('#load').load(url, function ()
    {

    }),
    size: "medium"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');

  })
  .modal('show');
}
