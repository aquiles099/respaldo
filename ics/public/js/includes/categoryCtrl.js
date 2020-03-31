/**
 *
 */

 $(document).ready( function() {

 });
/**
 *
 */
function searchCategory() {
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
   var wait = (messages.language == 'es') ? 'Espere...':'Wait...';
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+wait+"</button>");
 }
 function loadButton(element) {
   var wait = (messages.language == 'es') ? 'Espere...':'Wait...';

  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+wait);
 }
function categoryDelete(element, from) {
  try {
    var category = getItem(element) || getItemFromParent(element);
    if(category != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/category/${category.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
