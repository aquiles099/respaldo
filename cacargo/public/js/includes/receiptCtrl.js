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
});
/**
*
*/
var icsDetailsPackage = function (id, reload) {
  var url = window.location.origin + AUX_PATH + '/admin/package/showpackage/' + id ;
  console.log(url);
  /**
  *
  */
  icsValidateSession(url);
  /**
  *
  */
  if (reload == false) {
    bootbox.dialog ({
      title: "<span id='tltgnif'>Información</span>",
      message: $('#load').load(url, function (){
        $('#event').select2({ width:'100%'});
        $('#dtble2').DataTable();
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
var changestatuspackage = function (id) {
  var url = window.location.origin + AUX_PATH + '/admin/package/showpackage/' + id;
  var dataString = {'event':$('#event').val(), 'observation':$('#observation').val()};
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: dataString,
    beforeSend: function () {
      $('#cl').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
    },
    success: function (json) {
      ((json.message == 'true') ? icsDetailsPackage(id, 'false'): evalJson (json.alert))
    },
    complete: function () {

    }
  });
}
/**
*
*/
/**
*
*/
var detailsreceipt = function (id) {
  var path  = window.location.origin + AUX_PATH + "/admin/package/" + id + "/receipt";
  var sw    = 0;
  var alert = false;

  $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>');
  bootbox.dialog({
    title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><span id='tltgnif'>Recibo</span>",
    message: $('#load').load(path,function(){

    }),
    size:"large",
    backdrop: true,
    onEscape: function() { },

    }).on('shown.bs.modal', function () {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e) {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
}
