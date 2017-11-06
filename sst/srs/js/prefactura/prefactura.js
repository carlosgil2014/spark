var formPrefactura = $("#formPrefactura"), arrCotOs, arrCotOsCon,tipo, arrCantidades,arrConceptos,arrIdConceptos,arrPrecios,arrComisiones, arrSubtotales, arrTiposPlan, arrTiposServicio, servicio;
var activo, detalle, importeTotal, descuento;
$(document).ready(function(){
	activo = "cot";
	$( "#Cotizaciones" ).accordion({heightStyle: "content"});
    $( "ul.cotizaciones" ).each(function() {
    	var tam = $(this).find('li').length;
    		if(tam > 1)
    			$(this).prepend("<li><input type='checkbox' cot='"+$(this).attr("cot")+"' class='selTodo'> Seleccionar todo</li>");
	});

	$( "#Ordenes" ).accordion({heightStyle: "content"});
    $( "ul.ordenes" ).each(function() {
    	var tam = $(this).find('li').length;
    		if(tam > 1)
    			$(this).prepend("<li><input type='checkbox' os='"+$(this).attr("pf")+"' class='selTodoOs'> Seleccionar todo</li>");
	});

	$("#tablaConceptosPendientes").DataTable({
  		"columns": [
	    {"width": "10%"},
	    {"width": "10%"},
	    {"width": "15%"},
	    {"width": "15%"},
	    {"width": "15%"},
	    {"width": "5%"},
	    {"width": "10%"},
	    {"width": "8%"},
	    {"width": "10%"},
	    {"width": "6%"},
	    {"width": "8%"},
	    {"width": "1%"}
	  ],
	  "columnDefs": [
       { type: 'date-dd-mmm-yyyy', targets: 0 }
     ]
	});
	$(".loader").fadeOut("slow");
});

$(document).on("change", ".listaCotizaciones", function()
{
	formPrefactura.submit();
});

$(document).on("click", ".detalleConceptoCotizacion", function()
{
	$.post( "../controller/crudPrefacturas.php?accion=modalDetalleConceptoCotizacion",{idCotConcepto: $(this).attr("value"), idCotizacion: $(this).attr("cot")},function(data)
    {
        $("#datosConcepto").html(data);
    });
});

$(document).on("click", ".detalleConceptoOs", function()
{
	$.post( "../controller/crudPrefacturas.php?accion=modalDetalleConceptoOS",{idOsConcepto: $(this).attr("value"), idOrden: $(this).attr("os")},function(data)
    {
        $("#datosConcepto").html(data);
    });
});

$(document).on("click", ".selTodo", function()
{	
	var li = $(this).parent("li");
	var ul = li.parent("ul");
	var idCotizacion =  $(this).attr("cot");
	var txt = $("h2[cot='" + idCotizacion + "']");
		$("small[cot='" + idCotizacion + "']").hide();
		li.remove();
		ul.find("li").each(function (){
			$(this).find("input").remove();
			$("#Prefactura").append("<li>" + $(this).html() + " <img src='../img/imgEliminar.gif' class='eliminarConcepto'></li>");
			$(this).remove();
			if($("#Prefactura").find("li").length == 1){
				servicio = $("small[cot='" + idCotizacion + "']").html();
			}
		});
		txt.append("<label cot='"+idCotizacion+"''>Completado <img src='../img/imgOk.png'/></label>" );

});

$(document).on("click", ".selTodoOs", function()
{	
	var li = $(this).parent("li");
	var ul = li.parent("ul");
	var idOrden =  $(this).attr("os");
	var txt = $("h2[os='" + idOrden + "']");
		$("small[os='" + idOrden + "']").hide();
		li.remove();
		ul.find("li").each(function (){
			$(this).find("input").remove();
			$("#Prefactura").append("<li>" + $(this).html() + " <img src='../img/imgEliminar.gif' class='eliminarConceptoOs'></li>");
			$(this).remove();
			if($("#Prefactura").find("li").length == 1){
				servicio = $("small[os='" + idOrden + "']").html();
			}
		});
		txt.append("<label os='"+idOrden+"''>Completado <img src='../img/imgOk.png'/></label>" );

});

$(document).on("click", ".cotConcepto", function()
{
	var li = $(this).parent("li");
	var ul = li.parent("ul");
	var tam;
	var idCotizacion =  $(this).attr("cot");
	var txt = $("h2[cot='" + idCotizacion + "']");
		$(this).remove();
		$("#Prefactura").append("<li>" + li.html() + " <img src='../img/imgEliminar.gif' class='eliminarConcepto'></li>");
		li.remove();
		tam = ul.find("li").length;
		if(tam == 2)
			ul.find("input.selTodo").parent("li").remove();
		if(tam == 0){
			$("small[cot='" + idCotizacion + "']").hide();
			txt.append("<label cot='"+idCotizacion+"''>Completado <img src='../img/imgOk.png'/></label>" );
		}
		if($("#Prefactura").find("li").length == 1){
			servicio = $("small[cot='" + idCotizacion + "']").html();
		}
		
});

$(document).on("click", ".osConcepto", function()
{
	var li = $(this).parent("li");
	var ul = li.parent("ul");
	var tam;
	var idOrden =  $(this).attr("os");
	var txt = $("h2[os='" + idOrden + "']");
		$(this).remove();
		$("#Prefactura").append("<li>" + li.html() + " <img src='../img/imgEliminar.gif' class='eliminarConceptoOs'></li>");
		li.remove();
		tam = ul.find("li").length;
		if(tam == 2)
			ul.find("input.selTodoOs").parent("li").remove();
		if(tam == 0){
			$("small[os='" + idOrden + "']").hide();
			txt.append("<label os='"+idOrden+"''>Completado <img src='../img/imgOk.png'/></label>" );
		}
		if($("#Prefactura").find("li").length == 1){
			servicio = $("small[os='" + idOrden + "']").html();
		}
		
});

$(document).on("click", ".eliminarConcepto", function()
{
	var li = $(this).parent("li");
	var idCotizacion = li.find("a").attr("cot");
	var idCotConcepto = li.find("a").attr("value");
	var ul = $("ul[cot='" + idCotizacion + "']");
	var tam;
	var x = li;
		x.find("img").remove();
		li.remove();
		ul.append("<li><input type='checkbox' class = 'cotConcepto' value='"+idCotConcepto+"' cot = '"+idCotizacion+"'>" + x.html() + "</li>");
		tam = ul.find("li").length;
		if(tam == 2)
    		ul.prepend("<li><input type='checkbox' cot='"+idCotizacion+"' class='selTodo'> Seleccionar todo</li>");
    	if(tam == 1){
    		$("small[cot='" + idCotizacion + "']").show();
    		$("label[cot='" + idCotizacion + "']").remove();
    	}
    	if($("#Prefactura").find("li").length == 0)
			servicio = '';

});

$(document).on("click", ".eliminarConceptoOs", function()
{
	var li = $(this).parent("li");
	var idOrden = li.find("a").attr("os");
	var idOsConcepto = li.find("a").attr("value");
	var ul = $("ul[os='" + idOrden + "']");
	var tam;
	var x = li;
		x.find("img").remove();
		li.remove();
		ul.append("<li><input type='checkbox' class = 'osConcepto' value='"+idOsConcepto+"' cot = '"+idOrden+"'>" + x.html() + "</li>");
		tam = ul.find("li").length;
		if(tam == 2)
    		ul.prepend("<li><input type='checkbox' cot='"+idOrden+"' class='selTodoOs'> Seleccionar todo</li>");
    	if(tam == 1){
    		$("small[os='" + idOrden + "']").show();
    		$("label[os='" + idOrden + "']").remove();
    	}
    	if($("#Prefactura").find("li").length == 0)
			servicio = '';

});

$(document).on("click", ".modalDetallePrefactura", function()
{
	if($("#Prefactura").find("li").length != 0){
		detalle = $(this).attr("tipo");
		tipo = [];
		arrCotOs = [];
		arrCotOsCon = [];
		idCliente = $("[name='Datos[idCliente]']").val();
		fechaInicial = $("[name='Datos[fechaInicial]']").val();
		fechaFinal = $("[name='Datos[fechaFinal]']").val();


		$("#Prefactura").find("li").each(function (){
			if($(this).find("a").attr("cot") != undefined){
				arrCotOs.push($(this).find("a").attr("cot"));
				tipo.push("cot");
			}
			else
			{
				arrCotOs.push($(this).find("a").attr("os"));
				tipo.push("os");
			}
			arrCotOsCon.push($(this).find("a").attr("value"));

		});

		$.post( "../controller/crudPrefacturas.php?accion=modalDetallePrefactura",{arrCotOs : arrCotOs, arrCotOsCon : arrCotOsCon, tipo : tipo, detalle : detalle, idCliente : idCliente, fechaInicial: fechaInicial, fechaFinal: fechaFinal},function(data)
	    {
	        $("#datosPrefactura").html(data);
	    	$('[data-toggle="tooltip"]').tooltip(); 
			$("#IdmodalDetallePrefactura").modal("show");
	    });
	}
	else{
    	$( "#aviso" ).dialog({
            resizable: false,
            modal: true,
            buttons: 
            {
	            'OK': function() 
	            {
	                $(this).dialog('close');
	            }
            }
      	});
	}
});

$("#IdmodalDetallePrefactura").on('show.bs.modal', function () {
	importeTotal = parseFloat($("#importe").val().replace(/,/g,''));
});

$(document).on("click",".modalDetallePorFacturar",function()
{
	if($("#osPorFacturar").find("tr").length != 0)
	{
		opcion = $(this).val();
		detalle = "cd";
		tipo = [];
		arrCotOs = [];
		arrCotOsCon = [];
		idCliente = $("[name='Datos[idCliente]']").val();
		fechaInicial = $("[name='Datos[fechaInicial]']").val();
		fechaFinal = $("[name='Datos[fechaFinal]']").val();
		$(":checked[name='Datos[concepto]']").each(function()
		{
			arrCotOs.push($(this).attr("idOrden"));
			arrCotOsCon.push($(this).val());
			tipo.push("os");
		});
		if(arrCotOs.length > 0)
		{
			$(".loader").fadeIn("slow", function()
  			{
				$.ajax(
				{
					type: "POST",
	            	url: "../controller/crudPrefacturas.php?accion=modalDetallePrefactura",
	            	data: {arrCotOs : arrCotOs, arrCotOsCon : arrCotOsCon, tipo : tipo, detalle : detalle, idCliente : idCliente, fechaInicial: fechaInicial, fechaFinal: fechaFinal,opcion:opcion},
	            	success: function(data) 
			        {
			        	$(".loader").fadeOut("fast");
			        	$("#datosPrefactura").html(data);
			    		$('[data-toggle="tooltip"]').tooltip(); 
						$("#IdmodalDetallePrefactura").modal("show");
						$("#btnGuardar").attr("id","btnGuardarOs");
			        }
				});
			});
		}
		else
		{
			$("#aviso").html(opcion == "Prefacturar" ? "<p><span class='glyphicon glyphicon-warning-sign' style='float:left; margin:0 7px 50px ;'></span>La prefactura no puede estar vacía.</p>" : "<p><span class='glyphicon glyphicon-warning-sign' style='float:left; margin:0 7px 50px ;'></span>La conciliación no puede estar vacía.</p>");
			$( "#aviso" ).dialog(
			{
	            resizable: false,
	            modal: true,
	            buttons: 
	            {
		            'OK': function() 
		            {
		                $(this).dialog('close');
		            }
	            }
      		});
		}

		
	}
});

$(document).on("click","#btnGuardarOs",function()
{
	var bandera = 1, idCliente, fechaInicial, fechaFinal, Datos = {}, arrCantidades = [],arrConceptos = [], arrIdConceptos = [],arrPrecios = [],arrComisiones = [], arrSubtotales = [], arrTiposPlan = [], arrTiposServicio = []; 
    var descuento = ($("#descuento").length > 0 ?  parseFloat($("#descuento").val()):0);

		if(descuento > 0)
			if(!$.trim($("[name='Datos[motivo]']").val()))//Comprobar que todos los datos solicitados sean correctos. 
				bandera = 0;
		$(".editables").each(function() {
	        if($(this).find("input.cantidad").val() == ''  || $(this).find("input.cantidad").val() <= 0  || Math.floor($(this).find("input.cantidad").val()) != $(this).find("input.cantidad").val() || !$.isNumeric($(this).find("input.cantidad").val()) || $(this).find("input.sumaPrecio").val() == '' || $(this).find("input.sumaPrecio").val() == "0")
	        	bandera = 0;
      	});
		if(bandera == 0){
			$("#IdmodalDetallePrefactura").modal("hide");
			$( "#error" ).dialog({
	            resizable: false,
	            modal: true,
	            buttons: 
	            {
		            'OK': function() {
		                $(this).dialog('close');
						$("#IdmodalDetallePrefactura").modal("show");
		            }
		        },
	            close: function(){
	                $(this).dialog('close');
					$("#IdmodalDetallePrefactura").modal("show");
	            }
	      	});
		}

		else
			if(bandera == 1)
			{
				idCliente = $("[name='Datos[idCliente]']").val();
				idClientePrefactura = $("[name='Datos[idClientePrefactura]']").val();
				tipoPrefactura = detalle;
				detalle = $.trim($("[name='Datos[detalle]']").val());
				motivo = $.trim($("[name='Datos[motivo]']").val());
    			descuento = parseFloat($("#descuento").val());
				
			$(".editables").each(function() {
				arrCantidades.push($(this).find("input.cantidad").val());
				arrIdConceptos.push($(this).attr("idcon"));
				arrConceptos.push($(this).find('td:eq(1)').html());
        		precio = $(this).find("td:eq(2)").find("input.sumaPrecio").val();
      			if(precio == undefined)
					precio = $.trim($(this).find('td:eq(2)').html().replace("$","").replace(/,/g,''));
				arrPrecios.push(precio);
				arrComisiones.push($(this).attr("com"));
				arrSubtotales.push($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));
				arrTiposPlan.push($(this).attr("tp"));
				arrTiposServicio.push($(this).attr("ts"));
			});
				$.each( arrCotOsCon, function( key, value ) 
				{
				  	$("#"+value).remove();
				});
				Datos["opcion"] = $(this).attr("opcion");
				Datos["idCliente"] = idCliente;
				Datos["idClientePrefactura"] = idClientePrefactura;
				Datos["tipoPrefactura"] = tipoPrefactura;
				Datos["detalle"] = detalle;  
				Datos["idcotos"] = arrCotOs;
				Datos["idcotosconceptos"] = arrCotOsCon;
				Datos["tiposarrCotOsCon"] = tipo;
				Datos["cantidad"] = arrCantidades;
				Datos["idconceptos"] = arrIdConceptos; 
				Datos["conceptos"] = arrConceptos; 
				Datos["precios"] = arrPrecios; 
				Datos["comisiones"] = arrComisiones;
				Datos["subtotales"] = arrSubtotales; 
				Datos["tiposPlan"] = arrTiposPlan; 
				Datos["tiposServicio"] = arrTiposServicio; 
				if(descuento > 0 && !isNaN(descuento))
				{
					Datos["descuento"] = descuento;
				}
				else
				{
					descuento = 0.00;
					Datos["descuento"] = descuento;
				}
				Datos["motivo"] = motivo;
				Datos["importe"] = $("#sumaT").html().replace("$","").replace(/,/g,'');
				$(".loader").fadeIn("slow", function()
				{
					$.ajax(
					{
						data:{Datos:Datos},
				        url:   '../controller/crudPrefacturas.php?accion=guardarPrefactura',
				        type:  'post',
				        success:  function (data) 
				        {
				        	$(".loader").fadeOut("fast");
				        	if(Datos["opcion"] == "Conciliar")
				        	{
				        		$("#folioConciliacion").html("<p><span class='glyphicon glyphicon-warning-sign' style='float:left; margin:0 7px 50px ;'></span>"+data+"</p>");
				        		$( "#folioConciliacion" ).dialog(
					        	{
						            resizable: false,
						            modal: true,
						            buttons: 
						            {
							            'OK': function() 
							            {
							            	$(this).dialog('close');
							            	$(".loader").fadeIn("slow",function()
							            	{
							            		window.location.reload();
							            	});
							                
							            }
						            }
						      	});
				        	}
				        	else
				        	{	
				        		$("#folioPrefactura").html("<p><span class='glyphicon glyphicon-warning-sign' style='float:left; margin:0 7px 50px ;'></span>"+data+"</p>");
					        	$( "#folioPrefactura" ).dialog(
					        	{
						            resizable: false,
						            modal: true,
						            buttons: 
						            {
							            'OK': function() 
							            {
							            	$(this).dialog('close');
							            	$(".loader").fadeIn("slow",function()
							            	{
							            		window.location.reload();
							            	});
							                
							            }
						            }
						      	});
					        }
							$("#IdmodalDetallePrefactura").modal("hide");
				        }
					});
				});
			}
});

$(document).on("keyup change", ".cantidad", function()
{
	var actual = parseFloat($(this).val());
    var precio = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
    var comision = parseFloat(($(this).closest('tr').attr('com')/100));
    var subtotal = 1 + comision;
    var max = parseFloat($(this).closest('tr').attr('dis'));
    var sumaPT = 0;sumaC = 0; sumaT = 0;
      if(isNaN(precio))
        precio = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();

    if(actual > max || actual == 0){
    	$(this).val(max);
    	actual =  parseFloat($(this).val());
    }
    	$(this).closest("tr").find("td:eq(3)").html(formatoMoneda(actual * precio ,"$"));
      	$(this).closest("tr").find("td:eq(4)").find("a").html(formatoMoneda(actual * precio * comision,"$"));
      	$(this).closest("tr").find("td:eq(5)").html(formatoMoneda(actual * precio * subtotal,"$"));

      	$(".editables").each(function() {
	        sumaPT += parseFloat($(this).find("td:eq(3)").html().replace("$","").replace(/,/g,""));
	        sumaC += parseFloat($(this).find("td:eq(4)").find("a").html().replace("$","").replace(/,/g,""));
	        sumaT += parseFloat($(this).find("td:eq(5)").html().replace("$","").replace(/,/g,""));
      	});

      	$("#sumaPT").html(formatoMoneda(sumaPT,"$"));
      	$("#sumaC").html(formatoMoneda(sumaC,"$"));
      	$("#sumaT").html(formatoMoneda(sumaT,"$"));
      	importeTotal = sumaT;
});

$(document).on('keyup change', "input.sumaPrecio", function() { 
  
    var actual = parseFloat($(this).val());
    var cantidad = parseFloat($(this).closest('tr').find('td:eq(0)').find("input.cantidad").val());
    var comision = parseFloat(($(this).closest('tr').attr('com')/100));
    var subtotal = 1 + comision;
        sumaPT = 0;sumaC = 0; sumaT = 0;
      $(this).closest('tr').find('td:eq(3)').html(formatoMoneda(actual * cantidad ,"$"));
      $(this).closest('tr').find('td:eq(4)').find("a").html(formatoMoneda(actual * cantidad * comision,"$"));
      $(this).closest('tr').find('td:eq(5)').html(formatoMoneda(actual * cantidad * subtotal,"$"));
      $(".editables").each(function() {
        sumaPT += parseFloat($(this).find('td:eq(3)').html().replace("$","").replace(/,/g,''));
        sumaC += parseFloat($(this).find('td:eq(4)').find("a").html().replace("$","").replace(/,/g,''));
        sumaT += parseFloat($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));
      });
      $("#sumaPT").html(formatoMoneda(sumaPT,"$"));
      $("#sumaC").html(formatoMoneda(sumaC,"$"));
      $("#sumaT").html(formatoMoneda(sumaT,"$"));
      	importeTotal = sumaT;
});

$(document).on('keyup change', "input#descuento", function() { 
    descuento = parseFloat($(this).val());
    var resta;
    	if(!isNaN(descuento) && !isNaN(importeTotal))
    	{
    		if(descuento > 0)
    			$(".motivo").attr("hidden",false);
    		else{
    			$(".motivo").attr("hidden",true);
    			$("[name='Datos[motivo]']").val("");
    		}
    		resta = importeTotal - descuento;
      		$("#sumaT").html(formatoMoneda(resta,"$"));
      	}
      	else{ 
      		$("#sumaT").html(formatoMoneda(importeTotal,"$"));
    		$(".motivo").attr("hidden",true);
    		$("[name='Datos[motivo]']").val("");
      	}
});

$(document).on("click", "#btnGuardar", function()
{
	var bandera = 1, idCliente, fechaInicial, fechaFinal, Datos = {}, arrCantidades = [],arrConceptos = [], arrIdConceptos = [],arrPrecios = [],arrComisiones = [], arrSubtotales = [], arrTiposPlan = [], arrTiposServicio = []; 
    var descuento = parseFloat($("#descuento").val());
		if(detalle == "sd")
			if(!$.trim($("[name='Datos[detalle]']").val()))//Comprobar que todos los datos solicitados sean correctos. 
				bandera = 0;
		if(descuento > 0)
			if(!$.trim($("[name='Datos[motivo]']").val()))//Comprobar que todos los datos solicitados sean correctos. 
				bandera = 0;
		$(".editables").each(function() {
	        if($(this).find("input.cantidad").val() == ''  || $(this).find("input.cantidad").val() <= 0  || Math.floor($(this).find("input.cantidad").val()) != $(this).find("input.cantidad").val() || !$.isNumeric($(this).find("input.cantidad").val()) || $(this).find("input.sumaPrecio").val() == '' || $(this).find("input.sumaPrecio").val() == "0")
	        	bandera = 0;
      	});
		if(bandera == 0){
			$("#IdmodalDetallePrefactura").modal("hide");
			$( "#error" ).dialog({
	            resizable: false,
	            modal: true,
	            buttons: 
	            {
		            'OK': function() {
		                $(this).dialog('close');
						$("#IdmodalDetallePrefactura").modal("show");
		            }
		        },
	            close: function(){
	                $(this).dialog('close');
					$("#IdmodalDetallePrefactura").modal("show");
	            }
	      	});
		}

		else
			if(bandera == 1)
			{
				idCliente = $("[name='Datos[idCliente]']").val();
				idClientePrefactura = $("[name='Datos[idClientePrefactura]']").val();
				tipoPrefactura = detalle;
				detalle = $.trim($("[name='Datos[detalle]']").val());
				motivo = $.trim($("[name='Datos[motivo]']").val());
    			descuento = parseFloat($("#descuento").val());
				
			$(".editables").each(function() {
				arrCantidades.push($(this).find("input.cantidad").val());
				arrIdConceptos.push($(this).attr("idcon"));
				arrConceptos.push($(this).find('td:eq(1)').html());
        		precio = $(this).find("td:eq(2)").find("input.sumaPrecio").val();
      			if(precio == undefined)
					precio = $.trim($(this).find('td:eq(2)').html().replace("$","").replace(/,/g,''));
				arrPrecios.push(precio);
				arrComisiones.push($(this).attr("com"));
				arrSubtotales.push($(this).find('td:eq(5)').html().replace("$","").replace(/,/g,''));
				arrTiposPlan.push($(this).attr("tp"));
				arrTiposServicio.push($(this).attr("ts"));
			});
			
				Datos["idCliente"] = idCliente;
				Datos["idClientePrefactura"] = idClientePrefactura;
				Datos["tipoPrefactura"] = tipoPrefactura;
				Datos["detalle"] = detalle;  
				Datos["idcotos"] = arrCotOs;
				Datos["idcotosconceptos"] = arrCotOsCon;
				Datos["tiposarrCotOsCon"] = tipo;
				Datos["cantidad"] = arrCantidades;
				Datos["idconceptos"] = arrIdConceptos; 
				Datos["conceptos"] = arrConceptos; 
				Datos["precios"] = arrPrecios; 
				Datos["comisiones"] = arrComisiones;
				Datos["subtotales"] = arrSubtotales; 
				Datos["tiposPlan"] = arrTiposPlan; 
				Datos["tiposServicio"] = arrTiposServicio; 
				if(descuento > 0 && !isNaN(descuento))
				{
					Datos["descuento"] = descuento;
				}
				else
				{
					descuento = 0.00;
					Datos["descuento"] = descuento;
				}
				Datos["motivo"] = motivo;
				Datos["importe"] = $("#sumaT").html().replace("$","").replace(/,/g,''); 
				$.post( "../controller/crudPrefacturas.php?accion=guardarPrefactura",{ Datos : Datos },function(data)
			    {
			        $("#folioPrefactura").html(data); 
					$("#IdmodalDetallePrefactura").modal("hide");
			    });
			}
});

function formatoMoneda(n, simbolo) {
    return simbolo + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
} 
$(document).on("click",".seldes",function()
{
	($(this).attr("value") == 0 ? $("[name='Datos[concepto]']").each(function(){$(this).prop("checked",true)}) : $("[name='Datos[concepto]']").each(function(){$(this).attr("checked",false)}))
})
$(document).on("keypress",".cantidad",function(e)
{
 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
    	return false;
}) 