var parametros = {
					style: 'btn-success btn-sm',
					size: 3,
					noneSelectedText: 'Seleccionar un elemento', 
					liveSearchPlaceholder:'Buscar',
					noneResultsText: '¡No existe el elemento buscado!',
					countSelectedText:'{0} elementos seleccionados',
					actionsBox:true,
					selectAllText: 'Seleccionar todos',
					deselectAllText: 'Deseleccionar todos',
					container:'body'
				}
$(function () {
	variable = $("#div_alert");
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    $('.selectpicker').selectpicker(parametros);
});

function rubrosCliente(cliente){

	$(".loader").fadeIn("slow", function(){
		$.ajax({
	   	 	url: 'index.php?accion=rubrosCliente&idCliente='+cliente.value,
		    	type:  'post',
		    success:  function (data) {
	    		$("#divDetalles").html(data);
	    		$('#formAgregar').validator({focus:false});
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("slow");
	    	},
		});
	});
}

function agregarFila(){  
	$("#tablaDetalles").append("<tr>"+$("#filaPrincipal").html()+"<td><a style='cursor:pointer;' data-toggle='tooltip' onclick='eliminarFila(this);''><i class='fa fa-minus text-red'></i></a></td></tr>");  
    $("#tablaDetalles tr:last").find('.bootstrap-select').replaceWith(function() { return $('select', this); });
	$('.selectpicker').selectpicker(parametros);  
}

function eliminarFila(elemento){ 
	$(elemento).closest('tr').remove();  
}