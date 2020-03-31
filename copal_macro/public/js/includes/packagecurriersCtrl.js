/**
 *
 */

 $(document).ready( function() {

   $('#dtble').DataTable({
     "order": [
       [ 1, "desc" ]
     ]
   });

        $('#category').change(function() {
         //  selecttaxcategory($('#category').val());
        });

        $('#type').change(function(){
          //taxcalculation();
          //selectservicio();
        });

        $('#addcharge').change(function(){
        //  taxcalculation();
          calctax();
          calcost();
        });

        $('#promotion').change(function(){
          //taxcalculation();
          calctax();
        });
        $('#service').change(function(){
            var auxm=0;
            for (x=1;x<=$('#countpack').val();x++) {
                auxm=parseFloat(auxm) + parseFloat($('#volumetricweightm'+x).val())
            }

          var auxm=0;
          for (x=1;x<=$('#countpack').val();x++) {
                auxm=parseFloat(auxm) + parseFloat($('#volumetricweightm'+x).val())
          }
          //taxcalculation();
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
          else if (el.attr('id') == 'currier')//si viene del clientSelect
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
              //selectdetailstransport(item.id);

              if(item.id=='1'){
                  var auxm=0;
                  for (x=1;x<=$('#countpack').val();x++) {
                      auxm=parseFloat(auxm) + parseFloat($('#volumetricweightm'+x).val())
                  }

                  $("#volre").val(auxm.toFixed(2)+" ft3");

              }else if(item.id=='2'){
                  var auxa=0;
                  for (x=1;x<=$('#countpack').val();x++) {
                        auxa=parseFloat(auxa) + parseFloat($('#volumetricweighta'+x).val())
                  }
                  $("#volre").val(auxa.toFixed(2)+" Vlb");


              }else{

              }
              selectservicio(item.id);
          }

          else if(el.attr('id')=='typeservice'){
            var item = eval('(' + el.find('option:selected').attr('item') + ')');
            console.log(item.id);

          }
        });

 });

   $('#time').datetimepicker({
          format: 'HH:mm:ss'
        });

/**
 *
 */
 var createLoad = function (element)
 {
   $(element).html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
 }
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
  * Ajax method for select servicio
  */
  var selectservicio = function (id) {
  var m,a;
    /*if(id==1){
      $("#volre").val($("#volumetricweightm").val()+" ft3");
    }else if(id==2){
      $("#volre").val($("#volumetricweighta").val()+" Vlb");
    }*/


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
  /**
   *
   */
  function loadButton(element) {
    $(element).attr('disabled','true');
    $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
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
    document.getElementById('destin_name').value=destinationData.name;
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
      log("val: "+ val + "valpromo: " + valpromo + "sum : "+ sum);
    var calt=calc.toFixed(2);
    $('#'+taxid).val(calt+"$");
    })
    resultcat=val*taxcat;
    console.log(resultcat);
    result=(sum+transport+service+addcharge+toinu).toFixed(2);
    console.log(result);
    resultsub=(transport+service+addcharge+toinu).toFixed(2);
    console.log(resultsub);
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

var detailspackage = function (id, open)
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
      {               $('#load').addClass('cl');
          bootbox.dialog({
            title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>Información</span>",
            message: $('#load').load(path+"/showpackage/"+id,function(){

            }),
            size:"large",
            backdrop: true,
            onEscape: function() { },
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
      else
      {
        $('#load').load(path+"/showpackage/"+id,function(){});
      }

    }
    else
    {
      bootbox.dialog({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='atrás' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>Información</span>",
        message: $('#load').load(path + "/" + id + "/read", function ()
        {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="Editar"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="Nuevo Cliente"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" ))
          {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>Clientes</h4></div><div id='cl' ><div class='progress'><div class='progress-bar progress-bar-striped active' role = 'progressbar' style = 'width:100%;'></div></div></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function ()
            {
              $('#dtble').DataTable({
                "order": [
                  [ 0, "desc" ]
                ]
              });
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
* Ajax method for create and update package
*/
var createPackage = function ()
{
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
/**
* Ajax method for change status package (VS)
*/
var changestatuspackage = function (id)
{
  var url      = `${window.location.origin}${window.location.pathname}`+"/showpackage/"+id;
  console.log(url+id);
  var dataString = {"event":$('#event').val()};
  $.ajax(
        {
          url: url,
          type: 'POST',
          dataType: 'json',
          data: dataString,
          beforeSend: function ()
{            $('#cl').html("<div class='progress'><div class='progress-bar progress-bar-striped active' role = 'progressbar' style = 'width:100%;'></div></div>");
          },
          success: function (json) {
            ((json.message == 'true') ? detailspackage(id,'false'): evalJson (json.alert))
          }
        });
}

/**
* Ajax method for select client in company (VS)
*/
var selectclient = function (id)
{
  var url      = `${window.location.origin}${window.location.pathname}`+"/"+id+"/clients/json";



    $.ajax(
        {
          url: url,
          type: 'GET',
          dataType: 'json',
          beforeSend: function ()
          {
          },
          success: function (json) {

            $('#clientSelect').empty();

            $('#clientSelect').append("<option value='0'>" +'Seleccione Cliente'+ "</option>");
              $.each(json.clients, function(key, element) {
                //console.log(element.name);
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

          }
        });
}


function selectdetailstransport (id)
{

  var url = `${window.location.origin}${window.location.pathname}`+"/"+id+"/transport/json";

    $.ajax(
        {
          url: url,
          type: 'GET',
          dataType: 'json',
          beforeSend: function ()
          {
          },
          success: function (json) {
            console.log(JSON.stringify(json));
            $('#dettype').empty();

            $('#dettype').append("<option value='0'>" +'Puerto o Aeropuertos'+ "</option>");

              $.each(json.detailsport, function(key, element) {
                console.log(element);
                var email,direction
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


                  var item="{'name':'"+element.name+"','code':'"+element.id+"','phone':'"+element.description+"','direction':'"+direction+"','identifier':'"+element.identifier+"','email':'"+email+"'}";
                  $('#dettype').append("<option item="+JSON.stringify(item)+" value='" + element.id + "'>" + element.name +" "+ element.description+ "</option>");


              });

          }
        });
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

             //taxcalculation();


          }
        });
}

/*
** Funcion que se encarga del calculo del costo del seguro
*/
/*function calcinsurence(){
  var porcent =$("#insurance").val()/100;
  var valor   =$("#value").val();
  var totalinsure=porcent*valor;
  $("#toinsurance").val((totalinsure).toString()+"$");
  //taxcalculation();
  console.log(totalinsure);
}*/



var detailsreceipt = function (id)
{
      var path      = `${window.location.origin}${window.location.pathname}`+"/"+id+"/receipt";
      var sw    = 0;
      var alert = false;
      console.log(path);
       bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>Recibo</span>",
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
var aux=1;
function addpackage(){
  aux=aux+1;
  $('#countpack').val(aux);
  $('#listpack').append("<li id='lipaquete"+aux+"' class='paq'> <a data-toggle='tab' href='#paquete"+aux+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> PK "+aux+"<span  onclick='deletepackage(depackage"+aux+","+aux+")' id='depackage"+aux+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
  $('#contentpack').append("<div class='row tab-pane fade' id='paquete"+aux+"' style='padding:20px'>"+"\n"+
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
              "<label class='col-lg-2 control-label' id='typeLabel'>Valor</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Valor ($)' id='valued"+aux+"' name='valued"+aux+"' onkeyup='resultvalue()' type='int' maxlength='10' min='1' required='true' value='' >"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
           " </div>"+"\n"+

           " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel'>Orden de Servcio</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<div class='input-group'>"+"\n"+
                  " <input type='text' class='form-control' placeholder='Orden de servicio' id='serviceOrder"+aux+"' name='serviceOrder"+aux+"' type='text' maxlenght='25' min='10' required='true' value='' >"+"\n"+
                  "<span class = 'input-group-addon'>"+"\n"+
                    "<a href='javascript:setCurrier(aux)' class='text-muted' data-toggle='tooltip' title='Consultar Prealerta'>"+"\n"+
                             "<i aria-hidden='true' class='fa fa-search'></i>"+"\n"+
                    "</a>"+"\n"+
                  "</span>"+"\n"+
                "</div>"+"\n"+

              "</div>"+"\n"+
           "  </div>"+"\n"+

          " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
               " <label class='col-lg-2 control-label' id='typeLabel' >Currier</label>"+"\n"+
               " <div class='col-lg-10'>"+"\n"+
                 " <!-- <input type='text' class='form-control' placeholder='Currier' id='currier"+aux+"' name='currier"+aux+"' type='text' onkeyup='setCurrier(aux)' maxlength='25' min='10' required='true' value='' > -->"+"\n"+
                 "<select class='form-control' id='currier"+aux+"' style='text-trasform: uppercase;' name='currier"+aux+"' maxlength='10' min='1' required='true' value='' >"+"\n"+
                 " <select/>"+"\n"+
                 "</div>"+"\n"+
          "  </div>"+"\n"+

          "</div>"+"\n"+
           "<div class='col-md-4'>"+"\n"+
            "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
              "<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>"+"\n"+
             " <div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+aux+"' name='large"+aux+"' onkeyup='pesovol()' type='float' maxlength='10' min='1' required='true' value=''>"+"\n"+
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
                "<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+aux+"' onkeyup='pesovol()' name='height"+aux+"' type='float' maxlength='10' min='1' required='true' value=''>"+"\n"+
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
           " <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>"+"\n"+
              "<div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+aux+"' onkeyup='pesovol()' name='weight"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >"+"\n"+
                "<span>lb</span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                "</div>"+"\n"+
            "</div>"+"\n"+
           "</div>"+"\n"+
           " </div>");

           AddCurrier(aux);
           $('#currier'+aux).select2();

}


var AddCurrier = function (value)
{
  var url = window.location.origin + window.location.pathname + '/courier' ;
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function ()
    {
    },
    success: function (json)
    {
      LoadDinamicSelectType(json.message, aux);
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
    $('#currier' + aux).append('<option value ="'+json[i].id+'">' + json[i].name  + '</option>');
  });
}


//Elimina las pestañas de los paquetes
function deletepackage(string,cont){
  var paq,auxco,contr;
  if(($("#paquete"+cont).hasClass('active'))){
    auxco=true;
  }else{
    auxco=false;
  }

  $("#paquete"+cont).remove();
  $("#lipaquete"+cont).remove();

  paq=$(".paq").size();
  if(cont===aux){
    aux=aux-1;
    $("#paquete"+aux).addClass("active in");
    $("#lipaquete"+aux).addClass("active");

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
    $("#paquete"+contr).addClass("active in");
    $("#lipaquete"+contr).addClass("active");
  }

  $('#countpack').val(aux);
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
   sum =sum+parseFloat(value);
  }

  $("#value").val(sum);
}

function setCurrier(i){
        var url = window.location.origin + window.location.pathname + '/service' ;
        var order = $("#serviceOrder"+i).val();
        if(i==1){
          order = $("#serviceOrder").val();
        }

        console.log('i: '+i);

        console.log('orden: '+order);

        $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',
          data: {'order': order},
          beforeSend: function (json) {
            if((i) == 1){
              $('#currier').val("No se encuentra Registrado");
            }
              $('#currier'+i).val("No se enecuetra registrado");
          },
          success: function (json) {
            var courier = 1;
            if((json.data[0])){
              courier = json.data[0].courier;
            }
            console.log('courier: '+courier);

            if((i) == 1){
              $('#currier').val(courier).change();
            }
              $('#currier'+i).val(courier).change();
          },
          error: function (e) {
          //  bootbox.alert('Error al Cargar TabsData ' + e.description);
          //$('#currier'+i).val(courier).change();
          }
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
      $('#listpack').append("<li id='lipaquete"+aux+"' class='paq'> <a data-toggle='tab' href='#paquete"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> PK "+(i+1)+"<span  onclick='deletepackage(depackage"+(i+1)+","+(i+1)+")' id='depackage"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpack').append("<div class='row tab-pane fade' id='paquete"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-8'>"+"\n"+
           " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
               " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
               " <div class='col-lg-10'>"+"\n"+
                 " <input type='text' class='form-control' placeholder='Descripcion' id='description"+(i+1)+"' name='description"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
                 " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
              "  </div>"+"\n"+

              "<div class='dimensmedidas'  id='divlarge'>"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Piezas' id='pieces"+(i+1)+"' name='pieces"+(i+1)+"' type='int' maxlength='10' min='1' required='true' value='"+ parseFloat(json[i].pieces) +"'>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
            "</div>"+"\n"+

            "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
              "<label class='col-lg-2 control-label' id='typeLabel'>Valor</label>"+"\n"+
              "<div class='col-lg-10'>"+"\n"+
                "<input type='number' class='form-control' placeholder='Valor ($)' id='valued"+(i+1)+"' name='valued"+(i+1)+"' onkeyup='resultvalue()' type='int' maxlength='10' min='1' required='true' value='"+ parseFloat(json[i].value) +"' >"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
              "</div>"+"\n"+
           " </div>"+"\n"+
          "</div>"+"\n"+
           "<div class='col-md-4'>"+"\n"+
            "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
              "<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>"+"\n"+
             " <div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+(i+1)+"' name='large"+(i+1)+"' onkeyup='pesovol()' type='float' maxlength='10' min='1' required='true' value='"+ json[i].large +"'>"+"\n"+
                "<span>in</span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
            "</div>"+"\n"+
            "<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>"+"\n"+
              "<label class='col-lg-3 control-label' id='typeLabel' >Ancho</label>"+"\n"+
              "<div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Ancho' id='width"+(i+1)+"' name='width"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+ json[i].width +"' >"+"\n"+
             "<span>in</span>"+"\n"+
             " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
            "</div>"+"\n"+
            " <div class='dimensmedidas' id='divheight'>"+"\n"+
            "<label class='col-lg-3 control-label' id='typeLabel' >Alto</label>"+"\n"+
              "<div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+(i+1)+"' onkeyup='pesovol()' name='height"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+ json[i].height +"'>"+"\n"+
                "<span>in</span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
               "</div>"+"\n"+
            "</div>"+"\n"+
            "<div class='dimensmedidas' id='divheight'>"+"\n"+
            "<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>"+"\n"+
             " <div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+(i+1)+"' onkeyup='pesovol()' name='volumetricweightm"+(i+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+ json[i].volumetricweightm +"' >"+"\n"+
                  "<span>ft<sup>3</sup></span>"+"\n"+
                  " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
            "</div>"+"\n"+
            "<div class='dimensmedidas' id='divheight'>"+"\n"+
            "<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>"+"\n"+
             " <div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+(i+1)+"' onkeyup='pesovol()' name='volumetricweighta"+(i+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+ json[i].volumetricweighta +"' >"+"\n"+
                  "<span>Vlb</span>"+"\n"+
                  " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
           "</div>"+"\n"+
           " <div class='dimensmedidas' id='divheight'>"+"\n"+
           " <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>"+"\n"+
              "<div class='col-lg-9'>"+"\n"+
                "<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+(i+1)+"' onkeyup='pesovol()' name='weight"+(i+1)+"' type='float' maxlength='10' min='1' required='true' value='"+ json[i].weight +"' >"+"\n"+
                "<span>lb</span>"+"\n"+
                " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                "</div>"+"\n"+
            "</div>"+"\n"+
           "</div>"+"\n"+
           " </div>");
        $('#countpack').val((i+1));
      }else{
      $('#description1').val(json[i].description);
      $('#pieces1').val(json[i].pieces);
      $('#large1').val(parseFloat(json[i].large));
      $('#width1').val(parseFloat(json[i].width));
      $('#height1').val(parseFloat(json[i].height));
      $('#valued1').val(parseFloat(json[i].value));
      $('#serviceOrder').val(json[i].order_service);
      $('#currier').val(parseInt(json[i].courier)).change();
      $('#volumetricweightm1').val(parseFloat(json[i].volumetricweightm));
      $('#volumetricweighta1').val(parseFloat(json[i].volumetricweighta));
      $('#weight1').val(parseFloat(json[i].weight));
      }
      aux = parseInt($('#countpack').val());

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
  console.log
  $('#'+id).remove();
}


var calcost = function (){

    var transport=parseInt($('#typeservice option:selected').attr('cost'));


    var vol=0,result;

    if($('#type').val()==1){
      console.log('maritimocost');
        var auxm=0;
        for (x=1;x<=$('#countpack').val();x++) {
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

   var addcharge,resinsu=0;
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

  var aux=0;auxre=0;
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
    $('#costadd').val(addcharge+" $");
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
  console.log(val);
  var insu = $('#insurance').val()/100;
  console.log(insu);
  var res= val *insu ;
  console.log(res);
  $('#toinsurance').val(res.toFixed(2)+' $');
  calcost();
  calctax();


}
