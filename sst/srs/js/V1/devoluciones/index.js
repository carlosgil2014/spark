var maximo;
$(document).ready(function(){
    $("#tblPrefacturas").DataTable();
	$(".loader").fadeOut("fast");
});

function saldoAnticipado(){
	$("#formDevolucion").submit();
};

function detalleConcepto(idPrefactura,idPfConcepto){
	$(".loader").fadeIn("slow", function()
  	{
  			$.ajax({
			data: {idPrefactura:idPrefactura, idPfConcepto : idPfConcepto},
	   	 	url:'../controller/crudOrdenes.php?accion=modalDetalleConceptoPrefactura',
		    type:  'post',
		    success:  function (data) {
	    		$("#datosConcepto").html(data);
	    	},
		});
	});
    $("#modalDevolucion").modal("show");
	$(".loader").fadeOut("slow");
}

function agregar(idPrefactura,idPfConcepto, maximoTmp){
	maximo = parseFloat(maximoTmp.toFixed(2));
	$(".loader").fadeIn("slow", function()
  	{
		$.ajax({
			data: {idPrefactura:idPrefactura, idPfConcepto : idPfConcepto},
			 	url:'../controller/crudDevoluciones.php?accion=agregar',
		    type:  'post',
		    success:  function (data) {
				$("#datosConcepto").html(data);
				(maximo != $("#maximo").val()) && (maximo = $("#maximo").val());
			},
		});
	});
    $("#modalDevolucion").modal("show");
	$(".loader").fadeOut("slow");
}

function validar(elemento){
	valTmp =  parseFloat($(elemento).val()).toFixed(2);
	(isNaN(valTmp)) ? $(elemento).val(maximo): $(elemento).val(valTmp);
	(valTmp > maximo) && $(elemento).val(maximo);
	(valTmp <= 0) && $(elemento).val(maximo);
	return true;
}

function guardar(idPrefactura, idPfConcepto){
	devolucion = $("#maximo");
	servicio = $("#servicio");
	if (typeof devolucion !== 'undefined' && devolucion !== null) {
		if(validar(devolucion) && $.trim(servicio.val()) && devolucion.val > 0){
			$(".loader").fadeIn("slow", function()
  			{
				$.ajax({
					data: {devolucion: devolucion.val(), servicio: servicio.val(), idPrefactura:idPrefactura, idPfConcepto : idPfConcepto},
			   	 	url:'../controller/crudDevoluciones.php?accion=guardar',
				    type:  'post',
				    success:  function (data) {
			    		$("#datosConcepto").html(data);
			    	},
				});
				$(".loader").fadeOut("slow");
			});
		}
		else{
			$("#div_alert").css("display", "block");
			$("#p_alert").html("La devolución es incorrecta.");
		}
	}
}
