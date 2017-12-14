$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblAsignaciones").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalAsignacion").html(data);
    		$('#formAgregar').validator({focus:false});
    		$("#linea").inputmask();

    	},
	});
    $("#modalAsignacion").modal("show");
}

function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalAsignacion").html(data);
    		$('#formEditar').validator({focus:false});

    	},
	});
    $("#modalAsignacion").modal("show");
}

function eliminar(idBanco, banco){
	$("#bancoEliminar").html(banco);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idBanco: idBanco},
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

var imeiExiste = "";
function buscarImei(){
	var imei = $('#imei').val();
	if (imei=="") {
		imei = $('#imei').val('');
	}else{
		$.ajax({
   	 	url:   'index.php?accion=buscarImei&imei='+imei,
	    	type:  'post',
	    success:  function (data) {
	    	console.log(data);
		    	data = JSON.parse(data)
		    	console.log(data);
		    	if (data==="error") {
		    		$('#imei').val(imeiExiste);
		    		$('#marca').val('');
		    		$('#modelo').val('');
		    		$('#sim').val('');
		    	}else{
		    		$('#marca').val(data.marca);
		    		$('#modelo').val(data.model);
		    	}
    		},
		});
	}	
}	

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
	                console.log(data);
		        	if (data==="error") {
		        		$('#nombre').val('')
			    		$('#apellidoPaterno').val('')
			    		$('#apellidoMaterno').val('')
			    		$('#estado').val('')
			    		$('#idEstado').val('')
		        	}else{
	        			$('#nombre').val(data.empleados_nombres);
			    		$('#apellidoPaterno').val(data.empleados_apellido_paterno);
			    		$('#apellidoMaterno').val(data.empleados_apellido_materno);
			    		$('#estado').val(data.nombre);
			    		$('#idEstado').val(data.empleados_estado);
		        	}
    	    	},
        	});
            $(".loader").fadeOut("slow"); 
        });  
	}
}