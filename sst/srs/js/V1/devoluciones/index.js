var parametros = {
          style: 'btn-info  btn-flat btn-sm',
          size: '5',
          noneSelectedText: 'Seleccionar un cliente', 
          liveSearchPlaceholder:'Buscar',
          noneResultsText: '¡No existe el cliente buscado!',
          countSelectedText:'{0} Clientes seleccionados',
          actionsBox:true,
          selectAllText: 'Seleccionar todos',
          deselectAllText: 'Deseleccionar todos'
        }
var maximo;

$(document).ready(function(){
    $("#tblPrefacturas").DataTable();
    $("#clientes").selectpicker(parametros);
	$(".loader").fadeOut("fast");
});

function detalleConcepto(idPrefactura,idPfConcepto){
	$(".loader").fadeIn("slow", function()
  	{
  			$.ajax({
			data: {idPrefactura:idPrefactura, idPfConcepto : idPfConcepto},
	   	 	url:'../ordenesdeservicio/index.php?accion=modalDetalleConceptoPrefactura',
		    type:  'post',
		    success:  function (data) {
	    		$("#modalDevolucion").html(data);
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
			 	url:'index.php?accion=agregar',
		    type:  'post',
		    success:  function (data) {
		    	$("#modalDevolucion").html(data);
				(maximo != $("#maximo").val()) && (maximo = $("#maximo").val());
			},
		});
	});
    $("#modalDevolucion").modal("show");
	$(".loader").fadeOut("slow");
}

function validar(elemento){
	valTmp =  parseFloat($(elemento).val()).toFixed(2);
	maximo = parseFloat(maximo);
	(isNaN(valTmp)) ? $(elemento).val(maximo): $(elemento).val(valTmp);
	(valTmp > maximo) && $(elemento).val(maximo);
	(valTmp <= 0) && $(elemento).val(maximo);
	return true;
}

function guardar(idPrefactura, idPfConcepto, elemento){
	devolucion = $("#maximo");
	servicio = $("#servicio");
	if (typeof devolucion !== 'undefined' && devolucion !== null) {
		if(validar(devolucion) && $.trim(servicio.val()) && devolucion.val() > 0){
			$(".loader").fadeIn("slow", function()
  			{
				$.ajax({
					data: {devolucion: devolucion.val(), servicio: servicio.val(), idPrefactura:idPrefactura, idPfConcepto : idPfConcepto},
			   	 	url:'index.php?accion=guardar',
				    type:  'post',
				    success:  function (data) {
	    				$("#folio").html(data);
	    				$(elemento).hide();
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
