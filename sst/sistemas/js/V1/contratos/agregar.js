var parametros = {
					noneSelectedText: 'Seleccione', 
					liveSearchPlaceholder:'Buscar',
					noneResultsText: '¡No existe el elemento buscado!',
					countSelectedText:'{0} elementos seleccionados',
					selectAllText: 'Seleccionar todos',
					deselectAllText: 'Deseleccionar todos'
				}

$(function () {
	variable = $("#div_alert");
    // alert(variable);
	$('.selectpicker').selectpicker(parametros);
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    actualizarNumeroLineas();
	$(".loader").fadeOut("slow");
});

function añadirLinea(){
	var linea = $("#linea option:selected").text(), idLinea = $("#linea").val(), repetido = 0;
	if(linea.length == 10){
		$(".loader").fadeIn("fast", function(){
			$("input[name='linea']").each(function(i, obj) {
				if($(this).val() == idLinea){
					repetido = 1;
				}
			});
			if(repetido == 0){
				$("#div_alert_modal").css("display", "none");
				$("#tablaLineas").append("<tr class='success text-center'><td><input style='background:none; border:none;' value='"+linea+"' readonly> <input name='linea' value='"+idLinea+"' hidden></td><td>Sin contrato</td><td>Existe en BD</td><td><a style='cursor:pointer;' data-toggle='tooltip' onclick='eliminarLinea(this,\""+idLinea+"\",\""+linea+"\");' ><i class='fa fa-minus text-red'></i></a></td></tr>");  
				$("#linea option:selected").remove();
				actualizarNumeroLineas();
				$("#linea").selectpicker("refresh");
			}
			else{
				$("#div_alert").show();
				$("#p_alert").html("La línea ya existe en la tabla posterior.");
			}
	    	$(".loader").fadeOut("fast");
		});
		$("#linea").focus();
	}
	else{
		$("#div_alert").show();
		$("#p_alert").html("La línea es incorrecta, debe contar con 10 dígitos.");
		$("#linea").val("").focus();
	}
}

function eliminarLinea(elemento,idLinea, linea){ 
	$(".loader").fadeIn("fast", function(){
		$("#linea").append("<option value='"+idLinea+"'>"+linea+"</option>");
		$("#linea").selectpicker("refresh");
	    $(elemento).closest('tr').remove();  
	    actualizarNumeroLineas();
	    $(".loader").fadeOut("fast");
	});
}

function actualizarNumeroLineas(){
    $("#totalLineas").val($('#tablaLineas tbody tr.success').length);
}

function guardar(elemento){
	if($("input[name='linea']").length > 0){
		$(".loader").fadeIn("fast", function(){
			$.ajax({
		   	 	url: 'index.php?accion=guardar',
			    data: {linea : tmp.val(), almacen : $("#almacen").val(), tipo : tipoTmp}, 
			    type:  'post',
			    success:  function (data) {
			    	$(".loader").fadeIn("fast", function(){
						$("input[name='linea']").each(function(i, obj) {
							var tmp = $(this), tipoTmp = tmp.closest("td").next("td").find("input[name='tipo']").val();
							$.ajax({
						   	 	url: 'index.php?accion=guardar',
							    data: {linea : tmp.val(), almacen : $("#almacen").val(), tipo : tipoTmp}, 
							    type:  'post',
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
	}
	else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("No hay datos para guardar.");
	}
}