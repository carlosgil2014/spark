var parametros = {
					style: 'btn-success btn-sm btn-flat',
					noneSelectedText: 'Seleccionar un elemento', 
					liveSearchPlaceholder:'Buscar',
					noneResultsText: '¡No existe el elemento buscado!',
					countSelectedText:'{0} elementos seleccionados',
					actionsBox:true,
					selectAllText: 'Seleccionar todos',
					deselectAllText: 'Deseleccionar todos'
				}

$(function () {
	variable = $("#div_alert");
    $("#tblSims").DataTable();
	$(".loader").fadeOut("fast");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

$(document).on('shown.bs.modal','#modalSim', function () {
	$(this).find('input:text:visible:first').focus();
})

function agregar(){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=agregar',
		    	type:  'post',
		    success:  function (data) {
    			$("#modalSim").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		});
    	$("#modalSim").modal("show");
	});
}

function añadirSim(variable){
	var sim = $("#sim").val(), tipo = $("#tipo").val(), patt = new RegExp("[0-9]{19}F"), res = patt.test(sim), patt1 = new RegExp("[0-9]{19}f"), res1 = patt1.test(sim), repetido = 0;
	if((res || res1) && sim.length == 20){
		$(".loader").fadeIn("fast", function(){
			$("input[name='sim']").each(function(i, obj) {
				if($(this).val() == sim){
					repetido = 1;
				}
			});
			if(repetido == 0){
				$("#div_alert_modal").css("display", "none");
				$("#tablaSims").append("<tr><td><input name='sim' style='background:none; border:none;' value='"+sim.toUpperCase()+"' readonly></td><td><input name='tipo' style='background:none; border:none;' value='"+tipo+"' readonly></td><td><a style='cursor:pointer;' data-toggle='tooltip' onclick='eliminarFila(this);''><i class='fa fa-minus text-red'></i></a></td></tr>");  
			}
			else{
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("El ICC ya existe en la tabla posterior.");
			}
	    	$(".loader").fadeOut("fast");
		});
		$("#sim").val("").focus();
	}
	else{
		if(variable == "botón"){
			$("#div_alert_modal").show();
			$("#p_alert_modal").html("El ICC es incorrecto. Debe contener 19 dígitos y una letra \"F\".");
			$("#sim").val("").focus();
		}
	}
}


function guardar(elemento){
	if($("input[name='sim']").length > 0){
		$(".loader").fadeIn("fast", function(){
			$("input[name='sim']").each(function(i, obj) {
				var tmp = $(this), tipoTmp = tmp.closest("td").next("td").find("input[name='tipo']").val();
				$.ajax({
			   	 	url: 'index.php?accion=guardar',
				    data: {icc : tmp.val(), almacen : $("#almacen").val(), tipo : tipoTmp}, 
				    type:  'post',
					async: false,
				    success:  function (data) {
				    	clase = "success";
				    	if(data != "OK"){
				    		clase = "danger";
				    	}
				    	else{
				    		data = "Guardado";
				    	}
		    			tmp.closest("td").next("td").next("td").attr("class", clase);
		    			tmp.closest("td").next("td").next("td").html(data);
			    	},
				}).done( function() {
					// $(elemento).remove();
				}).fail( function( jqXHR, textStatus, errorThrown ) {
				  	if(jqXHR.status === 0) {
						$("#div_alert_modal").show();
						$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
					}
				});
			});
		    $(".loader").fadeOut("fast");
		});
	}
	else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("No hay datos para guardar.");
	}
}

function modificar(idSim){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=modificar&idSim='+idSim,
		    type:  'post',
		    success:  function (data) {
    			$("#modalSim").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		});
    	$("#modalSim").modal("show");
	});
}

function validarSim(elemento){
	var sim = $(elemento).val(), patt = new RegExp("[0-9]{19}F"), res = patt.test(sim), patt1 = new RegExp("[0-9]{19}f"), res1 = patt1.test(sim), repetido = 0;
	if((res || res1) && sim.length == 20){
		$(".loader").fadeIn("fast", function(){
			$("#div_alert_modal").css("display", "none");
	    	$(".loader").fadeOut("fast");
		});
		$("#sim").val("").focus();
	}
	else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("El ICC es incorrecto. Debe contener 19 dígitos y una letra \"F\".");
		$("#sim").val("").focus();
	}
}

function actualizar(idSim){
	var icc = $("#simModificar").val(), tipo = $("#tipoModificar").val(), estado = $("#estadoModificar").val(), almacen = $("#almacenModificar").val();
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=actualizar',
		    data: {idSim : idSim, icc : icc, almacen : almacen, tipo : tipo, estado : estado}, 
		    type:  'post',
		    async: false,
		    success:  function (data) {
		    	modificar(idSim);
	    	},
		}).done( function() {
			// $(elemento).remove();

		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
			}
		});
	    $(".loader").fadeOut("fast");
	});
}