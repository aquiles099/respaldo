/**
*
*/
'use strict';

var countimg=0;
/**
*
*/
$(document).ready(function() {
    $("#ics_inactive_tab4").remove();
    $("#ics_inactive_tab5").remove();
    $("#ics_inactive_tab6").remove();
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
    $('#ics_vessel_country2').select2().on('select2:select', function(e) {
      var elemento = eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')');
      icsLoadSelect2(elemento.id);
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_shipper_select')
    {
      setShipperData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_entityToNotify_select')
    {
      setentityToNotifyData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_cargoAgent_select')
    {
      setcargoAgentData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_consigneer_select')
    {
      setconsigneerData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_intermediate_select')
    {
      setintermediateData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('select').select2().on('select2:select', function(e) {
    if ($(e.currentTarget).attr('id') == 'ics_destinyAgent_select')
    {
      setdestinyAgentData(eval('(' + $(e.currentTarget).find('option:selected').attr('item') + ')')); /** Call Function**/
    }
  });
  /**
  *
  */
  $('#realizationDate_shipment').datepicker({
      dateFormat:    "yy-mm-dd",
  });
  /**
  * Se llama tipo de embarque martimo
  */
  icsSetTypeShipment(1);
  /**
  *
  */
  /**
  *
  */


});
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
  var url = window.location.origin + AUX_PATH + '/admin/vessels/new/' + country + '/city';
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

var icsLoadSelect2 = function (country) {
  var url = window.location.origin + AUX_PATH + '/admin/vessels/new/' + country + '/city';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: country,
    beforeSend: function () {
      $('#ics_load_vessel_city2').html("<i class='fa fa-spin fa-spinner'></i>");
    },
    success: function (json) {
      if (Object.keys(json).length > 0) {
         icsSetDataLoadSelect2(json.message);
      }else {
        console.log('no hay elementos');
      }
    },
    error: function ()
    {
      log('no se ha cargado' + url);
    },
    complete: function() {
    $('#ics_load_vessel_city2').html("");
    }
  });
}
/**
*
*/
var icsSetDataLoadSelect2 = function (json) {
  /**
  *
  */
  $('#ics_vessel_city2').empty();
  /**
  *
  */
  $.each(json, function(i, item){
    $('#ics_vessel_city2').append(new Option((json[i].name), (json[i].id), true, true));
  });
}
/**
*
*/
var icsSetTypeShipment = function (id) {
  var edit = true;
  var root = `${window.location.origin}`;
  if(root=='http://localhost'){
    root = `${window.location.origin}`+"/ics-app-version-2.0/public";
  }
  var url = (edit == false) ? root +'/admin/shipments/new/' + id + '/type/shipment/' + '0' : root +'/admin/shipments/new/'+ id + '/type/shipment/' + '0';
  console.log(url);
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: id,
    beforeSend: function () {
      var wait = (messages.language == 'es') ? 'Cargando...':'Loading...';
      $('#ics_load').html("<i class='fa fa-spin fa-spinner'></i> "+wait);
    },
    success: function (json) {
      //console.log(json);
      /**
      * Cargando formulario de informacion general
      */

        if(id == 1) {
          var selected_mar = (messages.language == 'es') ? '(Maritimo Seleccionado)':'(Maritime Selected)';

          $('#ics_selected_item').html(selected_mar);
          $("#ics_inactive_tab5").remove();
          $("#ics_inactive_tab6").remove();
          $('#typet').append("<li id='ics_inactive_tab4' class='ics-inactive-tab'> <a data-toggle='tab' href='#ics_tab_menu4'> Maritima <i class='fa fa-life-ring' aria-hidden='true'></i></span></a></li>");
        }
        /**
        *
        */
        if(id == 2) {
          var selected_air = (messages.language == 'es') ? '(Aereo Seleccionado)':'(Aerial Selected)';

          $('#ics_selected_item').html(selected_air);
          $("#ics_inactive_tab4").remove();
          $("#ics_inactive_tab6").remove();
          $('#typet').append("<li id='ics_inactive_tab5' class='ics-inactive-tab'> <a data-toggle='tab' href='#ics_tab_menu5'> Aereo <i class='fa fa-plane' aria-hidden='true'></i></span></a></li>");
        }
        /**
        *
        */
        if(id == 3) {
          var selected_gr = (messages.language == 'es') ? '(Terrestre Seleccionado)':'(Ground Selected)';

          $('#ics_selected_item').html(selected_gr);
          $("#ics_inactive_tab4").remove();
          $("#ics_inactive_tab5").remove();
          $('#typet').append("<li id='ics_inactive_tab6' class='ics-inactive-tab'> <a data-toggle='tab' href='#ics_tab_menu6'> Terrestre <i class='fa fa-truck' aria-hidden='true'></i></span></a></li>");
        }


      $('select').select2();
    },

    error: function ()
    {
      log('no se ha cargado' + url);
    },
    complete: function (){
        $('#ics_load').html("");
    }
  });
  /**
  * set shipment type to hidden field
  */
  $('#transport').val(id);

}
/**
* se asigna bandera del buque
*/
var setVesselData = function (item) {
  if (item)
  {
    $('#vesselFlagMaritime_shipment').val(item.flag);
    $('#vesselFlagMaritime_shipment').attr('readonly', true);
  }
  else
  {
    $('#vesselFlagMaritime_shipment').val('');
    $('#vesselFlagMaritime_shipment').attr('readonly', false);
  }
}
/**
*
*/
var setShipperData = function (item)
{
  if (item)
  {
    $('#ics_shipper_name').val(item.name);
    $('#ics_shipper_address').val(item.address);
    $('#ics_shipper_name').attr('readonly', true);
    $('#ics_shipper_address').attr('readonly', true);
  }
  else
  {
    $('#ics_shipper_name').val('');
    $('#ics_shipper_address').val('');
    $('#ics_shipper_name').attr('readonly', false);
    $('#ics_shipper_address').attr('readonly', false);
  }
}
/**
*
*/
var setentityToNotifyData = function (item) {
  if (item)
  {
    $('#ics_entityToNotify_name').val(item.name);
    $('#ics_entityToNotify_address').val(item.address);
    $('#ics_entityToNotify_name').attr('readonly', true);
    $('#ics_entityToNotify_address').attr('readonly', true);
  }
  else
  {
    $('#ics_entityToNotify_name').val('');
    $('#ics_entityToNotify_address').val('');
    $('#ics_entityToNotify_name').attr('readonly', false);
    $('#ics_entityToNotify_address').attr('readonly', false);
  }
}
/**
*
*/
var setcargoAgentData = function (item) {
  if (item)
  {
    $('#ics_cargoAgent_name').val(item.name);
    $('#ics_cargoAgent_address').val(item.address);
    $('#ics_cargoAgent_name').attr('readonly', true);
    $('#ics_cargoAgent_address').attr('readonly', true);
  }
  else
  {
    $('#ics_cargoAgent_name').val('');
    $('#ics_cargoAgent_address').val('');
    $('#ics_cargoAgent_name').attr('readonly', false);
    $('#ics_cargoAgent_address').attr('readonly', false);
  }
}
/**
*
*/
var setconsigneerData = function (item) {
  if (item)
  {
    $('#ics_consigneer_name').val(item.name);
    $('#ics_consigneer_address').val(item.address);
    $('#ics_consigneer_name').attr('readonly', true);
    $('#ics_consigneer_address').attr('readonly', true);
  }
  else
  {
    $('#ics_consigneer_name').val('');
    $('#ics_consigneer_address').val('');
    $('#ics_consigneer_name').attr('readonly', false);
    $('#ics_consigneer_address').attr('readonly', false);
  }
}
/**
*
*/
var setintermediateData = function (item) {
  if (item)
  {
    $('#ics_intermediate_name').val(item.name);
    $('#ics_intermediate_address').val(item.address);
    $('#ics_intermediate_name').attr('readonly', true);
    $('#ics_intermediate_address').attr('readonly', true);
  }
  else
  {
    $('#ics_intermediate_name').val('');
    $('#ics_intermediate_address').val('');
    $('#ics_intermediate_name').attr('readonly', false);
    $('#ics_intermediate_address').attr('readonly', false);
  }
}
/**
*
*/
var setdestinyAgentData = function (item) {
  if (item)
  {
    $('#ics_destinyAgent_name').val(item.name);
    $('#ics_destinyAgent_address').val(item.address);
    $('#ics_destinyAgent_name').attr('readonly', true);
    $('#ics_destinyAgent_address').attr('readonly', true);
  }
  else
  {
    $('#ics_destinyAgent_name').val('');
    $('#ics_destinyAgent_address').val('');
    $('#ics_destinyAgent_name').attr('readonly', false);
    $('#ics_destinyAgent_address').attr('readonly', false);
  }
}

/**
 *
 */
function transportersDelete(element, from) {
  try {
    var transporters = getItem(element) || getItemFromParent(element);
    if(transporters != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/transporters/${transporters.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}

 function preview_image()
{
 var res=countimg+1;
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
   var del = (messages.language == 'es') ? 'Eliminar':'Delete';
  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>"+del+"</a>");
 }
}

function remove_preview(id){
  $('#'+id).remove();
}
