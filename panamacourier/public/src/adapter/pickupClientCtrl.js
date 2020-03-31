/**
*
*/
'use strict';
var aux = 1;
var step;

/**
 * TRANSLATE OBJECT DEFINITION ************************************************
 */
var translate = function() {
  if (messages.language == 'es') {
    return ({
      'mailNotification' : 'Notificando al correo',
      'loading' : 'Cargando...',
      'info' : 'Informacion',
      'back' : 'Atras',
      'receivedOfficeUsa' : 'Recibido en oficina (USA)',
      'receivedOfficePa'  : 'Recibido en oficina (PA)',
      'edit' : 'Editar',
      'processed' : 'Procesado satisfactoriamente',
      'newClient' : 'Nuevo cliente',
      'errorFound' : 'Se Encontraron los siguientes errores: ',
      'errorTry' : 'Ha ocurrido un error, intentelo de nuevo',
      'typePackage' : 'Tipos de paquetes recibidos del mes',
      'psckagesInvoice': 'Paquetes Con y sin Factura del mes actual',
      'chooseMonth' : 'Seleccione el mes',
      'noAsync' : 'no se ha podido procesar la solicitud asíncrona',
      'chooseDay' : 'Seleccione el dia',
      'monthNames' : [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
      'dayNamesMin' : [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      'cancel' : 'Cancelar',
      'accept' : 'Aceptar',
      'serverError' : 'Ha ocurrido un error en el servidor',
      'wait' : 'Espere...',
      'loadInvoice' : 'Cargar Factura',
      'saving' : 'Guardando datos...',
      'completed' : 'Completado',
      'chooseClient': 'Seleccione el cliente',
      'chooseRoute': 'Seleccione la ruta',
      'receipt' : 'Recibo',
      'stateName' : 'Nombre del estado',
      'description' : 'Descripción',
      'alert' : 'Alerta!!',
      'deleteMessage' : '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.',
      'withoutRoute' : 'Sin rutas para el servicio seleccionado',
      'noNotify': 'No notificar',
      'notifyBoth': 'Ambos correos',
      'client' : 'Client',
      'portAirport' : 'Puerto o Aeropuertos',
      'pieces' : 'Piezas',
      'value' : 'Valor',
      'prealert' : 'Prealerta',
      'chooseOption' : 'Seleccione una opcion',
      'courier' : 'Courier',
      'large' : 'Largo',
      'width' : 'Ancho',
      'height' : 'Alto',
      'weight' : 'Peso',
      'unregistered' : 'No se encuentra Registrado',
      'delete' : 'Eliminar',
      'noUser' : 'No ha seleccionado ningun usuario',
      'typepickup' : 'Tipo de Recolecta',
      'numberpart' : 'Numero de Parte',
      'invoice' : 'Factura',
      'tracking' : 'Tracking',
      'deletepickup' : "¿Esta seguro que desea eliminar la Orden de Recogida?",
      'confirmToWarehouse' : '¿Desea agreagar esta orde de recolecta a Almacen?'

    });
  }else {
    return({
      'mailNotification' : 'Notifying to user email',
      'loading' : 'Loading...',
      'info' : 'Details',
      'back' : 'Previous',
      'receivedOfficeUsa' : 'Received in office (USA)',
      'receivedOfficePa'  : 'Received in office (PA)',
      'edit' : 'Edit',
      'processed' : 'Processed success',
      'newClient' : 'New Client',
      'errorFound' : 'Error found: ',
      'errorTry' : 'Error, try again',
      'typePackage' : 'Type of packages arrived on the month',
      'psckagesInvoice': 'Packages with or without invoice',
      'chooseMonth' : 'Choose a Month',
      'noAsync' : 'Could\'t process async request',
      'chooseDay' : 'Choose a day',
      'monthNames' : [ "January", "February", "March", "April", "May", "Jun", "July", "August", "September", "October", "November", "December" ],
      'dayNamesMin' : [ "Su", "Mo", "Th", "We", "Thr", "Fr", "Sa" ],
      'cancel' : 'Cancel',
      'accept' : 'Accept',
      'serverError' : 'Something went wrong in the server',
      'wait' : 'Wait...',
      'loadInvoice' : 'Load Invoice',
      'saving' : 'Saving data...',
      'completed' : 'Complete',
      'chooseClient' : 'Choose a client',
      'chooseRoute': 'Choose Route',
      'receipt' : 'Receipt',
      'stateName' : 'State Name',
      'description' : 'Description',
      'alert' : 'Warning!!',
      'deleteMessage' : 'Are you sure want to delete this status, this may cause problem whit packages that use it!',
      'withoutRoute' : 'Don\'nt are routes for service choosen',
      'noNotify': 'No nofication',
      'notifyBoth': 'Both e-mails',
      'client' : 'Cliente',
      'portAirport' : 'Port or Airport',
      'pieces' : 'Pieces',
      'value' : 'Value',
      'prealert' : 'Prealert',
      'chooseOption' : 'Choose an Option',
      'courier' : 'Courier',
      'large' : 'Large',
      'width' : 'Width',
      'height' : 'Height',
      'weight' : 'Weight',
      'unregistered' : 'Not registered',
      'delete' : 'Delete',
      'noUser' : 'No user choosen',
      'typepickup' : 'Tipe of PickUp',
      'numberpart' : 'Part Number',
      'invoice' : 'Invoice',
      'tracking' : 'Tracking',
      'deletepickup' : 'Are you sure want to delete this PickUp Order?',
      'confirmToWarehouse' : '¿Do you want to move this PickUp Order to Warehouse?'
    });
  }
}
/**
 * ****************************************************************************
 */

/**
*
*/
$(document).ready( function () {
  /**
  *
  */
  $('#pickup_date').datepicker({
    dateFormat:    "yy-mm-dd",
  });
  /*
  *
  */
  $('#pickup_hour').datetimepicker({
     format: 'HH:mm:ss'
  });
  /**
  *
  */
  $('#since_date').datepicker({
     dateFormat: "yy-mm-dd"
  });
  /**
  *
  */
  $('#until_date').datepicker({
      dateFormat: "yy-mm-dd"
  });
  /**
  *
  */
  $('#deliver_date').datepicker({
    dateFormat:    "yy-mm-dd",
  });
  /*
  *
  */
  $('#deliver_hour').datetimepicker({
     format: 'HH:mm:ss'
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
  /**
   *
   */
  $('#type').change(function(){
  //  taxcalculation();
  });

  $('#addcharge').change(function(){
    //taxcalculation();
    calcost();
    calctax();
  });
  /**
   *
   */
  $('#promotion').change(function(){
    //taxcalculation();
  });
  /*
  *
  */
  $('#service').change(function(){
    // taxcalculation();
  });

  $('#companySelect').change(function(){
    selectclient($('#companySelect').val());
  });

  $('#invoice').change(function(){
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

   $('select').select2({
          width: '100%'
          //placeholder: "Select a client",
          //allowClear: true
        }).on('select2:select', function(e) //seleccionar cualquier opcion del select
        {
          var text = translate();
          var el = $(e.currentTarget);

          if (el.attr('id') == 'from') //si viene del from
          {
            showElements(el.val());
          }
          else if (el.attr('id') == 'transporter')//si viene del clientSelect
          {
              if(el.find('option:selected').attr('value') != 0){

                var trans = el.find('option:selected').attr('item');
                trans = JSON.parse(trans);
                document.getElementById('transporter_pro').value=trans.numberscac;
              }else {
                document.getElementById('transporter_pro').value='';
              }
          }
          else if (el.attr('id') == 'exporter_dir')//si viene del clientSelect
          {
            if ((el.find('option:selected').val())=='1') {
              $("#cons_country").removeAttr("readonly");
              $("#cons_region").removeAttr("readonly");
              $("#cons_city").removeAttr("readonly");
              $("#cons_phone").removeAttr("readonly");
              $("#cons_direction").removeAttr("readonly");

              document.getElementById('cons_direction').value="";
              document.getElementById('cons_country').value="";
              document.getElementById('cons_region').value="";
              document.getElementById('cons_city').value="";
              document.getElementById('cons_phone').value="";
            }else {
              $("#exporter option:selected").each(function(){
                 var item = ($(this).attr('item'));
                 if (item==0) {
                   bootbox.alert(text.noUser);
                 }
                 setDataConsignationUser(JSON.parse(item));
              });
            }
          }else if (el.attr('id') == 'consigner_dir')//si viene del clientSelect
          {
            if ((el.find('option:selected').val())=='1') {
              $("#destin_country").removeAttr("readonly");
              $("#destin_region").removeAttr("readonly");
              $("#destin_city").removeAttr("readonly");
              $("#destin_phone").removeAttr("readonly");
              $("#destin_direction").removeAttr("readonly");

              document.getElementById('destin_direction').value="";
              document.getElementById('destin_country').value="";
              document.getElementById('destin_region').value="";
              document.getElementById('destin_city').value="";
              document.getElementById('destin_phone').value="";
            }else {
              $("#consigner option:selected").each(function(){
                 var item = ($(this).attr('item'));
                 if (!item) {
                   bootbox.alert(text.noUser);
                 }else
                 if (item==0) {
                   bootbox.alert(text.noUser);
                 }
                 setDataDestinationUser(JSON.parse(item));
              });
            }
          }else if (el.attr('id') == 'consigner_dir')//si viene del clientSelect
          {
            if ((el.find('option:selected').val())=='1') {
              $("#destin_country").removeAttr("readonly");
              $("#destin_region").removeAttr("readonly");
              $("#destin_city").removeAttr("readonly");
              $("#destin_phone").removeAttr("readonly");
              $("#destin_direction").removeAttr("readonly");

              document.getElementById('destin_direction').value="";
              document.getElementById('destin_country').value="";
              document.getElementById('destin_region').value="";
              document.getElementById('destin_city').value="";
              document.getElementById('destin_phone').value="";
            }
          }
          else if (el.attr('id') == 'finalOriginUser') //si viene de finalDestinationClient
          {
              var i = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataUsertoring(i);
          }
          else if (el.attr('id') == 'consigner') //si viene de finalDestinationClient
          {
              if((el.find('option:selected').val())=='0'){
                document.getElementById('clientName').classList.remove("hidden");
                $("#destin_name").removeAttr("readonly");
                $("#destin_country").removeAttr("readonly");
                $("#destin_region").removeAttr("readonly");
                $("#destin_city").removeAttr("readonly");
                $("#destin_phone").removeAttr("readonly");
                $("#destin_direction").removeAttr("readonly");
                document.getElementById('destin_direction').value="";
                document.getElementById('destin_country').value="";
                document.getElementById('destin_region').value="";
                document.getElementById('destin_city').value="";
                document.getElementById('destin_phone').value="";
              }else
              if((el.find('option:selected').val())=='addud'){
                $("#destin_country").removeAttr("readonly");
                $("#destin_region").removeAttr("readonly");
                $("#destin_city").removeAttr("readonly");
                $("#destin_phone").removeAttr("readonly");
                $("#destin_direction").removeAttr("readonly");

                document.getElementById('destin_direction').value="";
                document.getElementById('destin_country').value="";
                document.getElementById('destin_region').value="";
                document.getElementById('destin_city').value="";
                document.getElementById('destin_phone').value="";

              }else{
                document.getElementById('clientName').classList.add("hidden");
                $("#destin_country").removeAttr("readonly");
                $("#destin_region").removeAttr("readonly");
                $("#destin_city").removeAttr("readonly");
                $("#destin_phone").removeAttr("readonly");
                $("#destin_direction").removeAttr("readonly");
                var item = eval('(' + el.find('option:selected').attr('item') + ')');
                setDataDestinationUser(item);
              }



          }else if (el.attr('id') == 'exporter') //si viene de finalDestinationClient
          {
             if(el.find('option:selected').val()=='adduc'){
              }else{
                var item = eval('(' + el.find('option:selected').attr('item') + ')');
                setDataConsignationUser(item);
              }


          }else if(el.attr('id')=='type'){
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
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
/**
*
*/
var createLoad = function () {
  var text = translate();
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+text.wait+"</button>");
}
/**
*
*/
var preparePayment = function (pickup) {
  var url = window.location.origin + window.location.pathname + "/" + pickup + "/payment";
  bootbox.dialog({
    title: "<h2>Confirmacion de Pago</h2>",
    message: $('#load').load(url, function () {
    }),
    size: "medium",
    backdrop: true,
    onEscape: function() {

    },
  })
  .on('shown.bs.modal', function () {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e) {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
*
*/
function loadButton (element) {
  var text = translate();
  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+text.wait);
}
/**
* Metodo por el cual se habilida o deshabilita los elementos web de los clientes
*/
function disabledClients (op) {
  $('#name,#phone,#email,#identifier,#direction').attr('disabled', op === 'true');
}
/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del paquete
*/
function showPackages (op) {
  $('#packageTitle,#width,#height,#weight,#value,#type,#invoice,#categoryDiv,#taxdiv').attr('style', 'display:'+op );
}
/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del destino
*/
function showDestination (op) {
  $('#destinationTitle,#destinationName,#destinationPhone,#destinationEmail,#destinationIdentifier,#destinationSelect,#destinationDirection').attr('style', 'display:'+op );

  $('#destin_name,#destin_phone,#destin_email,#destin_identifier,#destin_direction').attr('required', op === 'block');
}

/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del cliente
*/
function showClients(op, disabled) {
  $('#clientTitle,#clientName,#clientPhone,#clientEmail,#clientIdentifier, #clientDirection').attr('style', 'display:'+op );
  $('#name,#phone,#email,#identifier,#direction').attr('required', op == 'block');
  disabledClients(disabled);
  showPackages(op);
  showDestination(op);
}
/**
* Metodo que controla cual select (client o users) se debe mostrar
*/
function showSelects(selectObj) {
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
function setDataUsertoring(clientData) {
  if (clientData) {
    document.getElementById('name').value=clientData.code+" "+clientData.name+" "+clientData.last_name;
    document.getElementById('phone').value=clientData.local_phone;
    document.getElementById('email').value=clientData.email;
    document.getElementById('direction').value=clientData.address;
    document.getElementById('zipcode').value=clientData.postal_code;
    document.getElementById('country').value=clientData.country;
    document.getElementById('region').value=clientData.region;
  }
  else {
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
function setDataDestinationUser(destinationData) {
  if (destinationData) {
    document.getElementById('destin_direction').value=destinationData.address;
    document.getElementById('destin_country').value=destinationData.country;
    document.getElementById('destin_region').value=destinationData.region;
    document.getElementById('destin_city').value=destinationData.city;
    document.getElementById('destin_phone').value=destinationData.local_phone;
  }
  else {
    document.getElementById('destin_direction').value="";
    document.getElementById('destin_country').value="";
    document.getElementById('destin_region').value="";
    document.getElementById('destin_city').value="";
    document.getElementById('destin_phone').value="";
  }

}

function setDataConsignationUser(destinationData) {
  if (destinationData) {
    document.getElementById('cons_direction').value=destinationData.address;
    document.getElementById('cons_country').value=destinationData.country;
    document.getElementById('cons_region').value=destinationData.region;
    document.getElementById('cons_city').value=destinationData.city;
    document.getElementById('cons_phone').value=destinationData.local_phone;
  }
  else {
    document.getElementById('cons_direction').value="";
    document.getElementById('cons_country').value="";
    document.getElementById('cons_region').value="";
    document.getElementById('cons_city').value="";
    document.getElementById('cons_phone').value="";
  }
}
/**
* add cargo on booking
*/
var addpackage = function () {
  var text = translate();
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
         " <label class='col-lg-2 control-label' id='typeLabel' >"+text.description+"</label>"+"\n"+
         " <div class='col-lg-10'>"+"\n"+
           " <input type='text' class='form-control' placeholder='"+text.description+"' id='description"+aux+"' name='description"+aux+"' min='1' required='true' value='' >"+"\n"+
           " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
        "  </div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >"+text.pieces+"</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='"+text.pieces+"' id='pieces"+aux+"' name='pieces"+aux+"' maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

        "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
          "<label class='col-lg-2 control-label' id='typeLabel' >"+text.value+"</label>"+"\n"+
          "<div class='col-lg-10'>"+"\n"+
            "<input type='number' class='form-control' placeholder='"+text.value+"' id='valued"+aux+"' name='valued"+aux+"'  maxlength='10' min='1' required='true' value=''>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
        "</div>"+"\n"+

    "</div>"+"\n"+
     "<div class='col-md-4'>"+"\n"+
      "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >"+text.large+"</label>"+"\n"+
       " <div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='"+text.large+"' id='large"+aux+"' name='large"+aux+"' onkeyup='icsGetpesovol()' type='float' maxlength='10' min='1' required='true' value=''>"+"\n"+
          "<span>in</span>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
         "</div>"+"\n"+
      "</div>"+"\n"+
      "<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>"+"\n"+
        "<label class='col-lg-3 control-label' id='typeLabel' >"+text.width+"</label>"+"\n"+
        "<div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='"+text.width+"' id='width"+aux+"' name='width"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >"+"\n"+
       "<span>in</span>"+"\n"+
       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
      "</div>"+"\n"+
      " <div class='dimensmedidas' id='divheight'>"+"\n"+
      "<label class='col-lg-3 control-label' id='typeLabel' >"+text.height+"</label>"+"\n"+
        "<div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='"+text.height+"' id='height"+aux+"' onkeyup='pesovol()' name='height"+aux+"' type='float' maxlength='10' min='1' required='true' value=''>"+"\n"+
          "<span>in</span>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
         "</div>"+"\n"+
      "</div>"+"\n"+
      "<div class='dimensmedidas' id='divheight'>"+"\n"+
      "<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>"+"\n"+
       " <div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+aux+"' onkeyup='pesovol()' name='volumetricweightm"+aux+"' type='float' readonly='' maxlength='10' min='1' required='true' value='' >"+"\n"+
            "<span>ft<sup>3</sup></span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
      "</div>"+"\n"+
      "<div class='dimensmedidas' id='divheight'>"+"\n"+
      "<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>"+"\n"+
       " <div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+aux+"' onkeyup='pesovol()' name='volumetricweighta"+aux+"' type='float' readonly='' maxlength='10' min='1' required='true' value='' >"+"\n"+
            "<span>Vlb</span>"+"\n"+
            " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
           "</div>"+"\n"+
     "</div>"+"\n"+
     " <div class='dimensmedidas' id='divheight'>"+"\n"+
     " <label class='col-lg-3 control-label' id='typeLabel' >"+text.weight+"</label>"+"\n"+
        "<div class='col-lg-9'>"+"\n"+
          "<input type='number' class='form-control form_dimension' placeholder='"+text.weight+"' id='weight"+aux+"' onkeyup='pesovol()' name='weight"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >"+"\n"+
          "<span>lb</span>"+"\n"+
          " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
          "</div>"+"\n"+
      "</div>"+"\n"+
     "</div>"+"\n"+
     " </div>");
     $('select').select2();
}
/**
*
*/
var AddNumberParts = function (value) {
  var url = window.location.origin + window.location.pathname + '/numberparts';
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {
    },
    success: function (json) {
      LoadDinamicSelectNumberParts(json.message, value);
    },
    error: function (e) {
      log(e);
    }
  });
}
/**
* getData for option select
*/
var AddType = function (value) {
  var url = window.location.origin + window.location.pathname + "/type";
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {
    },
    success: function (json) {
      console.log(json.message);
      LoadDinamicSelectType(json.message, value);
    },
    error: function (e) {
      log(e);
    }
  });

}
/**
*
*/
var LoadDinamicSelectType = function (json, value) {
  $.each(json, function(i, item) {
    $('#typepickup' + value).append('<option value ="'+json[i].id+'">' + json[i].name  + '</option>');
  });
}
/**
*
*/
var LoadDinamicSelectNumberParts = function (json, value) {
  var text = translate();
  $('#numberparts' + value).append('<option item ="" value ="0">'+text.chooseOption+'</option>');
  $.each(json, function(i, item) {
    var obj = JSON.stringify(json[i]).replace("\n", "&nbsp;");
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
/**
*
*/
function taxcalculation () {
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
function calcinsurence () {
  var porcent =$("#insurance").val()/100;
  var valor   =$("#value").val();
  var totalinsure=porcent*valor;
  $("#toinsurance").val((totalinsure).toString()+"$");
  taxcalculation();
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
/**
*
*/
function deletepickup(string,cont){
  $("#pick"+cont).remove();
  $("#lipick"+cont).remove();
  aux=aux-1;
  //$('#countpack').val(aux);
  resultvalue();
}
/**
*Calculo del Peso volumetri
*/
function pesovol(){
  for (step = 1; step <= aux; step++) {
   var larg=$("#pick"+step+" "+"#large"+step).val();
   var anch=$("#pick"+step+" "+"#width"+step).val();
   var alto=$("#pick"+step+" "+"#height"+step).val();
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;
   $("#pick"+step+" "+"#volumetricweightm"+step).val((resultm.toFixed(2)).toString());
   $("#pick"+step+" "+"#volumetricweighta"+step).val((resulta.toFixed(2)).toString());
   console.log('calculando large: '+ larg+' anch:'+ anch+' alto:'+ alto+' mar:'+resultm+' aer:'+resulta+"\n");
  }

}
/**
*Calculo de valor total de los paquetes
*/
function resultvalue () {
 var sum = 0;
 for (step = 1; step <= aux; step++) {
   var value=$("#pick"+step+" "+"#valued"+step).val();
   sum =sum+parseFloat(value);
  }
  $("#value").val(sum);
}
/**
*
*/
var detailspickup = function (id, open) {
  var path  = window.location.origin + window.location.pathname;
  var sw    = 0;
  var alert = false;
  var text  = translate();
  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) {
    bootbox.dialog({
      title: "<span id='tltgnif'>"+text.info+"</span>",
      message: $('#load').load(path + "/" + id, function () {
      }),
      size: "large",
      backdrop: true,
      onEscape: function() { },
    })
    .on('shown.bs.modal', function () {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e) {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
  }
  else  {
    if ($('#pnlin').hasClass( "showpack" )) {
      if (open == 'true') {
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
        bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.info+"</span>",
          message: $('#load').load(path + "/" + id + "/view", function () {
            $('#event').select2();
          }),
          size:"large",
          backdrop: true,
          onEscape: function() { },
        })
        .on('shown.bs.modal', function () {
          $('#load').show();
        })
        .on('hide.bs.modal', function (e) {
          $('#load').hide().appendTo('body');
        })
        .modal('show');
      }
      else {
        $('#load').load(path + "/" + id + "/view", function() {
            $('#event').select2();
        });
      }
    }
    else {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
      bootbox.dialog({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='"+text.back+"' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.info+"</span>",
        message: $('#load').load(path + "/" + id + "/read", function () {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="Editar"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="Nuevo Cliente"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" )) {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>Clientes</h4></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> "+text.loading+"</p></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function () {
              $('#dtble').DataTable();
            });
          }
        }),
        size: "large",
        backdrop: true,
        onEscape: function() { },
      })
      .on('shown.bs.modal', function () {
        $('#load').show();
      })
      .on('hide.bs.modal', function (e) {
        $('#load').hide().appendTo('body');
      })
      .modal('show');
    }
  }
}
/**
*
*/
function valselect(id) {
  var data=JSON.parse($('#numberparts'+id).find('option:selected').attr('item'));
  document.getElementById('pieces'+id).value=data.pieces;
  document.getElementById('large'+id).value=data.large.toFixed();
  document.getElementById('width'+id).value=data.width.toFixed();
  document.getElementById('height'+id).value=data.height.toFixed();
  document.getElementById('volumetricweightm'+id).value=data.volumetricweightm.toFixed();
  document.getElementById('volumetricweighta'+id).value=data.volumetricweighta.toFixed();
  document.getElementById('weight'+id).value=data.weight.toFixed();
}
/**
* load tabs data
*/
var icsLoadTabsAndData = function () {
  var url = window.location.origin + window.location.pathname + "/details";
  var text = translate();

  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {

    },
    success: function (json) {
      (json.message) ? icsSetTabsData(json.alert) : bootbox.alert(text.serverError) ;
    },
    error: function (e) {
      bootbox.alert(text.serverError + e.description);
    }
  });
}
/**
* Set Tabs and data
*/
var icsSetTabsData = function (json) {
    $.each(json, function(i, item) {
    if ( i > 0 ) {
      $('#listpack').append("<li id='ics_li_cargo"+(i+1)+"' class='paq'><a data-toggle='tab' href='#pick"+(i+1)+"'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> PKO"+(i+1)+"<span  onclick='icsDelCargoOnBooking("+(i+1)+")' id='ics_del_cargo_on_booking"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      /**
      *
      */
      $('#contentpack').append("<div class='row tab-pane fade' id='pick"+(i+1)+"' style='padding:20px'>"+"\n"+
        "<div class='col-md-8'>"+"\n"+
         " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
             " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
             " <div class='col-lg-10'>"+"\n"+
               " <input type='text' class='form-control' placeholder='Descripcion' id='description"+(i+1)+"' name='description"+(i+1)+"' min='1' required='true' value='"+json[i].description+"'>"+"\n"+
               " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
            "  </div>"+"\n"+

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

        "</div>"+"\n"+
         "<div class='col-md-4'>"+"\n"+
          "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
            "<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>"+"\n"+
           " <div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+(i+1)+"' name='large"+(i+1)+"' onkeyup='pesovol()' type='float' maxlength='10' min='1' required='true' value='"+json[i].large+"'>"+"\n"+
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
              "<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+(i+1)+"' onkeyup='pesovol()' name='height"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+json[i].height+"'>"+"\n"+
              "<span>in</span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
             "</div>"+"\n"+
          "</div>"+"\n"+
          "<div class='dimensmedidas' id='divheight'>"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>"+"\n"+
           " <div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+(i+1)+"' onkeyup='pesovol()' name='volumetricweightm"+(i+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+json[i].volumetricweightm+"' >"+"\n"+
                "<span>ft<sup>3</sup></span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
          "</div>"+"\n"+
          "<div class='dimensmedidas' id='divheight'>"+"\n"+
          "<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>"+"\n"+
           " <div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+(i+1)+"' onkeyup='pesovol()' name='volumetricweighta"+(i+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+json[i].volumetricweighta+"' >"+"\n"+
                "<span>Vlb</span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
         "</div>"+"\n"+
         " <div class='dimensmedidas' id='divheight'>"+"\n"+
         " <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>"+"\n"+
            "<div class='col-lg-9'>"+"\n"+
              "<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+(i+1)+"' onkeyup='pesovol()' name='weight"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+json[i].weight+"' >"+"\n"+
              "<span>lb</span>"+"\n"+
              " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
          "</div>"+"\n"+
         "</div>"+"\n"+
         " </div>");
         $('#countpack').val((i+1));

    } else {
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

var countimg = 0;
function preview_image () {
  var text = translate();
  var res=countimg+1;
  var total_file=document.getElementById("upload_file").files.length;
  for(var i = 0; i < total_file; i++) {
    $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>"+text.delete+"</a>");
  }
}
/**
*
*/
function remove_preview(id){
  $('#'+id).remove();
}
/**
*
*/
var selectservicio = function (id) {
    var m,a;
    var text = translate();
    $('#subtotal').val('');
    var url = window.location.origin + window.location.pathname + "/" + id + "/service/json";
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
      },
      success: function (json) {
        $('#typeservice').empty();
        $('#typeservice').append("<option value=''>" +text.chooseOption+ "</option>");
        $.each(json.service, function(key, element) {
        var item="{'id':'"+element.id+"','code':'"+element.code+"','price':'"+element.value+"','name':'"+element.name+"'}";
        $('#typeservice').append("<option item="+JSON.stringify(item)+" cost='"+parseInt(element.value)+"' value='" + element.id + "'>" +" "+ element.name + " "+ parseInt(element.value)+"($) </option>");
        });
      }
    });
}
/**
*
*/
var calcost = function (){
    var vol=0,result;
    var addcharge,resinsu=0;
    var transport=parseInt($('#typeservice option:selected').attr('cost'));

    if($('#type option:selected').val()==1 || $('#type').val()==3){
        var auxm=0;

        for (var x=1;x<=$('#countpack').val();x++) {
            auxm=parseFloat(auxm) + parseFloat($('#volumetricweightm'+x).val())
        }

        vol=auxm;

    }else if($('#type').val()==2){
        var auxa=0;
        for (x=1;x<=$('#countpack').val();x++) {
              auxa=parseFloat(auxa) + parseFloat($('#volumetricweighta'+x).val())
        }

        vol=auxa;

    }

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
  var subtax=$('#subtotal').val()/100;
  var taxvalue= $("#taxval").val();
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
