/**
 *
 */

 $(document).ready( function() {
  //  $('#dtble').DataTable({
  //    "order": [
  //      [ 0, "desc" ]
  //    ]
  //  });
 });
/**
 *
 */
function searchAccess() {
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
  var wait = (messages.language == 'es') ? 'Espere...':'Wait...';
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+wait+"</button>");
}
function loadButton(element) {
  var wait = (messages.language == 'es') ? 'Espere...':'Wait...';

 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+wait);
}

/**
 *
 */
function accessDelete(element, from) {
  try {
    var access = getItem(element) || getItemFromParent(element);
    if(access != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/security/access/${access.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
