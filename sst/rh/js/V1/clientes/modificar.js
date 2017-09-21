function eliminar(idCliente, cliente){
	$("#clienteEliminar").html(cliente);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idCliente: idCliente},
		        url:   'crudClientes.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("crudClientes.php?accion=index");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}