
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
  $('#profile').select2();
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
function searchOperator()
{
  try
  {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '')
    {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  } catch(e)
  {

  }
}

/**
 *
 */
function operatorDelete(element, from){
  try {
    var operator = getItem(element) || getItemFromParent(element);
    if(operator != undefined){
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
         if(result) {
           doForm(`./admin/operators/${operator.id}`, 'delete', undefined, from === undefined ? true : from);
         }
      });
    }
  } catch (e)
  {
    log(e);
  }
}

/**
*
*/
var submitFormOperator = function ()
{
  $('#loadRecover').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
}
