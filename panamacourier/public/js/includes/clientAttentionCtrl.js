$(document).ready(function() {

});
/**
* Ver informacion de usuarios
*/

var showClient = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var path = window.location.origin +`/admin/user/`+ id +`/view`;
  bootbox.dialog({
    title: "<span>"+info+"</span>",
    message: $('#load').load(path, function ()
    {

    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* Ver informacion de paquetes
*/
var detailspackage = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var path = `${window.location.origin}`+ `/admin/package/showpackage/`+id;
  bootbox.dialog ({
    title: "<span id='tltgnif'>"+info+"</span>",
    message: $('#load').load(path, function ()
    {
      $('#packevnt').hide();
      $('#packinvo').hide();
    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* Ver informacion de compañia
*/
var detailscompany = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var path = `${window.location.origin}`+ `/admin/company/`+ id +`/read`;
  bootbox.dialog({
    title: "<span id='tltgnif'>"+info+"</span>",
    message: $('#load').load(path, function ()
    {
      $('#hdprovs').hide();
    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* ver informacion de servicios
*/
var detailsservice = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
    var path = `${window.location.origin}`+ `/admin/transport/`+ id +`/read`;
    console.log(path);
    bootbox.dialog ({
      title: "<span id='tltgnif'>"+info+"</span>",
      message: $('#load').load(path, function ()
      {

      }),
      size: "large"
    })
    .on('shown.bs.modal', function ()
    {
      $('#load').show();
    })
    .on('hide.bs.modal', function (e)
    {
      $('#load').hide().appendTo('body');
    })
    .modal('show');
}
/**
* ver informacion de categorias
*/
var detailscategory = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var path = `${window.location.origin}`+ `/admin/category/`+ id +`/read`;
  bootbox.dialog({
    title: "<span id='tltgnif'>"+info+"</span>",
    message: $('#load').load(path, function ()
    {

    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* ver informacion de promociones
*/
var detailspromotions = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var path = `${window.location.origin}`+ `/admin/promotions/`+ id +`/view`;
  bootbox.dialog({
    title: "<span id='tltgnif'>"+info+"</span>",
    message: $('#load').load(path, function ()
    {

    }),
    size: "large"
  })
  .on('shown.bs.modal', function ()
  {
    $('#load').show();
  })
  .on('hide.bs.modal', function (e)
  {
    $('#load').hide().appendTo('body');
  })
  .modal('show');
}
/**
* ver informacion de promociones
*/
var detailstax = function (id) {
  var info = (messages.language=='es') ? 'Información' : 'Details';
   var path = `${window.location.origin}`+ `/admin/tax/`+ id +`/view`;
   bootbox.dialog ({
     title: "<span id='tltgnif'>"+info+"</span>",
     message: $('#load').load(path, function ()
     {

     }),
     size: "large"
   })
   .on('shown.bs.modal', function ()
   {
     $('#load').show();
   })
   .on('hide.bs.modal', function (e)
   {
     $('#load').hide().appendTo('body');
   })
   .modal('show');
}
