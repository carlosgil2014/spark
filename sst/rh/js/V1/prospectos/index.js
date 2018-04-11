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
    		$('#tableMatch').hide();
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

function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalPerfil").html(data);
    		$(".timepicker").timepicker({ showInputs: false, showMeridian: false});
    		$('.selectpicker').selectpicker(parametros);
    		$('#formAgregar').validator({focus:false});
    	},
	});
	$("#modalPerfil").modal({backdrop: 'static', keyboard: false});
    $("#modalPerfil").modal("show");
}


$(document).on("submit", "#formularioAgregar", function (e) {
	e.preventDefault();
	var allChecksBoxes = document.querySelectorAll('input[type="checkbox"]');
	var chkVacio = [].filter.call(allChecksBoxes, function(el) {
	    //console.log(el.checked);
	    return !el.checked
	  });

	  if (allChecksBoxes.length == chkVacio.length) {
	  	$('#mensaje').addClass('btn btn-danger').html('Seleccione los dias trabajados.').show(50).delay(5000).hide(200);
	    	return false;
	  }
	  	var edad = $('#edad').val();
	  	var edadM = $('#edadMaxima').val();
	  if (edad >= edadM){
	  	$('#mensaje').addClass('btn btn-danger').html('La edad mínima debe ser menor que la edad maxima.').show(50).delay(5000).hide(200);
	    	return false;
	  }
      var frm= $(this).serialize();
       $.ajax({
       type:"POST",
       url: 'index.php?accion=guardar',
       data: frm,
       success: function(data){
	    	if(data == "OK") {
	          	window.location.replace("index.php?accion=index&clase=success");
	        }else{
	          	window.location.replace("index.php?accion=index&clase=danger");
	        }
	       }
       })
});


function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalPerfil").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formularioModificar').validator({focus:false});
    		$(".timepicker").timepicker({ showInputs: false});

    		$('#salario').on('keypress', function (e) {
			   // console.log(e.keyCode);
			    if (e.keyCode == 101 || e.keyCode == 45 || e.keyCode == 46 || e.keyCode == 43 || e.keyCode == 44 || e.keyCode == 47) {
			        return false;
			    }
			    soloNumeros(e.keyCode);
			});

			function soloNumeros(e) {
			    var key = window.Event ? e.which : e.keyCode
			        return (key >= 48 && key <= 57)
			}
    	},
	});
	$("#modalPerfil").modal({backdrop: 'static', keyboard: false});
    $("#modalPerfil").modal("show");
}


$(document).on("submit", "#formularioModificar", function (e) {
	e.preventDefault();
	var allChecksBoxes = document.querySelectorAll('input[type="checkbox"]');
	var chkVacio = [].filter.call(allChecksBoxes, function(el) {
	    //console.log(el.checked);
	    return !el.checked
	  });

	  if (allChecksBoxes.length == chkVacio.length) {
	  	$('#mensaje').addClass('btn btn-danger').html('Seleccione los dias trabajados.').show(50).delay(5000).hide(200);
	    	return false;
	  }
	  	var edad = $('#edad').val();
	  	var edadM = $('#edadMaxima').val();
	  if (edad >= edadM){
	  	$('#mensaje').addClass('btn btn-danger').html('La edad mínima debe ser menor que la edad maxima.').show(50).delay(5000).hide(200);
	    	return false;
	  }
      var frm= $(this).serialize();
       $.ajax({
       type:"POST",
       url: 'index.php?accion=actualizar',
       data: frm,
       success: function(data){
	    	if(data == "OK") {
	          window.location.replace("index.php?accion=index&clase=success");
	        }else{
	          window.location.replace("index.php?accion=index&clase=danger");
	        }
	       }
       })
});

function eliminar(id){
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{id: id},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index&clase=success");
					else{
						window.location.replace("index.php?accion=index&clase=danger");
					}
		        },
	        	
		    });
	    });
	});	
}



