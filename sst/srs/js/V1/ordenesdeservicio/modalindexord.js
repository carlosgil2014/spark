var tabla;
$(document).ready(function()
{
    $('[data-toggle="tooltip"]').tooltip(); 
});

function modalOrden(idOrden)
{ 
    $(".loader").fadeIn("slow", function(){
        $.ajax({
            data:{idOrden : idOrden},
            url:   'view/ordenesdeservicio/index.php?accion=modalIndexOrden',
            type:  'post',
            success:  function (data) {
                $("#modalIndex").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $(".loader").fadeOut("fast");
            },
        });
        $("#modalIndex").modal("show");
    });
}

function autorizarOrden(idOrden)
{ 
    var fechaInicial = $("#fechaInicial").val();
    var fechaFinal = $("#fechaFinal").val();
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          data:{idCotOrdPf : idOrden,estado : "Autorizada",motivo : "", tabla : "Ordenes",fechaInicial:fechaInicial,fechaFinal:fechaFinal},
          url:   'index.php?accion=accionCotOrd',
          type:  'post',
          success:  function (data) {
            modalOrden(idOrden);
          },
      });
    });

}

$(document).on("click", "#modificarOrdenes", function() 
{ 
  sumaPT = 0;sumaC = 0; sumaT = 0;
  var servicio = $("#servicio");
  var fechaInicial = $("#fechaInicial");
  var fechaFinal = $("#fechaFinal");
  var idOrden = $(this).val();
    fechaInicial.prop("readonly",false);
    fechaFinal.prop("readonly",false);
    servicio.prop("readonly",false);
	$(".editables").each(function() 
	{
    var texto = $(this).find("td:eq(0)").text();
    var celdaConcepto = $(this).find("td:eq(0)");
    var celdaPrecio = $(this).find("td:eq(2)");
    var tipoPrecio = $(this).attr("precioCon");
    var idCotPfConcepto = $(this).attr("idCotPfConcepto");
    var precio = parseFloat($(this).find("td:eq(2)").text().replace("$ ","").replace(/,/g,''));
        tabla = $(this).attr("tipo");
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          data:{idCotPfConcepto : idCotPfConcepto , tabla : tabla, idOrden : idOrden},
          url:   'view/ordenesdeservicio/index.php?accion=maximosConceptos',
          type:  'post',
          success:  function (data) {
            if(tabla == "cot")
              celdaConcepto.html("<input type='number' class='form-control text-center cantidad input-sm' max = '"+data+"' value='"+texto+"' data-toggle='tooltip'  data-placement='bottom' title='Disponibles: "+data+"' />");
            else
              celdaConcepto.html("<input type='number' class='form-control text-center cantidad input-sm' max = '"+data+"' value='"+texto+"' data-toggle='tooltip'  data-placement='bottom' title='Saldo Disponible: "+formatoMoneda(parseFloat(data),"$")+"' />");  
            if(tipoPrecio == "0.00")
              celdaPrecio.html("<input type='number' class='form-control text-center sumaPrecio input-sm' max = '"+data+"' value='"+precio+"' />");            
            $('[data-toggle="tooltip"]').tooltip(); 
            $(".loader").fadeOut("fast");
          },
      });
    });
  });
	$(this).html("Guardar");
	$(this).attr("id","guardarCambios");
 	$(this).attr("value",idOrden);
});

$(document).on("click", "#guardarCambios", function() 
{ 
  var idOrden = $(this).val();
  var servicio = $("#servicio").val();
  var fechaInicial = $("#fechaInicial").val();
  var fechaFinal = $("#fechaFinal").val();
  var total = $("#sumaT").html().replace("$","").replace(/,/g,'');

  if(comprobartabla())
  {
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          data:{idOrden : idOrden , servicio : servicio, fechaInicial : fechaInicial, fechaFinal : fechaFinal, total : total},
          url:   'view/ordenesdeservicio/index.php?accion=actualizarOrden',
          type:  'post',
          success:  function (data) {
            $(".editables").each(function() 
            {
              var datosConcepto = {}; 
              var comision = parseFloat(1 + ($(this).closest('tr').attr('com')/100));
              datosConcepto["idOrdenConcepto"] = $(this).attr("osCon");
              datosConcepto["cantidad"] = $(this).find('td:eq(0)').find("input.cantidad").val();
              datosConcepto["precioUnitario"] = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
              datosConcepto["subtotal"];
              if(isNaN(datosConcepto["precioUnitario"]))
                datosConcepto["precioUnitario"] = parseFloat($(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val());
                datosConcepto["subtotal"] = (datosConcepto["cantidad"] * datosConcepto["precioUnitario"] * comision).toFixed(2);
                $.ajax({
                  data:{datosConcepto : datosConcepto},
                  url:   'view/ordenesdeservicio/index.php?accion=actualizarOrdenConcepto',
                  type:  'post',
                  success:  function (data) {
                  },
                });
            });
            $(".loader").fadeOut("fast");
            modalOrden(idOrden);
          },
      });
    });
  }
  else
    $("#p_alert").html("La OS de servicio es incorrecta, verifique.");
    $("#div_alert").show();

});

function comprobartabla() 
{
  	var vecesEachComprobar = 0, filasCorrectas = 0;
  	var bandera = 1;
  	var servicio = $("#servicio");
    
  	if(!$.trim($("#servicio").val()) || !$.trim($("#fechaInicial").val()) || !$.trim($("#fechaFinal").val()))
     	bandera = 0;
      	$(".editables").each(function() 
      	{
	        if($(this).find("input.cantidad").val() != '' && $(this).find("input.cantidad").val() != "0" && Math.floor($(this).find("input.cantidad").val()) == $(this).find("input.cantidad").val() && $.isNumeric($(this).find("input.cantidad").val()) && $(this).find("input.sumaPrecio").val() != '' && $(this).find("input.sumaPrecio").val() != "0")
	        {
	          filasCorrectas++;
	        }
          	vecesEachComprobar++;
      	});

  	if(filasCorrectas == vecesEachComprobar && bandera == 1)
    return true;
  	else
    return false;
}


$(document).on("keyup change", ".cantidad", function()
{
    var actual = parseFloat($(this).val());
    var precio = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
    var comision = parseFloat(($(this).closest('tr').attr('com')/100));
    var subtotal = 1 + comision;
    var max = parseFloat($(this).attr('max'));
    var sumaPT = 0;sumaC = 0; sumaT = 0;
      if(isNaN(precio))
        precio = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();

    if(tabla == "cot")
      if(actual > max || actual <= 0){
        $(this).val(max);
        actual =  parseFloat($(this).val());
      }
      $(this).closest("tr").find("td:eq(3)").html(formatoMoneda(actual * precio ,"$"));
        $(this).closest("tr").find("td:eq(4)").html(formatoMoneda(actual * precio * comision,"$"));
        $(this).closest("tr").find("td:eq(5)").html(formatoMoneda(actual * precio * subtotal,"$"));

    if(tabla == "pf"){
    var prueba = actual * precio * subtotal;
      if(prueba.toFixed(2) > max){
        $("#p_alert").html("Saldo disponible: " + formatoMoneda(max,"$"));
        $("#div_alert").show();
        $(this).val("");
        actual =  parseFloat($(this).val());
        $(this).closest("tr").find("td:eq(3)").html(formatoMoneda(0,"$"));
        $(this).closest("tr").find("td:eq(4)").html(formatoMoneda(0,"$"));
        $(this).closest("tr").find("td:eq(5)").html(formatoMoneda(0,"$"));
      }
    }

        $(".editables").each(function() {
          sumaPT += parseFloat($(this).find("td:eq(3)").html().replace("$","").replace(/,/g,""));
          sumaC += parseFloat($(this).find("td:eq(4)").html().replace("$","").replace(/,/g,""));
          sumaT += parseFloat($(this).find("td:eq(5)").html().replace("$","").replace(/,/g,""));
        });

        $("#sumaPT").html(formatoMoneda(sumaPT,"$"));
        $("#sumaC").html(formatoMoneda(sumaC,"$"));
        $("#sumaT").html(formatoMoneda(sumaT,"$"));
});



$(document).on('keyup change', "input.sumaPrecio", function() { 
  
    var actual = parseFloat($(this).val());
    var cantidad = parseFloat($(this).closest('tr').find('td:eq(0)').find("input.cantidad").val());
    var comision = parseFloat(($(this).closest('tr').attr('com')/100));
    var subtotal = 1 + comision;
    var max = parseFloat($(this).attr('max'));
        sumaPT = 0;sumaC = 0; sumaT = 0;
      $(this).closest('tr').find('td:eq(3)').html(formatoMoneda(actual * cantidad ,"$"));
      $(this).closest('tr').find('td:eq(4)').html(formatoMoneda(actual * cantidad * comision,"$"));
      $(this).closest('tr').find('td:eq(5)').html(formatoMoneda(actual * cantidad * subtotal,"$"));

      if(tabla == "pf"){
      var prueba = actual * cantidad * subtotal;
        if(prueba.toFixed(2) > max){
          $("#p_alert").html("Saldo disponible: " + formatoMoneda(max,"$"));
          $("#div_alert").show();
          $(this).val("");
          actual =  parseFloat($(this).val());
          $(this).closest("tr").find("td:eq(3)").html(formatoMoneda(0,"$"));
          $(this).closest("tr").find("td:eq(4)").html(formatoMoneda(0,"$"));
          $(this).closest("tr").find("td:eq(5)").html(formatoMoneda(0,"$"));
        }
      }


      $(".editables").each(function() {
        sumaPT += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,''));
        sumaC += parseFloat($(this).find('td:eq(4)').html().replace("$","").replace(/,/g,''));
        sumaT += parseFloat($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));
      });
      $("#sumaPT").html(formatoMoneda(sumaPT,"$"));
      $("#sumaC").html(formatoMoneda(sumaC,"$"));
      $("#sumaT").html(formatoMoneda(sumaT,"$"));
});

$(document).on("change", "#fechaInicial, #fechaFinal", function() { 
  

  var f = new Date();

  var mes = f.getMonth()+1;

  var dia = f.getDate();

  var hoy = f.getFullYear() + '-' + (mes<10 ? '0' : '') + mes + '-' + (dia<10 ? '0' : '') + dia;

  var fechaMinima;





  if(dia <= '5'){

          mes = mes - 1;

          dia = '1';

          fechaMinima = f.getFullYear() + '-' + (mes<'10' ? '0' : '') + mes + '-' + (dia<'10' ? '0' : '') + dia;

    }

    else{

          dia = '1';

          fechaMinima = f.getFullYear() + '-' + (mes<'10' ? '0' : '') + mes + '-' + (dia<'10' ? '0' : '') + dia;

    }



    if($("#fechaInicial").val() < fechaMinima){

      $("#fechaInicial").val(fechaMinima);

    }



    if($("#fechaFinal").val() < fechaMinima){

      $("#fechaFinal").val(fechaMinima);

    }



  if($("#fechaInicial").val() > $("#fechaFinal").val())

    $("#fechaFinal").val($("#fechaInicial").val());
});

$(document).on("click",".ejec",function()
{
  if($(this).val() == "ejecutandose")
  {
    $(".numPoliza").removeAttr("hidden");
    $(".btnGenerar").prop("disabled",true);
  }
  else
  {
    $(".numPoliza").attr("hidden","hidden");
    $(".btnGenerar").prop("disabled",false);
    $("#numPoliza").val("")
  }
});

$(document).on("keyup","#numPoliza",function()
{
  if(!$.trim($(this).val()))
  {
    $(".btnGenerar").prop("disabled",true);
  }
  else
  {
    $(".btnGenerar").prop("disabled",false);
  }

});

$(document).on("click","#asignarEjec",function()
{
  idOrden = $(this).val();
  $(".loader").fadeIn("slow", function(){
    $.ajax({
        data:{idOrden : idOrden,numeroPoliza:$("#numPoliza").val(),numeroFolio:$("#numFolio").val()},
        url:   'view/ordenesdeservicio/index.php?accion=numeroPoliza',
        type:  'post',
        success:  function (data) {
          modalOrden(idOrden);
        },
    });
  });
})

