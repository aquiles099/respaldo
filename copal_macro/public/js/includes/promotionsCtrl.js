/**
 *
 */
 $(document).ready( function() {
   $('#dtble').DataTable({
     "order": [
       [ 0, "desc" ]
     ]
   });
  /**
  *
  */
  $('#dtps').datepicker({
      dateFormat:    "yy-mm-dd",
  });
  /**
  *
  */
  $('#dtpe').datepicker({
      dateFormat:    "yy-mm-dd",
  });
  /**
  *
  */
  $('select').select2();
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
/**
 * Funcion JavaScipt Para Buscar Promociones
 */
function searchPromotions()
{
  try
  {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '')
    {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  }
  catch(e)
  {

  }
}

/**
 * Funcion JavaScript Para Eliminar una Promocion
 */
function promotionsDelete(element, from)
{
  try
  {
    var promotion = getItem(element) || getItemFromParent(element);
    if(promotion != undefined)
    {
      bootbox.confirm(eval(msg(messages.delete)), function(result)
      {
        if(result)
        {
          doForm(`./admin/promotions/${promotion.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }
  catch (e)
  {
    log(e);
  }
}
