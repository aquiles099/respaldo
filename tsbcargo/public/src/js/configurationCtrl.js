/**
*
*/
/**
*
*/
$(document).ready(function(e){
    $('select').select2({
      //width: 100%
    });
    $("#country_company").select2();
    icsLoadTabsAndData();

});
/**
*
*/

var upperDesc = function (id){
  var str = $('#description'+id).val();
  str = str.charAt(0).toUpperCase() + str.slice(1);
  $('#description'+id).val(str);

  var str2 = $('#name'+id).val();
  str2 = str2.charAt(0).toUpperCase() + str2.slice(1);
  $('#name'+id).val(str2);
}

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
/*******************************Warehouse Status*********************************/
var aux=1;
function addpackage(){
  if (aux<6) {
    aux=aux+1;
    $('#countpack').val(aux);
    console.log("aux arriba: "+aux);
    $('#listpack').append("<li id='lipaquete"+aux+"' class='paq'> <a id='packageHref"+aux+"'data-toggle='tab' href='#paquete"+aux+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+aux+"<span  onclick='delpackage(depackage"+aux+","+aux+")' id='depackage"+aux+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    $('#contentpack').append("<div class='row tab-pane fade' id='paquete"+aux+"' style='padding:20px'>"+"\n"+

            "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
                "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabel' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='name"+aux+"' name='name"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabel' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='description"+aux+"' name='description"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
            upperDesc(aux);
            document.getElementById("packageHref"+aux).click();
}
//Elimina las pestañas de los paquetes
function delpackage(string,cont){
    bootbox.confirm({
      title    : "Alerta!",
      message  : ((messages.language == 'es') ? '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.' : 'Are you sure want to delete this Status, that may cause some problems in packages uses it'),
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> '+(messages.language == 'es') ? 'Cancelar' : 'Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> '+(messages.language == 'es') ? 'Confirmar' : 'Confirm'
        }
      },
      callback : function(result){
                    if(result==true){
                      deletepackage(string,cont);
                    }
                 }
    });
}
function deletepackage(string,cont){
  aux = $('#countpack').val();
  console.log(aux);
  if(aux>2){
    console.log('adentro');
    $("#paquete"+cont).remove();
    $("#lipaquete"+cont).remove();
    aux=aux-1;
    $("#paquete"+aux).addClass("active in");
    $("#lipaquete"+aux).addClass("active");
    $('#countpack').val(aux);
  }
}
/*******************************Booking Status*********************************/
var aux1=1;
function addpackageBookings(){
  console.log(aux1);
  if (aux1<6) {
    aux1=aux1+1;
    $('#countpackBookings').val(aux1);
    console.log("aux arriba: "+aux1);
    $('#listpackBookings').append("<li id='lipaqueteBookings"+aux1+"' class='paq'> <a id='bookingHref"+aux1+"' data-toggle='tab' href='#paqueteBookings"+aux1+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+aux1+"<span  onclick='delpackageBookings(depackageBookings"+aux1+","+aux1+")' id='depackageBookings"+aux1+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    $('#contentpackBookings').append("<div class='row tab-pane fade' id='paqueteBookings"+aux1+"' style='padding:20px'>"+"\n"+

            "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
                "<div class='dimensmedidas'  id='divlargeBookings' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelBookings' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='nameBookings"+aux1+"' name='nameBookings"+aux1+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlargeBookings' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelBookings' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionBookings"+aux1+"' name='descriptionBookings"+aux1+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
            document.getElementById("bookingHref"+aux1).click();
}
function delpackageBookings(string,cont){
    bootbox.confirm({
      title    : "Alerta!",
      message  : ((messages.language == 'es') ? '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.' : 'Are you sure want to delete this Status, that may cause some problems in packages uses it'),
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> '+(messages.language == 'es') ? 'Cancelar' : 'Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> '+(messages.language == 'es') ? 'Confirmar' : 'Confirm'
        }
      },
      callback : function(result){
                    if(result==true){
                      deletepackageBookings(string,cont);
                    }
                 }
    });
}
function deletepackageBookings(string,cont){
  aux1 = $('#countpackBookings').val();
  if(aux1>2){
    console.log(cont);
    $("#paqueteBookings"+cont).remove();
    $("#lipaqueteBookings"+cont).remove();
    aux1=aux1-1;
    $("#paqueteBookings"+aux1).addClass("active in");
    $("#lipaqueteBookings"+aux1).addClass("active");
    $('#countpackBookings').val(aux1);
  }
}
/*******************************PickUp Status*********************************/
var aux3=1;
function addpackagePO(){
  console.log(aux3);
  if (aux3<6) {
    aux3=aux3+1;
    $('#countpackPO').val(aux3);
    console.log("aux arriba: "+aux3);
    $('#listpackPO').append("<li id='lipaquetePO"+aux3+"' class='paq'> <a id='pickupHref"+aux3+"'data-toggle='tab' href='#paquetePO"+aux3+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+aux3+"<span  onclick='delpackagePO(depackagePO"+aux3+","+aux3+")' id='depackagePO"+aux3+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    $('#contentpackPO').append("<div class='row tab-pane fade' id='paquetePO"+aux3+"' style='padding:20px'>"+"\n"+

            "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
                "<div class='dimensmedidas'  id='divlargePO' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelPO' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='namePO"+aux3+"' name='namePO"+aux3+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlargePO' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelPO' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionPO"+aux3+"' name='descriptionPO"+aux3+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
            document.getElementById("pickupHref"+aux3).click();
}
function delpackagePO(string,cont){
    bootbox.confirm({
      title    : "Alerta!",
      message  : ((messages.language == 'es') ? '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.' : 'Are you sure want to delete this Status, that may cause some problems in packages uses it'),
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> '+(messages.language == 'es') ? 'Cancelar' : 'Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> '+(messages.language == 'es') ? 'Confirmar' : 'Confirm'
        }
      },
      callback : function(result){
                    if(result==true){
                      deletepackagePO(string,cont);
                    }
                 }
    });
}
function deletepackagePO(string,cont){
  aux3 = $('#countpackPO').val();
  if(aux3>2){
    console.log(cont);
    $("#paquetePO"+cont).remove();
    $("#lipaquetePO"+cont).remove();
    aux3=aux3-1;
    $("#paquetePO"+aux3).addClass("active in");
    $("#lipaquetePO"+aux3).addClass("active");
    $('#countpackPO').val(aux3);
  }
}
/*******************************Shipment Status*********************************/
var aux4=1;
function addpackageShipment(){
  console.log(aux4);
  if (aux4<6) {
    aux4=aux4+1;
    $('#countpackShipment').val(aux4);
    console.log("aux arriba: "+aux4);
    $('#listpackShipment').append("<li id='lipaqueteShipment"+aux4+"' class='paq'> <a id='shipmentHref"+aux4+"'data-toggle='tab' href='#paqueteShipment"+aux4+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+aux4+"<span  onclick='delpackageShipment(depackageShipment"+aux4+","+aux4+")' id='depackageShipment"+aux4+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    $('#contentpackShipment').append("<div class='row tab-pane fade' id='paqueteShipment"+aux4+"' style='padding:20px'>"+"\n"+

            "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
                "<div class='dimensmedidas'  id='divlargeShipment' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelShipment' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='nameShipment"+aux4+"' name='nameShipment"+aux4+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlargeShipment' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelShipment' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionShipment"+aux4+"' name='descriptionShipment"+aux4+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
            document.getElementById("shipmentHref"+aux4).click();

}
function delpackageShipment(string,cont){
    bootbox.confirm({
      title    : "Alerta!",
      message  : ((messages.language == 'es') ? '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.' : 'Are you sure want to delete this Status, that may cause some problems in packages uses it'),
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> '+(messages.language == 'es') ? 'Cancelar' : 'Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> '+(messages.language == 'es') ? 'Confirmar' : 'Confirm'
        }
      },
      callback : function(result){
                    if(result==true){
                      deletepackageShipment(string,cont);
                    }
                 }
    });
}
function deletepackageShipment(string,cont){
  aux4 = $('#countpackShipment').val();
  console.log('ship: ',aux4);
  if(aux4>2){
    console.log(cont);
    $("#paqueteShipment"+cont).remove();
    $("#lipaqueteShipment"+cont).remove();
    aux4=aux4-1;
    $("#paqueteShipment"+aux4).addClass("active in");
    $("#lipaqueteShipment"+aux4).addClass("active");
    $('#countpackShipment').val(aux4);
  }
}
/*******************************Cargo Release Status*********************************/
var aux5=1;
function addpackageRelease(){
  if (aux5<6) {
    aux5=aux5+1;
    $('#countpackRelease').val(aux5);
    console.log("aux arriba: "+aux5);
    $('#listpackRelease').append("<li id='lipaqueteRelease"+aux5+"' class='paq'> <a id='releaseHref"+aux5+"' data-toggle='tab' href='#paqueteRelease"+aux5+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+aux5+"<span  onclick='delpackageRelease(depackageRelease"+aux5+","+aux5+")' id='depackageRelease"+aux5+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    $('#contentpackRelease').append("<div class='row tab-pane fade' id='paqueteRelease"+aux5+"' style='padding:20px'>"+"\n"+

            "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
                "<div class='dimensmedidas'  id='divlargeRelease' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelRelease' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='nameRelease"+aux5+"' name='nameRelease"+aux5+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlargeRelease' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabelRelease' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionRelease"+aux5+"' name='descriptionRelease"+aux5+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
          document.getElementById("releaseHref"+aux5).click();
}
function delpackageRelease(string,cont){
    bootbox.confirm({
      title    : "Alerta!",
      message  : ((messages.language == 'es') ? '¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.' : 'Are you sure want to delete this Status, that may cause some problems in packages uses it'),
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> '+(messages.language == 'es') ? 'Cancelar' : 'Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> '+(messages.language == 'es') ? 'Confirmar' : 'Confirm'
        }
      },
      callback : function(result){
                    if(result==true){
                      deletepackageRelease(string,cont);
                    }
                 }
    });
}
function deletepackageRelease(string,cont){
  aux5 = $('#countpackRelease').val();
  console.log('rel: ',aux5);
  if(aux5>2){
    console.log(cont);
    $("#paqueteRelease"+cont).remove();
    $("#lipaqueteRelease"+cont).remove();
    aux5=aux5-1;
    $("#paqueteRelease"+aux5).addClass("active in");
    $("#lipaqueteRelease"+aux5).addClass("active");
    $('#countpackRelease').val(aux5);
  }
}
function resultvalue(){
 var sum=0;

 for (step = 1; step <= aux; step++) {
   var value=$("#paquete"+step+" "+"#valued"+step).val();
   sum =sum+parseFloat(value);
  }

  $("#value").val(sum);
}

var icsLoadTabsAndData = function () {
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
      (json.message) ? icsSetTabsData(json.warehouses) : bootbox.alert('Error en el servidor');
      (json.message) ? icsSetTabsDataRelease(json.releases) : bootbox.alert('Error en el servidor');
      (json.message) ? icsSetTabsDataBooking(json.bookings) : bootbox.alert('Error en el servidor');
      (json.message) ? icsSetTabsDataPO(json.pickups) : bootbox.alert('Error en el servidor');
      (json.message) ? icsSetTabsDataShipment(json.shipments) : bootbox.alert('Error en el servidor');
    },
    error: function (e) {
      bootbox.alert('Error al Cargar TabsData ' + e.description);
    }
  });
}

var icsSetTabsData = function (json){
  //console.log(JSON.stringify(json));
    $.each(json, function(i, item) {
     if ( i > 0)
     {
      $('#listpack').append("<li id='lipaquete"+(i+1)+"' class='paq'> <a data-toggle='tab' href='#paquete"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+(i+1)+"<span  onclick='delpackage(depackage"+(i+1)+","+(i+1)+")' id='depackage"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpack').append("<div class='row tab-pane fade' id='paquete"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
             " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
                 " <label class='col-lg-2 control-label' id='typeLabel' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='name"+(i+1)+"' name='name"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabel' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='description"+(i+1)+"' name='description"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
                         " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                     "</div>"+"\n"+
             "  </div>"+"\n"+
        " </div>");
        $('#countpack').val((i+1));
      }else{
      $('#name1').val(json[i].name);
      $('#description1').val(json[i].description);
      }
      aux = parseInt($('#countpack').val());
      upperDesc(aux);
    });
}
var icsSetTabsDataRelease = function (json){
  //console.log(JSON.stringify(json));
    $.each(json, function(i, item) {
     if ( i > 0)
     {
      $('#listpackRelease').append("<li id='lipaqueteRelease"+(i+1)+"' class='paq'> <a data-toggle='tab' href='#paqueteRelease"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+(i+1)+"<span  onclick='delpackageRelease(depackageRelease"+(i+1)+","+(i+1)+")' id='depackageRelease"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpackRelease').append("<div class='row tab-pane fade' id='paqueteRelease"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
             " <div class='dimensmedidas'  id='divlargeRelease' >"+"\n"+
                 " <label class='col-lg-2 control-label' id='typeLabelRelease' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='nameRelease"+(i+1)+"' name='nameRelease"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidasRelease'  id='divlargeRelease' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabelRelease' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionRelease"+(i+1)+"' name='descriptionRelease"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
                         " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                     "</div>"+"\n"+
             "  </div>"+"\n"+
        " </div>");
        $('#countpackRelease').val((i+1));
      }else{
      $('#nameRelease1').val(json[i].name);
      $('#descriptionRelease1').val(json[i].description);
      }
      aux5 = parseInt($('#countpackRelease').val());

    });
}
var icsSetTabsDataBooking = function (json){
  //console.log(JSON.stringify(json));
    $.each(json, function(i, item) {
     if ( i > 0)
     {
      $('#listpackBookings').append("<li id='lipaqueteBookings"+(i+1)+"' class='paq'> <a data-toggle='tab' href='#paqueteBookings"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+(i+1)+"<span  onclick='delpackageBookings(depackageBookings"+(i+1)+","+(i+1)+")' id='depackageBookings"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpackBookings').append("<div class='row tab-pane fade' id='paqueteBookings"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
             " <div class='dimensmedidas'  id='divlargeBookings' >"+"\n"+
                 " <label class='col-lg-2 control-label' id='typeLabelBookings' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='nameBookings"+(i+1)+"' name='nameBookings"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidasBookings'  id='divlargeBookings' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabelBookings' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionBookings"+(i+1)+"' name='descriptionBookings"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
                         " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                     "</div>"+"\n"+
             "  </div>"+"\n"+
        " </div>");
        $('#countpackBookings').val((i+1));
      }else{
      $('#nameBooking1').val(json[i].name);
      $('#descriptionBooking1').val(json[i].description);
      }
      aux1 = parseInt($('#countpackBookings').val());

    });
}
var icsSetTabsDataShipment = function (json){
  //console.log(JSON.stringify(json));
    $.each(json, function(i, item) {
     if ( i > 0)
     {
      $('#listpackShipment').append("<li id='lipaqueteShipment"+(i+1)+"' class='paq'> <a data-toggle='tab' href='#paqueteShipment"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+(i+1)+"<span  onclick='delpackageShipment(depackageShipment"+(i+1)+","+(i+1)+")' id='depackageShipment"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpackShipment').append("<div class='row tab-pane fade' id='paqueteShipment"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
             " <div class='dimensmedidas'  id='divlargeShipment' >"+"\n"+
                 " <label class='col-lg-2 control-label' id='typeLabelShipment' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='nameShipment"+(i+1)+"' name='nameShipment"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidasShipment'  id='divlargeShipment' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabelShipment' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionShipment"+(i+1)+"' name='descriptionShipment"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
                         " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                     "</div>"+"\n"+
             "  </div>"+"\n"+
        " </div>");
        $('#countpackShipment').val((i+1));
      }else{
      $('#nameShipment1').val(json[i].name);
      $('#descriptionShipment1').val(json[i].description);
      }
      aux4 = parseInt($('#countpackShipment').val());

    });
}
var icsSetTabsDataPO = function (json){
  //console.log(JSON.stringify(json));
    $.each(json, function(i, item) {
     if ( i > 0)
     {
      $('#listpackPO').append("<li id='lipaquetePO"+(i+1)+"' class='paq'> <a data-toggle='tab' href='#paquetePO"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+(i+1)+"<span  onclick='delpackagePO(depackagePO"+(i+1)+","+(i+1)+")' id='depackagePO"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpackPO').append("<div class='row tab-pane fade' id='paquetePO"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
             " <div class='dimensmedidas'  id='divlargePO' >"+"\n"+
                 " <label class='col-lg-2 control-label' id='typeLabelPO' >"+((messages.language == 'es') ? 'Nombre' : 'Name')+"</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Nombre del Estado' : 'Name of new status') +"' id='namePO"+(i+1)+"' name='namePO"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidasPO'  id='divlargePO' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabelPO' >"+((messages.language == 'es') ? 'Descripción' : 'Description') +"</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='"+((messages.language == 'es') ? 'Descripción' : 'Description') +"' id='descriptionPO"+(i+1)+"' name='descriptionPO"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
                         " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                     "</div>"+"\n"+
             "  </div>"+"\n"+
        " </div>");
        $('#countpackPO').val((i+1));
      }else{
      $('#namePO1').val(json[i].name);
      $('#descriptionPO1').val(json[i].description);
      }
      aux3 = parseInt($('#countpackPO').val());

    });
}
