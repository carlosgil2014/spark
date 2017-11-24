var divTablaPrincipal = $("#activo"),modalContent = $("#modalContent");
$(document).ready(function() {
    $(".loader").fadeOut("slow");
} );

$(document).on("click", "#usuarios", function() {
	$(".loader").fadeIn("slow", function(){
		$.ajax({
	        url:   '../../controller/crudAdministrador.php?accion=cargarUsuarios',
	        type:  'post',
	        success:  function (data) {
	        divTablaPrincipal.html(data);
            tabla = $("#tablaUsuarios").DataTable(
              {
                responsive: true,
                columnDefs: [{ type: 'natural', targets: '_all' }]
              });
				$(".loader").fadeOut("fast");
	        },
	        error:function (data) {
	        	alert("Error");
	        	$(".loader").fadeOut("fast");
	        } 	
	    });
	});
});

$(document).on("click", ".clientes", function() {
	var idUsuario =  $(this).val();
	$(".loader").fadeIn("slow", function(){
		$.ajax({
			data: {idUsuario:idUsuario},
	        url:   '../../controller/crudAdministrador.php?accion=listarClientesUsuario',
	        type:  'post',
	        success:  function (data) {
	        modalContent.html(data);   
			$(".loader").fadeOut("fast");
	        },
	        error:function (data) {
	        	alert("Error");
	        	$(".loader").fadeOut("fast");
	        } 	
	    });
	});
});
