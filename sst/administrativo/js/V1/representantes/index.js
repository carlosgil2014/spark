$(function () {
	variable = $("#div_alert");
 // alert(variable);
    $("#tblRepresentantes").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }

	
});

$(document).on('shown.bs.modal', function (e) {
    $('[autofocus]', e.target).focus();
});


function validarRfc(){
	rfc = $('#rfc').val();
	var rfc = rfc.toUpperCase();
	$('#rfc').val(rfc);
    if(rfc==""){
        cp = $('#rfc').val();
	}else{
        $(".loader").fadeIn("slow", function(){
    		$.ajax({
       	 	    url:   'index.php?accion=buscarRfc&rfc='+rfc,
    	    	type:  'post',
            success:  function (data) {
                data = JSON.parse(data)
        	if (data==="error") {
        		//$('#mensaje').addClass('btn btn-danger').html('No existe el RFC que ingreso.').show(100).delay(10000).hide(200);
        		$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
        	}else{
                rfcRepetido = data.empleados_rfc;
        		$('#mensaje').addClass('btn btn-danger').html('El RFC que ingreso ya existe como empleado spar, verifique…').show(50).delay(5000).hide(200);
        		$("#rfc").val('');
                $("#rfc").focus();
        	}
    	    },
            });
            $(".loader").fadeOut("slow"); 
        });  
	}
}

var codigoExiste = "";
function cp(){
	var cp = $('#codigoPostal').val();
	if (cp=="") {
		cp = $('#codigoPostal').val('');
	}else{
		$.ajax({
   	 	url:   'index.php?accion=buscar&cp='+cp,
	    	type:  'post',

	    success:  function (data) {
	    	data = JSON.parse(data)
	    	if (data==="error") {
	    		$('#mensaje').addClass('btn btn-danger').html('No existe el código postal '+cp).show(100).delay(5000).hide(200);
	    		$('#codigoPostal').val(codigoExiste);
	    	}else{
	    		$('#mensaje').html('').hide().removeClass('btn btn-danger');
	    		$('#idEstado').val(data.idEstado);
	    		$('#delegacion').val(data.delegacion);
	    		$('#estado').val(data.estado);
	    		$('#region').val(data.region);
	    		codigoExiste = data.cp;
	    		colonias = "";
				for (var i = 0; i < data.colonias.length; i++) {
            		colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
    			}
    			$('#colonias').html(colonias);
    			$('#colonias').selectpicker("refresh");
	    	}
    	},
	});
	}	
}

var edad = 0;
function menorDeEdad(){
	var fechaNacimiento = document.getElementById('fechaNacimiento').value;
	var hoy = new Date();
	var yyyy = hoy.getFullYear();
	var nacimiento = new Date(fechaNacimiento);
	var datosFecha = fechaNacimiento.split("-");
	var fecha = datosFecha[0];
	var edad = yyyy-fecha;
	fechaVencida = fecha-65;
	if(edad>65 && edad<90){
	$("#mensaje").addClass('btn btn-warning').html('La fecha de nacimiento corresponde a una persona de mayor de edad, verifique…').show(100).delay(6000).hide(200);
	$("#fechaNacimiento").focus();
	return false;
	}else if(edad<18 && edad>=0){
	$("#mensaje").addClass('btn btn-warning').html('La fecha de nacimiento corresponde a una persona de menor de edad, verifique…').show(100).delay(6000).hide(200);
	$("#fechaNacimiento").focus();
	return false;
	}else if(fecha>yyyy){
	$("#mensaje").addClass('btn btn-warning').html('La fecha que ingreso no es válida, verifique…').show(100).delay(5000).hide(200);
	$("#fechaNacimiento").focus();
	return false;
	}else if(fecha<1927){
	$("#mensaje").addClass('btn btn-warning').html('La fecha que ingreso no es válida, verifique…').show(100).delay(5000).hide(200);
	$("#fechaNacimiento").focus();
	return false;
	}
	if (edad>=18 && edad<=65){
	$('#mensaje').html('').hide().removeClass('btn btn-warning');
	}
}

	
function validarTelefono(telefono){
	if (typeof $(telefono).val() !== 'undefined' && $(telefono).val() !== null) {
		telefonoTmp = $(telefono).val().match( /\d+/g);
    	if($.trim(telefonoTmp) != ""){
	    	telefonoTmp = telefonoTmp.join("");
	    	if (telefonoTmp.length<10) {
	    		$("#mensaje").addClass('btn btn-danger').html('El teléfono debe tener 10 dígitos').show(100).delay(5000).hide(200);
	    		$(telefono).focus();
	    		return false;
	    	}else{
	    		$('#mensaje').html('').hide().removeClass('btn btn-warning');
                return true;
	    	}
	    }
    }
}

function caracteresCorreoValido(){
    var email = $('#email').val();
    var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

    if(caract.test(email) == false){
       $("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un correo valido.').show(100).delay(5000).hide(200);
       	$("#email").focus();
       return false;
    }else{
    	$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    }
}

function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalRepresentante").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		var f = new Date();
    		fechaMayorDeDiciocho= f.getFullYear()-18;
    		fechaMenorSesentayCinco= f.getFullYear()-65;
    		dia = f.getDate();
    		if (dia===1 || dia===2 || dia===3 || dia===4 || dia===5 || dia===6 || dia===7 || dia===8 || dia===9) {
    			dia = "0"+dia;
    		}
    		fechaMinima= fechaMayorDeDiciocho+"-"+(f.getMonth() +1)+"-"+dia;
    		fechaMaxima= fechaMenorSesentayCinco+"-"+(f.getMonth() +1)+"-"+dia;
    		$("#fechaNacimiento").attr("min",fechaMaxima);
    		$("#fechaNacimiento").attr("max",fechaMinima);
    		$("#telefonoCelular").inputmask();
            $("#telefonoCasa").inputmask();
            $("#telefonoAlterno").inputmask();
    		$('#formAgregar').validator({focus:false});
    		$("#formAgregar").submit(function(){
    			if($("#nombre").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar nombre(s).').show(100).delay(5000).hide(200);
        			$("#nombre").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#apellidoPaterno").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar apellido paterno.').show(100).delay(5000).hide(200);
        		$("#apellidoPaterno").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#fechaNacimiento").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar fecha de nacimiento.').show(100).delay(5000).hide(200);
        		$("#fechaNacimiento").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#rfc").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar RFC .').show(100).delay(3000).hide(200);
        		$("#rfc").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#calle").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar la calle.').show(100).delay(5000).hide(200);
        		$("#calle").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#numeroInterior").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un número interior.').show(100).delay(5000).hide(200);
        		$("#numeroInterior").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#codigoPostal").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un código postal.').show(1).delay(5000).hide(200);
        		$("#codigoPostal").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
    			if($("#email").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un correo electrónico.').show(100).delay(4000).hide(200);
        		$("#email").focus();
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);	
    			}
				if($("#telefonoCelular").val()=="" && $("#telefonoCasa").val()=="" && $("#telefonoAlterno").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un número telefónico.').show(10).delay(4000).hide(50);
        		return false;
    			}else{
    				$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
    			}
    			if(validarTelefono($("#telefonoCasa"))== false){return false};
    			if(validarTelefono($("#telefonoCelular"))== false){return false};
    			if(validarTelefono($("#telefonoAlterno"))== false){return false};

     		});
    	},
	});
    $("#modalRepresentante").modal("show");
}


function modificar(idRepresentante,cp){
	$.ajax({
   	 	url:   'index.php?accion=modificar&idRepresentante='+idRepresentante+'&cp='+cp,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalRepresentante").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		var f = new Date();
    		fechaMayorDeDiciocho= f.getFullYear()-18;
    		fechaMenorSesentayCinco= f.getFullYear()-65;
    		dia = f.getDate();
    		if (dia===1 || dia===2 || dia===3 || dia===4 || dia===5 || dia===6 || dia===7 || dia===8 || dia===9) {
    			dia = "0"+dia;
    		}
    		fechaMinima= fechaMayorDeDiciocho+"-"+(f.getMonth() +1)+"-"+dia;
    		fechaMaxima= fechaMenorSesentayCinco+"-"+(f.getMonth() +1)+"-"+dia;
    		$("#fechaNacimiento").attr("min",fechaMaxima);
    		$("#fechaNacimiento").attr("max",fechaMinima);
    		$("#telefonoCelular").inputmask();
            $("#telefonoCasa").inputmask();
            $("#telefonoAlterno").inputmask();
    		$('#formEditar').validator({focus:false});
    		$("#formEditar").submit(function(){
    			if($("#email").val()==""){
        		$("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un correo electrónico.').show(100).delay(6000).hide(200);
        		return false;
    			}
				if($("#telefonoCelular").val()=="" && $("#telefonoCasa").val()=="" && $("#telefonoAlterno").val()==""){
                $("#mensaje").addClass('btn btn-danger').html('Tiene que ingresar un número telefónico.').show(10).delay(4000).hide(50);
                return false;
                }else{
                    $('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
                }
                if(validarTelefono($("#telefonoCasa"))== false){return false};
                if(validarTelefono($("#telefonoCelular"))== false){return false};
                if(validarTelefono($("#telefonoAlterno"))== false){return false};
     		});
    	},
	});
    $("#modalRepresentante").modal("show");
}

function eliminar(idRepresentante){
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idRepresentante: idRepresentante},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index&clase=success");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}
