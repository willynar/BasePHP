$("#formLogin").submit(function (e) {
  e.preventDefault();
  if ($("#email").val() != "" && $("#password").val() != "" && $("#email").val() != " " && $("#password").val() != " ") {
    // se envian los datos al controlador        
    $.ajax({
      url: "validar-login",
      type: "post",
      dataType: "json",
      data: ({ user: $("#email").val(), pass: $("#password").val() }),
      success: function (result) {
        console.log(result);
        if (result == "admin") {
          // se redirecciona a la pagina
          location.href = "adminstracion";
        } else if (result == "user") {
          // se redirecciona a la pagina
          location.href = "user";
        } else {
          $("div.message").remove();
          //Escribimos el mensaje que se nos develve a traves de la variable result
          $("#formLogin").after("<div class='message'>" + result + "</div>");
          //Hacemos desaparecer el mensaje    
          setTimeout(function () { $("div.message").remove(); }, 4000);
        }
      },
      error: function (result) { console.log(result); }
    });
  } else {
    $("div.message").remove();
    $("#formLogin").after("<div class='message'>Todos los campos son requeridos.</div>");
    //Hacemos desaparecer el mensaje    
    setTimeout(function () { $("div.message").remove(); }, 4000);
  }
});


$('#tableUser').DataTable({
  "bLengthChange": false,
  language: {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de MAX total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar MENU Entradas",
    "loadingRecords": "Cargando...",
    "processing": "Procesando...",
    "search": "Buscar:",
    "zeroRecords": "Sin resultados encontrados",
    "paginate": {
      "first": "Primero",
      "last": "Ultimo",
      "next": "Siguiente",
      "previous": "Anterior"
    }
  },
});
$('#tableUser-2').DataTable({
  "bLengthChange": false,
  language: {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de MAX total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar MENU Entradas",
    "loadingRecords": "Cargando...",
    "processing": "Procesando...",
    "search": "Buscar:",
    "zeroRecords": "Sin resultados encontrados",
    "paginate": {
      "first": "Primero",
      "last": "Ultimo",
      "next": "Siguiente",
      "previous": "Anterior"
    }
  },
});

//crear usuario
$("#createUser").submit(function (e) {
  e.preventDefault();
  if ($("#nameUser").val().trim() != "" && $("#SnameUser").val().trim() != ""
    && $("#lastnameUser").val().trim() != "" && $("#SlastnameUser").val().trim() != ""
    && $("#emailUser").val().trim() != "" && $("#nivelUser").val().trim() != ""
    && $("#rolUser").val().trim() != "" && $("#passUser").val().trim() != ""
    && $("#repPassUser").val().trim() != "" && $("#groupUser").val().trim() != "") {
    if ($("#passUser").val() == $("#repPassUser").val()) {
      var data = [];
      data.push($("#nameUser").val());
      data.push($("#SnameUser").val());
      data.push($("#lastnameUser").val());
      data.push($("#SlastnameUser").val());
      data.push($("#emailUser").val());
      data.push($("#rolUser").val());
      data.push($("#passUser").val());
      data.push($("#repPassUser").val());
      data.push($("#nivelUser").val());
      data.push($("#groupUser").val());
      // se envian los datos al controlador        
      $.ajax({
        url: "crear-usuario",
        type: "post",
        dataType: "json",
        data: ({ user: data }),
        success: function (result) {
          console.log(result);
          if (result == true) {
            // se limpian los datos en 
            $("#createUser")[0].reset();
            location.reload();
          } else {
            $("div.message").remove();
            //Escribimos el mensaje que se nos develve a traves de la variable result
            $("#createUser").after("<div class='message'>" + result + "</div>");
            //Hacemos desaparecer el mensaje
            setTimeout(function () { $("div.message").remove(); }, 4000);
          }
        },
        error: function (result) { console.log(result); }
      });
    } else {
      $("div.message").remove();
      $("#createUser").after("<div class='message'>Las contraseñas deben ser iguales.</div>");
      //Hacemos desaparecer el mensaje
      setTimeout(function () { $("div.message").remove(); }, 4000);
    }
  } else {
    $("div.message").remove();
    $("#createUser").after("<div class='message'>Todos los campos son requeridos.</div>");
    //Hacemos desaparecer el mensaje
    setTimeout(function () { $("div.message").remove(); }, 4000);
  }
});





// generar reporte por archivo ecxel
function ExportarExel() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

  var table = 'exel';
  var name = 'nombre_hoja_calculo';

  if (!table.nodeType) table = document.getElementById(table)
  var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
  window.location.href = uri + base64(format(template, ctx))
}
//Exportar a pdf
function ReportePDFProyecto() {
  var printContents = document.getElementById('pdf').innerHTML;
  var originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;

  window.print();

  document.body.innerHTML = originalContents;

}
$(document).ready(function (e) {
  $(document).on('click', '#btnsave', function (e) {
    var nombres = $('#nombres').val();
    var apellidos = $('#apellidos').val();

    var values = "nombres=" + nombres + "&apellidos=" + apellidos;
    $.ajax({
      type: "POST",
      url: "https://www.ensenanzaweb.com/test/post.php",
            data: values,
      success: function (data) {
        if (data == "Guardado") {
          $('.mensaje').html('');
          $('.mensaje').append('Guardado');
        } else {
          $('.mensaje').append('Error');
        }

      }
    })
  });
});


