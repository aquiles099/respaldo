"use strict";$(document).on("ready",function(){});var icsExportLog=function(){$.ajax({url:CURRENT_LOCATION+"/exportLog",type:"GET",dataType:"json",beforeSend:function(){icsGeneralLoad("sendButton")},success:function(o){!0===o.message?log(o):icsShowErrorServer()},error:function(){icsShowErrorAjax()}})};