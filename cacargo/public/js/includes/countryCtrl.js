/**
 *
 */
 $(document).on('ready', function() {
   $('#dtble').DataTable({
     "order": [
       [ 0, "desc" ]
     ]
   });
   if (messages.language == 'en') {
     $('#dataTableSearch').attr('placeholder','Search...');
     $('#dtble_next').html('Next');
     $('#dtble_previous').html('Previous');
     $('.dataTables_empty').html('No data to show...');
   }
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
 *
 */
function searchCountry() {
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
function countryDelete(element, from) {
  try {
    var country = getItem(element) || getItemFromParent(element);
    if(country != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/country/${country.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
