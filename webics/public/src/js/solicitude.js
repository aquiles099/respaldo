"use strict";$(document).on("ready",function(){});var solicitudeDelete=function(element,from){try{var solicitude=getItem(element)||getItemFromParent(element);void 0!=solicitude&&bootbox.confirm(eval(msg(messages.delete)),function(e){e&&doForm("./admin/solicitudes/"+solicitude.id,"delete",void 0,void 0===from||from)})}catch(e){log(e)}},icsUpdateSolicitude=function(e){var t=$("#status option:selected").val(),i=$("#sub").val();icsValidateSubDomain(i)?icsExecuteUpdateSolicitude(e):void 0!==i?t===DENIED_STATUS?icsExecuteUpdateSolicitude(e):($("#sub").addClass("shake animated"),bootbox.confirm("<strong>ATENCION:</strong> Verifique el Subdominio a Registrar",function(e){$("#sub").removeClass("shake animated")})):icsExecuteUpdateSolicitude(e)},icsDoContract=function(element,from){try{var solicitude=getItem(element)||getItemFromParent(element);void 0!=solicitude&&bootbox.confirm(eval(msg(messages.test)),function(e){e&&doForm("./admin/solicitudes/"+solicitude.id,"post",void 0,void 0===from||from)})}catch(e){log(e)}},icsValidateSubDomain=function(e){return/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(e)},icsExecuteUpdateSolicitude=function(e){var t=$("#icsserializeform").serialize();$.ajax({url:CURRENT_LOCATION+"/"+e,type:"PATCH",dataType:"json",data:t,beforeSend:function(){icsGeneralLoad("sendButton")},success:function(t){!0===t.message?icsDetails(e,!0):icsShowErrorServer()},error:function(){icsShowErrorAjax()}})},icsViewInfoApplicant=function(e,t){$("#icsArrowBack").html('<a onclick="icsDetails('+e+', true)" class="icslinkdetails"><i class="fa fa-chevron-left" aria-hidden="true"></i></a> '),$("#icsload").load(CURRENT_LOCATION+"/"+e+"/viewClient",function(e,t,i){"error"==t&&$("#icsload").html('<strong>Error</strong><div class="alert alert-danger" role="alert"> "Se ha encontrado un error en el Servidor: <strong>'+i.status+" "+i.statusText+'"</strong></div>')})};