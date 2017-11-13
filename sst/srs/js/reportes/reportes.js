$(function()
{
	$(".ocultarCotizaciones").removeAttr("hidden");
	$("select.reporte").multiselect();
	$("select.reporte").multiselect("checkAll");
	$(".loader").fadeOut("slow");
	
});

$(document).on('change', "#fechaIn", function() 
{
    if($(this).val() > $('#fechaFin').val())
    {
      $('#fechaFin').val($(this).val());
    }
   
});

$(document).on('change', "#fechaFin", function() 
{
	if($(this).val() < $('#fechaIn').val())
	{
	  $(this).val($('#fechaIn').val());
	}

});

$("#IdcmbClientes").change(function()
{
	$(".grupoRadios").removeAttr("hidden");
});

function filtrar()
{
	$("#idTotal").val("");
	var campos = [];
	var cotRevision = null;
	var cotAutorizada = null;
	var cotRechazada = null;
	var cotCancelada = null;

	var ordenRevision = null;
	var ordenAutorizada = null;
	var ordenRechazada = null;
	var ordenCancelada = null;

	var prefacturaporFacturar = null;
	var prefacturaFacturada = null;
	var prefacturaCancelada = null;
	var prefacturaCerrada = null;

	var prefacturanoPagadas = null;
	var prefacturapParcialmente = null;
	var prefacturaPagadas = null;
	var prefacturaCanceladas = null;

	if($("#checkCotizacion").is(':checked'))
	{
		
		var reporteCot="Cotizacion";

		$(".ocultarCategorias").removeAttr("hidden");
		$(".ocultarCotizaciones").removeAttr("hidden","hidden");
		$("#IdBtnExportar").attr("class","btn btn-primary btn-sm");

		if($("#idCheckCotRevision").is(':checked'))
		{
			cotRevision = $("#idCheckCotRevision").val();
		}
		if($("#idCheckCotAutorizada").is(':checked'))
		{
			cotAutorizada = $("#idCheckCotAutorizada").val();
		}
		if($("#idCheckCotRechazada").is(':checked'))
		{
			cotRechazada = $("#idCheckCotRechazada").val();
		}
		if($("#idCheckCotCancelada").is(':checked'))
		{
			cotCancelada = $("#idCheckCotCancelada").val();
		}
	}
	else
	{
		$(".ocultarCotizaciones").attr("hidden","hidden");
		$("div.tipoPlanServicio").attr("hidden","hidden")
		reporteCot="";
	}

	if($("#checkoOrden").is(':checked'))
	{
		
		var reporteOrden="Ordenes";
		$(".ocultarCategorias").removeAttr("hidden");
		$(".ocultarOrdenes").removeAttr("hidden");
		$("#IdBtnExportar").attr("class","btn btn-success btn-sm");

		if($("#idCheckOrdenRevision").is(':checked'))
		{
			ordenRevision = $("#idCheckOrdenRevision").val();
			//console.log(ordenRevision);
		}
		if($("#idCheckOrdenAutorizadas").is(':checked'))
		{
			ordenAutorizada = $("#idCheckOrdenAutorizadas").val();
			//console.log(ordenAutorizada);
		}
		if($("#idCheckOrdenRechazadas").is(':checked'))
		{
			ordenRechazada = $("#idCheckOrdenRechazadas").val();
		}
		if($("#idCheckOrdenCanceladas").is(':checked'))
		{
			ordenCancelada = $("#idCheckOrdenCanceladas").val();
		}
	}
	else
	{
		$(".ocultarOrdenes").attr("hidden","hidden");
		$("div.tipoPlanServicio").attr("hidden","hidden")
		reporteOrden="";
	}

	if($("#checkPrefacturas").is(':checked'))
	{
		
		var reportePf="Prefacturas";

		$(".ocultarCategorias").removeAttr("hidden");
		$(".ocultarPrefacturas").removeAttr("hidden");
		$("#IdBtnExportar").attr("class","btn btn-warning btn-sm");

		if($("#idCheckPrefacturaporFacturar").is(':checked'))
		{
			prefacturaporFacturar = $("#idCheckPrefacturaporFacturar").val();
		}
		if($("#idCheckPrefacturaFacturada").is(':checked'))
		{
			prefacturaFacturada = $("#idCheckPrefacturaFacturada").val();
		}
		if($("#idCheckPrefacturaCancelada").is(':checked'))
		{
			prefacturaCancelada = $("#idCheckPrefacturaCancelada").val();
		}
		if($("#idCheckPrefacturaCerrada").is(':checked'))
		{
			prefacturaCerrada = $("#idCheckPrefacturaCerrada").val();
		}
	}
	else
	{
		$(".ocultarPrefacturas").attr("hidden","hidden");
		$("div.tipoPlanServicio").attr("hidden","hidden")
		reportePf="";
	}

	if($("#checkFacturas").is(':checked'))
	{
		
		var reporteF = "Facturas";

		$(".ocultarCategorias").removeAttr("hidden");
		$(".ocultarFacturas").removeAttr("hidden","hidden");
		$("#IdBtnExportar").attr("class","btn btn-danger btn-sm");

		if($("#idCheckPrefacturaPagadas").is(':checked'))
		{
			prefacturaPagadas = $("#idCheckPrefacturaPagadas").val();
			console.log(prefacturaPagadas);
		}
		if($("#idCheckPrefacturanoPagadas").is(':checked'))
		{
			prefacturanoPagadas = $("#idCheckPrefacturanoPagadas").val();
		}
		if($("#idCheckPrefacturapPagadas").is(':checked'))
		{
			prefacturapParcialmente = $("#idCheckPrefacturapPagadas").val();
		}
		if($("#idCheckPrefacturaCanceladas").is(':checked'))
		{
			prefacturaCanceladas = $("#idCheckPrefacturaCanceladas").val();
		}
	}
	else
	{
		$(".ocultarFacturas").attr("hidden","hidden");
		$("div.tipoPlanServicio").attr("hidden","hidden")
		reporteF = "";
	}

	if($("#checkCotizacion").is(':checked') || $("#checkoOrden").is(':checked') || $("#checkPrefacturas").is(':checked') || $("#checkFacturas").is(':checked'))
	{
		$("div.tipoPlanServicio").removeAttr("hidden");
		var idcliente = $("#IdcmbClientes").val();
		var fechaInicial = $("#fechaIn").val();
		var fechaFinal = $("#fechaFin").val();
		var tipoPLan=$("#IdcmbTipoPlan").val();
		var tipoServicio=$("#IdcmbTipoServicio").val();
		if(idcliente == null)
		{
			idcliente=[0];
		}
		//alert(cotRevision);
		if(cotRevision!=null || cotAutorizada!=null || cotRechazada!=null || cotCancelada!=null || ordenRevision!=null || ordenAutorizada!=null || ordenRechazada!=null || ordenCancelada!=null || prefacturaporFacturar!=null || prefacturaFacturada!=null || prefacturaCancelada!=null || prefacturaCerrada!=null || prefacturapParcialmente != null || prefacturaPagadas != null || prefacturanoPagadas!=null || prefacturaCanceladas!=null)
		{
			if($("#IdcmbTipoPlan").val()!= undefined && $("#IdcmbTipoServicio").val()!= undefined) 
			{
				var tipoPlan = $("#IdcmbTipoPlan").val();
				var tipoServicio = $("#IdcmbTipoServicio").val();
			}
			$.post("tablareportes.php",{ reporteCot:reporteCot,reporteOrden:reporteOrden,reportePf:reportePf,reporteF:reporteF,idcliente:idcliente,fechaInicial:fechaInicial,fechaFinal:fechaFinal,cotRevision:cotRevision,cotAutorizada:cotAutorizada,cotRechazada:cotRechazada,cotCancelada:cotCancelada,ordenRevision:ordenRevision,ordenAutorizada:ordenAutorizada,ordenRechazada:ordenRechazada,ordenCancelada:ordenCancelada,prefacturaporFacturar:prefacturaporFacturar,prefacturaFacturada:prefacturaFacturada,prefacturaCancelada:prefacturaCancelada,prefacturaCerrada:prefacturaCerrada,prefacturapParcialmente:prefacturapParcialmente, prefacturaPagadas:prefacturaPagadas, prefacturanoPagadas:prefacturanoPagadas, prefacturaCanceladas:prefacturaCanceladas,tipoPlan:tipoPlan,tipoServicio:tipoServicio },function(data){
			$("div.tablareportes").html(data);
				$('#idtabla').DataTable(
				{
		            responsive: true,
		            "order": [[ 1, "asc" ]],
		            columnDefs: [
				       { type: 'natural', targets: 1 }
				     ]
		            
		        });
		        var subTotalCot = $("#idSubTotal").val();
		        if(subTotalCot!=0.00 && $("#IdcmbTipoPlan").val()!= undefined && $("#IdcmbTipoServicio").val()!= undefined)
			    {
			    	$("#IdBtnExportar").removeAttr("style");
			    }
			    else
			    {
			    	$("#IdBtnExportar").attr("style","display:none;");
			    }
		        $("#idTotal").val("$ "+subTotalCot);
			});
		}
		else
		{
			$("div.tablareportes").html("");
			$("#IdBtnExportar").attr("style","display:none;");
		}
	}
	$(".campos").each(function()
	{
		if($(this).is(':checked'))
		campos.push($(this).val());
		
	});
	
	$("div.Campos").append('<input name="campos" value="'+campos+'" id="idCampos">');

}


$("#IdBtnExportar").on("click",function()
{
	var idCotizacion=[];
	var idOrdenes=[];
	var idPrefacturas=[];
	var idfacturas=[];
	var campos = [];
	$(".campos").each(function()
	{
		if($(this).is(':checked'))
		campos.push($(this).val());
		
	});
	// alert(campos)
	$("div.Campos").html('<input name="campos" value="'+campos+'" id="idCampos" hidden>');
	
	if($("#checkCotizacion").is(':checked') || $("#checkoOrden").is(':checked') || $("#checkPrefacturas").is(':checked') || $("#checkFacturas").is(':checked'))
	{
		
		$("#pleaseWaitDialog").modal("show");
		$("#idExportar").submit();
		
		$.ajax({
			type: "POST",
            url: "exportar.php",
            data: "tipoPLan="+$("#tipoPlan").val()+"&tipoServicio="+$("#tipoServicio").val()+"&idCot="+$("#idCot").val()+"&idOrdServicio="+$("#idOrd").val()+"&idpFactura="+$("#idPf").val()+"&idFactura="+$("#idFact").val()+"&campos="+campos,
            success: function(data) 
            {
            	if (data=="No existe") 
				{
					$("#pleaseWaitDialog").modal("hide");
					$( "#confirmacion" ).dialog(
		            {
		                resizable: false,
		                modal: true,
		                buttons: 
		                {
		                  'Cerrar': function() 
		                  {
		                      $(this).dialog('close');
		                  }
		                }

		            });
				}
				else
				{
             		$("#pleaseWaitDialog").modal("hide");  
             	}
            }
		});
	}

	
});
$(document).on("click",".campos",function() 
{
	tmp = $(this).is(":checked");
  	celda = $(this).closest("td").index();
  	campo = $(this).closest("td").index() +1;
  	if(tmp)
  	{
		$(this).closest("tr").find("td:eq("+celda+")").attr("class","info text-center");
		$(this).closest("tr").find("td:eq("+campo+")").attr("class","info text-center");
  	}
  	else
  	{
  		$(this).closest("tr").find("td:eq("+celda+")").attr("class","success text-center");
		$(this).closest("tr").find("td:eq("+campo+")").attr("class","success text-center");
  	}
});

