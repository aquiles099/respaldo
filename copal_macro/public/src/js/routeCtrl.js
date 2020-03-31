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
*/
$('#dtble').DataTable({
  "order": [
    [ 0, "desc" ]
  ]
});
 /**
 *
 */
  $('#ics_route_transport').select2();
  /**
  *
  */
  $('#ics_route_origin_country')
    .select2()
      .on('select2:select', function(e)
       {
          var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
          icsLoadSelect(elemento.id, '#ics_route_origin_city' ,'#ics_load_route_origin');
       });
  /**
  *
  */
  $('#ics_route_origin_city').select2();
  /**
  *
  */
  $('#ics_route_destiny_country').select2().select2()
      .on('select2:select', function(e)
       {
          var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
          icsLoadSelect(elemento.id, '#ics_route_destiny_city', '#ics_load_route_destiny');
       });
  /**
  *
  */
  $('#ics_route_destiny_city').select2();
  /**
  *
  */
});
/**
*
*/
var icsLoadSelect = function (country, city, load) {
  var url = window.location.origin + window.location.pathname + '/' + country + '/city';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: country,
    beforeSend: function () {
      $(load).html("<i class='fa fa-spin fa-spinner'></i>");
    },
    success: function (json) {
      if (Object.keys(json).length > 0) {
         icsSetDataLoadSelect(json.message, city);
      }else {
        console.log('no hay elementos');
      }
    },
    error: function ()
    {
      log('no se ha cargado' + url);
    },
    complete: function() {
      $(load).html("");
    }
  });
}
/**
*
*/
var icsSetDataLoadSelect = function (json , city) {
  /**
  *
  */
  $(city).empty();
  /**
  *
  */
  $.each(json, function(i, item){
    $(city).append(new Option((json[i].name), (json[i].id), true, true));
  });
}
/**
*
*/
var routeDelete = function(element, from) {
  try {
    var route = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + '/' + route.id;
    /**
    *
    */
    if(route != undefined) {
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
