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
    $("#tblProspectos").DataTable();
    $("#tblProspectosSolicitudes").DataTable();
	$('.selectpicker').selectpicker(parametros);
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function listarProspectos(presupuesto, vacante){
	$.ajax({
	data: {presupuesto : presupuesto, vacante : vacante},
   	 	url:   'index.php?accion=listarProspectos',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalProspecto").html(data);
    		$('#formMatch').validator({focus:false});
    		//$('#tableMatch').hide();
    	},
	});
	$("#modalProspecto").modal({backdrop: 'static', keyboard: false});
    $("#modalProspecto").modal("show");
}

function verMatch(elemento, presupuesto, vacante, solicitudEmpleo){
	$("tr.tmp").remove();
	tmp = $(elemento); fila = tmp.closest('tr');
	$.ajax({
	data: {presupuesto : presupuesto, vacante : vacante, solicitudEmpleo : solicitudEmpleo},
   	 	url:   'index.php?accion=verMatch',
	    	type:  'post',
	    success:  function (data) {
    		fila.after("<tr class='tmp'><td colspan='6'>"+data+"</td></tr>");
    		$(".loader").fadeOut("fast");
    		$('.selectpicker').selectpicker(parametros);
    	},
	});
}

function listarVacantesDisponibles(solicitud){
	$.ajax({
		data: {solicitud : solicitud},
	   	 	url:   'index.php?accion=listarVacantesSolicitadas',
		    	type:  'post',
		    success:  function (data) {
		    	$("#modalProspecto").modal({backdrop: 'static', keyboard: false});
		    	$("#modalProspecto").html(data);
	    	},
		});
		$("#modalProspecto").modal({backdrop: 'static', keyboard: false});
		$("#modalProspecto").modal("show");
}

function verMatch2(elemento,solicitudEmpleo,idPerfil){
	$("tr.tmp").remove();
	tmp = $(elemento); fila = tmp.closest('tr');
	$.ajax({
	data: {solicitudEmpleo : solicitudEmpleo,idPerfil : idPerfil},
   	 	url:   'index.php?accion=verMatch2',
	    	type:  'post',
	    success:  function (data) {
    		fila.after("<tr class='tmp'><td colspan='6'>"+data+"</td></tr>");
    		$(".loader").fadeOut("fast");
    		$('.selectpicker').selectpicker(parametros);
    	},
	});
}


