/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function(e){
    $('select').select2({
    	width: '100%'
    });
    icsLoadTabsAndData();
});

var createLoad = function ()
{
  var text = translate();
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+text.wait+"</button>");
}
function loadButton() {
  var text = translate();
 $('#divButton').attr('disabled','true');
 $('#divButton').html('<i class="fa fa-circle-o-notch fa-spin"></i>'+text.wait);
}
/**
*
*/
var submitForm = function () {
  createLoad();
  var text = translate();
  $("#divload").html('<p><i class="fa fa-spin fa-spinner"></i>'+text.loading+'</p>');
}

var upperDesc = function (id){
  var str = $('#description'+id).val();
  str = str.charAt(0).toUpperCase() + str.slice(1);
  $('#description'+id).val(str);

  var str2 = $('#name'+id).val();
  str2 = str2.charAt(0).toUpperCase() + str2.slice(1);
  $('#name'+id).val(str2);
}
/*******************************Warehouse Status*********************************/
var aux=1;
function addpackage(){
  var text = translate();
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
                     " <label class='col-lg-2 control-label' id='typeLabel' >"+text.stateName+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+text.stateName+"' id='name"+aux+"' name='name"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabel' >"+text.description+"</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='"+text.description+"' id='description"+aux+"' name='description"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
            upperDesc(aux);
            document.getElementById("packageHref"+aux).click();
}
//Elimina las pestañas de los paquetes
function delpackage(string,cont){
  var text =translate();

    bootbox.confirm({
      title    : text.alert,
      message  : text.deleteMessage,
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i>'+text.cancel
        },
        confirm: {
            label: '<i class="fa fa-check"></i>'+ text.accept
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
  console.log('aux: '+aux);
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
    },
    error: function (e) {
      bootbox.alert('Error al Cargar TabsData ' + e.description);
    }
  });
}

var icsSetTabsData = function (json){
  //console.log(JSON.stringify(json));
  var text =translate();
    $.each(json, function(i, item) {
     if ( i > 0)
     {
      $('#listpack').append("<li id='lipaquete"+(i+1)+"' class='paq'> <a data-toggle='tab' href='#paquete"+(i+1)+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+(i+1)+"<span  onclick='delpackage(depackage"+(i+1)+","+(i+1)+")' id='depackage"+(i+1)+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
      $('#contentpack').append("<div class='row tab-pane fade' id='paquete"+(i+1)+"' style='padding:20px'>"+"\n"+
          "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
             " <div class='dimensmedidas'  id='divlarge' >"+"\n"+
                 " <label class='col-lg-2 control-label' id='typeLabel' >"+text.stateName+"</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='"+text.stateName+"' id='name"+(i+1)+"' name='name"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabel' >"+text.description+"</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='"+text.description+"' id='description"+(i+1)+"' name='description"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
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
