/**
*
*/
'use strict';
var aux = 1;
var step;
/**
*
*/
$(document).ready( function()
{
  /**
  *
  */
  $('#dtble').DataTable({
    "order": [
      [ 1, "desc" ]
    ]
  });
  /**
  *
  */
  $('select').select2();
  /**
  *
  */

     $('#category').change(function() {
           // taxcalculation();
        //   selecttaxcategory($('#category').val());
        });

        $('#type').change(function(){
        //  taxcalculation();
        });

        $('#addcharge').change(function(){
          //taxcalculation();
          calcost();
          calctax();
        });

        $('#promotion').change(function(){
          //taxcalculation();
        });
        $('#service').change(function(){
         // taxcalculation();
        });

        $('#companySelect').change(function(){
          selectclient($('#companySelect').val());
        });

        $('#invoice').change(function(){
          console.log($('#invoice select').val());
          if($('#invoice select').val()=='0'){
            $('#uploadinvoice').css("display","none");
          }else{
            $('#uploadinvoice').toggle("fast");
          }
        });

        $('#typeservice').change(function(){
          $('#costservice').val(parseFloat($('#typeservice option:selected').attr('cost'))+" $");
          calcost();
          calctax();

        });






   $('select').select2(
        {
          width: '100%'
          //placeholder: "Select a client",
          //allowClear: true
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
          else if (el.attr('id') == 'courierSelect')//si viene del clientSelect
          {

          }
          else if (el.attr('id') == 'finalOriginUser') //si viene de finalDestinationClient
          {
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataUsertoring(item);


          }
          else if (el.attr('id') == 'finalDestinationUser') //si viene de finalDestinationClient
          {

              if((el.find('option:selected').val())=='addud'){


                $("#destin_name").removeAttr("readonly");
                $("#destin_lastname").removeAttr("readonly");
                $("#destin_dni").removeAttr("readonly");
                $("#destin_phone").removeAttr("readonly");
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
                document.getElementById('destin_phone').value="";
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
                $("#destin_phone").attr("readonly","readonly");
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



          }else if (el.attr('id') == 'finalConsigUser') //si viene de finalDestinationClient
          {
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

               if(item.id=='1' || item.id=='3'){
                  var auxm=0;
                  var x;
                  for (x=1;x<=$('#countpack').val();x++) {
                      auxm=parseFloat(auxm) + parseFloat($('#volumetricweightm'+x).val())
                  }
                  if(isNaN(auxm)){
                    $("#volre").val("0 ft3");
                  }else{
                    $("#volre").val(auxm+" ft3");
                  }




              }else if(item.id=='2' ){
                  var auxa=0;
                  for (x=1;x<=$('#countpack').val();x++) {
                        auxa=parseFloat(auxa) + parseFloat($('#volumetricweighta'+x).val())
                  }

                  if(isNaN(auxa)){
                    $("#volre").val("0 Vlb");
                  }else{
                    $("#volre").val(auxa+" Vlb");
                  }



              }else{

              }
              selectservicio(item.id);
          }
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
* Metodo por el cual se habilida o deshabilita los elementos web de los clientes
*/
function disabledClients(op)
{
  $('#name,#phone,#email,#identifier,#direction').attr('disabled', op === 'true');
}

/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del paquete
*/
function showPackages(op)
{
  $('#packageTitle,#width,#height,#weight,#value,#type,#invoice,#categoryDiv,#taxdiv').attr('style', 'display:'+op );
}

/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del destino
*/
function showDestination(op)
{
  $('#destinationTitle,#destinationName,#destinationPhone,#destinationEmail,#destinationIdentifier,#destinationSelect,#destinationDirection').attr('style', 'display:'+op );

  $('#destin_name,#destin_phone,#destin_email,#destin_identifier,#destin_direction').attr('required', op === 'block');
}

/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del cliente
*/
function showClients(op, disabled)
{
  $('#clientTitle,#clientName,#clientPhone,#clientEmail,#clientIdentifier, #clientDirection').attr('style', 'display:'+op );

  $('#name,#phone,#email,#identifier,#direction').attr('required', op == 'block');

  disabledClients(disabled);

  showPackages(op);

  showDestination(op);
}

/**
* Metodo que controla cual select (client o users) se debe mostrar
*/
function showSelects(selectObj)
{
  var index = selectObj.selectedIndex;
  var selectedValue = selectObj.options[index].value;

  if (selectedValue == 0) //Cliente
  {
    document.getElementById('finalDestinationUser').style.display='none';
    document.getElementById('finalDestinationUser').required=false;
    document.getElementById('finalDestinationClient').style.display='block';
    document.getElementById('finalDestinationClient').required=true;
    return;
  }
  else (selectedValue == 1) //usuario
  {
    document.getElementById('finalDestinationClient').style.display='none';
    document.getElementById('finalDestinationClient').required=false;
    document.getElementById('finalDestinationUser').style.display='block';
    document.getElementById('finalDestinationUser').required=true;
    return;
  }
  return;
}

/**
* Metodo que controla cuales elementos se deben mostrar si los del cliente o los del courier
*/
function showElements(selectedValue)
{
   //var index = selectObj.selectedIndex;
   //var selectedValue = selectObj.options[index].value;

   $('#divButton,#divObservation,#divdimens,#divweight,#divvalue').attr('style', 'display:block,' );

   if (selectedValue == 1)
   {
     //show client
     document.getElementById('client').style.display='block';
     document.getElementById('divcli').style.display='block';
     showClients('block','false');
     //hide courier
     $('#courier,#divTracking,#destination').attr('style', 'display:none' );
     document.getElementById('tracking').required=false;
   }
   else if (selectedValue == 2)
   {
     //hide client
     document.getElementById('client').style.display='none';
     document.getElementById('divcli').style.display='none';
     showClients('none');
     //show courier
     $('#courier,#divTracking,#destinationTitle,#destination').attr('style', 'display:block' );
     document.getElementById('tracking').required=true;
     showPackages('block');
     //disabledDestination('false');
   }
   else
   {
     //hide
     //client, courier, button
     showClients('none');
     $('#client,#courier,#divTracking,#destination,#divButton,#divObservation').attr('style', 'display:none' );
     document.getElementById('tracking').required=false;
     showPackages('none');
   }
   return false;
}

/**
* Metodo por medio del cual se le asignan valores a los elementos web del cliente
*/
function setDataUsertoring(clientData)
{
  if (clientData)
  {
    document.getElementById('name').value=clientData.code+" "+clientData.name+" "+clientData.last_name;
    document.getElementById('phone').value=clientData.local_phone;
    document.getElementById('email').value=clientData.email;
    document.getElementById('direction').value=clientData.address;
    document.getElementById('zipcode').value=clientData.postal_code;
    document.getElementById('country').value=clientData.country;
    document.getElementById('region').value=clientData.region;
  }
  else
  {
    document.getElementById('name').value="";
    document.getElementById('phone').value="";
    document.getElementById('email').value="";
    document.getElementById('direction').value="";
    document.getElementById('zipcode').value="";
    document.getElementById('country').value="";
    document.getElementById('region').value="";

  }

}

/**
* Metodo por medio del cual se le asignan valores a los elementos web del destino
*/
function setDataDestinationUser(destinationData)
{
  if (destinationData)
  {
    document.getElementById('destin_name').value=destinationData.code+" "+destinationData.name+" "+destinationData.last_name;
    document.getElementById('destin_lastname').value=destinationData.last_name;
    document.getElementById('destin_dni').value=destinationData.dni;
    document.getElementById('destin_phone').value=destinationData.local_phone;
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
    document.getElementById('destin_name').value="";
    document.getElementById('destin_lastname').value="";
    document.getElementById('destin_dni').value="";
    document.getElementById('destin_phone').value="";
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
    document.getElementById('cons_name').value=destinationData.code+" "+destinationData.name+" "+destinationData.last_name;
    document.getElementById('cons_phone').value=destinationData.local_phone;
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


/**
 *
 */
var tpickupDelete =  function (element, from)
{
  try
  {
    var container = getItem(element) || getItemFromParent(element);

    /**
    *
    */
    if(container != undefined)
    {
      bootbox.confirm(eval(msg(messages.delete)), function(result)
      {
        if(result)
        {
          doForm(`./admin/tpickup/${container.id}`, 'delete', undefined, from === undefined ? true : from);

}      });
    }

  } catch (e)
  {
    log(e);
  }
}


/**
* add cargo on booking
*/
var addpackage = function ()
{
  aux = aux + 1;
  /**
  *
  */
  $('#countpack').val(aux);
  /**
  *
  */
  $('#listpack').append("<li id='ics_li_cargo"+aux+"' class='paq'><a data-toggle='tab' href='#pick"+aux+"'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> PKO"+aux+"<span  onclick='icsDelCargoOnBooking("+aux+")' id='ics_del_cargo_on_booking"+aux+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
  /**
  *
  */
  $('#contentpack').append("<div class='row tab-pane fade' id='pick"+aux+"' style='padding:20px'>"+"\n"+
    "<div class='col-md-8'>"+"\n"+
     " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
         " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
         " <div class='col-lg-10'>"+"\n"+
           " <input type='text' class='form-control' placeholder='Descripcion' id='description"+aux+"' name='description"+aux+"' min='1' required='true' value='' >"+"\n"+
           " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
        "  </div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
          "<div class='row' style='margin-right: 0px;margin-left: 0px;'>"+"\n"+
            "<label class='col-lg-2 control-label' id='typeLabel' style='line-height: 14px;'>Tipo de pickup</label>"+"\n"+
            "<div class='col-lg-10' style='padding-bottom: 5px;'>"+"\n"+
              "<select class='form-control' placeholder='Tipo' id='typepickup"+aux+"' name='typepickup"+aux+"' maxlength='10' min='1' required='true' value='' >"+"\n"+
              " <select/>"+"\n"+
            "</div>"+"\n"+
          " </div>"+"\n"+
        " </div>"+"\n"+
        "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
          "<div class='row' style='margin-right: 0px;margin-left: 0px;'>"+"\n"+
            "<label class='col-lg-2 control-label' id='typeLabel' style='line-height: 12px;'>Numero de Partes</label>"+"\n"+
            "<div class='col-lg-10' style='padding-bottom: 5px;'>"+"\n"+
              "<select class='form-control' placeholder='Partes' id='numberparts"+aux+"' onchange=valselect('"+aux+"') name='numberparts"+aux+"' maxlength='10' min='1' required='true' value='' >"+"\n"+
              " <select/>"+"\n"+
            "</div>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='Piezas' id='pieces"+aux+"' name='pieces"+aux+"' maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >Valor</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='Valor' id='valued"+aux+"' name='valued"+aux+"'  maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >Factura</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='Factura' id='invoiced"+aux+"' name='invoiced"+aux+"' maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >Tracking</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='Po' id='tracking"+aux+"' name='tracking"+aux+"' maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+


        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >Po</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='Po' id='po"+aux+"' name='po"+aux+"' maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+
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
     AddType(aux);
     AddNumberParts(aux);
     $('select').select2();
}


/**
* getData for option select
*/
var AddType = function (value)
{
  var url = `${window.location.origin}${window.location.pathname}/type`;
  console.log(url);
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function ()
    {
    },
    success: function (json)
    {
      LoadDinamicSelectType(json.message, value);
      //console.log(json.message);
    },
    error: function (e)
    {
      log(e);
    }
  });

}

var LoadDinamicSelectType = function (json, value)
{
  $.each(json, function(i, item)
  {
    $('#typepickup' + value).append('<option value ="'+json[i].id+'">' + json[i].name  + '</option>');
  });
}

/**
*
*/

var AddNumberParts = function (value)
{
  var url = `${window.location.origin}${window.location.pathname}/numberparts`;
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function ()
    {
    },
    success: function (json)
    {
      LoadDinamicSelectNumberParts(json.message, value);
    //  console.log(json.message);
    },
    error: function (e)
    {
      log(e);
    }
  });

}

var LoadDinamicSelectNumberParts = function (json, value)
{
  $.each(json, function(i, item)
  {
    //console.log(json[i]);
    var obj = JSON.stringify(json[i]).replace("\n", "&nbsp;");
    //console.log(obj);
    var params = {
                "name" : json[i].name,
                "description":(json[i].description).replace(" ", "&nbsp;"),
                "pieces":(json[i].pieces).replace(" ", "&nbsp;"),
                "large":(json[i].large).replace(" ", "&nbsp;"),
                "width":(json[i].width).replace(" ", "&nbsp;"),
                "height":(json[i].height).replace(" ", "&nbsp;"),
                "volumetricweightm":(json[i].volumetricweightm).replace(" ", "&nbsp;"),
                "volumetricweighta":(json[i].volumetricweighta).replace(" ", "&nbsp;"),
                "weight":(json[i].weight).replace(" ", "&nbsp;")

    };

    var result=JSON.stringify(params);


    $('#numberparts' + value).append('<option item ='+result+' value ="'+json[i].id+'">' + json[i].name  + '</option>');
  });
}



function taxcalculation(){
  var val=$("#value").val()
  var valpromo=$("#promotionval").val()
  var sum=0,resultcat,result,aux,resultsub=0;
  var transport;
  var promotion=parseInt($('#promotion option:selected').attr('reduction'));
  var addcharge=parseInt($('#addcharge option:selected').attr('cost'));
  var sub=$("#subtotal").val();
  var service;
  if(transport>0){
    transport=0;
  }else{
    transport=parseInt($('#type option:selected').attr('cost'));
  }

  if(service>0){
    service=0;
  }else{
    service=parseInt($('#service option:selected').attr('cost'));
  }



  var taxcat=$('#category option:selected').attr('porcent')/100;

  var toinu;

  if(toinu==''){
    toinu=0;
  }else{
    toinu=parseFloat($("#toinsurance").val());
  }

  var sub2=sub.replace("$","");
  $('#taxdiv input').each(function(){
    var taxvalue= $(this).attr('attr-mivalue')/100;
    var taxid= $(this).attr('id');
    var calc=taxvalue*sub2;
    sum= sum+calc;
    var calt=calc.toFixed(2);
    $('#'+taxid).val(calt+"$");
    })
    resultcat=val*taxcat;
    result=(sum+transport+service+addcharge+toinu).toFixed(2);
    resultsub=(transport+service+addcharge+toinu).toFixed(2);
    if(promotion>0){
      aux=result*(promotion/100);
      $("#subtotal").val((resultsub).toString()+"$");
      $("#promotionval").val("-"+aux+"$");
      $("#total").val((result-aux).toString()+"$");

    }else{
      $("#subtotal").val(resultsub.toString()+"$");
      $("#total").val(result.toString()+"$");
      $("#promotionval").val("0");
    }
}

/*
** Funcion que se encarga del calculo del costo del seguro
*/
function calcinsurence(){
  var porcent =$("#insurance").val()/100;
  var valor   =$("#value").val();
  var totalinsure=porcent*valor;
  $("#toinsurance").val((totalinsure).toString()+"$");
  taxcalculation();
  console.log(totalinsure);
}

/**
* delete cargo of booking
*/
var icsDelCargoOnBooking = function (numberOfCargo)
{
  var paq,auxco,contr;
  if(($("#ics_li_cargo"+numberOfCargo).hasClass('active'))){
    auxco=true;
  }else{
    auxco=false;
  }

  $("#ics_li_cargo"+numberOfCargo).remove();
  $("#pick"+numberOfCargo).remove();

  paq=$(".paq").size();
  if(numberOfCargo===aux){
    aux=aux-1;
    $("#ics_li_cargo"+aux).addClass("active ");
    $("#pick"+aux).addClass("active in");

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
    $("#pick"+contr).addClass("active in");
  }

  $('#countpack').val(aux);
   resultvalue();
}


function deletepickup(string,cont){
  console.log(string);
  $("#paquete"+cont).remove();
  $("#lipaquete"+cont).remove();
  aux=aux-1;
  //$('#countpack').val(aux);
  resultvalue();
}

/**
*Calculo del Peso volumetri
*/

function pesovol(){
  for (step = 1; step <= aux; step++) {
   var larg=$("#paquete"+step+" "+"#large"+step).val();
   var anch=$("#paquete"+step+" "+"#width"+step).val();
   var alto=$("#paquete"+step+" "+"#height"+step).val();
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;
   $("#paquete"+step+" "+"#volumetricweightm"+step).val((resultm.toFixed(2)).toString());
   $("#paquete"+step+" "+"#volumetricweighta"+step).val((resulta.toFixed(2)).toString());
  }

}

/**
*Calculo de valor total de los paquetes
*/

function resultvalue(){
 var sum=0;
 for (step = 1; step <= aux; step++) {
   var value=$("#paquete"+step+" "+"#valued"+step).val();
   console.log(value);
   sum =sum+parseFloat(value);
  }
  $("#value").val(sum);
}

function selecttaxcategory (id)
{

  var url = `${window.location.origin}${window.location.pathname}`+"/"+id+"/tax/json";

    $.ajax(
        {
          url: url,
          type: 'GET',
          dataType: 'json',
          beforeSend: function ()
          {
          },
          success: function (json) {
            console.log(json);
            $('#taxdiv').empty();
            $('#taxdiv').append("<h6>Impuestos</h6>");

             $.each(json.taxcategory, function(key, element) {

              $('#taxdiv').append("<div class='row' style='margin:0'><label class='col-lg-3 control-label' id='invoiceLabel'>"+element.name+"</label> <div class='col-lg-9'> "+
                "<input class='form-control' placeholder="+element.name+" attr-mivalue="+element.value+" id=tax"+element.id+" name=tax"+element.id+" readonly type='float'></div></div>");



             })

             taxcalculation();


          }
        });
}


var billoflading = function (id)
{
  var url = `${window.location.origin}${window.location.pathname}/newbill/`+id;
  console.log(url);


  bootbox.dialog
  ({
    title: "<span id=''>Creacion del Bill of Lading</span>",
    message: $('#load').load(url, function ()
    {

    }),
    size: "large",
    backdrop: true,
    onEscape: function() { },
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');

  })
  .modal('show');
}

var resultbill = function (id)
{
  var url      = `${window.location.origin}${window.location.pathname}`+"/newbill/"+id;
  var dataString = $("#billoflading")[0];
  $.ajax(
        {
          url: url,
          type: 'POST',
          dataType: 'json',
          data: new FormData($("#billoflading")[0]),
          processData: false,
          contentType: false,
          beforeSend: function ()
          {
            $('#cl').html("<div class='progress'><div class='progress-bar progress-bar-striped active' role = 'progressbar' style = 'width:100%;'></div></div>");
          },
          success: function (json) {
            window.open(`${window.location.origin}${window.location.pathname}`+"/pdfbill/"+id, '_blank');
            //((json.message == 'true') ? detailspackage(id,'false'): evalJson (json.alert))
          }
        });
}

var detailspickup = function (id, open)
{
  var path  =`${window.location.origin}${window.location.pathname}`;
  var sw    = 0;
  var alert = false;
  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) /** show in the modal details of package**/
  {
    bootbox.dialog({
      title: "<span id='tltgnif'>Información</span>",
      message: $('#load').load(path + "/" + id, function ()
      {
      }),
      size: "large",
      backdrop: true,
      onEscape: function() { },
    })
    .on('shown.bs.modal', function ()
    {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
  }
  else /** show in the modal general views**/
  {
    if ($('#pnlin').hasClass( "showpack" ))
    {
      if (open == 'true')
      {
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
        bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>Información</span>",
          message: $('#load').load(path + "/showpickup/" + id, function ()
          {
            $('#event').select2();
          }),
          size:"large",
          backdrop: true,
          onEscape: function() { },
        })
        .on('shown.bs.modal', function ()
        {
          $('#load').show();
        })
        .on('hide.bs.modal', function (e)
        {
          $('#load').hide().appendTo('body');
        })
        .modal('show');
      }
      else
      {
        $('#load').load(path+"/showpickup/"+id,function()
        {
            $('#event').select2();
        });
      }
    }
    else
    {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
      bootbox.dialog
      ({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='atrás' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>Información</span>",
        message: $('#load').load(path + "/" + id + "/read", function ()
        {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="Editar"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="Nuevo Cliente"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" ))
          {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>Clientes</h4></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> Cargando...</p></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function ()
            {
              $('#dtble').DataTable();
            });
          }
        }),
        size: "large",
        backdrop: true,
        onEscape: function() { },
      })
      .on('shown.bs.modal', function ()
      {
        $('#load').show();
      })
      .on('hide.bs.modal', function (e)
      {
        $('#load').hide().appendTo('body');
      })
      .modal('show');
    }
  }
}

/**
* Ajax method for change status package (VS)
*/
var changestatuspickup = function (id)
{
  var url      = `${window.location.origin}${window.location.pathname}`+"/showpickup/"+id;
  var dataString = {"event":$('#event').val(),
                    "observation":$('#observation').val()};
  //console.log(dataString);
  $.ajax(
      {
        url: url,
        type: 'POST',
        dataType: 'json',
        data: dataString,
        beforeSend: function ()
        {
          $('#cl').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
        },
        success: function (json)
        {
          ((json.message == 'true') ? detailspickup(id,'false'): evalJson (json.alert))
        }
      });
}

function valselect(id){

  var data=JSON.parse($('#numberparts'+id).find('option:selected').attr('item'));
  //console.log($('#numberparts'+id).find('option:selected').attr('item'));

 document.getElementById('pieces'+id).value=data.pieces;
 document.getElementById('large'+id).value=data.large.toFixed();
 document.getElementById('width'+id).value=data.width.toFixed();
 document.getElementById('height'+id).value=data.height.toFixed();
 document.getElementById('volumetricweightm'+id).value=data.volumetricweightm.toFixed();
 document.getElementById('volumetricweighta'+id).value=data.volumetricweighta.toFixed();
 document.getElementById('weight'+id).value=data.weight.toFixed();



}


/**
* Metodo para Agregar pickup a los wr
*/
function pickupadd(id)
{
  var url = `${window.location.origin}${window.location.pathname}/` + id + `/addwr`;

  bootbox.confirm("Desea Agregar este pickup a Warehouse ",
    function(result)
    {
       $.ajax({
        url: url,
        type: 'POST',
        beforeSend: function ()
        {
          $('#ics-checkpayd').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
        },
        success: function (json)
        {
          if(json.message == 'true')
          {
            location.reload();

          }
          else
          {

          }

        },
        error: function ()
        {

        }
      });
   });

}

/**
* load tabs data
*/
var icsLoadTabsAndData = function (booking) {
  var url = `${window.location.origin}${window.location.pathname}/items`;

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
var icsSetTabsData = function (json){
  console.log(JSON.stringify(json));

    $.each(json, function(i, item) {
    if ( i > 0)
    {
      $('#listpack').append("<li id='ics_li_cargo"+(i+1)+"' class='paq'><a data-toggle='tab' href='#pick"+(i+1)+"'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> PKO"+(i+1)+"<span  onclick='icsDelCargoOnBooking("+(i+1)+")' id='ics_del_cargo_on_booking"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      /**
      *
      */
      $('#contentpack').append("<div class='row tab-pane fade' id='pick"+(i+1)+"' style='padding:20px'>"+"\n"+
        "<div class='col-md-8'>"+"\n"+
         " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
             " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
             " <div class='col-lg-10'>"+"\n"+
               " <input type='text' class='form-control' placeholder='Descripcion' id='description"+(i+1)+"' name='description"+(i+1)+"' min='1' required='true' value='' >"+"\n"+
               " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
            "  </div>"+"\n"+

            "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
              "<div class='row' style='margin-right: 0px;margin-left: 0px;'>"+"\n"+
                "<label class='col-lg-2 control-label' id='typeLabel' style='line-height: 14px;'>Tipo de pickup</label>"+"\n"+
                "<div class='col-lg-10' style='padding-bottom: 5px;'>"+"\n"+
                  "<select class='form-control' placeholder='Tipo' id='typepickup"+(i+1)+"' name='typepickup"+(i+1)+"' maxlength='10' min='1' required='true' value='' >"+"\n"+
                  " <select/>"+"\n"+
                "</div>"+"\n"+
              " </div>"+"\n"+
            " </div>"+"\n"+
            "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
              "<div class='row' style='margin-right: 0px;margin-left: 0px;'>"+"\n"+
                "<label class='col-lg-2 control-label' id='typeLabel' style='line-height: 12px;'>Numero de Partes</label>"+"\n"+
                "<div class='col-lg-10' style='padding-bottom: 5px;'>"+"\n"+
                  "<select class='form-control' placeholder='Partes' id='numberparts"+(i+1)+"' onchange=valselect('"+(i+1)+"') name='numberparts"+(i+1)+"' maxlength='10' min='1' required='true' value='"+json[i].description+"' >"+"\n"+
                  " <select/>"+"\n"+
                "</div>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+

            "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Piezas' id='pieces"+(i+1)+"' name='pieces"+(i+1)+"' maxlength='10' min='1' required='true' value='"+json[i].pieces+"'>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+

            "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel' >Valor</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Valor' id='valued"+(i+1)+"' name='valued"+(i+1)+"'  maxlength='10' min='1' required='true' value='"+json[i].value+"'>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+

            "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel' >Factura</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Factura' id='invoiced"+(i+1)+"' name='invoiced"+(i+1)+"' maxlength='10' min='1' required='true' value='"+json[i].invoice+"'>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+

            "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel' >Tracking</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Tracking' id='tracking"+(i+1)+"' name='tracking"+(i+1)+"' maxlength='10' min='1' required='true' value='"+json[i].tracking+"'>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+


            "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel' >Po</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Po' id='po"+(i+1)+"' name='po"+(i+1)+"' maxlength='10' min='1' required='true' value='"+json[i].po+"'>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+
        "</div>"+"\n"+
         "<div class='col-md-4'>"+"\n"+
          "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
            "<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>"+"\n"+
           " <div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+(i+1)+"' name='large"+(i+1)+"' onkeyup='icsGeticsGetPesoVol()' type='float' maxlength='10' min='1' required='true' value='"+json[i].large+"'>"+"\n"+
              "<span>in</span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
          "</div>"+"\n"+
          "<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>"+"\n"+
            "<label class='col-lg-3 control-label' id='typeLabel' >Ancho</label>"+"\n"+
            "<div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Ancho' id='width"+(i+1)+"' name='width"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+json[i].width+"' >"+"\n"+
           "<span>in</span>"+"\n"+
           " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
          "</div>"+"\n"+
          " <div class='dimensmedidas' id='divheight'>"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Alto</label>"+"\n"+
            "<div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+(i+1)+"' onkeyup='icsGetPesoVol()' name='height"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+json[i].height+"'>"+"\n"+
              "<span>in</span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
          "</div>"+"\n"+
          "<div class='dimensmedidas' id='divheight'>"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>"+"\n"+
           " <div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+(i+1)+"' onkeyup='icsGetPesoVol()' name='volumetricweightm"+(i+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+json[i].volumetricweight+"' >"+"\n"+
                "<span>ft<sup>3</sup></span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
          "</div>"+"\n"+
          "<div class='dimensmedidas' id='divheight'>"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>"+"\n"+
           " <div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+(i+1)+"' onkeyup='icsGetPesoVol()' name='volumetricweighta"+(i+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+json[i].volumetricweight+"' >"+"\n"+
                "<span>Vlb</span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
         "</div>"+"\n"+
         " <div class='dimensmedidas' id='divheight'>"+"\n"+
         " <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>"+"\n"+
            "<div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+(i+1)+"' onkeyup='icsGetPesoVol()' name='weight"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+json[i].weight+"' >"+"\n"+
              "<span>lb</span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
          "</div>"+"\n"+
         "</div>"+"\n"+
         " </div>");
         AddType((i+1));
         AddNumberParts((i+1));
         $('#countpack').val((i+1));

    }else{
      $('#description1').val(json[i].description);
      $('#pieces1').val(json[i].pieces);
      $('#type1 > option[value="'+json[i].type+'"]').attr('selected', 'selected');
      $('#numberparts1 > option[value="'+json[i].partnumber+'"]').attr('selected', 'selected');
      $('#large1').val(parseFloat(json[i].large));
      $('#width1').val(parseFloat(json[i].width));
      $('#height1').val(parseFloat(json[i].height));
      $('#valued1').val(parseFloat(json[i].value));
      $('#invoiced1').val(json[i].invoice);
      $('#tracking1').val(json[i].tracking);
      $('#po1').val(json[i].po);
      $('#volumetricweightm1').val(parseFloat(json[i].volumetricweight));
      $('#volumetricweighta1').val(parseFloat(json[i].volumetricweight));
      $('#weight1').val(parseFloat(json[i].weight));
    }
  });
  $('select').select2();
  aux = parseInt($('#countpack').val());
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


var selectservicio = function (id) {
var m,a;

    $('#subtotal').val('');
    var url = `${window.location.origin}${window.location.pathname}`+"/"+id+"/service/json";
      $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            beforeSend: function ()
            {
            },
            success: function (json) {

              $('#typeservice').empty();
              $('#typeservice').append("<option value=''>" +'Seleccione tipo de Servicio'+ "</option>");
              $.each(json.service, function(key, element) {
                var item="{'id':'"+element.id+"','code':'"+element.code+"','price':'"+element.value+"','name':'"+element.name+"'}";
                $('#typeservice').append("<option item="+JSON.stringify(item)+" cost='"+parseInt(element.value)+"' value='" + element.id + "'>" +" "+ element.name + " "+ parseInt(element.value)+"($) </option>");
              });

            }
      });

}

var calcost = function (){

    var vol=0,result;
    var addcharge,resinsu=0;
    var transport=parseInt($('#typeservice option:selected').attr('cost'));

    if($('#type option:selected').val()==1 || $('#type').val()==3){
      console.log('maritimocost');
        var auxm=0;

        for (var x=1;x<=$('#countpack').val();x++) {
            auxm=parseFloat(auxm) + parseFloat($('#volumetricweightm'+x).val())
        }

        vol=auxm;

    }else if($('#type').val()==2){
      console.log('aereocost');
        var auxa=0;
        for (x=1;x<=$('#countpack').val();x++) {
              auxa=parseFloat(auxa) + parseFloat($('#volumetricweighta'+x).val())
        }

        vol=auxa;

    }
    console.log('vol:'+vol);


    addcharge=$('#addcharge option:selected').attr('cost');
    if(jQuery.type(addcharge)=== "undefined"){
      addcharge=0;
    }else{
      addcharge=parseFloat($('#addcharge option:selected').attr('cost'));
    }

    if(jQuery.type(transport)=== "undefined"){
      transport=0;
    }else{
      transport=parseInt($('#typeservice option:selected').attr('cost'));
    }


    if($('#insurance').val()>0){
      var valinsu= $('#value').val();
      var insu = $('#insurance').val()/100;
      resinsu = valinsu *insu ;
    }

    result=vol*transport+addcharge+resinsu;
    $('#subtotal').val(result.toFixed(2));

}

var calctax = function (){

  var promotion=parseInt($('#promotion option:selected').attr('reduction'));
  var addcharge;
    addcharge=$('#addcharge option:selected').attr('cost');
   if(jQuery.type(addcharge)=== "undefined"){
    addcharge=0;
  }else{
    addcharge=parseFloat($('#addcharge option:selected').attr('cost'));
  }

  var aux=0;var auxre=0;
  var sub=$('#subtotal').val();
  console.log($('#subtotal').val());
  var subtax=$('#subtotal').val()/100;
  var taxvalue= $("#taxval").val();
  console.log(taxvalue);
  var calc=taxvalue*subtax;


  $('#taxre').val(calc.toFixed(2));
  var res=parseFloat(calc)+parseFloat(sub);
  var resinsu=0;

  if($('#insurance').val()>0){
    var valinsu= $('#value').val();
    var insu = $('#insurance').val()/100;
    resinsu = valinsu *insu ;
  }

  if(promotion>0){
    aux=res*(promotion/100);
    auxre=parseFloat(res)-parseFloat(aux);
    $('#costadd').val(addcharge);
    $('#promotionval').val("-"+aux.toFixed(2));
    $('#total').val(auxre.toFixed(2));


  }else{
    auxre=parseFloat(res);
    $('#costadd').val(addcharge+" $");
    $('#edit-promotionval').attr('placeholder', 'N/A');
    $('#promotionval').val("");
    $('#total').val(auxre.toFixed(2));
  }



}


var calcinsurance= function (){

  var val= $('#value').val();
  var insu = $('#insurance').val()/100;
  var res= val *insu ;
  $('#toinsurance').val(res.toFixed(2)+' $');
  calcost();
  calctax();


}
