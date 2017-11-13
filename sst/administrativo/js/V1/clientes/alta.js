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
    $('#nombres').val('');
    $('#apellidoPaterno').val('');
    $('#apellidoMaterno').val('');
    $('#calle').val('');
    $('#numeroInterior').val('');
    $('#numeroExterior').val('');
    $('#delegacion').val('');
    $('#estado').val('');
    $('#codigoPostal').val('');
    $('#estado').val('');
    $('#colonias').html('');
    $('#colonias').selectpicker("refresh");
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
                console.log(data);
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
                    data = JSON.parse(data);
                    console.log(data);
                    if (data==='') {
                        console.log(data);
                        $('#formularioFisica')[0].reset();
                        $('#colonias').html('');
                        $('#colonias').selectpicker("refresh");
                    }else{
                        rfcRepetido = data.rfc;
                        $('#nombres').val(data.empleados_nombres);
                        $('#apellidoPaterno').val(data.empleados_apellido_paterno);
                        $('#apellidoMaterno').val(data.empleados_apellido_materno);
                        $('#calle').val(data.calle);
                        $('#numeroInterior').val(data.numeroInterior);
                        $('#numeroExterior').val(data.numeroExterior);
                        $('#delegacion').val(data.delegacion);
                        $('#codigoPostal').val(data.codigoPostal);
                        $('#idEstado').val(data.estado);
                        $('#estado').val(data.nombre);
                        codigoExiste = data.cp;
                        colonias = "";
                        for (var i = 0; i < data.colonias.length; i++) {
                            selected = "";
                            if(data.asentamiento == data.colonias[i].asentamiento){ selected = "selected";}
                            colonias += '<option value="' + data.colonias[i].idcp + '" '+selected+'>' + data.colonias[i].asentamiento + '</option>';
                        }
                        $('#colonias').html(colonias);
                        $('#colonias').selectpicker("refresh");
                    }
                },
            });
            $(".loader").fadeOut("slow");
        });
    }).one("click", "#noFisicas", function(){
        $('#mensaje').addClass('btn btn-danger').html('Ingrese un RFC diferente').show(0).delay(8000).hide();
        $("#rfc").focus();
        $('#formularioFisica')[0].reset();
        $('#colonias').html('');
        $('#colonias').selectpicker("refresh");
        return false;
    });
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