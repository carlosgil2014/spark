function restablecer(num_empleado, rfc, correo, nombre){
	$("#empleadoModal").html(nombre);
	$("#rfcModal").html(rfc);
	$("#correoModal").html(correo);
		$("#modalRestablecer").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#restablecer", function (e) {
			
		    	$.ajax({
			        data:{num_empleado: num_empleado , rfc: rfc , correo: correo},
			        url:   '../controller/crudKiosco.php?accion=restablecer',
			        type:  'post',
			        success:  function (data) {
			        	if(data == "OK"){
			            window.location.replace("crudKiosco.php?accion=index");
						}else{
							alert(data);
						}
			        },
		        	
			    });
		});	
}

/*
function restablecer(num_empleado, rfc, correo, nombre){
	$("#empleadoModal").html(nombre);
	$("#rfcModal").html(rfc);
	$("#correoModal").html(correo);
	$("#modalRestablecer").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#restablecer", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{num_empleado: num_empleado , rfc: rfc , correo: correo},
		        url:   '../controller/crudKiosco.php?accion=restablecer',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK"){

		//window.location.replace("crudKiosco.php?accion=index");
					}else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}
*/