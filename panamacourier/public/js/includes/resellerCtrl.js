/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function() {
  $('#dtble').DataTable({
    "order": [[ 0, "desc" ]]
  });

  /**
  *
  */
  $('#country').select2();
  /**
  *
  */
  $('#courierSelect').select2();
  /**
  *
  */
  $('#type').select2({width:'85%'});
  /**
  *
  */
  $('#origin').select2();
  /**
  *
  */
  $('#arrivedate').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    monthNames:  [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
  });
  /**
  *
  */
  $('#since_date').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    monthNames:  [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
  });
  /**
  *
  */
  $('#until_date').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    monthNames:  [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
  });
  /**
  *
  */
});

function selectUndInt (){
  if ($('#unidad').val()==0) {
    $('#ics_load').html('Sistema Internacional de Unidades');
    $('#unidad').val('1');
    $('#large_span').html('cm');
    $('#width_span').html('cm');
    $('#height').html('cm');
    $('#volumem').html('m<sup>3</sup>');
    $('#volumea').html('Vkg');
    $('#weight').html('kg');

    $('#large').val(($('#large').val() / 0.39370).toFixed(2));
    $('#width').val(($('#width').val() / 0.39370).toFixed(2));
    $('#height1').val(($('#height1').val() / 0.39370).toFixed(2));
    pesovol();
    $('#weight1').val(($('#weight1').val() / 2.2046).toFixed(2));
  }
}

function selectUndImperial (){
  if ($('#unidad').val()==1) {
    $('#ics_load').html('Sistema de Medidas Imperial');
    $('#unidad').val('0');
    $('#large_span').html('in');
    $('#width_span').html('in');
    $('#height').html('in');
    $('#volumem').html('ft<sup>3</sup>');
    $('#volumea').html('Vlb');
    $('#weight').html('lb');

    $('#large').val(($('#large').val() * 0.39370).toFixed(2));
    $('#width').val(($('#width').val() *   0.39370).toFixed(2));
    $('#height1').val(($('#height1').val() * 0.39370).toFixed(2));
    pesovol();
    $('#weight1').val(($('#weight1').val() * 2.2046).toFixed(2));
  }
}
function pesovol(){
   var larg=$("#large").val();
   var anch=$("#width").val();
   var alto=$("#height1").val();
   var resultm=(larg*anch*alto)/1728;
   var resulta=(larg*anch*alto)/166;
   $("#volumetricweightm1").val((resultm.toFixed(2)).toString());
   $("#volumetricweighta1").val((resulta.toFixed(2)).toString());
}
var icsViewPrelert = function (prealert) {
  var url = window.location.origin + window.location.pathname + '/' + prealert +'/view';
  /**
  * validar session
  */
  //icsValidateSession(url);
  /**
  *
  */
    $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
   bootbox.dialog ({
     title: "<span id='tltgnif'><i class='fa fa-flag' aria-hidden='true'></i> Ver Prealerta</span>",
     message: $('#load').load(url, function() {
         $('[data-toggle="tooltip"]').tooltip();
     }),
     size: "medium",
     backdrop: true,
     onEscape: function() { },
   }).on('shown.bs.modal', function () {
     $('#load').show();
   }).on('hide.bs.modal', function (e) {
     $('#load').hide().appendTo('body');
     refreshData();
   }).modal('show');
}
/**
*
*/
var disableElement = function () {
  if(!($("#check:checked").val()==1)) {
      $("#submitBnt").attr('disabled', 'disabled');
  }
  else {
      $("#submitBnt").removeAttr("disabled");
  }
}
/**
* hide/show prealert form
*/
var openPreAlert = function () {
  $('#pre_alert').slideToggle();
}
/**
*
*/
var submitForm = function () {
  $("#divload").html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
}
/**
*
*/
var icsViewPicProfile = function () {
  var url = window.location.origin + window.location.pathname + '/avatar';
  /**
  * validar session
  */
  icsValidateSession(url);
  /**
  *
  */
  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
   bootbox.dialog ({
     title: "<span id='tltgnif'><i class='fa fa-picture-o' aria-hidden='true'></i> Avatar de Usuario</span>",
     message: $('#load').load(url, function() {
         $('[data-toggle="tooltip"]').tooltip();
     }),
     size: "medium",
     backdrop: true,
     onEscape: function() { },
   }).on('shown.bs.modal', function () {
     $('#load').show();
   }).on('hide.bs.modal', function (e) {
     $('#load').hide().appendTo('body');
     refreshData();
   }).modal('show');
}
/**
*
*/
var icsUpdatePicProfile = function (update) {
  var url = window.location.origin + window.location.pathname + '/avatar/update';
  /**
  *
  */
  icsValidateSession(url);
  /**
  *
  */
  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
  /**
  *
  */
  if (update == false) {
    $('#load').load(url, function () {
      $('[data-toggle="tooltip"]').tooltip();
      initDropzone();
    });
  }
  else {


  }
  /**
  *
  */
}
/**
*
*/
var countimg = 0;
function preview_image()  {
 var res = countimg + 1;
 var total_file = document.getElementById("upload_file").files.length;
 for(var i = 0; i < 1; i++) {
  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp img-responsive img-rounded' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')><i class='fa fa-trash-o'></i> Eliminar</a>");
 }
}
/**
*
*/
function remove_preview(id){
  $('#' + id).remove();
}
