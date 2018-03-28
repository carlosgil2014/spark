$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblHabilidades").DataTable();
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
    		$("#modalHabilidad").html(data);
    		$('#formAgregar').validator({focus:false});
    	},
	});
            $("#modalHabilidad").modal("show");
}



function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalHabilidad").html(data);
    		$('#formEditar').validator({focus:false});

    	},
	});
    $("#modalHabilidad").modal("show");
}

function eliminar(id, Habilidad){
	$("#habilidadEliminar").html(habilidad);
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