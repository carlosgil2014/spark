$(function () {
	variable = $("#div_alert");
    $("#tblUsuarios").DataTable();
	if (variable.length > 0) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    $(".loader").fadeOut("slow");
});

function permisos(usuario){
	if ($(".divPermisos").length > 0) { $(".divPermisos").remove();}
	cerrar("div_alert_modal");
	$(".loader").fadeIn("fast", function(){
		$.ajax({
			data:{usuario : usuario},
	   	 	url: 'index.php?accion=permisos',
		    type:  'post',
		    success:  function (data) {
    			$("#modalDivPermisos").append(data);
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {

		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
    	$("#modalPermisos").modal("show");
	});
}

function cambiarPermiso(elemento, usuario, valor, clase){ 
	icono = $("#elemento").find("i");
	$(".loader").fadeIn("fast", function(){
		$.ajax({
			data:{usuario : usuario, valor : valor, clase : clase},
	   	 	url: 'index.php?accion=cambiarPermiso',
		    type:  'post',
		    success:  function (data) {
		    	icono.attr("class", "fa fa-toggle-"+clase); 
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {

		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
	});
}