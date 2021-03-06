var parametros = {
		style: 'btn-success btn-sm btn-flat',
		noneSelectedText: 'Seleccionar un elemento', 
		liveSearchPlaceholder:'Buscar',
		noneResultsText: '¡No existe el elemento buscado!',
		countSelectedText:'{0} elementos seleccionados',
		actionsBox:true,
		selectAllText: 'Seleccionar todos',
		deselectAllText: 'Deseleccionar todos'
	};

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

function procesar(presupuesto, vacante){
	$(".loader").fadeIn("fast", function(){
		$.ajax({
			data: {presupuesto : presupuesto, vacante : vacante},
	   	 	url: 'index.php?accion=procesar',
		    type:  'post',
		    success:  function (data) {
    			$("#modalProcesar").html(data);
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
    	$("#modalProcesar").modal("show");
	});
}

function buscar(idVacante){
	busqueda = $.trim($("#busqueda").val());
	if(busqueda !== ""){
		$(".loader").fadeIn("fast", function(){
			$.ajax({
				data: {busqueda : busqueda,idVacante : idVacante},
		   	 	url: 'index.php?accion=busqueda',
			    type:  'post',
			    success:  function (data) {
	    			$("#divSolicitudesModal").html(data);
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
	    	$("#modalProcesar").modal("show");
		});
	}
	else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("El campo a buscar no puede estar vacío");
		$(".loader").fadeOut("fast");
	}
}

function postular(elemento,solicitud,vacante){
	tmp = $(elemento); fila = tmp.closest('tr'), repetido = 0;
	$("input[name='solicitud']").each(function(i, obj) {
		if($(this).val() == solicitud){
			repetido = 1;
		}
	});
	if(repetido == 0){
		fila.find('td:last-child').remove();
		fila.append("<td><input type='hidden' name='solicitud[]' value='"+solicitud+"'> <input type='hidden' name='idVacante[]' value='"+vacante+"'> <a style='cursor:pointer;' data-toggle='tooltip' onclick='cancelarPostular(this,\""+solicitud+"\",\""+vacante+"\");'><i class='fa fa-chevron-circle-left text-red'></i></a></td>");
		$("#tblSolicitudesPostular").append("<tr>"+fila.html()+"</tr>");  
		fila.remove();
	}
	else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("No se puede postular la misma solicitud");
		$(".loader").fadeOut("fast");
	}
}

function cancelarPostular(elemento, solicitud,vacante){ 
	tmp = $(elemento); fila = tmp.closest('tr');
	fila.find('td:last-child').remove();
	fila.append("<td><a style='cursor: pointer;' onclick='postular(this, \""+solicitud+"\", \""+vacante+"\");'><i class='fa fa-chevron-circle-right'></i></a></td>");
	$("#tblSolicitudesModal").append("<tr>"+fila.html()+"</tr>");  
	fila.remove();
}

function guardar(elemento){
	var form = new FormData($("#guardar")[0]);
	if($("input[name^='solicitud']").length > 0){
		$(".loader").fadeIn("fast", function(){
			$.ajax({
				contentType: false,
		       	type:"POST",
		       	url: 'index.php?accion=guardarPostulacion',
	   	 		data: form,
	   	 		processData: false,
	  			cache: false,
		       	success: function(data){
			    	if(data == "OK") {
			          window.location.replace("index.php?accion=index&clase=success");
			        }else{
			          window.location.replace("index.php?accion=index&clase=danger");
			        }
		       }
	       	});
	    });
	}else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("No hay datos para guardar.");
	}
}
