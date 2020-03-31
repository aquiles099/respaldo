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
var submitForm = function () {
  $("#divload").html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
}

var aux=1;
function addpackage(){
  if (aux<6) {
    aux=aux+1;
    $('#countpack').val(aux);
    console.log("aux arriba: "+aux);
    $('#listpack').append("<li id='lipaquete"+aux+"' class='paq'> <a data-toggle='tab' href='#paquete"+aux+"'> <i class='fa fa-circle-o-notch' aria-hidden='true'></i> STATUS "+aux+"<span  onclick='delpackage(depackage"+aux+","+aux+")' id='depackage"+aux+"'>"+'  '+"<i class='fa fa-times' aria-hidden='true'></i></span></a></li>");
    $('#contentpack').append("<div class='row tab-pane fade' id='paquete"+aux+"' style='padding:20px'>"+"\n"+

            "<div class='col-md-2'>"+"\n"+
            "  </div>"+"\n"+
            "<div class='col-md-8'>"+"\n"+
                "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabel' >Nombre</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='Nombre del estado' id='name"+aux+"' name='name"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
                "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                     " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
                     " <div class='col-lg-10'>"+"\n"+
                       " <input type='text' class='form-control' placeholder='Descripcion' id='description"+aux+"' name='description"+aux+"' type='float' min='1' required='true' value='' >"+"\n"+
                       " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                       "</div>"+"\n"+
                "</div>"+"\n"+
            " </div>");  }
}
//Elimina las pestañas de los paquetes
function delpackage(string,cont){
    bootbox.confirm({
      title    : "Alerta!",
      message  : "¿Esta seguro que desea eliminar este estado? \nEliminar estados puede producir errores en los paquetes que los usan.",
      buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm'
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

  if(aux>2){
    console.log(cont);
    $("#paquete"+cont).remove();
    $("#lipaquete"+cont).remove();
    aux=aux-1;
    $("#paquete"+aux).addClass("active in");
    $("#lipaquete"+aux).addClass("active");
    $('#countpack').val(aux);
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
      (json.message) ? icsSetTabsData(json.alert) : bootbox.alert('Error en el servidor') ;
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
                 " <label class='col-lg-2 control-label' id='typeLabel' >Nombre</label>"+"\n"+
                 " <div class='col-lg-10'>"+"\n"+
                   " <input type='text' class='form-control' placeholder='Nombre del Estado' id='name"+(i+1)+"' name='name"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].name +"' >"+"\n"+
                   " <span class='help-block' style='margin-bottom: 0px;'></span>"+"\n"+
                 "</div>"+"\n"+
             "</div>"+"\n"+
             "<div class='dimensmedidas'  id='divlarge' >"+"\n"+
                   " <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>"+"\n"+
                   " <div class='col-lg-10'>"+"\n"+
                         " <input type='text' class='form-control' placeholder='Descripcion del Estado' id='description"+(i+1)+"' name='description"+(i+1)+"' type='float' min='1' required='true' value='"+ json[i].description +"' >"+"\n"+
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

    });
}
