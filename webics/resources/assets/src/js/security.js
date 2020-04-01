/**
* Javascrip Code
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
var icsExportLog = function () {
  $.ajax({
      url: CURRENT_LOCATION + "/exportLog" ,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        icsGeneralLoad('sendButton');
      },
      success: function (json) {
        json.message === true ? log(json) : icsShowErrorServer();
      },
      error: function () {
        icsShowErrorAjax();
      }
    });
}
/**
*
*/
