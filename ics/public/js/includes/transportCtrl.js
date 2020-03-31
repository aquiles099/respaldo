/**
*
*/
'use strict';
/**
*
*/
$(document).ready( function() {
  
});
/**
 * Eliminar Transport
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

function transportDelete(element, from) {
  try {
    var transport = getItem(element) || getItemFromParent(element);
    if(transport != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/transport/${transport.id}`, 'delete', undefined, from === undefined ? true : from);
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
function view()
{
  $('#loginButton').on('click', function() {
      bootbox
        .dialog({
            title: 'Login',
            message: $('#loginForm'),
            show: false
        })
        .on('shown.bs.modal', function() {
            $('#loginForm')
                .show()
                .formValidation('resetForm', true);
        })
        .on('hide.bs.modal', function(e) {
            $('#loginForm').hide().appendTo('body');
        })
        .modal('show');
    });
}
/**
*
*/
var adddetailstransport = function (id){
    var path  =`${window.location.origin}${window.location.pathname}`;
    console.log(path + "/details/new/"+id);
    $('#load').load(path + "/details/new/"+id, function ()
    {
      $('#bckic').show();
    });
}
/**
*
*/
var detailstransport = function (id,open) {
  var path  = window.location.origin + window.location.pathname;
  /**
  *
  */
  if (open == 'true') {
    var sw    = 0;
    var alert = false;
    /**
    *
    */
    bootbox.dialog({
    title: "<a href='javascript:loadBacktransport("+id+")' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>Informacion</span>",
    message: $('#load').load(path + "/" + id + "/read", function() {
    }),
    size:"large"
    }).on('shown.bs.modal', function ()
    {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
    $('#load').hide().appendTo('body');
    })
    .modal('show');
    }
    else {
      $('#load').load(path + "/" + id + "/read", function(){});
    }
  }
/**
*
*/
var loadBacktransport = function (id)
{
  var path    =`${window.location.origin}${window.location.pathname}`;
  var url     = path +"/"+id+"/read";
  /**
  *
  */
  $('#bckic').hide();
  $('#tltgnif').html('Detalles');
  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
  /**
  *
  */
  $('#load').load(url, function ()
   {

   });
  showAlertInLoadBack(false); /** show succes alert callback **/
}
/**
*
*/
var showAlertInLoadBack = function (alert)
{
  if (alert == true)
  {
    $('#tltgnif').append('<div id="success" style="height: 45px"><div><div class = "alert alert-success"><b>procesado de manera correcta</b> <span><i class="fa fa-check" aria-hidden="true"></i></span></div></div>');
    setTimeout(function()
    {
      $( "#success" ).slideUp( 300 ).delay( 800 );
    }, 1500);

    $('#reload').val(alert);
  }
}
/**
* Ajax method for add port o airport
*/
var adddetails = function (id)
{
  var name=$('#name').val();
  var description=$('#description').val();
  var params1 = {
            "name": name,
            "description":description
            };

  var url   = `${window.location.origin}${window.location.pathname}` + "/details/new/"+id;


  $.ajax({
    url: url,
    type: 'POST',
    data: params1,
    beforeSend: function ()
    {
      $('#cl').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
    },
    success: function (json)
    {
       ((json.message == 'true') ? detailstransport(id,'false'): evalJson (json.alert))
    },
    error: function (jqXHR, textStatus, errorThrown)
        {
           if (jqXHR.status == 500) {
                    alert('Internal error: ' + jqXHR.responseText);
            } else {
                    alert(jqXHR.status);
            }
        }
  });

}
