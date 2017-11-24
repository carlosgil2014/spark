$(function () {
	variable = $("#div_alert");
 // alert(variable);
    $("#tblSalarios").DataTable();
	$(".loader").fadeOut("slow"); 
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    $('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});

	
});
	
function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalSalario").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formAgregar').validator({focus:false});
    	},
	});
    $("#modalSalario").modal("show");
}


function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalSalario").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formEditar').validator({focus:false});
    	},
	});
    $("#modalSalario").modal("show");
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

