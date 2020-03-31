/**
 *
 */
 $(document).on('ready', function() {
   $('#dtble').DataTable({
     "order": [
       [ 0, "desc" ]
     ]
   });
   /**
   *
   */
   $('select').select2({
    width:'100%'
   });
 });
/**
 *
 */
function searchOperator() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e) {

  }
}
var createLoad = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
function loadButton() {
 $('#divButton').attr('disabled','true');
 $('#divButton').html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}
/**
 *
 */
function operatorDelete(element, from) {
  try {
    var operator = getItem(element) || getItemFromParent(element);
    if(operator != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
         if(result) {
           doForm(`./admin/operator/${operator.id}`, 'delete', undefined, from === undefined ? true : from);
         }
      });
    }
  } catch (e) {
    log(e);
  }
}

/**
*
*/
var submitFormOperator = function () {
  createLoad();
  $('#loadRecover').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
}
