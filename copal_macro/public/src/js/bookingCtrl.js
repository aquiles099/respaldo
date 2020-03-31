/**
*
*/
"use strict";
/**
* global vars
*/
var aux  = 1;
/**
*
*/
$(document).ready( function() {
  $('#departureSince').datepicker({
    dateFormat:    "yy-mm-dd",
  });
  $('#departureUntil').datepicker({
    dateFormat:    "yy-mm-dd",
  });
  $('#arrivedSince').datepicker({
    dateFormat:    "yy-mm-dd",
  });
  $('#arrivedUntil').datepicker({
    dateFormat:    "yy-mm-dd",
  });
  /**
  *
  */
  $('select').select2({
          width: '100%'
        }).on('select2:select', function(e) //seleccionar cualquier opcion del select
        {
          var el = $(e.currentTarget);

          if (el.attr('id') == 'from') //si viene del from
          {
            showElements(el.val());
          }
          else if (el.attr('id') == 'clientSelect')//si viene del clientSelect
          {
              //console.log($("#clientSelect").val())
              showClients('block','true');
              //para capturar el valor de lo que se esta seleccionando
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataClient(item);
              console.log('hola2');

          }
          else if (el.attr('id') == 'currier')//si viene del clientSelect
          {

          }
          else if (el.attr('id') == 'finalOriginUser') //si viene de finalDestinationClient
          {
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataUsertoring(item);


          }
          else if (el.attr('id') == 'consName') //si viene de finalDestinationClient
          {

            console.log(el.find('option:selected').val());

              if((el.find('option:selected').val())=='addud'){


                $("#destin_name").removeAttr("readonly");
                $("#destin_lastname").removeAttr("readonly");
                $("#destin_dni").removeAttr("readonly");
                $("#destin_phonedestin").removeAttr("readonly");
                $("#destin_cell").removeAttr("readonly");
                $("#destin_email").removeAttr("readonly");
                $("#destin_zipcode").removeAttr("readonly");
                $("#destin_country").removeAttr("readonly");
                $("#destin_region").removeAttr("readonly");
                $("#destin_city").removeAttr("readonly");
                $("#destin_direction").removeAttr("readonly");

                document.getElementById('destin_name').value="";
                document.getElementById('destin_lastname').value="";
                document.getElementById('destin_dni').value="";
                document.getElementById('destin_phonedestin').value="";
                document.getElementById('destin_cell').value="";
                document.getElementById('destin_email').value="";
                document.getElementById('destin_direction').value="";
                document.getElementById('destin_zipcode').value="";
                document.getElementById('destin_country').value="";
                document.getElementById('destin_region').value="";
                document.getElementById('destin_city').value="";

              }else{

                $("#destin_name").attr("readonly","readonly");
                $("#destin_lastname").attr("readonly","readonly");
                $("#destin_dni").attr("readonly","readonly");
                $("#destin_phonedestin").attr("readonly","readonly");
                $("#destin_cell").attr("readonly","readonly");
                $("#destin_email").attr("readonly","readonly");
                $("#destin_zipcode").attr("readonly","readonly");
                $("#destin_country").attr("readonly","readonly");
                $("#destin_region").attr("readonly","readonly");
                $("#destin_city").attr("readonly","readonly");
                $("#destin_direction").attr("readonly","readonly");

                var item = eval('(' + el.find('option:selected').attr('item') + ')');
                setDataDestinationUser(item);
              }


          }else if (el.attr('id') == 'shipperName') //si viene de finalDestinationClient
          {
            console.log(el.find('option:selected').val());

              if(el.find('option:selected').val()=='adduc'){
                $("#cons_name").removeAttr("readonly");
                $("#cons_lastname").removeAttr("readonly");
                $("#cons_dni").removeAttr("readonly");
                $("#cons_phone").removeAttr("readonly");
                $("#cons_cell").removeAttr("readonly");
                $("#cons_email").removeAttr("readonly");
                $("#cons_zipcode").removeAttr("readonly");
                $("#cons_country").removeAttr("readonly");
                $("#cons_region").removeAttr("readonly");
                $("#cons_city").removeAttr("readonly");
                $("#cons_direction").removeAttr("readonly");
                document.getElementById('cons_name').value="";
                document.getElementById('cons_lastname').value="";
                document.getElementById('cons_dni').value="";
                document.getElementById('cons_phone').value="";
                document.getElementById('cons_cell').value="";
                document.getElementById('cons_email').value="";
                document.getElementById('cons_direction').value="";
                document.getElementById('cons_zipcode').value="";
                document.getElementById('cons_country').value="";
                document.getElementById('cons_region').value="";
                document.getElementById('cons_city').value="";

              }else{

                $("#cons_name").attr("readonly","readonly");
                $("#cons_lastname").attr("readonly","readonly");
                $("#cons_dni").attr("readonly","readonly");
                $("#cons_phone").attr("readonly","readonly");
                $("#cons_cell").attr("readonly","readonly");
                $("#cons_email").attr("readonly","readonly");
                $("#cons_zipcode").attr("readonly","readonly");
                $("#cons_country").attr("readonly","readonly");
                $("#cons_region").attr("readonly","readonly");
                $("#cons_city").attr("readonly","readonly");
                $("#cons_direction").attr("readonly","readonly");

                var item = eval('(' + el.find('option:selected').attr('item') + ')');
                setDataConsignationUser(item);
              }



          }else if(el.attr('id')=='type'){
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              //console.log(item.id);
              //selectdetailstransport(item.id);
              selectservicio(item.id);
          }
        });

  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });

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
function setDataDestinationUser(destinationData)
{
  if (destinationData)
  {
    document.getElementById('destin_name').value=destinationData.name;
    document.getElementById('destin_lastname').value=destinationData.last_name;
    document.getElementById('destin_dni').value=destinationData.dni;
    document.getElementById('destin_phonedestin').value=destinationData.local_phone;
    document.getElementById('destin_cell').value=destinationData.cell;
    document.getElementById('destin_email').value=destinationData.email;
    document.getElementById('destin_direction').value=destinationData.address;
    document.getElementById('destin_zipcode').value=destinationData.postal_code;
    document.getElementById('destin_country').value=destinationData.country;
    document.getElementById('destin_region').value=destinationData.region;
    document.getElementById('destin_city').value=destinationData.city;
  }
  else
  {
    document.getElementById('destin_phonedestin').value="";
    document.getElementById('destin_name').value="";
    document.getElementById('destin_lastname').value="";
    document.getElementById('destin_dni').value="";
    document.getElementById('destin_cell').value="";
    document.getElementById('destin_email').value="";
    document.getElementById('destin_direction').value="";
    document.getElementById('destin_zipcode').value="";
    document.getElementById('destin_country').value="";
    document.getElementById('destin_region').value="";
    document.getElementById('destin_city').value="";
  }

}

function setDataConsignationUser(destinationData)
{
  if (destinationData)
  {
    document.getElementById('cons_name').value=destinationData.name;
    document.getElementById('cons_lastname').value=destinationData.last_name;
    document.getElementById('cons_dni').value=destinationData.dni;
    document.getElementById('cons_phone').value=destinationData.local_phone;
    document.getElementById('cons_cell').value=destinationData.cell;
    document.getElementById('cons_email').value=destinationData.email;
    document.getElementById('cons_direction').value=destinationData.address;
    document.getElementById('cons_zipcode').value=destinationData.postal_code;
    document.getElementById('cons_country').value=destinationData.country;
    document.getElementById('cons_region').value=destinationData.region;
    document.getElementById('cons_city').value=destinationData.city;
  }
  else
  {
    document.getElementById('cons_name').value="";
    document.getElementById('cons_lastname').value="";
    document.getElementById('cons_dni').value="";
    document.getElementById('cons_phone').value="";
    document.getElementById('cons_cell').value="";
    document.getElementById('cons_email').value="";
    document.getElementById('cons_direction').value="";
    document.getElementById('cons_zipcode').value="";
    document.getElementById('cons_country').value="";
    document.getElementById('cons_region').value="";
    document.getElementById('cons_city').value="";

  }

}


var initDropzone = function() {
  Dropzone.options.myDropzone = {
    autoProcessQueue: false,
    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 8,
    addRemoveLinks: true,
    dictRemoveFile: 'eliminar',
    dictFileTooBig: 'el peso del archivo debe ser menor a 8MB',
    init: function() {
      var submitButton = document.querySelector("#submit-all");
      var myDropzone = this;
      /**
      *
      */
      submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        myDropzone.processQueue();
        $("#ics_cargo_booking_form").submit();
      });
      /**
      *
      */
      this.on("addedfile", function() {
      });
      /**
      *
      */
      this.on("complete", function(file) {
        myDropzone.removeFile(file);
      });
      /**
      *
      */
      this.on("success",
        myDropzone.processQueue.bind(myDropzone)
      );
      /**
      *
      */
      myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("filesize", file.size);
      });
    }
  };
}
/**
* set shipper data
*/
var setShipperData = function (item) {
  if (item) {
    log(item);
    $('#cons_name').val(item.name);
    $('#shipperPhone').val(item.celular);
    $('#shipperCountry').val(item.country);
    $('#shipperRegion').val(item.region);
    $('#shipperCity').val(item.city);
    $('#shipperAdress').val(item.address);
    $('#shipperPostalCode').val(item.postal_code);
  }
  else {
    $('#shipperPhone').val('');
    $('#shipperCountry').val('');
    $('#shipperRegion').val('');
    $('#shipperCity').val('');
    $('#shipperAdress').val('');
    $('#shipperPostalCode').val('');
  }
}
/**
* set consignee data
*/
var setConsigneeData = function (item) {
  if (item) {
    $('#consigneePhone').val(item.celular);
    $('#consigneeCountry').val(item.country);
    $('#consigneeRegion').val(item.region);
    $('#consigneeCity').val(item.city);
    $('#consigneeAdress').val(item.address);
    $('#consigneePostalCode').val(item.postal_code);
  }
  else {
    $('#consigneePhone').val('');
    $('#consigneeCountry').val('');
    $('#consigneeRegion').val('');
    $('#consigneeCity').val('');
    $('#consigneeAdress').val('');
    $('#consigneePostalCode').val('');
  }
}
/**
* add cargo on booking
*/
var icsAddCargoOnBooking = function (edit) {
  aux = aux + 1;
  /**
  *
  */
  $('#countbooking').val(aux);
  /**
  *
  */
  $('#ics_booking_list').append("<li id='ics_li_cargo"+aux+"' class='paq'><a data-toggle='tab' href='#ics_bk_"+aux+"'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> Bk"+aux+"<span  onclick='icsDelCargoOnBooking("+aux+")' id='ics_del_cargo_on_booking"+aux+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
  /**
  *
  */
  $('#ics_content_booking').append("<div class='row tab-pane fade' id='ics_bk_"+aux+"' style='padding:20px'>"+"\n"+
    "<div class='col-md-8'>"+"\n"+
     " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
         " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
         " <div class='col-lg-10'>"+"\n"+
           " <input type='text' class='form-control' placeholder='Descripcion' id='description"+aux+"' name='description"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
           " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
        "  </div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
        "<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>"+"\n"+
        "<div class='col-lg-10'>"+"\n"+
          "<input type='number' class='form-control' placeholder='Piezas' id='pieces"+aux+"' name='pieces"+aux+"' type='int' maxlength='10' min='1' required='true' value=''>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
        "</div>"+"\n"+
      "</div>"+"\n"+

      "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
        "<label class='col-lg-2 control-label' id='typeLabel'>Tipo</label>"+"\n"+
        "<div class='col-lg-10'>"+"\n"+
          "<select class='form-control' placeholder='Valor ($)' id='type"+aux+"' name='type"+aux+"' type='int' maxlength='10' min='1' required='true' value='' >"+"\n"+
          " <select/>"+"\n"+
        "</div>"+"\n"+
     " </div>"+"\n"+
    "</div>"+"\n"+
     "<div class='col-md-4'>"+"\n"+
      "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>"+"\n"+
       " <div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+aux+"' name='large"+aux+"' onkeyup='icsGeticsGetPesoVol()' type='float' maxlength='10' min='1' required='true' value=''>"+"\n"+
          "<span>in</span>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
         "</div>"+"\n"+
      "</div>"+"\n"+
      "<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >Ancho</label>"+"\n"+
        "<div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Ancho' id='width"+aux+"' name='width"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >"+"\n"+
       "<span>in</span>"+"\n"+
       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
      "</div>"+"\n"+
      " <div class='dimensmedidas' id='divheight'>"+"\n"+
      "<label class='col-lg-3 control-label' id='typeLabel' >Alto</label>"+"\n"+
        "<div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+aux+"' onkeyup='icsGetPesoVol()' name='height"+aux+"' type='float' maxlength='10' min='1' required='true' value=''>"+"\n"+
          "<span>in</span>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
         "</div>"+"\n"+
      "</div>"+"\n"+
      "<div class='dimensmedidas' id='divheight'>"+"\n"+
      "<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>"+"\n"+
       " <div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+aux+"' onkeyup='icsGetPesoVol()' name='volumetricweightm"+aux+"' type='float' readonly='' maxlength='10' min='1' required='true' value='' >"+"\n"+
            "<span>ft<sup>3</sup></span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
      "</div>"+"\n"+
      "<div class='dimensmedidas' id='divheight'>"+"\n"+
      "<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>"+"\n"+
       " <div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+aux+"' onkeyup='icsGetPesoVol()' name='volumetricweighta"+aux+"' type='float' readonly='' maxlength='10' min='1' required='true' value='' >"+"\n"+
            "<span>Vlb</span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
     "</div>"+"\n"+
     " <div class='dimensmedidas' id='divheight'>"+"\n"+
     " <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>"+"\n"+
        "<div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+aux+"' onkeyup='icsGetPesoVol()' name='weight"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >"+"\n"+
          "<span>lb</span>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
      "</div>"+"\n"+
     "</div>"+"\n"+
     " </div>");
     /**
     * load the container type aux (quantity), true (current create mode), edit (current no edit mode)
     */
     icsAddTypeOn(aux, true, edit, 0);
     /**
     *
     */
     $('select').select2();
}
/**
* getData for option select
*/
var icsAddTypeOn = function (value, create, edit, container) {
  var url = (create == true && edit == false) ? window.location.origin + window.location.pathname + "/type" : window.location.origin + AUX_PATH +"/admin/bookings/new/type";
  /**
  *
  */
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function ()
    {
    },
    success: function (json)
    {
      icsLoadDinamicSelect(json.message, value, container);
    },
    error: function (e)
    {
      log("Error: " + e.message);
    }
  });
}
/**
* delete cargo of booking
*/
var icsDelCargoOnBooking = function (numberOfCargo) {
  var paq,auxco,contr;
  if(($("#ics_li_cargo"+numberOfCargo).hasClass('active'))){
    auxco=true;
  }else{
    auxco=false;
  }

  $("#ics_li_cargo"+numberOfCargo).remove();
  $("#ics_bk_"+numberOfCargo).remove();

  paq=$(".paq").size();
  if(numberOfCargo===aux){
    aux=aux-1;
    $("#ics_li_cargo"+aux).addClass("active ");
    $("#ics_bk_"+aux).addClass("active in");

  }
  if(paq==1){
    aux=1;
  }

  if(auxco===true){
    if(paq>1){
      contr=aux;
    }else{
      contr=1;
    }
    $("#ics_li_cargo"+contr).addClass("active ");
    $("#ics_bk_"+contr).addClass("active in");
  }

  $('#countbooking').val(aux);
   resultvalue();
}
/**
* get volumetric volume
*/
var icsGetPesoVol = function () {
  for (var step = 1; step <= aux; step++) {
   var larg    = $("#ics_bk_" + step + " " + "#large" + step).val();
   var anch    = $("#ics_bk_" + step + " " + "#width" + step).val();
   var alto    = $("#ics_bk_" + step + " " + "#height" + step).val();
   var resultm = (larg * anch * alto) / 1728;
   var resulta = (larg * anch * alto) / 166;
   $("#ics_bk_" + step + " " + "#volumetricweightm" + step).val(resultm.toFixed(2).toString());
   $("#ics_bk_" + step + " " + "#volumetricweighta" + step).val(resulta.toFixed(2).toString());
  }
}
/**
* load dinamic select
* compares the container number with the <option> identifer
*/
var icsLoadDinamicSelect = function (json, value, container) {
  $.each(json, function(i, item) {
    $('#type' + value).append(new Option(json[i].name, json[i].id, true, (container == json[i].id) ? true : false));
  });
}
/**
* show booking details
*/
var icsShowDetailsOfBooking = function (booking, open) {
  var url = window.location.origin + window.location.pathname + "/" + booking + "/view";
  /**
  * verificamos si el modal esta abierto
  */
  if (open == false){
    bootbox.dialog({
      title:'informacion',
      message:$('#load').load(url, function () {
        $('#ics_booking_status').select2();
      }),
      size:'large',
      backdrop: true,
      onEscape: function() { },
    }).on('shown.bs.modal', function () {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e) {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
  }
  else{
    $('#load').load(url, function () {
      $('#ics_booking_status').select2();
    });
  }
}
/**
*
*/
var icsChangeStatusBooking = function (booking) {
  var status      = $('#ics_booking_status').val();
  var observation = $('#observation').val();
  var url         = window.location.origin + window.location.pathname + "/" + booking + "/view";
  $.ajax({
    url: url,
    method: 'POST',
    dataType:'json',
    data: {
      'status'      : status,
      'observation' : observation
    },
    beforeSend: function () {

    },
    success: function (json) {
      if (json.message == true) {
        $('#load').load(url, function () {
          $('select').select2();
        });
      }
    },
    error: function (e) {
      bootbox.alert('Error: ' + e.message );
    }
  });
}
/**
* load tabs data
*/
var icsLoadTabsAndData = function (booking) {
  var url = window.location.origin + window.location.pathname + "/items";
  /**
  *
  */
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {

    },
    success: function (json) {
      (json.message) ? icsSetTabsData(json.alert) : bootbox.alert('Error en el servidor') ;
    },
    error: function (e) {
      bootbox.alert('Error al Cargar TabsData ' + e.description);
    }
  });
}
/**
* Set Tabs and data
*/
var icsSetTabsData = function (json) {
  $.each(json, function(i, item) {
    if ( i > 0)
    {
    $('#ics_booking_list').append("<li id='ics_li_cargo"+(i + 1)+"'><a data-toggle='tab' href='#ics_bk_" +(i + 1)+ "'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> Bk" +(i + 1)+ "<span  onclick='icsDelCargoOnBooking(" +(i + 1)+ ")' id='ics_del_cargo_on_booking"+(i + 1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    /**
    *
    */
    $('#ics_content_booking').append("<div class='row tab-pane fade' id='ics_bk_" +(i + 1)+ "' style='padding:20px'>"+"\n"+
      "<div class='col-md-8'>"+"\n"+
       " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
           " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
           " <div class='col-lg-10'>"+"\n"+
             " <input type='text' class='form-control' placeholder='Descripcion' id='description" +(i + 1)+ "' name='description" +(i + 1)+ "' type='float' min='1' required='true' value='" + json[i].description + "' >"+"\n"+
             " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
          "  </div>"+"\n"+

          "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='Piezas' id='pieces" +(i + 1)+ "' name='pieces" +(i + 1)+ "' type='int' maxlength='10' min='1' required='true' value='" + json[i].pieces + "'>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel'>Tipo</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<select class='form-control' placeholder='Valor ($)' id='type" +(i + 1)+ "' name='type" +(i + 1)+ "' type='int' maxlength='10' min='1' required='true' value='' >"+"\n"+
            " <select/>"+"\n"+
          "</div>"+"\n"+
       " </div>"+"\n"+
      "</div>"+"\n"+

       "<div class='col-md-4'>"+"\n"+
        "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>"+"\n"+
         " <div class='col-lg-9'>"+"\n"+
            "<input type='number' class='form-control form_dimension' placeholder='Largo' id='large" +(i + 1) + "' name='large" +(i + 1)+ "' onkeyup='icsGeticsGetPesoVol()' type='float' maxlength='10' min='1' required='true' value='" + json[i].large + "'>"+"\n"+
            "<span>in</span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Ancho</label>"+"\n"+
          "<div class='col-lg-9'>"+"\n"+
            "<input type='number' class='form-control form_dimension' placeholder='Ancho' id='width" +(i + 1)+ "' name='width" +(i + 1)+ "' type='float' maxlength='10' min='1' required='true' value='" + json[i].width + "' >"+"\n"+
         "<span>in</span>"+"\n"+
         " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
        "</div>"+"\n"+

        " <div class='dimensmedidas' id='divheight'>"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >Alto</label>"+"\n"+
          "<div class='col-lg-9'>"+"\n"+
            "<input type='number' class='form-control form_dimension' placeholder='Alto' id='height" +(i + 1)+ "' onkeyup='icsGetPesoVol()' name='height" +(i + 1)+ "' type='float' maxlength='10' min='1' required='true' value='" + json[i].height + "'>"+"\n"+
            "<span>in</span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas' id='divheight'>"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>"+"\n"+
         " <div class='col-lg-9'>"+"\n"+
            "<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm" +(i + 1)+ "' onkeyup='icsGetPesoVol()' name='volumetricweightm" +(i + 1)+ "' type='float' readonly='' maxlength='10' min='1' required='true' value='" + json[i].maritime_volume + "' >"+"\n"+
              "<span>ft<sup>3</sup></span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas' id='divheight'>"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>"+"\n"+
         " <div class='col-lg-9'>"+"\n"+
            "<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta" +(i + 1)+ "' onkeyup='icsGetPesoVol()' name='volumetricweighta" +(i + 1)+ "' type='float' readonly='' maxlength='10' min='1' required='true' value='" + json[i].aerial_volume + "' >"+"\n"+
              "<span>Vlb</span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
       "</div>"+"\n"+

       " <div class='dimensmedidas' id='divheight'>"+"\n"+
       " <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>"+"\n"+
          "<div class='col-lg-9'>"+"\n"+
            "<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight" +(i + 1)+ "' onkeyup='icsGetPesoVol()' name='weight" +(i + 1)+ "' type='float' maxlength='10' min='1' required='true' value='" + json[i].weight + "' >"+"\n"+
            "<span>lb</span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
            "</div>"+"\n"+
        "</div>"+"\n"+

       "</div>"+"\n"+
       " </div>");
      $('#countbooking').val(i+1);
      /**
       * load the container type:  i (quantity), true (current no create mode), false (current edit mode)
      */
     icsAddTypeOn((i + 1), false, true, json[i].container);
     /**
     *
     **/
    }
    else {
      $('#description1').val(json[i].description);
      $('#pieces1').val(json[i].pieces);
      $('#type1 > option[value="'+json[i].container+'"]').attr('selected', 'selected');
      $('#large1').val(json[i].large);
      $('#width1').val(json[i].width);
      $('#height1').val(json[i].height);
      $('#volumetricweightm1').val(json[i].maritime_volume);
      $('#volumetricweighta1').val(json[i].aerial_volume);
      $('#weight1').val(json[i].weight);
    }
  });
  $('select').select2();
  aux = parseInt($('#countbooking').val());
}
/**
 * delete booking
 */
var icsBookingDelete = function (element, from) {
  try {
    var booking = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + "/" + booking.id;
    if(booking != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result)
      {
        if(result)
        {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e)
  {
    log(e);
  }
}

var countimg=0;
function preview_image()
{
 var res=countimg+1;
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {

  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>Eliminar</a>");
 }
}

function remove_preview(id){
  console.log
  $('#'+id).remove();
}
