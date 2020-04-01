/**
 *
 */

 $(document).ready( function() {
        $('#dtble').DataTable({
           "order": [[ 3, "desc" ]]
        });

        $('#category').change(function() {
            //taxcalculation();
        });

        $('#type').change(function(){
          console.log($('#type').val());
          selectservicio($('#type').val());
        });

        $('#typeservice').change(function(){
          $('#costservice').val(parseFloat($('#typeservice option:selected').attr('cost'))+" $");
          calcost();
          calctax();

        });


        $('#addcharge').change(function(){
          //$('#costadd').val(parseFloat($('#addcharge option:selected').attr('cost'))+" $");
          calctax();
          calcost();
        });


        $('#promotion').change(function(){
          calctax();
        });


        $('#promotion').change(function(){
         // taxcalculation();
         calctax();
        });



 });


function initSelect2() {
  showElements("1");
      $('select').select2({
          width: '100%'
        }).on('select2:select', function(e) {
          var el = $(e.currentTarget);
          if (el.attr('id') == 'from') {
            showElements(el.val());
          }
          else if (el.attr('id') == 'clientSelect') {

              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataClient(item);
          }
          else if (el.attr('id') == 'courierSelect')
          {

          }
          else if (el.attr('id') == 'finalDestinationClient')
          {
              var item = eval('(' + el.find('option:selected').attr('item') + ')');
              setDataDestination(item);
              disabledDestination('true');
          }
        });


        $('#companySelect').change(function(){
          var company = $('#companySelect').val();
          company != null || company != '' || company != '0'? selectclient(company) : '' ;
        });

        $('#invoice').change(function(){
          if($('#invoice select').val()=='0'){
            $('#uploadinvoice').css("display","none");
          }else{
            $('#uploadinvoice').toggle("fast");
          }
        });

}

var createLoad = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}

var executeupload = function (id)
{
  var url = `${window.location.origin}${window.location.pathname}/` + id + `/upload`;

  $.ajax({
    url: url,
    type: 'POST',
    data: new FormData($("#upload_form")[0]),
    processData: false,
    contentType: false,
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
        evalJson(json.message) ;
        $('#ics-checkpayd').html('');
      }

    },
    error: function ()
    {
      console.log('sin archivo');
    }
  });
}

var upload = function (id)
{
  var url = `${window.location.origin}${window.location.pathname}/` + id + `/upload`;


  bootbox.dialog ({
    title: "<span id=''>Cargar archivo de factura</span>",
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
/**
 *
 */
function packageDelete(element, from) {
  try {
    var package = getItem(element) || getItemFromParent(element);
    if(package != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/package/${package.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }
  catch (e) {
    log(e);
  }
}
/**
* Metodo por el cual se habilida o deshabilita los elementos web de los clientes
*/
function disabledClients(op) {
  $('#name,#phone,#email,#identifier,#direction').attr('disabled', op === 'true');
}
/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del paquete
*/
function showPackages(op) {
  $('#packageTitle,#type,#invoice,#categoryDiv,#taxdiv').attr('style', 'display:'+op );
}
/**
* Metodo por medio del cual se hacen visibles o invisibles los elementos web del destino
*/
function showDestination(op) {
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
function showSelects(selectObj)
{
  var index = selectObj.selectedIndex;
  var selectedValue = selectObj.options[index].value;

  if (selectedValue == 0)
  {
    document.getElementById('finalDestinationUser').style.display='none';
    document.getElementById('finalDestinationUser').required=false;
    document.getElementById('finalDestinationClient').style.display='block';
    document.getElementById('finalDestinationClient').required=true;
    return;
  }
  else (selectedValue == 1)
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

   $('#divButton,#divObservation,#divdimens,#divweight').attr('style', 'display:block,' );

   if (selectedValue == 1)
   {
     //show client

     $('#courier').attr('style', 'display:none' );

   }
   else if (selectedValue == 2)
   {
     document.getElementById('client').style.display='none';
     document.getElementById('divcli').style.display='none';
     showClients('none');

     $('#courier,#divTracking,#destinationTitle,#destination').attr('style', 'display:block' );
     document.getElementById('tracking').required=true;
     showPackages('block');

   }
   else
   {
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
function setDataClient(clientData) {
  console.log(Object.keys(clientData).length);

  if (clientData && Object.keys(clientData).length > 0) {
    document.getElementById('name').value = clientData.name;
    $('#name').attr('readonly', true);

    document.getElementById('phone').value = clientData.phone;
    $('#phone').attr('readonly', true);

    document.getElementById('email').value = clientData.email;
    $('#email').attr('readonly', true);

    document.getElementById('identifier').value = clientData.identifier;
    $('#identifier').attr('readonly', true);

    document.getElementById('direction').value = clientData.direction;
    $('#direction').attr('readonly', true);
  }
  else {
    document.getElementById('name').value = "";
    $('#name').attr('readonly', false);

    document.getElementById('phone').value = "";
    $('#phone').attr('readonly', false);

    document.getElementById('email').value = "";
    $('#email').attr('readonly', false);

    document.getElementById('identifier').value = "";
    $('#identifier').attr('readonly', false);

    document.getElementById('direction').value = "";
    $('#direction').attr('readonly', false);
  }

}
/**
* Metodo por medio del cual se le asignan valores a los elementos web del destino
*/
function setDataDestination(destinationData) {
  if (destinationData) {
    document.getElementById('destin_name').value=destinationData.name;
    document.getElementById('destin_phone').value=destinationData.phone;
    document.getElementById('destin_email').value=destinationData.email;
    document.getElementById('destin_identifier').value=destinationData.identifier;
    document.getElementById('destin_direction').value=destinationData.direction;
  }
  else {
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
  var path  =`${window.location.origin}${window.location.pathname}`;
  console.log(path);
  var sw    = 0;
  var alert = false;
  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) /** show in the modal details of package**/
  {
    bootbox.dialog ({
      title: "<span id='tltgnif'>"+translate().info+"</span>",
      message: $('#load').load(path + "/" + id, function (){
        $('#event').select2({ width:'100%'});
        $('#dtble2').DataTable();
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
    if ($('#pnlin').hasClass( "showpack" )) {
      if (open == 'true') {
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
        bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+translate().info+"</span>",
          message: $('#load').load(path + "/showpackage/" + id, function () {
            $('#event').select2({ width:'100%'});
            $('#dtble2').DataTable();
          }),
          size:"large",
          backdrop: true,
          onEscape: function() { },
        })
        .on('shown.bs.modal', function () {
          $('#load').show();
        }).on('hide.bs.modal', function (e) {
          $('#load').hide().appendTo('body');
        }).modal('show');
      }
      else {
        $('#load').load(path+"/showpackage/" + id, function () {
          $('#event').select2({ width:'100%'});
          $('#dtble2').DataTable();
        });
      }
    }
    else {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
      bootbox.dialog ({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='atrás' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+translate().info+"</span>",
        message: $('#load').load(path + "/" + id + "/read", function () {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="Editar"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="Nuevo Cliente"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" )) {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>Clientes</h4></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> Cargando...</p></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/' + id + '/clients', function () {
              $('#dtble').DataTable();
            });
          }
        }),
        size: "large"
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
* Ajax method for change status package (VS)
*/
var changestatuspackage = function (id)
{
  var url        = `${window.location.origin}${window.location.pathname}`+"/showpackage/"+id;
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
          $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-circle-o-notch fa-spin"></i> Espere...</button>');
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
  setTimeout(function () {
    $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%"><span class="sr-only"></span>Enviando notificacion al correo...</div>');
  }, 3000);
}

function loadButton(element) {
  $(element).attr('disabled','true');
  $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> Espere...');
}

function progressComplete() {
  $('#cl').html('<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%"><span class="sr-only"></span>Completado</div>');
  $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Completado</button>');
}
function hideCL() {
  $('#button').html('<button type="button" onclick = "this.disabled = true" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Completado</button>');
  $('#cl').css('display','none');
}

/**
* Ajax method for select client in company
*/
var selectclient = function (id) {
  var url = window.location.origin + window.location.pathname +  "/" + id + "/clients/json";
  $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('#clientload').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
      },
      success: function (json) {
        var clients = Object.keys(json.clients).length;
        if (clients > 0) {
          $('#clientSelect').empty();
            $.each(json.clients, function(key, element) {
              var email,direction;
              if (element.email != "") {
                 email=element.email;
              } else {
                email="N/R";
              }
              if (element.direction!="") {
                 direction=element.direction;
              } else {
                direction="N/R";
              }
                var item="{'name':'"+element.name+"','code':'"+element.code+"','phone':'"+element.phone+"','direction':'"+direction+"','identifier':'"+element.identifier+"','email':'"+email+"'}";
                $('#clientSelect').append("<option item="+JSON.stringify(item)+" value='" + element.id + "'>" + element.code +" "+ element.name +" "+ element.email+ "</option>");
            });
        } else {
            $('#clientSelect').empty();
            $('#clientSelect').append("<option>Selecciona Cliente</option>");
            setDataClient(json.clients);
        }
      },
      complete: function(){
        $('#clientload').html('');
      }
    });
}
/**
*
*/
var detailsreceipt = function (id) {
  var path  = `${window.location.origin}${window.location.pathname}` + "/" + id + "/receipt";
  var sw    = 0;
  var alert = false;

  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
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
