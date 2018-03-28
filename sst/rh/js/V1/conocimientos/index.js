$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblconocimientos").DataTable();
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
    		$("#modalConocimiento").html(data);
    		$('#formAgregar').validator({focus:false});
    	},
	});
            $("#modalConocimiento").modal("show");
}



function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalConocimiento").html(data);
    		$('#formEditar').validator({focus:false});

    	},
	});
    $("#modalConocimiento").modal("show");
}

function eliminar(id, conocimiento){
	$("#conocimientoEliminar").html(conocimiento);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{id: id},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index");
					else{
						window.location.replace("index.php?accion=index");
						//alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}