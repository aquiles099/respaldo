/**
 *
 */

 $(document).ready( function() {

        $('#release_date').datepicker({
          dateFormat:    "yy-mm-dd",
        });

        $('#release_time').datetimepicker({
          format: 'HH:mm:ss'
        });
        $("#clientCountry").hide();
   $('select').select2(
        {
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
              showClients('block','true');
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataClient(item);

          }
          else if (el.attr('id') == 'cons_country')//si viene del clientSelect
          {

          }
          else if (el.attr('id') == 'finalOriginUser') //si viene de finalDestinationClient
          {

              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataUsertoring(item);


          }
          else if (el.attr('id') == 'clientSelectCountry ') //si viene de finalDestinationClient
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
                document.getElementById('clientCountry').style.display = 'none';
                document.getElementById('clientSelectCountry').style.display = 'none';

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
                console.log("aqui");
                $("#cons_name").removeAttr("readonly");
                $("#cons_lastname").removeAttr("readonly");
                $("#cons_dni").removeAttr("readonly");
                $("#cons_phone").removeAttr("readonly");
                $("#cons_cell").removeAttr("readonly");
                $("#cons_email").removeAttr("readonly");
                $("#cons_zipcode").removeAttr("readonly");
              //  $("#cons_country").removeAttr("readonly");
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
                //document.getElementById('clientCountry').style.display = 'none';
                //document.getElementById('clientSelectCountry').style.display = 'yes';
                $("#clientCountry").hide();
                $("#clientSelectCountry").show();
                document.getElementById('cons_zipcode').value="";
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
                var item = eval('(' + el.find('option:selected').attr('item') + ')');;
                setDataConsignationUser(item);
              }



          }else if(el.attr('id')=='type'){
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              //console.log('otro '+ item.id);
              selectdetailstransport(item.id);
          }
        });
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
        $('#dtble2').DataTable({
          "order": [
            [ 1, "desc" ]
          ]
        });
 });


/**
 *
 */
/*function searchPackage()
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
*/

var createLoad = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
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
        $("#ics_cargo_release_form").submit();
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
* set user info
*/
var setReleaseData = function (item) {
  if (item) {

    $('#contact_name').val(item.name + ' ' +item.last_name);
    $('#contact_phone').val(item.celular);
    $('#contact_country').val(item.id);
    $('#contact_region').val(item.region);
    $('#contact_city').val(item.city);
    $('#contact_address').val(item.address);
    $('#contact_postal_code').val(item.postal_code);
  }
  else {
    $('#contact_name').val('');
    $('#contact_phone').val('');
    $('#contact_country').val('');
    $('#contact_region').val('');
    $('#contact_city').val('');
    $('#contact_address').val('');
    $('#contact_postal_code').val('');
  }
}
/**
* delete cargo release
*/
var cargoReleaseDelete = function (element, from) {
  try {
    var cargoRelease = getItem(element) || getItemFromParent(element);
    var url = window.location.origin + window.location.pathname + "/" + cargoRelease.id;
    /**
    *
    */
    if(cargoRelease != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(url, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
* show details on modal
*/
var icsGetDetailCargoRelease = function (id) {
  var url = window.location.origin + window.location.pathname + "/" + id + "/view";

  bootbox.dialog({
    title:'<span>Informacion</span>',
    message: $('#load').load(url, function () {
      $('#icscargoReleaseStatus').select2();
    }),
    size:'large',
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
/**
* show info contact on modal
*/
var icsShowCargoContaInfo = function (id) {
    var url = window.location.origin + window.location.pathname + "/" + id + "/contact";

    bootbox.dialog({
      title:'<span>Informacion de Contacto</span>',
      message: $('#load').load(url, function () {
      }),
      size:'medium',
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
/**
* change status to cargo release
*/
var icsChangeStatusCargoRelease = function (id) {
  var status       = $('#icscargoReleaseStatus').val();
  var observation  = $('#observation').val();
  var url          = window.location.origin + window.location.pathname + "/" + id + "/view";
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
          $('#icscargoReleaseStatus').select2();
        });
      }
    },
    error: function (e) {
      bootbox.alert('Error: ' + e.message );
    }
  });
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
  $('#'+id).remove();
}

/**
 *
 */
/*function packageDelete(element, from)
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
*/

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
    document.getElementById('destin_name').value=destinationData.code+" "+destinationData.name;
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
    //document.getElementById('clientSelectCountry').style.display = 'none';
    document.getElementById('cons_name').value=destinationData.code+" "+destinationData.name+" "+destinationData.last_name;
    document.getElementById('cons_lastname').value=destinationData.last_name;
    document.getElementById('cons_dni').value=destinationData.dni;
    document.getElementById('cons_phone').value=destinationData.local_phone;
    document.getElementById('cons_cell').value=destinationData.cell;
    document.getElementById('cons_email').value=destinationData.email;
    document.getElementById('cons_direction').value=destinationData.address;
    document.getElementById('cons_zipcode').value=destinationData.postal_code;
    //document.getElementById('clientCountry').style.display = 'yes';
    $("#clientSelectCountry").hide();
    $("#clientCountry").show();
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
