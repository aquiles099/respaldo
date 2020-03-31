
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
/**
 * Buscar Transporte
 */
function searchTransport() {
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
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}
/**
 * Eliminar Transport
 */
function transportDelete(element, from) {
  try {
    var transport = getItem(element) || getItemFromParent(element);
    if(transport != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/service/${transport.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}

function view()
{

    /* Login button click handler */
    $('#loginButton').on('click', function() {
        bootbox
            .dialog({
                title: 'Login',
                message: $('#loginForm'),
                show: false /* We will show it manually later */
            })
            .on('shown.bs.modal', function() {
                $('#loginForm')
                    .show()                             /* Show the login form */
                    .formValidation('resetForm', true); /* Reset form */
            })
            .on('hide.bs.modal', function(e) {
                /**
                 * Bootbox will remove the modal (including the body which contains the login form)
                 * after hiding the modal
                 * Therefor, we need to backup the form
                 */
                $('#loginForm').hide().appendTo('body');
            })
            .modal('show');
    });



}

var adddetailstransport = function (){
    var path  =`${window.location.origin}${window.location.pathname}`;
    console.log(path + "/details/new");
    $('#load').load(path + "/details/new", function ()
    {
      $('#bckic').show();
    });
}
