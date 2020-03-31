/**
 *
 */
function searchClient() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e) {

  }
}

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
function clientDelete(element, from) {
  try {
    var client = getItem(element) || getItemFromParent(element);
    if(client != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/company/${client.get_company.id}/clients/${client.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
