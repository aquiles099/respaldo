/**
*
*/
'use strict';
/**
*
*/
$(document).ready( function() {
/**
*
*/var url = window.location.origin + window.location.pathname;
console.log(url);
$('#dtble').dataTable();
/**
*
*/
$('select').select2(
  {
    width: '100%',

    //placeholder: "Select a client",
    //allowClear: true
  }).on('select2:select', function(e) //seleccionar cualquier opcion del select
  {
    var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
    icsLoadSelect(elemento.id);
  });
 });

/**
*
*/
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
  var url = window.location.origin + window.location.pathname + '/' + country + '/state';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: country,
    beforeSend: function () {
    //  $('#ics_load_vessel_city').html("<i class='fa fa-spin fa-spinner'></i>");
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
  //  $('#ics_load_vessel_city').html("");
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
  $('#ics_city_state').empty();
  /**
  *
  */
  $.each(json, function(i, item){
    $('#ics_city_state').append(new Option((json[i].name), (json[i].id), true, true));
  });
}



var icsCityDelete = function(element, from) {
  try {
    var city = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + city.id;
    /**
    *
    */
    if(city != undefined) {
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
