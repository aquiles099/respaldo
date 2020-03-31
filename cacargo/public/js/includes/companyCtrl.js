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
function searchCompany() {
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
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primarypull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}
/**
 *
 */
function companyDelete(element, from) {
  try {
    var company = getItem(element) || getItemFromParent(element);
    if(company != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/company/${company.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}


/**********************************************************************************************/
/**********************************************************************************************/
/*************************************________________*****************************************/
/************************************| Client Gestion |****************************************/
/************************************|________________|****************************************/
/************************************                  ****************************************/
/**********************************************************************************************/

/**
* ajax load the editClient view (VS)
*/
var editClient = function (id, user)
{
  var path    =`${window.location.origin}${window.location.pathname}`;
  var company = $('#cpldcl').val();
  var sw      = '1';
  var provs   = "";

  $('#tltgnif').html('Editar'); /** modifca el titulo del modal **/
  if(user == true)
  {
    path    = `${window.location.origin}`+ AUX_PATH +`/admin/user/`+ id +`/view`;
    $('#load').load(path , function ()
    {
        $('#load').removeClass('cl'); /** Redimensona el modal a su tamaño original **/
        $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview(3 , '+id+')"><span class="badge" title="Editar"><span class="glyphicon glyphicon-pencil"></span></span></a></div><input type="hidden" id="cpldcl" value = "1"><input type = "hidden" id="edtcl" value = "true">');
        $('#bckic').show();
    });
  }
  else /**  **/
  {
    $('#bckic').attr('name', sw);
    $('#load').load(path + "/" + company + "/clients/" + id + "/read", function ()
      {
        $('#load').removeClass('cl');
        $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="Editar"><span class="glyphicon glyphicon-pencil"></span></span></a></div><input type="hidden" id="cpldcl" value = '+ company +'><input type = "hidden" id="edtcl" value = "true">');
        $('#tltgnif').html('Editar '+$('#'+id).text());
        $('#bckic').show();
        $('#pnldel').hide();
      });
  }
}

/**
* Ajax method for delete client (VS)
*/
var deleteClient = function (client, user)
{
  var company  = $('#cpldcl').val();
  var url      = "";
  bootbox.confirm({
    message: "Seguro que desea eliminar este registro?",
    buttons: {
        confirm: {
            label: 'Aceptar',
            className: 'btn-primary'
        },
        cancel: {
            label: 'Cancelar',
            className: 'btn-default'
        }
    },
    callback: function (confirmed) {
      if (confirmed)
      {
        if(user == true) /* Delete User */
        {
          url     = `${window.location.origin}`+ AUX_PATH +`/admin/user/`+ client + `/delete`;
        }
        else  /* Delete Client of Company*/
        {
          url = `${window.location.origin}${window.location.pathname}` + "/" + company + "/clients/" + client;
        }
        /**
        * Execute ajax
        */
        $.ajax(
        {
          url: url,
          type: 'DELETE',
          dataType: 'json',
          data: client,
          beforeSend: function () {
            $('#cl').html("<div class='progress'><div class='progress-bar progress-bar-striped active' role = 'progressbar' style = 'width:100%;'></div></div>");
          },
          success: function (json) {
            ((json.message == 'true') ? loadBack (alert = true , company) : evalJson (json.alert))
          }
        });
      }
    }
  });
}

/**
* ajax load the createClient view (VS)
*/
var addClient = function (swcl, id, user )
{
  var path    =`${window.location.origin}${window.location.pathname}`;
  var company = $('#cpldcl').val();
  var gen     = 'true';
  var provs   = "";

  $('#swcl').val('1');
  $('#tltgnif').html('Nuevo');

  if (user == true) /** se añade usuario **/
  {
    path  = `${window.location.origin}`+ AUX_PATH + `/admin/user/viewNew`;
    swcl  = '3';
    $('#load').load(path, function ()
    {
      $('#load').removeClass('cl');
      $('#pnlft').append('<div class="panel-footer" id="pft2"><span class="label label-danger pull-left" id="uplbdgr"></span><a href="javascript:saveOnEdit('+ swcl +','+ id +','+ gen +')"><span class="badge" title="guardar"><span class="glyphicon glyphicon-ok"></span></span></a></div><input type="hidden" id="cpldcl" value = "1">');
      $('#bckic').show();
      $('#bckic').attr('name', '1');
      $()
    });
  }
  else /** Se añade cliente **/
  {
    $('#load').load(path + "/" + company + "/clients/new",function ()
      {
        $('#load').removeClass('cl');
        $('#pnlft').append('<div class="panel-footer" id="pft2"><span class="label label-danger pull-left" id="uplbdgr"></span><a href="javascript:saveOnEdit('+ swcl +','+ id +','+ gen +')"><span class="badge" title="guardar"><span class="glyphicon glyphicon-ok"></span></span></a></div><input type="hidden" id="cpldcl" value = '+ company +'><input type = "hidden" id="edtcl" value = "false">');
        $('#bckic').show();
        $('#bckic').attr('name', '1');
      });
  }
}
