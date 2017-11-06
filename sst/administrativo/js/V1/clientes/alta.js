$(function () {
	
	variable = $("#div_alert");
	$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    //Personalizar los campos telefónicos
	$("[data-mask]").inputmask();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }

    $('[data-toggle="tooltip"]').tooltip({
	    trigger : 'hover'
	});
	$('#siMoral').hide();
	$("#noMoral").hide();
	$('#siFisica').hide();
	$("#noFisica").hide();
});

$('input[name="tabs"]').click(function () {
    $(this).tab('show');
});


function cargarEstados(pais){
	var estados = $("#estados");
	$(".loader").fadeIn("slow", function(){
		$.ajax(
		{
			data:{pais: pais.value},
	    	url:   "../estados/index.php?accion=listar",
	    	type:  "post",
	    	success:  function (data) 
	    	{
				estados.html(data);
				estados.selectpicker("refresh");
	    		$(".loader").fadeOut("slow");
	    	}
		});
	});
}

function validarRfc(parametro){
	console.log('ss');
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
        	if (data==="error") {
        		//$('#mensaje').addClass('btn btn-danger').html('No existe el RFC que ingreso.').show(100).delay(10000).hide(200);
        		$('#mensaje').html('').hide().removeClass('btn btn-warning').delay(0).hide(0);
        	}else{
                data = JSON.parse(data)
                rfcRepetido = data.empleados_rfc;
                if (parametro === "fisica") {
                	$('#mensaje').addClass('btn btn-warning').html('El RFC que ingreso ya existe como empleado spar, ¿Desea registrarlo como cliente?').show().delay(5000);
                	$('#siFisica').show();
                	$('#noFisica').show();
                }			
        	}
    	    },
            });
            $(".loader").fadeOut("slow"); 
        });  
	}
}

function validarRfcMoral(){
	console.log('fkjjfj');
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
        	if (data==="error") {
        		//$('#mensaje').addClass('btn btn-danger').html('No existe el RFC que ingreso.').show(100).delay(10000).hide(200);
        		$('#mensajeMoral').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
        	}else{
                data = JSON.parse(data)
                rfcRepetido = data.rfc;
        		$('#mensajeMoral').addClass('btn btn-danger').html('El RFC que ingreso ya existe como cliente, verifique…').show(50).delay(5000).hide(200);
        		$("#rfcMoral").focus();
        	}
    	    },
            });
            $(".loader").fadeOut("slow"); 
        });  
	}
}

function validarRespuesta(respuesta){
	if (respuesta === "si") {
			console.log('ssss');
			$('#siFisica').hide();
			$("#noFisica").hide();
        	$('#mensaje').hide();
        	$('#nombre').focus();
	}else{
		$('#mensaje').removeClass('btn btn-warning').delay().hide();
		$('#siFisica').hide();
        $("#noFisica").hide();
        $('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
		$('#mensaje').addClass('btn btn-danger').html('Ingrese un RFC diferente').show(0).delay(5000).hide();
		$("#rfc").focus();
		return false;
	}
}

var codigoExiste = "";
function codigoPostales(codigoPostal,tipo){
	console.log(tipo);
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
	    		$('#idEstado').val(data.idEstado);
	    		$('#delegacion').val(data.delegacion);
	    		$('#estado').val(data.estado);
	    		//$('#region').val(data.region);
	    		codigoExiste = data.cp;
	    		colonias = "";
				for (var i = 0; i < data.colonias.length; i++) {
            		colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
    			}
    			$('#colonias').html(colonias);
    			$('#colonias').selectpicker("refresh");
	    		}else if(tipo==="moral"){
	    			console.log('skks');
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
    			}
    			$('#coloniasMoral').html(colonias);
    			$('#coloniasMoral').selectpicker("refresh");

	    		}
	    	}
    	},
	});
	}	
}