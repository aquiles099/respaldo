"use strict";function setDataDestinationUser(e){e?(document.getElementById("destin_name").value=e.name,document.getElementById("destin_lastname").value=e.last_name,document.getElementById("destin_dni").value=e.dni,document.getElementById("destin_phonedestin").value=e.local_phone,document.getElementById("destin_cell").value=e.cell,document.getElementById("destin_email").value=e.email,document.getElementById("destin_direction").value=e.address,document.getElementById("destin_zipcode").value=e.postal_code,document.getElementById("destin_country").value=e.country,document.getElementById("destin_region").value=e.region,document.getElementById("destin_city").value=e.city):(document.getElementById("destin_phonedestin").value="",document.getElementById("destin_name").value="",document.getElementById("destin_lastname").value="",document.getElementById("destin_dni").value="",document.getElementById("destin_cell").value="",document.getElementById("destin_email").value="",document.getElementById("destin_direction").value="",document.getElementById("destin_zipcode").value="",document.getElementById("destin_country").value="",document.getElementById("destin_region").value="",document.getElementById("destin_city").value="")}function setDataConsignationUser(e){e?(document.getElementById("cons_name").value=e.name,document.getElementById("cons_lastname").value=e.last_name,document.getElementById("cons_dni").value=e.dni,document.getElementById("cons_phone").value=e.local_phone,document.getElementById("cons_cell").value=e.cell,document.getElementById("cons_email").value=e.email,document.getElementById("cons_direction").value=e.address,document.getElementById("cons_zipcode").value=e.postal_code,document.getElementById("cons_country").value=e.country,document.getElementById("cons_region").value=e.region,document.getElementById("cons_city").value=e.city):(document.getElementById("cons_name").value="",document.getElementById("cons_lastname").value="",document.getElementById("cons_dni").value="",document.getElementById("cons_phone").value="",document.getElementById("cons_cell").value="",document.getElementById("cons_email").value="",document.getElementById("cons_direction").value="",document.getElementById("cons_zipcode").value="",document.getElementById("cons_country").value="",document.getElementById("cons_region").value="",document.getElementById("cons_city").value="")}function preview_image(){for(var e=countimg+1,n=document.getElementById("upload_file").files.length,l=0;l<n;l++)$("#image_preview").append("<div class='preview' id='prev"+e+"'><div class='divimg'><img class='thumbnailp' src='"+URL.createObjectURL(event.target.files[l])+"'></div><a class='removeimg' onclick=remove_preview('prev"+e+"')>Eliminar</a>")}function remove_preview(e){console.log,$("#"+e).remove()}var aux=1;$(document).ready(function(){$("#departureSince").datepicker({dateFormat:"yy-mm-dd"}),$("#departureUntil").datepicker({dateFormat:"yy-mm-dd"}),$("#arrivedSince").datepicker({dateFormat:"yy-mm-dd"}),$("#arrivedUntil").datepicker({dateFormat:"yy-mm-dd"}),$("select").select2({width:"100%"}).on("select2:select",function(e){var el=$(e.currentTarget);if("from"==el.attr("id"))showElements(el.val());else if("clientSelect"==el.attr("id")){showClients("block","true");var item=eval("("+el.find("option:selected").attr("item")+")");setDataClient(item),console.log("hola2")}else if("currier"==el.attr("id"));else if("finalOriginUser"==el.attr("id")){var item=eval("("+el.find("option:selected").attr("item")+")");setDataUsertoring(item)}else if("consName"==el.attr("id"))if(console.log(el.find("option:selected").val()),"addud"==el.find("option:selected").val())$("#destin_name").removeAttr("readonly"),$("#destin_lastname").removeAttr("readonly"),$("#destin_dni").removeAttr("readonly"),$("#destin_phonedestin").removeAttr("readonly"),$("#destin_cell").removeAttr("readonly"),$("#destin_email").removeAttr("readonly"),$("#destin_zipcode").removeAttr("readonly"),$("#destin_country").removeAttr("readonly"),$("#destin_region").removeAttr("readonly"),$("#destin_city").removeAttr("readonly"),$("#destin_direction").removeAttr("readonly"),document.getElementById("destin_name").value="",document.getElementById("destin_lastname").value="",document.getElementById("destin_dni").value="",document.getElementById("destin_phonedestin").value="",document.getElementById("destin_cell").value="",document.getElementById("destin_email").value="",document.getElementById("destin_direction").value="",document.getElementById("destin_zipcode").value="",document.getElementById("destin_country").value="",document.getElementById("destin_region").value="",document.getElementById("destin_city").value="";else{$("#destin_name").attr("readonly","readonly"),$("#destin_lastname").attr("readonly","readonly"),$("#destin_dni").attr("readonly","readonly"),$("#destin_phonedestin").attr("readonly","readonly"),$("#destin_cell").attr("readonly","readonly"),$("#destin_email").attr("readonly","readonly"),$("#destin_zipcode").attr("readonly","readonly"),$("#destin_country").attr("readonly","readonly"),$("#destin_region").attr("readonly","readonly"),$("#destin_city").attr("readonly","readonly"),$("#destin_direction").attr("readonly","readonly");var item=eval("("+el.find("option:selected").attr("item")+")");setDataDestinationUser(item)}else if("shipperName"==el.attr("id"))if(console.log(el.find("option:selected").val()),"adduc"==el.find("option:selected").val())$("#cons_name").removeAttr("readonly"),$("#cons_lastname").removeAttr("readonly"),$("#cons_dni").removeAttr("readonly"),$("#cons_phone").removeAttr("readonly"),$("#cons_cell").removeAttr("readonly"),$("#cons_email").removeAttr("readonly"),$("#cons_zipcode").removeAttr("readonly"),$("#cons_country").removeAttr("readonly"),$("#cons_region").removeAttr("readonly"),$("#cons_city").removeAttr("readonly"),$("#cons_direction").removeAttr("readonly"),document.getElementById("cons_name").value="",document.getElementById("cons_lastname").value="",document.getElementById("cons_dni").value="",document.getElementById("cons_phone").value="",document.getElementById("cons_cell").value="",document.getElementById("cons_email").value="",document.getElementById("cons_direction").value="",document.getElementById("cons_zipcode").value="",document.getElementById("cons_country").value="",document.getElementById("cons_region").value="",document.getElementById("cons_city").value="";else{$("#cons_name").attr("readonly","readonly"),$("#cons_lastname").attr("readonly","readonly"),$("#cons_dni").attr("readonly","readonly"),$("#cons_phone").attr("readonly","readonly"),$("#cons_cell").attr("readonly","readonly"),$("#cons_email").attr("readonly","readonly"),$("#cons_zipcode").attr("readonly","readonly"),$("#cons_country").attr("readonly","readonly"),$("#cons_region").attr("readonly","readonly"),$("#cons_city").attr("readonly","readonly"),$("#cons_direction").attr("readonly","readonly");var item=eval("("+el.find("option:selected").attr("item")+")");setDataConsignationUser(item)}else if("type"==el.attr("id")){var item=eval("("+el.find("option:selected").attr("item")+")");selectservicio(item.id)}}),$("#dtble").DataTable({order:[[0,"desc"]]})});var initDropzone=function(){Dropzone.options.myDropzone={autoProcessQueue:!1,uploadMultiple:!1,parallelUploads:100,maxFilesize:8,addRemoveLinks:!0,dictRemoveFile:"eliminar",dictFileTooBig:"el peso del archivo debe ser menor a 8MB",init:function(){var e=document.querySelector("#submit-all"),n=this;e.addEventListener("click",function(e){e.preventDefault(),n.processQueue(),$("#ics_cargo_booking_form").submit()}),this.on("addedfile",function(){}),this.on("complete",function(e){n.removeFile(e)}),this.on("success",n.processQueue.bind(n)),n.on("sending",function(e,n,l){l.append("filesize",e.size)})}}},setShipperData=function(e){e?(log(e),$("#cons_name").val(e.name),$("#shipperPhone").val(e.celular),$("#shipperCountry").val(e.country),$("#shipperRegion").val(e.region),$("#shipperCity").val(e.city),$("#shipperAdress").val(e.address),$("#shipperPostalCode").val(e.postal_code)):($("#shipperPhone").val(""),$("#shipperCountry").val(""),$("#shipperRegion").val(""),$("#shipperCity").val(""),$("#shipperAdress").val(""),$("#shipperPostalCode").val(""))},setConsigneeData=function(e){e?($("#consigneePhone").val(e.celular),$("#consigneeCountry").val(e.country),$("#consigneeRegion").val(e.region),$("#consigneeCity").val(e.city),$("#consigneeAdress").val(e.address),$("#consigneePostalCode").val(e.postal_code)):($("#consigneePhone").val(""),$("#consigneeCountry").val(""),$("#consigneeRegion").val(""),$("#consigneeCity").val(""),$("#consigneeAdress").val(""),$("#consigneePostalCode").val(""))},icsAddCargoOnBooking=function(e){aux+=1,$("#countbooking").val(aux),$("#ics_booking_list").append("<li id='ics_li_cargo"+aux+"' class='paq'><a data-toggle='tab' href='#ics_bk_"+aux+"'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> Bk"+aux+"<span  onclick='icsDelCargoOnBooking("+aux+")' id='ics_del_cargo_on_booking"+aux+"'>  <i class='fa fa-times' aria-hidden='true'></i></span></a></li>"),$("#ics_content_booking").append("<div class='row tab-pane fade' id='ics_bk_"+aux+"' style='padding:20px'>\n<div class='col-md-8'>\n <div class='dimensmedidas'  id='divlarge' >\n <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>\n <div class='col-lg-10'>\n <input type='text' class='form-control' placeholder='Descripcion' id='description"+aux+"' name='description"+aux+"' type='float' min='1' required='true' value='' >\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n  </div>\n<div class='dimensmedidas'  id='divlarge'>\n<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>\n<div class='col-lg-10'>\n<input type='number' class='form-control' placeholder='Piezas' id='pieces"+aux+"' name='pieces"+aux+"' type='int' maxlength='10' min='1' required='true' value=''>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas'  id='divlarge' >\n<label class='col-lg-2 control-label' id='typeLabel'>Tipo</label>\n<div class='col-lg-10'>\n<select class='form-control' placeholder='Valor ($)' id='type"+aux+"' name='type"+aux+"' type='int' maxlength='10' min='1' required='true' value='' >\n <select/>\n</div>\n </div>\n</div>\n<div class='col-md-4'>\n<div class='dimensmedidas'  id='divlarge' >\n<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>\n <div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+aux+"' name='large"+aux+"' onkeyup='icsGeticsGetPesoVol()' type='float' maxlength='10' min='1' required='true' value=''>\n<span>in</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>\n<label class='col-lg-3 control-label' id='typeLabel' >Ancho</label>\n<div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Ancho' id='width"+aux+"' name='width"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >\n<span>in</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n <div class='dimensmedidas' id='divheight'>\n<label class='col-lg-3 control-label' id='typeLabel' >Alto</label>\n<div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+aux+"' onkeyup='icsGetPesoVol()' name='height"+aux+"' type='float' maxlength='10' min='1' required='true' value=''>\n<span>in</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas' id='divheight'>\n<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>\n <div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+aux+"' onkeyup='icsGetPesoVol()' name='volumetricweightm"+aux+"' type='float' readonly='' maxlength='10' min='1' required='true' value='' >\n<span>ft<sup>3</sup></span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas' id='divheight'>\n<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>\n <div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+aux+"' onkeyup='icsGetPesoVol()' name='volumetricweighta"+aux+"' type='float' readonly='' maxlength='10' min='1' required='true' value='' >\n<span>Vlb</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n <div class='dimensmedidas' id='divheight'>\n <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>\n<div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+aux+"' onkeyup='icsGetPesoVol()' name='weight"+aux+"' type='float' maxlength='10' min='1' required='true' value='' >\n<span>lb</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n</div>\n </div>"),icsAddTypeOn(aux,!0,e,0),$("select").select2()},icsAddTypeOn=function(e,n,l,t){var a=1==n&&0==l?window.location.origin+window.location.pathname+"/type":window.location.origin+AUX_PATH+"/admin/bookings/new/type";$.ajax({url:a,type:"GET",dataType:"json",beforeSend:function(){},success:function(n){icsLoadDinamicSelect(n.message,e,t)},error:function(e){log("Error: "+e.message)}})},icsDelCargoOnBooking=function(e){var n,l,t;l=!!$("#ics_li_cargo"+e).hasClass("active"),$("#ics_li_cargo"+e).remove(),$("#ics_bk_"+e).remove(),n=$(".paq").size(),e===aux&&(aux-=1,$("#ics_li_cargo"+aux).addClass("active "),$("#ics_bk_"+aux).addClass("active in")),1==n&&(aux=1),l===!0&&(t=n>1?aux:1,$("#ics_li_cargo"+t).addClass("active "),$("#ics_bk_"+t).addClass("active in")),$("#countbooking").val(aux),resultvalue()},icsGetPesoVol=function(){for(var e=1;e<=aux;e++){var n=$("#ics_bk_"+e+" #large"+e).val(),l=$("#ics_bk_"+e+" #width"+e).val(),t=$("#ics_bk_"+e+" #height"+e).val(),a=n*l*t/1728,o=n*l*t/166;$("#ics_bk_"+e+" #volumetricweightm"+e).val(Math.round(a).toString()),$("#ics_bk_"+e+" #volumetricweighta"+e).val(Math.round(o).toString())}},icsLoadDinamicSelect=function(e,n,l){$.each(e,function(t,a){$("#type"+n).append(new Option(e[t].name,e[t].id,!0,l==e[t].id))})},icsShowDetailsOfBooking=function(e,n){var l=window.location.origin+window.location.pathname+"/"+e+"/view";0==n?bootbox.dialog({title:"informacion",message:$("#load").load(l,function(){$("#ics_booking_status").select2()}),size:"large",backdrop:!0,onEscape:function(){}}).on("shown.bs.modal",function(){$("#load").show()}).on("hide.bs.modal",function(e){$("#load").hide().appendTo("body")}).modal("show"):$("#load").load(l,function(){$("#ics_booking_status").select2()})},icsChangeStatusBooking=function(e){var n=$("#ics_booking_status").val(),l=$("#observation").val(),t=window.location.origin+window.location.pathname+"/"+e+"/view";$.ajax({url:t,method:"POST",dataType:"json",data:{status:n,observation:l},beforeSend:function(){},success:function(e){1==e.message&&$("#load").load(t,function(){$("select").select2()})},error:function(e){bootbox.alert("Error: "+e.message)}})},icsLoadTabsAndData=function(e){var n=window.location.origin+window.location.pathname+"/items";$.ajax({url:n,type:"GET",dataType:"json",beforeSend:function(){},success:function(e){e.message?icsSetTabsData(e.alert):bootbox.alert("Error en el servidor")},error:function(e){bootbox.alert("Error al Cargar TabsData "+e.description)}})},icsSetTabsData=function(e){$.each(e,function(n,l){n>0?($("#ics_booking_list").append("<li id='ics_li_cargo"+(n+1)+"'><a data-toggle='tab' href='#ics_bk_"+(n+1)+"'><i class='fa fa-circle-o-notch' aria-hidden='true'></i> Bk"+(n+1)+"<span  onclick='icsDelCargoOnBooking("+(n+1)+")' id='ics_del_cargo_on_booking"+(n+1)+"'>  <i class='fa fa-times' aria-hidden='true'></i></span></a></li>"),$("#ics_content_booking").append("<div class='row tab-pane fade' id='ics_bk_"+(n+1)+"' style='padding:20px'>\n<div class='col-md-8'>\n <div class='dimensmedidas'  id='divlarge' >\n <label class='col-lg-2 control-label' id='typeLabel' >Descripcion</label>\n <div class='col-lg-10'>\n <input type='text' class='form-control' placeholder='Descripcion' id='description"+(n+1)+"' name='description"+(n+1)+"' type='float' min='1' required='true' value='"+e[n].description+"' >\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n  </div>\n<div class='dimensmedidas'  id='divlarge'>\n<label class='col-lg-2 control-label' id='typeLabel' >Piezas</label>\n<div class='col-lg-10'>\n<input type='number' class='form-control' placeholder='Piezas' id='pieces"+(n+1)+"' name='pieces"+(n+1)+"' type='int' maxlength='10' min='1' required='true' value='"+e[n].pieces+"'>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas'  id='divlarge' >\n<label class='col-lg-2 control-label' id='typeLabel'>Tipo</label>\n<div class='col-lg-10'>\n<select class='form-control' placeholder='Valor ($)' id='type"+(n+1)+"' name='type"+(n+1)+"' type='int' maxlength='10' min='1' required='true' value='' >\n <select/>\n</div>\n </div>\n</div>\n<div class='col-md-4'>\n<div class='dimensmedidas'  id='divlarge' >\n<label class='col-lg-3 control-label' id='typeLabel' >Largo</label>\n <div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Largo' id='large"+(n+1)+"' name='large"+(n+1)+"' onkeyup='icsGeticsGetPesoVol()' type='float' maxlength='10' min='1' required='true' value='"+e[n].large+"'>\n<span>in</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas' onkeyup='pesovol()' id='divwidth'>\n<label class='col-lg-3 control-label' id='typeLabel' >Ancho</label>\n<div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Ancho' id='width"+(n+1)+"' name='width"+(n+1)+"' type='float' maxlength='10' min='1' required='true' value='"+e[n].width+"' >\n<span>in</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n <div class='dimensmedidas' id='divheight'>\n<label class='col-lg-3 control-label' id='typeLabel' >Alto</label>\n<div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Alto' id='height"+(n+1)+"' onkeyup='icsGetPesoVol()' name='height"+(n+1)+"' type='float' maxlength='10' min='1' required='true' value='"+e[n].height+"'>\n<span>in</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas' id='divheight'>\n<label class='col-lg-3 control-label' id='typeLabel' >Vol(M)</label>\n <div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Vol(M)' id='volumetricweightm"+(n+1)+"' onkeyup='icsGetPesoVol()' name='volumetricweightm"+(n+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+e[n].maritime_volume+"' >\n<span>ft<sup>3</sup></span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n<div class='dimensmedidas' id='divheight'>\n<label class='col-lg-3 control-label' id='typeLabel' >Vol(A)</label>\n <div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Vol(A)' id='volumetricweighta"+(n+1)+"' onkeyup='icsGetPesoVol()' name='volumetricweighta"+(n+1)+"' type='float' readonly='' maxlength='10' min='1' required='true' value='"+e[n].aerial_volume+"' >\n<span>Vlb</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n <div class='dimensmedidas' id='divheight'>\n <label class='col-lg-3 control-label' id='typeLabel' >Peso</label>\n<div class='col-lg-9'>\n<input type='number' class='form-control form_dimension' placeholder='Peso' id='weight"+(n+1)+"' onkeyup='icsGetPesoVol()' name='weight"+(n+1)+"' type='float' maxlength='10' min='1' required='true' value='"+e[n].weight+"' >\n<span>lb</span>\n <span class='help-block' style='margin-bottom: 0px;'></span>\n</div>\n</div>\n</div>\n </div>"),$("#countbooking").val(n+1),icsAddTypeOn(n+1,!1,!0,e[n].container)):($("#description1").val(e[n].description),$("#pieces1").val(e[n].pieces),$('#type1 > option[value="'+e[n].container+'"]').attr("selected","selected"),$("#large1").val(e[n].large),$("#width1").val(e[n].width),$("#height1").val(e[n].height),$("#volumetricweightm1").val(e[n].maritime_volume),$("#volumetricweighta1").val(e[n].aerial_volume),$("#weight1").val(e[n].weight))}),$("select").select2(),aux=parseInt($("#countbooking").val())},icsBookingDelete=function(element,from){try{var booking=getItem(element)||getItemFromParent(element),url=window.location.origin+window.location.pathname+"/"+booking.id;void 0!=booking&&bootbox.confirm(eval(msg(messages.delete)),function(e){e&&doForm(url,"delete",void 0,void 0===from||from)})}catch(e){log(e)}},countimg=0;