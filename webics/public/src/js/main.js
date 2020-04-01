"use strict";function log(a){console.log(a)}function msg(a){return"`"+a+"`"}function getItem(element){try{return eval("("+element.parent().parent().parent().parent().attr("item")+")")}catch(a){return}}function getItemFromParent(element){try{return eval("("+element.parent().attr("item")+")")}catch(a){return}}function doForm(a,t,o,n){var e=$("<form></form>");e.attr("method","post"),e.attr("action",a||"./"),e.attr("target","_self"),o=o||{},n&&(o.from=window.location.href),o._method=t||"post",$.each(o,function(a,t){var o=$("<input></input>");o.attr("type","hidden"),o.attr("name",a),o.attr("value",t),e.append(o)}),$(document.body).append(e),e.submit()}var CURRENT_LOCATION=window.location.origin+window.location.pathname,DENIED_STATUS="12";$(document).on("ready",function(){$("#icstable").DataTable({order:[[0,"desc"]]}),$("body").append("<div id='icsload' class='icsload'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Cargando...</p></div>"),$("select").select2(),$("#years").select2().on("select2:select",function(e){var elemento=eval("("+$(e.currentTarget).find("option:selected").attr("item")+")");icsSetPaymentAmount(elemento)})});var icsSetPaymentAmount=function(a){a?($("#total").val(a.annual),$("#debt").html(a.annual)):($("#total").val(""),$("#total").html(""))},icsSetPaymentMode=function(a){if("0"!==a){var t=$("#icsp").val();$("#icsbannerpayment").html('<div class="icsinnerpayment" id="icsinnerpayment" fadeInUp animated"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Espere...</div>'),setTimeout(function(){$("#icsbannerpayment").load(CURRENT_LOCATION+"/"+a,{p:t})},1e3)}},icsOthersPayment=function(){var a=$("#p").val();bootbox.dialog({title:"<span id='tltgnif'>Pagar ICS</span>",message:$("#icsload").load(CURRENT_LOCATION+"/other",{p:a},function(){}),size:"large",backdrop:!0,onEscape:function(){}}).on("shown.bs.modal",function(){$("#icsload").show()}).on("hide.bs.modal",function(a){$("#icsload").hide().appendTo("body")}).modal("show")},icsDetails=function(a,t){!1===t?($("#icsload").html('<p><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Cargando...</p>'),bootbox.dialog({title:"<span id='icsArrowBack'></span><span id='tltgnif'>Información</span>",message:$("#icsload").load(CURRENT_LOCATION+"/"+a,function(){}),size:"large",backdrop:!0,onEscape:function(){}}).on("shown.bs.modal",function(){$("#icsload").show()}).on("hide.bs.modal",function(a){$("#icsload").hide().appendTo("body")}).modal("show")):$("#icsload").load(CURRENT_LOCATION+"/"+a,function(){void 0!==$("#icsArrowBack")&&$("#icsArrowBack").html("")})},modalTable=function(a,t,o){!1===o?($("#icsload").html('<p><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Cargando...</p>'),bootbox.dialog({title:"<span id='icsArrowBack'></span><span id='tltgnif'>Solicitudes</span>",message:$("#icsload").load(CURRENT_LOCATION+"/"+a+"/"+t,function(){$("#solicitudeTable").DataTable({order:[[0,"desc"]]}),$("#solicitudeTable_length").hide()}),size:"large",backdrop:!0,onEscape:function(){}}).on("shown.bs.modal",function(){$("#icsload").show()}).on("hide.bs.modal",function(a){$("#icsload").hide().appendTo("body")}).modal("show")):$("#icsload").load(CURRENT_LOCATION+"/"+a+"/"+t,function(){void 0!==$("#icsArrowBack")&&$("#icsArrowBack").html("")})},icsReadNew=function(a){$.ajax({url:CURRENT_LOCATION+"/"+a,type:"GET",dataType:"json",data:a,beforeSend:function(){$("#icsTitleNew").html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>"),$("#icsExtractNew").html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>"),$("#icsDescriptionNew").html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>"),$("#icsPrgImgNew").html("<span class='text-muted'><p><i class='fa fa-circle-o-notch fa-spin fa-fw'></i> Espere...</p></span>")},success:function(a){!0===a.message?icsSetDataNotice(a.notice):icsShowErrorServer()},error:function(){icsShowErrorAjax()}})},icsSetDataNotice=function(a){$("#icsTitleNew").html(a.title),$("#icsExtractNew").html(a.extract),$("#icsDescriptionNew").html(a.description),$("#icsPrgImgNew").html(null!==a.img?"<img src="+a.img+" alt = 'ICS NOTICIAS "+a.extract+"'>":"")},icsShowErrorServer=function(){bootbox.alert("ERROR: No se pudo realizar la accion..!!")},icsShowErrorAjax=function(){bootbox.alert("ERROR: No se pudo completar la solicitud asincrona")},icsGeneralLoad=function(a){$("#"+a).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Espere...'),$("#"+a).prop("disabled",!0)},icsAutoReload=function(){location.reload()},icsReloadSection=function(a,t){$("#"+t).load(a,function(){})},icsAutoBack=function(){return history.back()},icsBackOnModal=function(a){$("#icsload").load(a,function(){})},icsDisableElement=function(a){$("#"+a).prop("disabled",!0)};