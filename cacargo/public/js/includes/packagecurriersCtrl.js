/**
 *
 */

 $(document).ready( function() {

   $('#dtble2').DataTable({
      "order": [[ 3, "desc" ]]
   });

   if (messages.language == 'en') {
     $('#dataTableSearch').attr('placeholder','Search...');
     $('#dtble2_next').html('Next');
     $('#dtble2_previous').html('Previous');
     $('.dataTables_empty').html('No data to show...');
   }

        $('#category').change(function() {

        });

        $('#type').change(function(){
          selectservicio($('#type').val());
        });

        $('#addcharge').change(function(){
          //$('#costadd').val(parseFloat($('#addcharge option:selected').attr('cost'))+" $");
          calctax();
          calcost();
        });

        $('#typeservice').change(function(){
          $('#costservice').val(parseFloat($('#typeservice option:selected').attr('cost'))+" $");
          calcost();
          calctax();

        });

        $('#promotion').change(function(){
          calctax();
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


   $('select').select2( {
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
              //console.log($("#clientSelect").val())
              showClients('block','true');
              //para capturar el valor de lo que se esta seleccionando
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataClient(item);

          }
          else if (el.attr('id') == 'courierSelect')//si viene del clientSelect
          {

          }
          else if (el.attr('id') == 'finalDestinationUser') //si viene de finalDestinationClient
          {
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataDestination(item);
              showClients('block','true');
          }
        });
 });
 /**
 *
 */

 var createLoad = function ()
 {
   var text = translate();
   $('#divButton').attr('disabled','true');
   $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' id='loginButton' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i>"+text.wait+"</button>");
 }
 function loadButton(element) {
   var text = translate();
  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i>'+ text.wait);
 }

 var icsNotifyUserSubmit = function () {
   var text = translate();
   var url      = asset('login')+"/load";
   var dataString =
     {
       'username' : $('#username').val(),
       'password' : $('#password').val()
     };
     $.ajax({
         url: url,
         type: 'GET',
         dataType: 'json',
         data: dataString,
         beforeSend: function ()
         {
           createLoad();
           $('#ics_user_notify').html('<i class="fa fa-spin fa-spinner"></i>'+text.mailNotification);
         },
         success: function (json)
         {
          if((json.message)=='false'){
            bootbox.alert({
              title: "PERIODO DE PRUEBA VENCIDO",
              backdrop: true,
              message: "A partir de ahora solo podra acceder a sus datos en modo SOLO LECTURA, si dessea obtener mas informacion solicite ayuda o contactenos a traves del menu de ayude en la aplicacion.",
              buttons: {
                ok: {
                  label: 'Aceptar'
                }
              },
              callback: function (result) {
                if(result) {
                  //$('#formulario').submit();
                  //ENVIAR INFORMACION AL MODULO ADMINISTRATIVO
                  //loadUserData();
                  $('#loginButton').removeAttr('disabled','true');
                  $('#divButton').html("<button type='submit' onclick = 'icsNotifyUserSubmit()' id='loginButton' class='btn btn-primary pull-right'><i class='fa fa-save'></i> Guardar</button>");;
                }else{
                  $('#loginButton').removeAttr('disabled','true');
                  $('#divButton').html("<button type='submit' onclick = 'icsNotifyUserSubmit()' id='loginButton' class='btn btn-primary pull-right'><i class='fa fa-save'></i> Guardar</button>");;
                }
              }
            });
          }else {
            $('#formulario').submit();
          }
         }
       });
       setTimeout(function () {

       }, 3000);
 }
/**
*
*/
var icsSearchPrealert = function () {
  var servicerOrder = $('#service_order').val();
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += '/casillero_cacargo/public';
  }
  var url = root + '/admin/packagecurriers/new' + '/verify';
  if (servicerOrder != null || servicerOrder != '') {
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      data: {'servicerOrder': servicerOrder},
      beforeSend: function () {
        $('#ics_service_order').html("<i class='fa fa-spin fa-spinner'></i>");
      },
      success: function (json) {
        json.message == true ? icsSetDataLoadSelect(json) : $('#ics_service_order').html("");
        $('#ics_service_order').html("");
      },
      error: function () {
        log('no se ha cargado' + url);
        $('#ics_service_order').html("");
      },
      complete: function() {
        $('#ics_service_order').html("");
      }
    });
  }
}
/**
*
*/
var icsSetDataLoadSelect = function (json) {

  $('#ics_service_order').html("<i class='fa fa-flag'></i>");
  var courier = json.data['courier'];
  console.log(json.data);
  var aux;
  $('#courierSelect').empty();
  /**
  *
  */

  $.each(json.courier, function(i, item) {
    if(item.id == courier){
      $('#courierSelect').append("<option value='"+item.id+"' selected> "+(item.name).toUpperCase()+"</option");
    }else {
       $('#courierSelect').append("<option value='"+item.id+"'> "+(item.name).toUpperCase()+"</option");
    }
  });

  $("#finalDestinationUser option[value='"+json.user.id+"']").attr('selected','selected');
    setDataClient(json.user);
    $('#finalDestinationUser').val(json.user.id).trigger('change');
  //showClients('block','true');
  /**
  *
  */
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
    document.getElementById('phone').value=clientData.local_phone;
    document.getElementById('email').value=clientData.email;
    document.getElementById('identifier').value=clientData.dni;
    document.getElementById('direction').value=clientData.address;

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
    document.getElementById('destin_identifier').value=destinationData.dni;
    document.getElementById('destin_direction').value=destinationData.address;
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
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;

   $("#volumetricweightm").val((resultm.toFixed(2)).toString());
   $("#volumetricweighta").val((resulta.toFixed(2)).toString());

   if($("#type").val()==1){
      $("#volre").val($("#volumetricweightm").val()+" ft3");
      calcost();
      calctax();
    }else if($("#type").val()==2){
      $("#volre").val($("#volumetricweighta").val()+" Vlb");
      calcost();
      calctax();
    }





}




function taxcalculation(){
  //var val=$("#value").val()
  var valpromo=$("#promotionval").val()
  var sum=0,resultcat,result,aux=0;
  var transport=parseInt($('#type option:selected').attr('cost'));
  var promotion=parseInt($('#promotion option:selected').attr('reduction'));

 // var category=parseInt($('#category option:selected').attr('cost'));

  var taxcat=$('#category option:selected').attr('porcent')/100;
  $('#taxdiv input').each(function(){
    var taxvalue= $(this).attr('attr-mivalue')/100;
    var taxid= $(this).attr('id');
    var calc=taxvalue;
    sum= sum+calc;
    $('#'+taxid).val(calc+"$");
    })
    resultcat=taxcat;
    result=(resultcat+sum+transport).toFixed(1);

    if(promotion>0){
      aux=result*(promotion/100);
      $("#subtotal").val((result));
      $("#promotionval").val(aux+" $");
      $("#total").val((result-aux).toString()+" $");

    }else{
      $("#subtotal").val(result.toString()+" $");
      $("#total").val(result.toString()+" $");
      $("#promotionval").val("0");
    }
}

/*function taxcalculation(){
  var val=$("#value").val()
  var valpromo=$("#promotionval").val()
  var sum=0,resultcat,result,aux=0;
  var transport=parseInt($('#type option:selected').attr('cost'));
  var promotion=parseInt($('#promotion option:selected').attr('reduction'));

 // var category=parseInt($('#category option:selected').attr('cost'));

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
}*/

var detailspackage = function (id, open)
{

  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += '/casillero_cacargo/public';
  }
  var path = root + '/admin/package';
  //var path  =`${window.location.origin}${window.location.pathname}`;
  var sw    = 0;
  var alert = false;

  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) /** show in the modal details of package**/
  {
    bootbox.dialog
    ({
      title: "<span id='tltgnif'>Información</span>",
      message: $('#load').load(path + "/" + id, function ()
      {
        /**
        * Esta operacion no esta funcionando
        */
      }),
      size: "large"
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
            size:"large"
          })    .on('shown.bs.modal', function ()
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
            $('#load').append("<div class = 'text-center' ><h4>Clientes</h4></div><div id='cl' ><div class='progress'><div class='progress-bar progress-bar-striped active' role = 'progressbar' style = 'width:100%;'></div></div></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function ()
            {
              $('#dtble').DataTable();
            });
          }
        }),
        size: "large"
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
  console.log('here');
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += '/casillero_cacargo/public';
  }
  var text = translate();

  var url        = root+"admin/package"+"/showpackage/"+id;
  var dataString = {"event":$('#event').val(),
                    "observation":$('#observation').val()};
  $('#button').disabled = true;
  $.ajax(
      {
        url: url,
        type: 'POST',
        dataType: 'json',
        data: dataString,
        beforeSend: function ()
        {
          $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:25%"><span class="sr-only"></span>Guardando datos...</div>');
          $('#cl').css('display','block');
          $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-circle-o-notch fa-spin"></i> '+text.wait+'</button>');
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
    $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%"><span class="sr-only"></span>'+text.mailNotification+'</div>');
  }, 3000);
}

function loadButton(element) {
  var text = translate();

  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i>'+ text.wait);
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
* Ajax method for select client in company (VS)
*/
var selectclient = function (id) {
  var url = `${window.location.origin}${window.location.pathname}`+"/"+id+"/clients/json";
    $.ajax({
          url: url,
          type: 'GET',
          dataType: 'json',
          beforeSend: function ()
          {
          },
          success: function (json) {

            $('#clientSelect').empty();
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


var detailsreceipt = function (id) {
  var root = window.location.origin;
  if (root == 'http://localhost') {
    root += '/casillero_cacargo/public';
  }
  var path  = root + '/admin/package' + "/" + id + "/receipt";
  var sw    = 0;
  var alert = false;
  var text = translate();
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





function setDataDestination(destinationData)
{
  if (destinationData)
  {
    document.getElementById('name').value=destinationData.name + ' ' + destinationData.last_name;
    $('#name').attr('readonly', true);
    document.getElementById('phone').value=destinationData.local_phone;
    $('#phone').attr('readonly', true);
    document.getElementById('email').value=destinationData.email;
    $('#email').attr('readonly', true);
    document.getElementById('identifier').value=destinationData.dni;
    $('#identifier').attr('readonly', true);
    document.getElementById('direction').value=destinationData.country+', '+destinationData.region+', '+destinationData.city+', '+destinationData.postal_code+', '+destinationData.address;
    $('#direction').attr('readonly', true);
  }
  else
  {
    document.getElementById('name').value="";
        $('#name').attr('readonly', false);
    document.getElementById('phone').value="";
        $('#phone').attr('readonly', false);
    document.getElementById('email').value="";
        $('#email').attr('readonly', false);
    document.getElementById('identifier').value="";
        $('#identifier').attr('readonly', false);
    document.getElementById('direction').value="";
        $('#direction').attr('readonly', false);
  }

}


/**
* Ajax method for select servicio
*/
var selectservicio = function (id) {
var m,a;
  if(id==1){
    $("#volre").val($("#volumetricweightm").val()+" ft3");
  }else if(id==2){
    $("#volre").val($("#volumetricweighta").val()+" Vlb");
  }


  $('#subtotal').val('');
  var url = `${window.location.origin}${window.location.pathname}`+"/"+id+"/typeservice/json";
    $.ajax({
          url: url,
          type: 'GET',
          dataType: 'json',
          beforeSend: function ()
          {
          },
          success: function (json) {
            //console.log(json);
            $('#typeservice').empty();
            $('#typeservice').append("<option value=''>" +'Seleccione tipo de Servicio'+ "</option>");
            $.each(json.typeTransports, function(key, element) {
              var item="{'id':'"+element.id+"','code':'"+element.code+"','price':'"+element.price+"','name':'"+element.name+"'}";
              $('#typeservice').append("<option item="+JSON.stringify(item)+" cost='"+parseInt(element.price)+"' value='" + element.id + "'>" +" "+ element.name + " "+ parseInt(element.price)+"($) </option>");
            });

          }
    });

}

var calctax = function (){
  console.log('calctax');
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
  $("#costinsu").val(calc.toFixed(2));

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

var calcost = function (){
  console.log('calcost');
    var transport=parseInt($('#typeservice option:selected').attr('cost'));


    var vol=0,result;
    if($('#type').val()==1){
      vol=$("#volumetricweightm").val();
    }else{
      vol=$("#volumetricweighta").val();
    }
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


var calcinsurance= function (){

  var val= $('#value').val();
 if(jQuery.type(val)=== "undefined"){

  }else{
    var insu = $('#insurance').val()/100;
    var res= val *insu ;
    $('#costinsu').val(res.toFixed(2)+' $');
    calcost();
    calctax();
  }



}
