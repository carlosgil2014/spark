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
 // alert(variable);
    $("#tblPerfiles").DataTable();
	$(".loader").fadeOut("slow"); 
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    $('.selectpicker').selectpicker(parametros);
    //$('.decimal').numeric(",");
    
});

function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalPerfil").html(data);
    		$(".timepicker").timepicker({ showInputs: false, showMeridian: false});
    		$('.selectpicker').selectpicker(parametros);
    		$('#formAgregar').validator({focus:false});
    		$('.decimal').numeric(",");
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
	  if (edad > edadM){
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
    		$(".timepicker").timepicker({ showInputs: false, showMeridian: false});
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
	  if (edad > edadM){
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
						//alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}

function diasSemana(dias){
 if(dias=='semana'){
 	$('#lunes').prop('checked',true);
 	$('#martes').prop('checked',true);
 	$('#miercoles').prop('checked',true);
 	$('#jueves').prop('checked',true);
 	$('#viernes').prop('checked',true);
 	$('#sabado').prop('checked',false);
 	$('#domingo').prop('checked',false);
 }if(dias=='finSemana'){
 	$('#sabado').prop('checked',true);
 	$('#domingo').prop('checked',true);
 	$('#lunes').prop('checked',false);
 	$('#martes').prop('checked',false);
 	$('#miercoles').prop('checked',false);
 	$('#jueves').prop('checked',false);
 	$('#viernes').prop('checked',false);
 }
}

