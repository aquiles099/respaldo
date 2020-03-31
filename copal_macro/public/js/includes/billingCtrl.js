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
  $('#typeSelect').select2();
  $('#dtble').DataTable({
    "order": [
      [ 0, "desc" ]
    ]
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
        bootbox.alert("Ha ocurrido un error, intentelo de nuevo");
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
