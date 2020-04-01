/**
 *
 */
 $(document).ready( function() {
   if (messages.language == 'en') {
     $('#dtble4').DataTable({
       "language": {
         "sEmptyTable":     "No data available in table",
         "sInfo":           "Showing _START_ to _END_ of _TOTAL_ entries",
         "sInfoEmpty":      "Showing 0 to 0 of 0 entries",
         "sInfoFiltered":   "(filtered from _MAX_ total entries)",
         "sInfoPostFix":    "",
         "sInfoThousands":  ",",
         "sLengthMenu":     "Show _MENU_ entries",
         "sLoadingRecords": "Loading...",
         "sProcessing":     "Processing...",
         "sZeroRecords":    "No matching records found",
         "oPaginate": {
           "sFirst":    "First",
           "sLast":     "Last",
           "sNext":     "Next",
           "sPrevious": "Previous"
         },
         "oAria": {
           "sSortAscending":  ": activate to sort column ascending",
           "sSortDescending": ": activate to sort column descending"
         }
        }
     });
     $('#dataTableSearch').attr('placeholder','Search');
   }else {
     $('#dtble4').DataTable({
       "order": [
         [ 0, "desc" ]
       ]
     });
   }
 });

 /**
  *
  */

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
        'delete' : 'Eliminar'

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
        'delete' : 'Delete'
      });
    }
  }
  /**
   * ****************************************************************************
   */
/**
* print label
*/
var icsPrint = function (id) {
  var url = `${window.location.origin}`+`/admin/package/`+ id +`/print`;
  console.log(url);
  var printWindow = window.open( url, 'Print', 'width=950, height=500, toolbar=0, resizable=0');
  printWindow.addEventListener('load', function(){
  printWindow.print();
  }, true);
}

/**
*
*/
function initSelect2() {
  showElements("1");

      $('select').select2(
        {

          width: '100%'
          //placeholder: "Select a client",
          //allowClear: true
        }).on('select2:select', function(e) //seleccionar cualquier opcion del select
        {
          var el = $(e.currentTarget);
          console.log(el.attr('id'))
          if (el.attr('id') == 'from') //si viene del from
          {
            showElements(el.val());
          }
          else if (el.attr('id') == 'clientSelect')//si viene del clientSelect
          {

              showClients('block','true');
              //para capturar el valor de lo que se esta seleccionando
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataClient(item);

          }
          else if (el.attr('id') == 'courierSelect')//si viene del clientSelect
          {

          }
          else if (el.attr('id') == 'finalDestinationClient') //si viene de finalDestinationClient
          {
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataDestination(item);
              disabledDestination('true');



          }else if (el.attr('id') == 'aduana') {
              //ADUANA
              if ($('#aduana').val()==0) {
                $('#aduana_name').toggle('true');
              }else
              if ($('#aduana').val()==1) {
                $('#aduana_name').css('display', 'none');
              }
          }
        });

        $('#category').change(function() {
            taxcalculation();
        });

        $('#type').change(function(){
          taxcalculation();
        });

        $('#promotion').change(function(){
          taxcalculation();
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

}

function createLoad (element)
{
  var text = translate();
  $(element).html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+text.wait+"</button>");
}
/**
 *
 */
function searchPackage()
{
  try
  {
    var search = $('#search').val().trim();
    if(search !== undefined && search !== '')
    {
      window.location = `${window.location.origin}${window.location.pathname}?search=${search}`;
    }
  }
  catch(e)
  {

  }
}

/**
 *
 */
function packageDelete(element, from)
{
  try
  {
    var package = getItem(element) || getItemFromParent(element);
    if(package != undefined)
    {
      bootbox.confirm(eval(msg(messages.delete)), function(result)
      {
        if(result)
        {
          doForm(`./admin/package/${package.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }
  catch (e)
  {
    log(e);
  }
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
function setDataClient(clientData)
{
  if (clientData)
  {
    document.getElementById('name').value=clientData.name;
    document.getElementById('phone').value=clientData.phone;
    document.getElementById('email').value=clientData.email;
    document.getElementById('identifier').value=clientData.identifier;
    document.getElementById('direction').value=clientData.direction;
  }
  else
  {
    document.getElementById('name').value="";
    document.getElementById('phone').value="";
    document.getElementById('email').value="";
    document.getElementById('identifier').value="";
    document.getElementById('direction').value="";
  }

}

/**
* Metodo por medio del cual se le asignan valores a los elementos web del destino
*/
function setDataDestination(destinationData)
{
  if (destinationData)
  {
    document.getElementById('destin_name').value=destinationData.name;
    document.getElementById('destin_phone').value=destinationData.phone;
    document.getElementById('destin_email').value=destinationData.email;
    document.getElementById('destin_identifier').value=destinationData.identifier;
    document.getElementById('destin_direction').value=destinationData.direction;
  }
  else
  {
    document.getElementById('destin_name').value="";
    document.getElementById('destin_phone').value="";
    document.getElementById('destin_email').value="";
    document.getElementById('destin_identifier').value="";
    document.getElementById('destin_direction').value="";
  }

}

/**
*Calculo del Peso volumetri
*/

function pesovol(){

   var larg=$("#large").val();
   var anch=$("#width").val();
   var alto=$("#height").val();
   var result=(larg*anch*alto)/166;

   $("#volumetricweight").val(Math.round(result).toString());
   //console.log(larg+anch+alto) ;
  //console.log(Math.round(result).toString());
}



function taxcalculation(){
  var val=$("#value").val()
  var valpromo=$("#promotionval").val()
  var sum=0,resultcat,result,aux=0;
  var transport=parseInt($('#type option:selected').attr('cost'));
  var promotion=parseInt($('#promotion option:selected').attr('reduction'));


  var taxcat=$('#category option:selected').attr('porcent')/100;
  $('#taxdiv input').each(function(){
    var taxvalue= $(this).attr('attr-mivalue')/100;
    var taxid= $(this).attr('id');
    var calc=taxvalue*val;
    sum= sum+calc;
    $('#'+taxid).val(calc+"$");
    })
    resultcat=val*taxcat;
    result=(resultcat+sum+transport).toFixed(1);
    if(promotion>0){
      aux=result*(promotion/100);
      $("#subtotal").val((result).toString()+"$");
      $("#promotionval").val(aux+"$");
      $("#total").val((result-aux).toString()+"$");

    }else{
      $("#subtotal").val(result.toString()+"$");
      $("#total").val(result.toString()+"$");
      $("#promotionval").val("0");
    }
}



var detailspackage = function (id, open)
{
  var text = translate();
  var path  =`${window.location.origin}${window.location.pathname}`;
  var sw    = 0;
  var alert = false;
  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) /** show in the modal details of package**/
  {
    bootbox.dialog
    ({
      title: "<span id='tltgnif'>"+text.info+"</span>",
      message: $('#load').load(path + "/" + id, function ()
      {
        /**
        * Esta operacion no esta funcionando
        */
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
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'.</p>');
        bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.info+"</span>",
          message: $('#load').load(path + "/showpackage/" + id, function () {
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
        $('#load').load(path+"/showpackage/"+id,function() {
          $('#event').select2();
        });
      }
    }
    else
    {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
      bootbox.dialog({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='"+text.back+"' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+text.info+"</span>",
        message: $('#load').load(path + "/" + id + "/read", function ()
        {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="'+text.edit+'"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="'+text.newClient+'"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" ))
          {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>Clientes</h4></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> Cargando...</p></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function ()
            {

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
var changestatuspackage = function (id)
{
  var url        = `${window.location.origin}${window.location.pathname}`+"/showpackage/"+id;
  var dataString = {"event":$('#event').val(),"observation":$('#observation').val()};
  var text = translate();
  $('#button').disabled = true;
  $.ajax(
      {
        url: url,
        type: 'POST',
        dataType: 'json',
        data: dataString,
        beforeSend: function ()
        {
          $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:25%"><span class="sr-only"></span>'+text.saving+'</div>');
          $('#cl').css('display','block');
          $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-circle-o-notch fa-spin"></i> '+text.wait+'.</button>');
          progressMiddle();
        },
        success: function (json)
        {
          ((json.message == 'true') ? detailspackage(id,'false'): evalJson (json.alert));
          progressComplete();
            timeout = setTimeout("hideCL()", 3000);
            clearTimeout(timeout);
        }
      });
}
function progressMiddle() {
  var text = translate();
  setTimeout(function () {
    $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%"><span class="sr-only"></span>E'+text.mailNotification+'</div>');
  }, 3000);
}

function loadButton(element) {
  var text = translate();
  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> '+ text.wait);
}

function progressComplete() {
  var text = translate();
  $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%"><span class="sr-only"></span>'+text.completed+'</div>');
  $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> '+text.completed+'</button>');
}
function hideCL() {
  var text = translate();
  $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> '+text.completed+'</button>');
  $('#cl').css('display','none');
}
/**
* Ajax method for select client in company
*/
var selectclient = function (id)
{
  var url = `${window.location.origin}${window.location.pathname}`+"/"+id+"/clients/json";
  var text = translate();

  $.ajax(
      {
      url: url,
      type: 'GET',
      dataType: 'json',
      beforeSend: function ()
      {
        $('#clientload').html('<i class="fa fa-spin fa-spinner"></i> '+text.loading);
      },
      success: function (json) {
        $('#clientSelect').empty();
        $('#clientSelect').append("<option value='0'>" +text.chooseClient+ "</option>");
          $.each(json.clients, function(key, element) {
            var email,direction;
            if (element.email!=""){
               email=element.email;
            }else{
              email="N/R";
            }
            if (element.direction!=""){
               direction=element.direction;
            }else{
              direction="N/R";
            }
              var item="{'name':'"+element.name+"','code':'"+element.code+"','phone':'"+element.phone+"','direction':'"+direction+"','identifier':'"+element.identifier+"','email':'"+email+"'}";
              $('#clientSelect').append("<option item="+JSON.stringify(item)+" value='" + element.id + "'>" + element.code +" "+ element.name +" "+ element.email+ "</option>");
          });
          $('#clientload').html('');
      }
    });
}


var detailsreceipt = function (id)
{
  var path  = `${window.location.origin}${window.location.pathname}`+"/"+id+"/receipt";
  var sw    = 0;
  var alert = false;
  var text = translate();

  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+text.loading+'</p>');
  bootbox.dialog({
    title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>"+text.receipt+"</span>",
    message: $('#load').load(path,function(){

    }),
    size:"large"
    }).on('shown.bs.modal', function ()
    {
          $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
    $('#load').hide().appendTo('body');
    })
    .modal('show');
}


/**
*
*/
var upload = function (id)
{
  var url = `${window.location.origin}${window.location.pathname}/` + id + `/upload`;
  var text = translate();

  bootbox.dialog ({
    title: "<span id=''>"+text.loadInvoice+"</span>",
    message: $('#load').load(url, function ()
    {
      $('select').select2();
    }),
    size: "medium",
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

var executeupload = function (id)
{


  var url = `${window.location.origin}${window.location.pathname}/` + id + `/upload`;
  var text = translate();

  $.ajax({
    url: url,
    type: 'POST',
    data: new FormData($("#upload_form")[0]),
    processData: false,
    contentType: false,
    beforeSend: function ()
    {
      $('#ics-checkpayd').html('<i class="fa fa-spin fa-spinner"></i>'+text.loading);
    },
    success: function (json)
    {
      if(json.message == 'true')
      {
        location.reload();

      }
      else
      {
        evalJson(json.alert) ;
        $('#ics-checkpayd').html('');
      }

    },
    error: function ()
    {

    }
  });
}

var billoflading = function (id)
{
  var url = `${window.location.origin}${window.location.pathname}/newbill/`+id;

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

var countimg=0;
function preview_image()
{
  var text = translate();
 var res=countimg+1;
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')>"+text.delete+"</a>");
 }
}

function remove_preview(id){
  $('#'+id).remove();
}
