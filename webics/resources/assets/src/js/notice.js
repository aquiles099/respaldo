/**
* Javascript Code
*/
'use strict';
/**
*
*/
$(document).on('ready', function() {

});
/**
*
*/
var noticeDelete = function (element, from) {
  try {
    var notice = getItem(element) || getItemFromParent(element);
    if(notice != undefined) {
      bootbox.confirm(eval(msg(messages.delete)), function(result) {
        if(result) {
          doForm('./admin/notices/' + notice.id, 'delete', undefined, from === undefined ? true : from);
        }
      });
    }
  } catch (e) {
    log(e);
  }
}
/**
*
*/
var icsShowNotice =  function (notice) {
  bootbox.dialog({
    title: "<span id='tltgnif'>Información</span>",
    message: $('#icsload').load(CURRENT_LOCATION + "/" + notice + "/view", function () {
      $('#icsDescription').html($('#icsDescription').text());
    }),
    size: "large",
    backdrop: true,
    onEscape: function() {},
  })
  .on('shown.bs.modal', function () {
    $('#icsload').show();
  })
  .on('hide.bs.modal', function (e) {
    $('#icsload').hide().appendTo('body');
  })
  .modal('show');
}
/**
*
*/
var icsAdminShowNew = function () {
  $.ajax({
      url: CURRENT_LOCATION + "/reload",
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('#icsTitleNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
        $('#icsExtractNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
        $('#icsDescriptionNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
        $('#icsPrgImgNew').html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>");
      },
      success: function (json) {
        json.message === true ? icsSetAdminDataNotice(json.notice)  : icsShowErrorServer();
      },
      error: function () {
        icsShowErrorAjax();
      }
    });
}
/**
*
*/
var icsSetAdminDataNotice = function (notice) {
  $('#icsTitleNew').html(notice.title);
  $('#icsExtractNew').html(notice.extract);
  $('#icsDescriptionNew').html(notice.description);
  $('#icsPrgImgNew').html(notice.img !== null ? "<img src="+ notice.img +" alt = 'ICS NOTICIAS "+ notice.extract +"'>" : '' );
}
