var parametros = {
					style: 'btn-success btn-sm',
					size: 2,
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

function cargaMasiva(){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
	   	 	url: 'index.php?accion=cargaMasiva',
		    	type:  'post',
		    success:  function (data) {
    			$("#modalSim").html(data);
	    		$('.almacen').selectpicker(parametros);
	    		$(".loader").fadeOut("fast");
	    	},
		});
    	$("#modalSim").modal("show");
	});
}

function añadirSim(){
	var str = $("#sim").val(), patt = new RegExp("[0-9]{19}F"), res = patt.test(str), patt1 = new RegExp("[0-9]{19}f"), res1 = patt1.test(str), repetido = 0;
	$("#div_alert_modal").css("display", "none");
	if((res || res1) && str.length == 20){

		$(".loader").fadeIn("fast", function(){
			$("input[name='sims']").each(function(i, obj) {
				if($(this).val() == str){
					repetido = 1;
				}
			});
			if(repetido == 0){
				$("#tablaSims").append("<tr><td><input name='sims' style='background:none; border:none;' value='"+str+"' readonly></td><td><a style='cursor:pointer;' data-toggle='tooltip' onclick='eliminarFila(this);''><i class='fa fa-minus text-red'></i></a></td></tr>");  
			}
			else{
				$("#div_alert_modal").css("display", "block");
				$("#p_alert_modal").html("El ICC está repetido.");
			}
	    	$(".loader").fadeOut("fast");
		});
	}
	else{
		$("#div_alert_modal").css("display", "block");
		$("#p_alert_modal").html("El ICC es incorrecto. Debe contener 19 dígitos y una letra \"F\".");
	}
}

function eliminarFila(elemento){ 
	$(elemento).closest('tr').remove();  
}

function guardar(elemento){
	if($("input[name='sims']").length > 0){
		$(".loader").fadeIn("fast", function(){
			$("input[name='sims']").each(function(i, obj) {
				var tmp = $(this);
				$.ajax({
			   	 	url: 'index.php?accion=guardar',
				    data: {icc : tmp.val(), almacen : $("#almacen").val()}, 
				    type:  'post',
				    success:  function (data) {
				    	clase = "success";
				    	if(data != "OK"){
				    		clase = "danger";
				    	}
		    			tmp.closest("td").next("td").attr("class", clase);
		    			tmp.closest("td").next("td").html(data);
			    	},
				}).done( function() {
					// $(elemento).remove();
				}).fail( function( jqXHR, textStatus, errorThrown ) {
				  	if(jqXHR.status === 0) {
						$("#div_alert_modal").css("display", "block");
						$("#p_alert_modal").html("No hay conexión a internet, verifique e intente nuevamente.");
					}
				});
			});
		    $(".loader").fadeOut("fast");
		});
	}
	else{
		$("#div_alert_modal").css("display", "block");
		$("#p_alert_modal").html("No hay datos para guardar.");
	}
}