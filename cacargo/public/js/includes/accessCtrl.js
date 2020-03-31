/**
 *
 */
 $(document).on('ready', function() {
   $('#dtble').DataTable({
     "order": [
       [ 0, "desc" ]
     ]
   });
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
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}

var verifyUser = function () {
  var url      = asset('login')+"/load";
  var dataString =
    {
      'username' : $('#username').val(),
      'password' : $('#password').val()
    };
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: dataString,
        beforeSend: function ()
        {
          createLoad();
          $('#ics_user_notify').html('<i class="fa fa-spin fa-spinner"></i> Notificando a Usuario...');
        },
        success: function (json)
        {
         if((json.message)=='false'){
           bootbox.alert({
             title: "PERIODO DE PRUEBA VENCIDO",
             backdrop: true,
             message: "A partir de ahora solo podra acceder a sus datos en modo SOLO LECTURA, si dessea obtener mas informacion solicite ayuda o contactenos a traves del menu de ayude en la aplicacion.",
             buttons: {
               ok: {
                 label: 'Aceptar'
               }
             },
             callback: function (result) {
               if(result) {
                 //$('#formulario').submit();
                 //ENVIAR INFORMACION AL MODULO ADMINISTRATIVOonsubmit="verifyUser()"
                 //loadUserData();
                 $('#loginButton').removeAttr('disabled','true');
                 $('#divButton').html("<button type='submit' onclick = 'verifyUser()' id='loginButton' class='btn btn-primary pull-right'><i class='fa fa-save'></i> Guardar</button>");;
               }else{
                 $('#loginButton').removeAttr('disabled','true');
                 $('#divButton').html("<button type='submit' onclick = 'verifyUser()' id='loginButton' class='btn btn-primary pull-right'><i class='fa fa-save'></i> Guardar</button>");;
               }
             }
           });
         }else {
           $('#formulario').submit();
         }
        }
      });
      setTimeout(function () {

      }, 3000);
}

function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
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
