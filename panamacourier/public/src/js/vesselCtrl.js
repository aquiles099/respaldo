/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {
/**
*
*/

/**
*
*/
$('#ics_vessel_country').select2().on('select2:select', function(e) {
      var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
      icsLoadSelect(elemento.id);
  });
/**
*
*/
$('#ics_vessel_city').select2();
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
var icsLoadSelect = function (country) {
  var url = window.location.origin + window.location.pathname + '/' + country + '/city';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: country,
    beforeSend: function () {
      $('#ics_load_vessel_city').html("<i class='fa fa-spin fa-spinner'></i>");
    },
    success: function (json) {
      if (Object.keys(json).length > 0) {
         icsSetDataLoadSelect(json.message);
      }else {
        console.log('no hay elementos');
      }
    },
    error: function ()
    {
      log('no se ha cargado' + url);
    },
    complete: function() {
    $('#ics_load_vessel_city').html("");
    }
  });
}
/**
*
*/
var icsSetDataLoadSelect = function (json) {
  /**
  *
  */
  $('#ics_vessel_city').empty();
  /**
  *
  */
  $.each(json, function(i, item){
    $('#ics_vessel_city').append(new Option((json[i].name), (json[i].id), true, true));
  });
}
/**
*
*/
var icsVesselDelete = function(element, from) {
  try {
    var vessel = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + vessel.id;
    /**
    *
    */
    if(vessel != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
    /**
    *
    */
  } catch (e) {
    log(e);
  }
}
