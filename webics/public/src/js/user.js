"use strict";$(document).on("ready",function(){});var userDelete=function(element,from){try{var user=getItem(element)||getItemFromParent(element);void 0!=user&&bootbox.confirm(eval(msg(messages.delete)),function(e){e&&doForm("./admin/users/"+user.id,"delete",void 0,void 0===from||from)})}catch(e){log(e)}},icsShowUser=function(e){$("#icsload").html('<p><i class="fa fa-spin fa-spinner"></i> Cargando...</p>'),bootbox.dialog({title:"<span id='tltgnif'>Información</span>",message:$("#icsload").load(CURRENT_LOCATION+"/"+e+"/view",function(){$("select").select2()}),size:"large",backdrop:!0,onEscape:function(){}}).on("shown.bs.modal",function(){$("#icsload").show()}).on("hide.bs.modal",function(e){$("#icsload").hide().appendTo("body")}).modal("show")};