/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function() {
  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  /**
  *
  */
  $('#country').select2({
    width: '100%'
  });
  /**
  *
  */
  $('#consolidated').select2();
  $('#courierSelect').select2({
    width: '100%'
  });
  /**
  *
  */
  $('#origin').select2({
    width: '100%'
  });
  /**
  *
  */
  $('#ics_select_sex').select2({
    width: '100%'
  });
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
var createLoad = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> Espere...</button>");
}
var createLoadPass = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<i class='fa fa-circle-o-notch fa-spin'></i> Espere...");
}
var updateUserLoad = function ()
{
  $('#submitBnt').attr('disabled','true');
  $('#submitBnt').html("<i class='fa fa-circle-o-notch fa-spin'></i> Espere...");
}
var icsViewPrelert = function (prealert) {
  var url = window.location.origin + window.location.pathname + '/' + prealert +'/view';
  /**
  * validar session
  */
  icsValidateSession(url);
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
  createLoadPass();
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
