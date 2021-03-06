function eliminar(idProveedor, proveedor){
	$("#proveedorEliminar").html(proveedor);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idProveedor: idProveedor},
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
	    		$('#estadoMoral').val(data.estado);
	    		//$('#region').val(data.region);
	    		codigoExiste = data.cp;
	    		colonias = "";
				for (var i = 0; i < data.colonias.length; i++) {
            		colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
    			}
    			$('#coloniasMoral').html(colonias);
    			$('#coloniasMoral').selectpicker("refresh");

	    		}
	    	}
    	},
	});
	}	
}

function validarRfc(parametro){
    rfc = $('#rfc').val();
    var rfc = rfc.toUpperCase();
    $('#rfc').val(rfc);
    if(rfc==""){
        cp = $('#rfc').val();
    }else{
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                url:   '../representantes/index.php?accion=buscarRfc&rfc='+rfc,
                type:  'post',
            success:  function (data) {
                data = JSON.parse(data)
            if (data==="error") {
                //$('#mensaje').addClass('btn btn-danger').html('No existe el RFC que ingreso.').show(100).delay(10000).hide(200);
                $('#mensaje').html('').hide().removeClass('btn btn-warning').delay(0).hide(0);
            }else{
                rfcRepetido = data.empleados_rfc;
                if (parametro === "fisica") {
                validarRespuestas('si');
                }
            }
            },
            });
            $(".loader").fadeOut("slow"); 
        });  
    }
}

function validarRfcMoral(){
		rfc = $('#rfcMoral').val();
	var rfc = rfc.toUpperCase();
	$('#rfcMoral').val(rfc);
    if(rfc==""){
        cp = $('#rfcMoral').val();
	}else{
        $(".loader").fadeIn("slow", function(){
    		$.ajax({
       	 	    url:   'index.php?accion=buscarRfc&rfc='+rfc,
    	    	type:  'post',
            success:  function (data) {
                data = JSON.parse(data)
        	if (data==="error") {
        		//$('#mensaje').addClass('btn btn-danger').html('No existe el RFC que ingreso.').show(100).delay(10000).hide(200);
        		$('#mensajeMoral').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
        	}else{
                rfcRepetido = data.rfc;
        		$("#modalRfcCliente").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#cerrar", function(e){
                    $('#formularioMoral')[0].reset();
                    $("#rfcMoral").focus();
                });
        	}
    	    },
            });
            $(".loader").fadeOut("slow"); 
        });  
	}
}

function validarRespuestas(respuesta){
$("#modalClienteEmpleado").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#siFisicas", function (e) {
        rfc = $('#rfc').val();
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                url:   '../representantes/index.php?accion=buscarRfc&rfc='+rfc,
                type:  'post',
                success:  function (data) {
                    data = JSON.parse(data)
                    if (data==="error") {
                        $('#mensajeMoral').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
                    }else{
                        rfcRepetido = data.rfc;
                        $('#nombreComercial').val('');
                        $('#nombreContacto').val('');
                        $('#telefonoPrincipal').val('');
                        $('#nombreSecundario').val('');
                        $('#otro').val('');
                        $('#nombre').val(data.empleados_nombres);
                        $('#apellidoPaterno').val(data.empleados_apellido_paterno);
                        $('#apellidoMaterno').val(data.empleados_apellido_materno);
                        $('#calle').val(data.calle);
                        $('#numeroInterior').val(data.numeroInterior);
                        $('#numeroExterior').val(data.numeroExterior);
                        $('#delegacionFisica').val(data.delegacion);
                        $('#codigoPostal').val(data.codigoPostal);
                        $('#estadoFisica').val(data.estado);
                        codigoExiste = data.cp;
                        colonias = "";
                        for (var i = 0; i < data.colonias.length; i++) {
                            colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
                        }
                        $('#coloniasFisica').html(colonias);
                        $('#coloniasFisica').selectpicker("refresh");
                    }
                },
            });
            $(".loader").fadeOut("slow");
        });
    }).one("click", "#noFisica", function(){
        $('#mensaje').addClass('btn btn-danger').html('Ingrese un RFC diferente').show(0).delay(8000).hide();
        $("#rfc").focus();
    });
}