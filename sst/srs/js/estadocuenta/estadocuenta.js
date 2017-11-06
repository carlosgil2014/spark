// $("#IdcmbClientes").change(function()
// {
// 	$(".grupoRadios").removeAttr("hidden");
// });
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

function filtrar()
{
	// var clientes=[];
	// clientes.push($(this).val());
	var idcliente = $("#IdcmbClientes").val();
	//alert(idcliente);
	var fechaInicial = $("#fechaIn").val();
	var fechaFinal = $("#fechaFin").val();
	//console.log(fechaInicial,fechaFinal,idcliente);
	if(idcliente == null)
	{
		$("#IdcmbClientes").focus();
		idcliente=[0];
	}

	if(idcliente != null || fechaInicial!= null || fechaFinal != null)
	{
		$.post("tablacuentaestado.php",{ idcliente:idcliente,fechaInicial:fechaInicial,fechaFinal:fechaFinal},function(data)
		{
			$("div.tablareportes").html(data);
			var facturapPagada=parseFloat($('#idtabla tr:eq(5) td:eq(4)').text().replace(/[$,]/g,''));
			var saldoActual=facturapPagada+parseFloat($("#monto5").val().replace(/[,]/g,''));
			$("#idlblSaldoActual").text("$ "+saldoActual.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
			var saldodeudor=parseFloat($("#monto3").val().replace(/[,]/g,''));
			$("#idlblSaldoDeudor").text("$ "+saldodeudor.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
			$("#tablaSaldos").removeClass("hidden");
			//alert(data);
		});
	}
}
$(document).on("click",".radioModalDetalle",function()
{
	// var nombreDetalle=$(this).val();
	var arrayIds=$(this).parents("tr").find("td:eq(1)").text();
	var categoria=$(this).parents("tr").find("td:eq(2)").text();
	$("#idLabelTituloModal").text("Total de : "+categoria);
	var fechaIn = $("#fechaIn").val().split("-");
	fechaIn.reverse();
	var fechaFin = $("#fechaFin").val().split("-");
	fechaFin.reverse();
	$("#idSmallFecha").text("De : "+fechaIn.join("-")+" Hasta: "+fechaFin.join("-"));
	//alert(categoria);
	$.post("modalestadocuenta.php",{arrayIds:arrayIds,categoria:categoria},function(data)
	{
		$("#IdModaldetalle").html(data);
		$("#idEstadoCuenta").accordion(
		{
			heightStyle:"content"
		});
    	$('[data-toggle="tooltip"]').tooltip(); 
	});
	  //$('[data-toggle="tooltip"]').tooltip(); 
});
 $(document).ready(function() {
      $("select.cliente").multiselect(); 
       
    });