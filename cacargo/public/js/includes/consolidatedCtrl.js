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
function searchConsolidated() {
  try {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '') {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  }
  catch(e) {

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
 *
 */
function consolidatedDelete(element, from){
  try {
    var consolidated = getItem(element) || getItemFromParent(element);
    if(consolidated != undefined){
      bootbox.confirm(eval(msg(messages.delete)), function(result){
        if(result){
          doForm(`./admin/consolidated/${consolidated.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }catch (e){
    log(e);
  }
}
/**
 *
 */
function packageConsolidatedDelete(element, e){
  try{
    if(element != undefined){
      bootbox.confirm(eval(msg(messagess.delete)), function(result){
        if(result){
          $.post(asset('admin/consolidated/deletepackage/'.concat(element)),$("#form").serialize(), function(data) {
            $('#errorTitle').attr('style', "display:block;");
            document.getElementById('errorTitle').innerHTML = data['error'];
            $(e.target).closest("tr").remove();
          });
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
function onKeyDown(e) {
  if(e.keyCode === 13) {
    e.preventDefault();
    addPackage();
  }
}

/**
*
*/
function addPackage()
{
  var id = $('#id').val();
  $('#errorTitle').attr('style', "display:none;");

  $.post(asset('admin/consolidated/addpackage/'.concat(id)),$("#form").serialize(), function(data)
  {
    if (typeof  data['error'] == 'undefined') {
      $('#table').append($("<tr> <td>" + data['id'] + "</td> <td>" + data['description'] + "</td> <td>" + data['tracking'] + "</td> <td>" + data['observation']
      + "</td> <td> <ul class=\"table-actions\"> <li><a onclick=\"packageConsolidatedDelete(" + data['id'] + ", event)\" ><i class=\"fa fa-times\"  title=\" " + table.delete + " \""
      + "></i></a></li> </ul> </td>       </tr>"));
    }
    else {
      $('#errorTitle').attr('style', "display:block;");
      document.getElementById('errorTitle').innerHTML = data['error'];
    }
  });
}

/**
*
*/
function setDisabled() {
  var trackDisabled = document.getElementById('tracking').disabled;
  $('#tracking, #packageObservation').attr('disabled', trackDisabled === true ? false : true);
}


var detailsconsolidate = function (id,open) {
  var path  =`${window.location.origin}${window.location.pathname}`;
   if (open == 'true'){

      var sw    = 0;
      var alert = false;

       bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>Información</span>",
          message: $('#load').load(path + "/showconsolidated/" + id, function() {
            $('select').select2({
              width: '100%'
            });
          }),
          size:"large",
          backdrop: true,
          onEscape: function() { },
          }).on('shown.bs.modal', function () {
                $('#load').show();
          })
          .on('hide.bs.modal', function (e) {
          $('#load').hide().appendTo('body');
          })
          .modal('show');
        } else {
          $('#load').load(path + "/showconsolidated/" + id, function() {
            $('select').select2({
              width: '100%'
            });
          });
        }
}
/**
*
*/
var changestatusconsolidated = function (id) {
  var url      = `${window.location.origin}${window.location.pathname}`+"/showconsolidated/"+id;
  var dataString = {"event":$('#event').val()};

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: dataString,
        beforeSend: function ()
        {
          $('#cl').html("<div class='progress'><div class='progress-bar progress-bar-striped active' role = 'progressbar' style = 'width:100%;'></div></div>");
        },
        success: function (json)
        {
         ((json.message == 'true') ? detailsconsolidate(id,'false'): evalJson (json.alert))
        }
      });
}
