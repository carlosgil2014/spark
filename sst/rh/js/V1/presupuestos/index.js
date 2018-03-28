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
    $("#tblPresupuestos").DataTable();
	$('.selectpicker').selectpicker(parametros);
	$(".loader").fadeOut("fast");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregar(){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=agregar',
		    type:  'post',
		    success:  function (data) {
    			$("#modalPresupuesto").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
	    	$("select[name='puestos']").selectpicker(parametros);
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
    	$("#modalPresupuesto").modal("show");
	});
}

function modificar(presupuesto){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=modificar&presupuesto='+presupuesto,
		    	type:  'post',
		    success:  function (data) {
    			$("#modalPresupuesto").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
	    	$("select[name='puestos']").selectpicker(parametros);
	    	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
    	$("#modalPresupuesto").modal("show");
	});
}

function cargarProyectos(elemento){
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		$.ajax({
			data: {cliente : elemento.value},
	   	 	url: 'index.php?accion=cargarProyectos',
		    type:  'post',
		    success:  function (data) {
		    	$("#proyecto").html(data);
		    	if($("#proyecto option").size() > 0){
	    			$("#proyecto").attr("disabled",false);
		    	}
		    	else{
					$("#div_alert_modal").show();
					$("#p_alert_modal").html("No existen proyectos con el cliente seleccionado.");
	    			$("#proyecto").attr("disabled",true);
				}
		    	$("#proyecto").selectpicker("refresh");
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
			// $(elemento).remove();
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
	    		$(".loader").fadeOut("fast");
			}
		});
	});
}

function validarPuestosRepetidos(elemento){
	$(".loader").fadeIn("fast", function(){
		if ($("select[name='puestos'] option[value='"+$(elemento).val()+"']:selected").length > 1) {
   			$(elemento).val("").selectpicker("refresh");
   			$("#div_alert_modal").show();
			$("#p_alert_modal").html("No se puede repetir el puesto en el presupuesto.");
    	}
	    $(".loader").fadeOut("fast");
	});
}

function agregarPuesto(){
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		if(validarPuestos()){
			$.ajax({
		   	 	url: 'index.php?accion=cargarPuestos',
			    type:  'post',
			    success:  function (data) {
			    	$("#tablaPuestos").append("<tr><td>"+data+"</td><td><input type='number' class='form-control input-sm text-center' min='1' step='1' name='cantidad' oninput='calcularAsistencias(this);'></td><td><input type='number' class='form-control input-sm text-center' min='.01' step='.01' name='costoUnitario'></td><td><input type='number' class='form-control input-sm text-center' min='1' step='1' name='dias' max='31' oninput='calcularAsistencias(this);'></td><td><input type='text' class='form-control input-sm text-center' style='background:none; border:none;' name='asistencias' readonly></td><td><a style='cursor:pointer;' data-toggle='tooltip' onclick='eliminarFila(this);'><i class='fa fa-minus text-red'></i></a></td></tr>");
	   				$(".loader").fadeOut("fast");
		    	},
			}).done( function() {
		    	$("select[name='puestos']").selectpicker(parametros);
			}).fail( function( jqXHR, textStatus, errorThrown ) {
			  	if(jqXHR.status === 0) {
					$("#div_alert_modal").show();
					$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
	    			$(".loader").fadeOut("fast");
				}
			});
		}
		else{
			$("#div_alert_modal").show();
			$("#p_alert_modal").html("Revise los puestos existentes, alguno es incorrecto.");
	    	$(".loader").fadeOut("fast");
		}		
	});
}

function calcularAsistencias(elemento){
	tmp = $(elemento); fila = tmp.closest('tr'), tmpCantidad = fila.find("input[name='cantidad']").val(), tmpDias = fila.find("input[name='dias']").val(), tmpAsistencias = fila.find("input[name='asistencias']"); 
	(validarEnteroPositivo(elemento)) ? tmpAsistencias.val(tmpCantidad * tmpDias) : tmpAsistencias.val("N/A");
}

function validarPuestos(){
	resultado = true;
	$("select[name='puestos']").each(function(i, obj) {
		tmp = $.trim($(this).val());
		if(tmp === "") {resultado = false;};
	});
	return resultado;
}

function guardar(elemento){
	nombre = $("#nombre").val(), tipo = $("#tipo").val(), cliente = $("#cliente").val(), proyecto = $("#proyecto").val();
	$(".loader").fadeIn("fast", function(){
		if(validarPuestos() && validarInputsNumerico("cantidad") && validarInputsNumerico("dias") && validarInputsNumerico("costoUnitario")){
			$("#div_alert_modal").hide();
			$.ajax({
				data: {nombre : nombre, tipo : tipo, cliente : cliente , proyecto : proyecto},
		   	 	url: 'index.php?accion=guardar',
			    type:  'post',
			    success:  function (data) {
		    		tmpPresupuesto = data;
					$(".loader").fadeIn("fast", function(){
						$("select[name='puestos']").each(function(i, obj) {
							tmp = $(this); fila = tmp.closest('tr'), tmpCantidad = fila.find("input[name='cantidad']").val(), tmpDias = fila.find("input[name='dias']").val(), tmpCostoUnitario = fila.find("input[name='costoUnitario']").val(); 

							$.ajax({
						   	 	url: 'index.php?accion=guardarPuestosPresupuesto',
							    data: {presupuesto : tmpPresupuesto, puesto : tmp.val(), cantidad : tmpCantidad, costoUnitario : tmpCostoUnitario, dias : tmpDias}, 
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
					    			tmp.closest("td").next("td").next("td").next("td").next("td").next("td").attr("class", clase);
					    			tmp.closest("td").next("td").next("td").next("td").next("td").next("td").html(data);
						    	},
							}).done( function() {
								// $(elemento).remove();
							}).fail( function( jqXHR, textStatus, errorThrown ) {
							  	if(jqXHR.status === 0) {
									$("#div_alert_modal").show();
									$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
									$(".loader").fadeOut("fast");
								}
							});
						});
						$(elemento).remove();
					    $(".loader").fadeOut("fast");
					});
			    	
			    $(".loader").fadeOut("fast");
		    	},
			}).done( function() {
		    	$("select[name='puestos']").selectpicker(parametros);
			}).fail( function( jqXHR, textStatus, errorThrown ) {
			  	if(jqXHR.status === 0) {
					$("#div_alert_modal").show();
					$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
					$(".loader").fadeOut("fast");
				}
			});

		}
		else{
			$("#div_alert_modal").show();
			$("#p_alert_modal").html("El presupuesto es incorrecto, llene los datos correctamente");
			$(".loader").fadeOut("fast");
		}
	});
}

function confirmarEliminar(elemento, presupuesto, filaPresupuesto){
	tmp = $(elemento); tmpDiv = tmp.closest('div.btn-group');
	tmpDiv.html("<button type='button' class='btn btn-success btn-xs' onclick='eliminarFilaPresupuesto(\""+presupuesto+"\", \""+filaPresupuesto+"\")'><i class='fa fa-check'></i></button><button type='button' class='btn btn-danger btn-xs' onclick='cancelarEliminar(this, \""+presupuesto+"\", \""+filaPresupuesto+"\")'><i class='fa fa-close'></i> </button>");
	$(".tooltip").hide();
}

function eliminarFilaPresupuesto(presupuesto, filaPresupuesto){
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		$.ajax({
			data: {presupuesto : presupuesto, filaPresupuesto : filaPresupuesto},
	   	 	url: 'index.php?accion=eliminarFilaPresupuesto',
		    type:  'post',
		    success:  function (data) {
		    	if(data != "OK"){
		    		$("#div_alert_modal").show();
					$("#p_alert_modal").html(data);
	    			$(".loader").fadeOut("fast");
		    	}
		    	else{
		    		modificar(presupuesto);
		    	}
	    	},
		}).done( function() {
	    	$("select[name='puestos']").selectpicker(parametros);
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
    			$(".loader").fadeOut("fast");
			}
		});
	});
}

function cancelarEliminar(elemento,presupuesto, filaPresupuesto){
	tmp = $(elemento); tmpDiv = tmp.closest('div.btn-group');
	tmpDiv.html("<a style='cursor:pointer;' onclick='confirmarEliminar(this,\""+presupuesto+"\", \""+filaPresupuesto+"\");' data-toggle='tooltip' data-container='body' title='¿Eliminar permanentemente?'><i class='fa fa-trash-o text-red'></i></a>");
	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
}

function actualizar(elemento,presupuesto){
	nombre = $("#nombre").val(), tipo = $("#tipo").val(), cliente = $("#cliente").val(), proyecto = $("#proyecto").val();
	$(".loader").fadeIn("fast", function(){
		if(validarPuestos() && validarInputsNumerico("cantidad") && validarInputsNumerico("dias") && validarInputsNumerico("costoUnitario")){
			$("#div_alert_modal").hide();
			$.ajax({
				data: {presupuesto: presupuesto, nombre : nombre, tipo : tipo, cliente : cliente , proyecto : proyecto},
		   	 	url: 'index.php?accion=actualizar',
			    type:  'post',
			    success:  function (data) {
			    	if(data === "OK"){
						$(".loader").fadeIn("fast", function(){
							$("select[name='puestos']").each(function(i, obj) {
								tmp = $(this); fila = tmp.closest('tr'), tmpFilaPresupuesto = fila.find("input[name='filaPresupuesto']").val(), tmpCantidad = fila.find("input[name='cantidad']").val(), tmpDias = fila.find("input[name='dias']").val(), tmpCostoUnitario = fila.find("input[name='costoUnitario']").val(); 
								tmpUrl = "index.php?accion=actualizarPuestosPresupuesto";
								if (typeof tmpFilaPresupuesto !== 'undefined' && tmpFilaPresupuesto !== null) {
									tmpUrl = "index.php?accion=actualizarPuestosPresupuesto";
    							}
    							else{
    								tmpUrl = "index.php?accion=guardarPuestosPresupuesto";
    							}
								$.ajax({
							   	 	url: tmpUrl,
								    data: {filaPresupuesto : tmpFilaPresupuesto, presupuesto : presupuesto , puesto : tmp.val(), cantidad : tmpCantidad, costoUnitario : tmpCostoUnitario, dias : tmpDias}, 
								    type:  'post',
								    async: false,
								    success:  function (data) {
								    	clase = "danger";
								    	if(data === "OK"){
								    		clase = "success";
								    		data = "Guardado";
								    		if (typeof tmpFilaPresupuesto !== 'undefined' && tmpFilaPresupuesto !== null) {
								    			clase = "active";
								    			data = "Sin modificaciones";
    										}
								    	}
								    	else{
								    		if(data === "Actualizado"){
								    			clase = "success";		
								    		}
								    	}
						    			tmp.closest("td").next("td").next("td").next("td").next("td").next("td").attr("class", clase);
						    			tmp.closest("td").next("td").next("td").next("td").next("td").next("td").html(data);
							    	},
								}).done( function() {
									// $(elemento).remove();
								}).fail( function( jqXHR, textStatus, errorThrown ) {
								  	if(jqXHR.status === 0) {
										$("#div_alert_modal").show();
										$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
    									$(".loader").fadeOut("fast");
									}
								});
							});
							$(elemento).remove();
						    $(".loader").fadeOut("fast");
						});
			    	}
			    	else{
			    		$("#div_alert_modal").show();
						$("#p_alert_modal").html(data);
			    	}
			    $(".loader").fadeOut("fast");
		    	},
			}).done( function() {
		    	$("select[name='puestos']").selectpicker(parametros);
			}).fail( function( jqXHR, textStatus, errorThrown ) {
			  	if(jqXHR.status === 0) {
					$("#div_alert_modal").show();
					$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
					$(".loader").fadeOut("fast");
				}
			});

		}
		else{
			$("#div_alert_modal").show();
			$("#p_alert_modal").html("El presupuesto es incorrecto, llene los datos correctamente");
			$(".loader").fadeOut("fast");
		}
	});
}