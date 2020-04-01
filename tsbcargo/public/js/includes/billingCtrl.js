$(document).ready( function() {
  $('#since_date').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    monthNames:  [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
  });
  /**
  *
  */
  $('#until_date').datepicker({
    dateFormat:    "yy-mm-dd",
    showButtonPanel: true,
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    monthNames:  [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
  });
  /**
  *
  */
  $('#route').select2();
  $('#typeSelect').select2().on('select2:select', function(e){
    var el = $(e.currentTarget);
    if (el.attr('id') == 'typeSelect'){
      var item = eval('(' + el.find('option:selected').attr('value') + ')');
      if (item == 6) {

        $('#until_date').css('display','none');
        $('#since_date').css('display','none');
        $('#date_to_input').css('display','none');
        $('#date_from_input').css('display','none');
        $('#dateToLabel').css('display','none');
        $('#dateFromLabel').css('display','none');

        $('#type').removeClass('hidden');
        $('#type').css('display','block');

      }else{
        $('#until_date').css('display','table');
        $('#since_date').css('display','table');
        $('#date_to_input').css('display','table');
        $('#date_from_input').css('display','table');
        $('#dateToLabel').css('display','table');
        $('#dateFromLabel').css('display','table');
        $('#row').css('display','block');
        $('#type').css('display','none');
    }
  }
});
});

var exportFile = function (option) {
  var hoy  = new Date();
  var dd   = hoy.getDate();
  var mm   = hoy.getMonth()+1;
  var yyyy = hoy.getFullYear();

  if(dd < 10) {
      dd='0'+dd
  }

  if(mm < 10) {
      mm='0'+mm
  }
  var fileName  = "ICS-Document "+ dd+'-'+mm+'-'+yyyy+' '+hoy.getHours()+":"+hoy.getMinutes()+":"+hoy.getSeconds(); ;
  if (option == 1) /** Print file **/
  {
    data = document.getElementById('dtble');
    newWin = window.open("");
    newWin.document.write(fileName+"<hr>"+data.outerHTML+"<hr>");
    newWin.print();
    newWin.close();
  }

  if (option == 2) /** Export file to pdf **/
  {
    var pdf  = new jsPDF('p', 'pt', 'letter');
    var type = $("#ics_hidden_option").val();
    var name = $("#ics_hidden_option").attr('name');
    pdf.cellInitialize();
    pdf.setFontSize(8);
    if (type < 4) /** Invoice **/
    {
      pdf.text(40, 40, fileName);
      pdf.line(40, 45, 560, 45);
      pdf.fromHTML('<h4>'+name+'</h4>' ,40, 35);
      $.each( $('#dtble tr'), function (i, row){
        $.each( $(row).find("td, th"), function(j, cell)
        {
          var leftMargin = 40;
          var topMargin  = 75;
          var heightCell = 30;
          var txt = $(cell).text().trim() || " ";
          var width = (j == 0 || j == 5 ) ? 40 : (j == 1) ? 120 : 80 ;
          pdf.cell(leftMargin, topMargin, width, heightCell, txt, i);
        });
      });
    }
    else /** Bookins **/
    {
      pdf.text(20, 50, fileName);
      pdf.line(20, 55, 580, 55);
      pdf.fromHTML('<h4>'+name+'</h4>' ,20, 45);
      $.each( $('#dtble tr'), function (i, row){
        $.each( $(row).find("td, th"), function(j, cell)
        {
          var leftMargin = 20;
          var topMargin  = 80;
          var heightCell = 30;
          var txt = $(cell).text().trim() || " ";
          var width = (j == 0 ) ? 30 : (j == 2) ? 90 : (j == 4) ? 40 : (j == 1) ? 50 : (j == 3) ? 65 : (j == 7) ? 60 : (j == 8) ? 40 : (j==6) ? 65 :60 ;
          pdf.cell(leftMargin, topMargin, width, heightCell, txt, i);
        });
      });
    }
    /**
    *
    */
    var url = `${window.location.origin}${window.location.pathname}/logo`;
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      beforeSend: function ()
      {

      },
      success: function (json)
      {
        if(json.message == "true")
        {
          var img = new Image();
          img.addEventListener('load', function() {
              var pdf = new jsPDF();
              pdf.addImage(img, 'png', 10, 50);
          });
          img.src = json.alert;
        }
      },
      error: function ()
      {
        bootbox.alert("Error!!");
      }
    });
    /**
    *
    */
    pdf.save(fileName +'.pdf');
  }

  if (option == 3) /** Export xls file **/
  {
      var tmpElemento = document.createElement('a');
      var tabla_div   = document.getElementById('dtble');
      tmpElemento.href = 'data:application/vnd.ms-excel' + ', ' + tabla_div.outerHTML.replace(/ /g, '%20');
      tmpElemento.download = fileName + '.xls';
      tmpElemento.click();
  }
}

var detailspackage = function (id, open)
{
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var loading = (messages.language=='es') ? 'Cargando...' : 'Loading...';
  var newClient = (messages.language=='es') ? 'Nuevo Cliente' : 'New Client';
  var clients = (messages.language=='es') ? 'Clientes' : 'Clients';
  var edit = (messages.language=='es') ? 'Editar' : 'Edit';


  var path  =`${window.location.origin}`+'/admin/package';
  var sw    = 0;
  var alert = false;
  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) /** show in the modal details of package**/
  {
    bootbox.dialog
    ({
      title: "<span id='tltgnif'>"+info+"</span>",
      message: $('#load').load(path + "/" + id, function ()
      {
        /**
        * Esta operacion no esta funcionando
        */
      }),
      size: "large",
      backdrop: true,
      onEscape: function() { },
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
  else /** show in the modal general views**/
  {
    if ($('#pnlin').hasClass( "showpack" ))
    {
      if (open == 'true')
      {
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+loading+'</p>');
        bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+loading+"</span>",
          message: $('#load').load(path + "/showpackage/" + id, function () {
            $('#packevnt').hide();
            $('#event').select2();
          }),
          size:"large",
          backdrop: true,
          onEscape: function() { },
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
      else
      {
        $('#load').load(path+"/showpackage/"+id,function() {
          $('#event').select2();
        });
      }
    }
    else
    {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+loading+'</p>');
      bootbox.dialog({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='atrás' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+loading+"</span>",
        message: $('#load').load(path + "/" + id + "/read", function ()
        {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="'+edit+'"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="'+newClient+'"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" ))
          {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>"+clients+"</h4></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> Cargando...</p></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function ()
            {

            });
          }
        }),
        size: "large",
        backdrop: true,
        onEscape: function() { },
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
  }
}

var detailspickup = function (id, open)
{
  var info = (messages.language=='es') ? 'Información' : 'Details';
  var loading = (messages.language=='es') ? 'Cargando...' : 'Loading...';
  var newClient = (messages.language=='es') ? 'Nuevo Cliente' : 'New Client';
  var clients = (messages.language=='es') ? 'Clientes' : 'Clients';
  var edit = (messages.language=='es') ? 'Editar' : 'Edit';

  var path  =`${window.location.origin}` +'/admin/pickup';
  var sw    = 0;
  var alert = false;

  /**
  *  Eval concat message
  */
  if ($('#pnlin').hasClass( "usrtrck" )) /** show in the modal details of package**/
  {
    bootbox.dialog({
      title: "<span id='tltgnif'>"+info+"</span>",
      message: $('#load').load(path + "/" + id, function ()
      {
      }),
      size: "large",
      backdrop: true,
      onEscape: function() { },
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
  else /** show in the modal general views**/
  {
    if ($('#pnlin').hasClass( "showpack" ))
    {
      if (open == 'true')
      {
        $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+loading+'</p>');
        bootbox.dialog({
          title: "<a href='' id='bckic' title='atrás' name =''><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+info+"</span>",
          message: $('#load').load(path + "/showpickup/" + id, function ()
          {
            $('#packevnt').hide();
            $('#event').select2();
          }),
          size:"large",
          backdrop: true,
          onEscape: function() { },
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
      else
      {
        $('#load').load(path+"/showpickup/"+id,function()
        {
            $('#event').select2();
        });
      }
    }
    else
    {
      $('#load').html('<p><i class="fa fa-spin fa-spinner"></i> '+loading+'</p>');
      bootbox.dialog
      ({
        title: "<a href='javascript:loadBack("+ alert +","+ id +")' id='bckic' title='atrás' name ='"+ sw +"'><span class= 'pull-left glyphicon glyphicon-menu-left'></span></a><input type= 'hidden' id='swcl' value ='0'><span id='tltgnif'>"+info+"</span>",
        message: $('#load').load(path + "/" + id + "/read", function ()
        {
          $('#pnlft').append('<div class="panel-footer" id="pft"><a href="javascript:loadEditview('+ sw +' , '+id+')"><span class="badge" title="'+edit+'"><span class="glyphicon glyphicon-pencil"></span></span></a>&nbsp<a href="javascript:addClient('+ 2 +','+ id +')" id="adcl"><span class="badge" title="'+newClient+'"><span class="glyphicon glyphicon-user"></span></span></a></div>');
          $('#pnldel').hide();
          if($('#pnlin').hasClass( "cp" ))
          {
            $('#adcl').show();
            $('#load').addClass('cl');
            $('#load').append("<div class = 'text-center' ><h4>"+clients+"</h4></div><div id='cl' ><p><i class='fa fa-spin fa-spinner'></i> "+loading+"</p></div><input type='hidden' id='cpldcl' value = "+id+">");
            $('#cl').load(path+'/'+id+'/clients', function ()
            {
              $('#dtble').DataTable();
            });
          }
        }),
        size: "large",
        backdrop: true,
        onEscape: function() { },
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
  }
}
