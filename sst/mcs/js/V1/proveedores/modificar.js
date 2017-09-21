function eliminar(idProveedor, proveedor){
	$("#proveedorEliminar").html(proveedor);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idProveedor: idProveedor},
		        url:   'crudProveedores.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("crudProveedores.php?accion=index");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}