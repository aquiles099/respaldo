/**
*
*/
'use strict';
/**
*
*/
$(document).ready(function () {
  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
  });
  /**
  *
  */
  $('#consolidated').select2();
  $('#country').select2();
  /**
  *
  */
  $('#courierSelect').select2();
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
    dayNamesMin: translate().dayNamesMin,
    monthNames:  translate().monthNames
  });
  /**
  *
  */
});
/**
*
*/

var createLoad = function ()
{
  $('#divButton').attr('disabled','true');
  $('#divButton').html("<button type='submit' onclick = 'this.disabled = true' class='btn btn-primary pull-right'><i class='fa fa-circle-o-notch fa-spin'></i> "+translate().wait+"</button>");
}
function loadButton(element) {
 $(element).attr('disabled','true');
 $(element).html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + translate().wait);
}
var icsDetailsPackage = function (packag, reload) {
  var url = window.location.origin + AUX_PATH + '/admin/package/showpackage/' + packag;
  /**
  *
  */
  icsValidateSession(url);
  /**
  *
  */
  if (reload == false) {
    $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+translate().wait+'</p>');
     bootbox.dialog({
       title: "<span id='tltgnif'>"+translate().info+"</span>",
       message: $('#load').load(url, function () {
           $('#dtble2').DataTable();
           $('select').select2({
             width: '100%'
           });
       }),
       size: "large",
       backdrop: true,
       onEscape: function() { },
     })
     .on('shown.bs.modal', function () {
       $('#load').show();
     })
     .on('hide.bs.modal', function (e) {
       $('#load').hide().appendTo('body');
       refreshData();
     })
     .modal('show');
  }
  else {
    $('#load').load(url, function () {
      $('#dtble2').DataTable();
      $('#event').select2({
        width:'100%'
      });
    });
  }
}
/**
*
*/
var changestatuspackage = function (packag) {
  var url = window.location.origin + AUX_PATH + '/admin/package/showpackage/' + packag;
  var dataString = {'event':$('#event').val(), 'observation':$('#observation').val()};
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: dataString,
    beforeSend: function () {
      $('#cl').html('<p><i class="fa fa-spin fa-spinner"></i> '+translate().wait+'</p>');
    },
    success: function (json) {
      ((json.message == 'true') ? icsDetailsPackage(packag, 'false'): evalJson (json.alert))
    },
    complete: function () {

    }
  });
}
/**
*
*/
var icsPrealertDelete = function (element, from) {
  try {
    var prealert = getItem(element) || getItemFromParent(element);
    if(prealert != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm(`./admin/package/prealert/${prealert.id}`, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  }
  catch (e) {
    log(e);
  }
}
/**
*
*/
var icsViewPrelert = function (prealert) {
  var url = window.location.origin + AUX_PATH + '/account/prealert/' + prealert +'/view';
  log(url);
  /**
  * validar session
  */
  icsValidateSession(url);
  /**
  *
  */
    $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
   bootbox.dialog ({
     title: "<span id='tltgnif'><i class='fa fa-flag' aria-hidden='true'></i> "+translate().see_prealert+"</span>",
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
var countimg = 0;
function preview_image()  {
 var res = countimg + 1;
 var total_file = document.getElementById("upload_file").files.length;
 for(var i = 0; i < 1; i++) {
  $('#image_preview').append("<div class='preview' id='prev"+res+"'><div class='divimg'><img class='thumbnailp img-responsive img-rounded' src='"+URL.createObjectURL(event.target.files[i])+"'></div><a class='removeimg' onclick=remove_preview('prev"+res+"')><i class='fa fa-trash-o'></i> "+translate().delete+"</a>");
 }
}
/**
*
*/
function remove_preview(id){
  $('#' + id).remove();
}
