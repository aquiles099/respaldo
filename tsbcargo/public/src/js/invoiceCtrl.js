'use strict';
/**
 * Execute the prncipal call
 */
 $(document).ready( function() {
  //  $('#dtble').DataTable({
  //    "order": [
  //      [ 0, "desc" ]
  //    ]
  //  });
  //  if (messages.language == 'en') {
  //    $('#dataTableSearch').attr('placeholder','Search...');
  //    $('#dtble_next').html('Next');
  //    $('#dtble_previous').html('Previous');
  //    $('.dataTables_empty').html('No data to show...');
  //  }
  /**
  *
  */
  searchInvoice(1);
  /**
  *
  */
 });
/**
* search Invoice
*/
var searchInvoice = function (option) {
  var url = window.location.origin + window.location.pathname + '/' + option;
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: {'id': option},
    beforeSend: function () {
      $('#ics_option_load').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
    },
    success: function (json) {
      if(json.message == "true") {
        $('#ics_selected_option').html(json.alert);
        $('#ics_pnlreceipt').load(url, function() {
          $('#dtble').DataTable({
            "order": [
              [ 0, "desc" ]
            ]
          });
          if (messages.language == 'en') {
            $('#dataTableSearch').attr('placeholder','Search...');
            $('#dtble_next').html('Next');
            $('#dtble_previous').html('Previous');
            $('.dataTables_empty').html('No data to show...');
          }
          $('[data-toggle="tooltip"]').tooltip();
          $('#ics_htype').val(option);
        });
        $('#ics_option_load').html('');
      }
    },
    error: function () {
      bootbox.alert("Ha ocurrido un error, intentelo de nuevo");
    }
  });
}
/**
*
*/
var paid = function (id) {
  var url = window.location.origin + window.location.pathname + '/' + id + '/checkIn';
  bootbox.dialog({
    title: "<span id=''>Pago</span>",
    message: $('#load').load(url, function (){
      $('select').select2();
    }),
    size: "medium",
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
/**
*
*/
var executePaid = function (id) {
  var data   = $('#ics_formSerial').serialize();
  var url    = window.location.origin + window.location.pathname + '/' + id + '/checkIn';
  var option = $('#ics_htype').val();
  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: data,
    beforeSend: function () {
      $('#ics-checkpayd').html('<i class="fa fa-spin fa-spinner"></i> Cargando...');
    },
    success: function (json) {
      if(json.message == 'true') {
        $('#load').load(url, function () {
          $('#ics-checkpayd').html('<i class="fa fa-check"></i> Pago registrado');
          $('select').select2();
        });
        searchInvoice(option)
      }
      else {
        evalJson(json.alert) ;
        $('#ics-checkpayd').html('');
      }
    },
    error: function () {
      bootbox.alert("Ha ocurrido un error, intentelo de nuevo");
    }
  });
}
/**
*
*/
var innerCheckin = function (id) {
  var url    =  window.location.origin + window.location.pathname + '/' + id + '/innerChekin';
  var option =  $('#ics_htype').val();
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    data: {'id': id},
    beforeSend: function () {
      $('#ics_innercheckinicon').html('<i class="fa fa-spin fa-spinner"></i>');
    },
    success: function (json) {
      (json.message == 'true') ? searchInvoice(option) : bootbox.alert('no se pudo agregar la factura') ;
    },
    error: function () {
      bootbox.alert("Ha ocurrido un error, intentelo de nuevo");
    }
  });
}
/**
*
*/
var showPayments = function (id) {
  var url =  window.location.origin + window.location.pathname + '/' + id + '/showPayment';
  bootbox.dialog ({
    title: "<span style='float: left' id='ics_back_icon'></span><span id='ics_pay_history'>Historial de Pago</span><p><a id='ics_title_head_modal' class='pull-right' href='javascript:ics_print(true, false, "+id+")' style='color:#23527c' data-toggle='tooltip' title='imprimir'><i class='fa fa-print' aria-hidden='true' ></i></a></p> ",
    message: $('#load').load(url, function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#load').append('<div class="panel-footer" id="pft"></div>');
    }),
    size: "medium",
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
/**
*
*/
var detailPayment = function (id) {
  var url = window.location.origin + window.location.pathname + '/' + id + '/paymentDetail';
  $('#load').load(url, function () {
    $('#ics_back_icon').show();
    $('#ics_back_icon').html("<a href='javascript:ics_back("+$('#ics_hreceipt').val()+")' data-toggle='tooltip' title='atrás'><span class='text-muted'><span class='glyphicon glyphicon-menu-left'></span><span></a>");
    $('#ics_pay_history').html('Detalle de Pago');
    $('#ics_title_head_modal').attr('href','javascript:ics_print(true, true, '+id+')');
    $('#load').append('<div class="panel-footer" id="pft"></span></div>');
    $('[data-toggle="tooltip"]').tooltip();
  });
}
/**
*
*/
var ics_back = function (id) {
  var url = window.location.origin + window.location.pathname + '/' + id + '/showPayment';
  $('#load').load(url, function () {
    $('#ics_back_icon').hide();
    $('#ics_pay_history').html('Historial de Pago');
    $('#load').append('<div class="panel-footer" id="pft"></div>');
    $('#ics_title_head_modal').attr('href','javascript:ics_print(true, false, '+id+')');
    $('[data-toggle="tooltip"]').tooltip();
  });
}
/**
*
*/
var ics_print = function (detail, print, id) {
  /**
  * detalles
  */
  if (detail == true) {
    if (print == true) {
      var url = window.location.origin + window.location.pathname + '/' + id + '/paymentDetail';
      var printWindow = window.open( url, 'Print', 'width=950, height=500, toolbar=0, resizable=0');
      printWindow.addEventListener('load', function(){
      printWindow.print();
      }, true);
    }
    else {
      var url = window.location.origin + window.location.pathname + '/' + id + '/showPayment';
      var printWindow = window.open( url, 'Print', 'width=950, height=500, toolbar=0, resizable=0');
      printWindow.addEventListener('load', function(){
      printWindow.print();
      }, true);
    }
  }
  /**
  *
  */
  else  {
    if (print == true) {

    }
    else {

    }
  }
}
/**
*
*/
var icsShowWarehouseOnReceipt = function (warehouse) {

  var url = window.location.origin + window.location.pathname + '/' + warehouse + '/showWarehouse';
  /**
  *
  */
  bootbox.dialog ({
    title: "Informacion",
    message: $('#load').load(url, function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('select').select2();
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
/**
*
*/
var icsShowPickupOnReceipt = function (pickup) {
  var url = window.location.origin + window.location.pathname + '/' + pickup + '/showPickup';
  /**
  *
  */
  bootbox.dialog ({
    title: "Informacion",
    message: $('#load').load(url, function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('select').select2();
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
