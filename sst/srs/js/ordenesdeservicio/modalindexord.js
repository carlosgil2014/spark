var tabla;
$(document).ready(function()
{
    $('[data-toggle="tooltip"]').tooltip(); 
});
$(document).on("click",".imgDetalleOrden",function()
{ 
	//alert();
    var idOrden=$(this).attr("value");
    $.post( "../controller/crudOrdenes.php?accion=modalIndexOrden",{  idOrden : idOrden },function(data)
    {
    	 
       	$("#IdModaldetalle").html(data);
       	$('[data-toggle="tooltip"]').tooltip();
    });
});

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
      	$.post( "../controller/crudOrdenes.php?accion=maximosConceptos",{idCotPfConcepto : idCotPfConcepto , tabla : tabla, idOrden : idOrden},function(data)
      	{ 
          //alert(data);
          if(tabla == "cot")
            celdaConcepto.html("<input type='number' class='form-control text-center cantidad tool' max = '"+data+"' value='"+texto+"' data-toggle='tooltip'  data-placement='bottom' title='Disponibles: "+data+"' />");
          else
            celdaConcepto.html("<input type='number' class='form-control text-center cantidad tool' max = '"+data+"' value='"+texto+"' data-toggle='tooltip'  data-placement='bottom' title='Saldo Disponible: "+formatoMoneda(parseFloat(data),"$")+"' />");  
          if(tipoPrecio == "0.00")
            celdaPrecio.html("<input type='number' class='form-control text-center sumaPrecio' max = '"+data+"' value='"+precio+"' />");            
          $('[data-toggle="tooltip"]').tooltip(); 
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
    $.post( "../controller/crudOrdenes.php?accion=actualizarOrden",{idOrden : idOrden , servicio : servicio, fechaInicial : fechaInicial, fechaFinal : fechaFinal, total : total},function(data)
    { 
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
         	$.post( "../controller/crudOrdenes.php?accion=actualizarOrdenConcepto",{datosConcepto : datosConcepto},function(data)
          	{ 

          	});
      	});
    });
  }
  else
    alert("Incorrecto");

});

function comprobartabla() 
{
  	var vecesEachComprobar = 0, filasCorrectas = 0;
  	var facturacion =  $('input[name="facturacion"]').val();
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
$(document).on('click', "button#autorizar", function() 
{ 
    idOrden = $(this).val();
    var fechaInicial = $("#fechaInicial").val();
    var fechaFinal = $("#fechaFinal").val();
     $.post( "../controller/crudPrincipal.php?accion=accionCotOrd",{idCotOrd : idOrden,estado : "Autorizada",motivo : "", tabla : "Ordenes",fechaInicial:fechaInicial,fechaFinal:fechaFinal},function(data)
    { 
        //alert(data.split("-"));
        $("#ord"+idOrden).html(data);
        //alert(imgClass[1]);
        $("#IdModaldetalle").modal("hide");
        $('[data-toggle="popover"]').popover(); 
    });
});

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
        alert("Saldo disponible: " + formatoMoneda(max,"$"));
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
          alert("Saldo disponible: " + formatoMoneda(max,"$"));
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



    if($("#fechaFinal']").val() < fechaMinima){

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

})
$(document).on("click","#asignarEjec",function()
{
  $.post("../controller/crudOrdenes.php?accion=numeroPoliza",{idOrden:$(this).val(),numeroPoliza:$("#numPoliza").val(),numeroFolio:$("#numFolio").val()},function(data)
  {
    $(".numPolizaActual").text(data);
    $(".numFolioActual").text("");
    //alert(data);
  });
})

