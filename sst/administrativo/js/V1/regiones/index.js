$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblRegiones").DataTable();
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
    		$("#modalRegion").html(data);
    		$('#formAgregar').validator({focus:false});
    	},
	});
            $("#modalRegion").modal("show");
}



function modificar(idRegion){
	$.ajax({
   	 	url:   'index.php?accion=modificar&idRegion='+idRegion,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalRegion").html(data);
    		$('#formEditar').validator({focus:false});

    	},
	});
    $("#modalRegion").modal("show");
}

function eliminar(idRegion, region){
	$("#regionEliminar").html(region);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idRegion: idRegion},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index");
					else{
						window.location.replace("index.php?accion=index");
					}
		        },
	        	
		    });
	    });
	});	
}