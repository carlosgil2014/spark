var progreso, parametros = {
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
    $("#tblVacantes").DataTable();
	$('.selectpicker').selectpicker(parametros);
	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    $(".loader").fadeOut("slow");
});

function agregar(){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=agregar',
		    type:  'post',
		    success:  function (data) {
    			$("#modalVacante").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		progreso = $("#progreso");
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {

		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
    	$("#modalVacante").modal("show");
	});
}

function cargarPresupuestos(elemento){
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		$.ajax({
			data: {cliente : elemento.value},
	   	 	url: 'index.php?accion=cargarPresupuestos',
		    type:  'post',
		    success:  function (data) {
		    	$("#presupuesto").html(data);
		    	if($("#presupuesto option").size() > 1){
	    			$("#presupuesto").attr("disabled",false);
	    			porcentajeBarra(progreso, "50%", "Paso 2");
		    	}
		    	else{
					$("#div_alert_modal").show();
					$("#p_alert_modal").html("No existen presupuestos con el cliente seleccionado.");
	    			$("#presupuesto").attr("disabled",true);
	    			$("#filasPresupuesto").attr("disabled",true);
		    		$("#filasPresupuesto").html("");
	    			$("#btnPerfiles").attr("disabled",true);
	    			$("#divPerfiles").html("");
	    			porcentajeBarra(progreso, "25%", "Paso 1");
				}
		    	$("#presupuesto").selectpicker("refresh");
		    	$("#filasPresupuesto").selectpicker("refresh");
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

function cargarPuestosPresupuestos(elemento){
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		$.ajax({
			data: {presupuesto : elemento.value},
	   	 	url: 'index.php?accion=cargarPuestosPresupuestos',
		    type:  'post',
		    success:  function (data) {
		    	$("#filasPresupuesto").html(data);
		    	if($("#filasPresupuesto option").size() > 1){
	    			$("#filasPresupuesto").attr("disabled",false);
	    			$("#btnPerfiles").attr("disabled",false);
	    			porcentajeBarra(progreso, "75%", "Paso 3");
		    	}
		    	else{
					$("#div_alert_modal").show();
					$("#p_alert_modal").html("No existen puestos para vacante en el presupuesto.");
	    			$("#filasPresupuesto").attr("disabled",true);
	    			$("#btnPerfiles").attr("disabled",true);
	    			$("#divPerfiles").html("");
	    			porcentajeBarra(progreso, "50%", "Paso 2");
				}
		    	$("#filasPresupuesto").selectpicker("refresh");
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

function cargarPerfiles(elemento){
	cliente = $("#cliente option:selected"), presupuesto = $("#presupuesto option:selected"), filasPresupuesto = $("#filasPresupuesto option:selected");
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		if(cliente.length > 0 && presupuesto.length > 0 && filasPresupuesto.length > 0){
			$.ajax({
				data: {filasPresupuesto : $("#filasPresupuesto").val(), cliente : cliente.val()},
		   	 	url: 'index.php?accion=cargarPerfiles',
			    type:  'post',
			    success:  function (data) {
	    			$("#divPerfiles").html(data);
		    		$('.selectpicker').selectpicker(parametros);
		    		$(".loader").fadeOut("fast");
	    			porcentajeBarra(progreso, "100%", "Paso 4");
		    	},
			}).done( function() {

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
			$("#p_alert_modal").html("<br>Debe seleccionar un cliente, un presupuesto y mínimo un puesto para continuar.");
			$(".loader").fadeOut("fast");
	    	$("#divPerfiles").html("");
	    	porcentajeBarra(progreso, "75%", "Paso 3");
		}
	});
}

function validarCantidad(elemento, maximo){
	valTmp =  $(elemento).val();
	if(validarEnteroPositivo(elemento)){
		(isNaN(valTmp)) ? $(elemento).val(maximo): $(elemento).val(valTmp);
		(valTmp > maximo) && $(elemento).val(maximo);
		(valTmp < 0) && $(elemento).val(maximo);
	}
	return true;
}

function validarPerfiles(){
	resultado = true;
	$("select[name='perfil']").each(function(i, obj) {
		tmp = $.trim($(this).val());
		if(tmp === "") {resultado = false;};
	});
	return resultado;
}

function guardar(elemento){
	cliente = $("#cliente option:selected"), presupuesto = $("#presupuesto option:selected"), filasPresupuesto = $("#filasPresupuesto option:selected");
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		if(validarPerfiles() && validarInputsNumerico("cantidad") && cliente.length > 0 && presupuesto.length > 0 && filasPresupuesto.length > 0 && $("input[name='filaPresupuesto']").length > 0){
			$("input[name='filaPresupuesto']").each(function(i, obj) {
				tmp = $(this); fila = tmp.closest('tr'), tmpFilaPresupuesto = fila.find("input[name='filaPresupuesto']").val(), tmpCantidad = fila.find("input[name='cantidad']").val(), tmpPerfil = fila.find("select[name='perfil']"); 
				$.ajax({
			   	 	url: 'index.php?accion=guardar',
				    data: {presupuesto : presupuesto.val(), filaPresupuesto : tmpFilaPresupuesto, cantidad : tmpCantidad, cliente : cliente.val(), perfil : tmpPerfil.val()}, 
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
		    			tmp.closest("td").next("td").next("td").next("td").next("td").attr("class", clase);
		    			tmp.closest("td").next("td").next("td").next("td").next("td").html(data);
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
			location.reload();
		}
		else{
			$("#div_alert_modal").show();
			$("#p_alert_modal").html("No se pueden crear vacantes, llene los datos correctamente");
			$(".loader").fadeOut("fast");
		}
	});
}

function modificar(cliente, presupuesto, perfil, puesto, fecha){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
			data: {cliente : cliente, presupuesto : presupuesto, perfil : perfil, puesto : puesto, fecha : fecha},
	   	 	url: 'index.php?accion=modificar',
		    type:  'post',
		    success:  function (data) {
    			$("#modalVacante").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
	    	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
    		$("#tblVacantesModal").DataTable({"bPaginate": false,"bInfo" : false});
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
    	$("#modalVacante").modal("show");
	});
}

function historial(elemento, vacante){
	tmp = $(elemento); fila = tmp.closest('tr');
	$(".loader").fadeIn("fast", function(){
		$("tr.tmp").remove();
		$.ajax({
			data: {vacante : vacante},
	   	 	url: 'index.php?accion=historial',
		    type:  'post',
		    success:  function (data) {
		    	fila.after("<tr class='tmp'><td colspan='6'>"+data+"</td></tr>");
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {

		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
	});
}

function confirmarCancelacion(elemento, presupuesto, vacante){
	tmp = $(elemento); fila = tmp.closest('tr');
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		$("tr.tmp").remove();
		$.ajax({
			data: {presupuesto : presupuesto, vacante : vacante},
	   	 	url: 'index.php?accion=confirmarCancelacion',
		    type:  'post',
		    success:  function (data) {
		    	fila.after(data);
	    	},
		}).done( function() {

		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
    			$(".loader").fadeOut("fast");
			}
		});
		
	    $(".loader").fadeOut("fast");
	});
}

function cancelarVacante(elemento, presupuesto, vacante){
	tmp = $(elemento); fila = tmp.closest('tr'); motivo = $.trim(fila.find("input[name='motivo']").val());
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		if(motivo !== ""){
			$.ajax({
				data: {presupuesto : presupuesto, vacante : vacante, motivo : motivo},
		   	 	url: 'index.php?accion=cancelarVacante',
			    type:  'post',
			    success:  function (data) {
			    	if(data !== "OK"){
			    		$("#div_alert_modal").show();
						$("#p_alert_modal").html(data);
		    			$(".loader").fadeOut("fast");
			    	}
			    	else{
			    		fila.html("<td colspan='6'>Cancelación exitosa</td>");
	    				$(".loader").fadeOut("fast");
			    	}
		    	},
			}).done( function() {

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
			$("#p_alert_modal").html("El motivo de cancelación no puede estar vacío.");
			$(".loader").fadeOut("fast");
		}
	});
}

function confirmarEstado(elemento, presupuesto, vacante, estado){
	tmp = $(elemento); tmpI = tmp.find("i"), tmpDiv = tmp.closest('div.btn-group'), titulo = tmp.data("original-title"), icono = tmpI.attr("class"), estilo = tmpI.attr("style") ;
	// console.log(titulo);
	tmpDiv.html('<button type="button" class="btn btn-success btn-xs" onclick="cambiarEstado(this,\''+presupuesto+'\', \''+vacante+'\', \''+estado+'\')"><i class="fa fa-check"></i></button><button type="button" class="btn btn-danger btn-xs" onclick="cancelarEstado(this, \''+presupuesto+'\', \''+vacante+'\', \''+estado+'\', \''+titulo+'\', \''+icono+'\' , \''+estilo+'\')"><i class="fa fa-close"></i> </button>');
	$(".tooltip").hide();
}

function cambiarEstado(elemento, presupuesto, vacante, estado){
	tmp = $(elemento); tmpDiv = tmp.closest('td');
	$(".loader").fadeIn("fast", function(){
		$("#div_alert_modal").hide();
		$.ajax({
			data: {presupuesto : presupuesto, vacante : vacante, estado : estado},
	   	 	url: 'index.php?accion=cambiarEstado',
		    type:  'post',
		    success:  function (data) {
		    	tmpDiv.html(data);
				$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
				$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
    			$(".loader").fadeOut("fast");
			}
		});
	});
}

function cancelarEstado(elemento,presupuesto, vacante, estado, titulo, icono, estilo){
	tmp = $(elemento); tmpDiv = tmp.closest('div.btn-group');
	tmpDiv.html("<a style='cursor:pointer;' onclick='confirmarEstado(this,\""+presupuesto+"\", \""+vacante+"\", \""+estado+"\");' data-toggle='tooltip' data-container='body' title='"+titulo+"'><i class='"+icono+"' style='"+estilo+"''></i></a>");
	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
}

function confirmarActualizar(elemento, presupuesto, vacante){
	tmp = $(elemento); tmpDiv = tmp.closest('div.btn-group'), fila = tmp.closest('tr'),  perfil = fila.find("select[name='perfil']").val();
	tmpDiv.html("<button type='button' class='btn btn-success btn-xs' onclick='actualizar(this,\""+presupuesto+"\", \""+vacante+"\", \""+perfil+"\")'><i class='fa fa-check'></i></button><button type='button' class='btn btn-danger btn-xs' onclick='cancelarActualizar(this, \""+presupuesto+"\", \""+vacante+"\")'><i class='fa fa-close'></i> </button>");
	$(".tooltip").hide();
}

function actualizar(elemento, presupuesto, vacante, perfil){
	tmp = $(elemento); tmpDiv = tmp.closest('td'), fila = tmp.closest('tr');
	$(".loader").fadeIn("fast", function(){
		$("tr.tmp").remove();
		$("#div_alert_modal").hide();
		$.ajax({
			data: {presupuesto : presupuesto, vacante : vacante, perfil : perfil},
	   	 	url: 'index.php?accion=actualizar',
		    type:  'post',
		    success:  function (data) {
		    	fila.after("<tr class='tmp'><td colspan='6'>"+data+"</td></tr>");
				$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
				$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
    			$(".loader").fadeOut("fast");
			}
		});
	});
}

function cancelarActualizar(elemento,presupuesto, vacante){
	tmp = $(elemento); tmpDiv = tmp.closest('div.btn-group');
	tmpDiv.html("<a style='cursor:pointer;' onclick='confirmarActualizar(this,\""+presupuesto+"\", \""+vacante+"\");' data-toggle='tooltip' data-container='body' title=''><i class='fa fa-trash-o text-red'></i></a>");
	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
}

function paginacion(elemento, cliente, presupuesto, pagina){
	$(".paginacion").removeClass("btn btn-sm btn-flat btn-success btn-default");
	$(".paginacion").addClass("btn btn-sm btn-flat btn-default");
	$(elemento).addClass("btn btn-sm btn-flat btn-success");
	$(".tooltip").hide();
	$(".loader").fadeIn("fast", function(){
		$.ajax({
			data: {cliente : cliente, presupuesto : presupuesto, pagina : pagina},
	   	 	url: 'index.php?accion=paginacion',
		    type:  'post',
		    success:  function (data) {
    			$("#divVacantesModal").html(data);
	    		$('.selectpicker').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		}).done( function() {
	    	$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
    		$("#tblVacantesModal").DataTable({"bPaginate": false,"bInfo" : false});
		}).fail( function( jqXHR, textStatus, errorThrown ) {
		  	if(jqXHR.status === 0) {
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
				$(".loader").fadeOut("fast");
			}
		});
	});
}