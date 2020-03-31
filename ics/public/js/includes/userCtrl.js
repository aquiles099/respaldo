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
  $('#country').select2();
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
function userDelete(element, from) {
  try {
    var user = getItem(element) || getItemFromParent(element);
    if(user != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/user/${user.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
