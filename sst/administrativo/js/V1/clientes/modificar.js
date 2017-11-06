function eliminar(idCliente, cliente){
	$("#clienteEliminar").html(cliente);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idCliente: idCliente},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}

var codigoExiste = "";
function codigoPostales(codigoPostal,tipo){
		var cp = $(codigoPostal).val();
	if (cp=="") {
		cp = $(codigoPostal).val('');
	}else{
		$.ajax({
   	 	url:   '../representantes/index.php?accion=buscar&cp='+cp,
	    	type:  'post',

	    success:  function (data) {
	    	data = JSON.parse(data)
	    	if (data==="error") {
	    		$('#mensaje').html('').removeClass('btn btn-danger').delay().hide();
	    		$('#mensaje').addClass('btn btn-danger').html('No existe el código postal '+cp).show(100).delay(5000).hide(200);
	    		$('#codigoPostal').val(codigoExiste);
	    	}else{
	    		if (tipo==="fisica") {
	    		$('#mensaje').html('').hide().removeClass('btn btn-danger');
	    		$('#idEstadoFisica').val(data.idEstado);
	    		$('#delegacionFisica').val(data.delegacion);
	    		$('#estadoFisica').val(data.estado);
	    		//$('#region').val(data.region);
	    		codigoExiste = data.cp;
	    		colonias = "";
				for (var i = 0; i < data.colonias.length; i++) {
            		colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
    			}
    			$('#coloniasFisica').html(colonias);
    			$('#coloniasFisica').selectpicker("refresh");
	    		}else if(tipo==="moral"){
	    		//$('#mensaje').html('').hide().removeClass('btn btn-danger');
	    		$('#idEstadoMoral').val(data.idEstado);
	    		$('#delegacionMoral').val(data.delegacion);
	    		console.log(data.delegacion);
	    		$('#estadoMoral').val(data.estado);
	    		//$('#region').val(data.region);
	    		codigoExiste = data.cp;
	    		colonias = "";
				for (var i = 0; i < data.colonias.length; i++) {
            		colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
            		console.log(data.colonias[i].asentamiento);
    			}
    			$('#coloniasMoral').html(colonias);
    			$('#coloniasMoral').selectpicker("refresh");

	    		}
	    	}
    	},
	});
	}	
}