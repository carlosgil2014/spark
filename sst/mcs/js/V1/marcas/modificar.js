$(function () {
	variable = $("#div_alert");
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function eliminar(idMarca, Marca){
	$("#MarcaEliminar").html(Marca);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idMarca: idMarca},
		        url:   'crudMarcas.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("crudMarcas.php?accion=index");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}