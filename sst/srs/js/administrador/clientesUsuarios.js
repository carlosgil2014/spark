$(document).on("click", ".checkCliente", function() {
	if($(this).prop("checked")==true)
		$(this).parents("td").attr("class","success");
	else
		$(this).parents("td").attr("class","danger");
});

$(document).on("click", "#btnGuardarClientes", function() {
	var idClientes = [],estados = [], idUsuario = $(this).attr("value");
	$("input[name=clientesCheck]").each(function () {
		idClientes.push($(this).attr("value"));
		if(this.checked)
			estados.push("1");
		else
			estados.push("0");
	});
	$(".loader").fadeIn("slow", function(){
		$.ajax({
			data: {idClientes:idClientes,estados:estados,idUsuario:idUsuario},
	        url:   '../../controller/crudAdministrador.php?accion=guardarClientesUsuario',
	        type:  'post',
	        success:  function (data) {
				$(".loader").fadeOut("fast");
	        },
	        error:function (data) {
	        	alert("Error");
	        	$(".loader").fadeOut("fast");
	        } 	
	    });
	});
});