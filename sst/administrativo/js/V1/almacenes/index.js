$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblAlmacenes").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
			$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
			$("#modalAlmacen").html(data);
    		$('#formAgregar').validator({focus:false});

    		$("input[name=tipo]").click(function () {
    			if( $("#virtual").is(':checked')) {
    				$('#lol').hide();
                    $('#ubicacion').val('');
    				$('#ubicacion').prop("required", false);
    			 }else{
    			 	$('#lol').show();
    			 	$('#ubicacion').prop("required", true);
    			 }
    		});
    	},
	});
    $("#modalAlmacen").modal("show");
}

function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
	    	$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$("#modalAlmacen").html(data);
    		$('#formEditar').validator({focus:false});

    		var ubicacion = "";
    		$("input[name=tipo]").click(function () {
    			if( $("#virtual").is(':checked')) {
    				ubicacion = $('#ubicacion').val();
    				$('#ubicacion').val('');
    				$('#lol').hide();
    				$('#ubicacion').prop("required", false);
    			 }else{
    			 	$('#lol').show();
    			 	$('#ubicacion').prop("required", true);
    			 	$('#ubicacion').val(ubicacion);
    			 }
    		});
    	},
	});
    $("#modalAlmacen").modal("show");
}

function eliminar(id){
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{id: id},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index&clase=success");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}
