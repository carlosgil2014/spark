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


/*function agregarFila(){
	if ($('#diasTrabajados option:selected')=="") {
		$('#entrada').hide();
		$('#salida').hide();
		$("#diasTrabajados").hide();		
	}else{
		$('#entrada').show();
		$('#salida').show();
		$("#telefonoExtension").attr("required","required");
	}
	diasTmp = [], opciones = "";
	$('#diasTrabajados option:selected').each(function(i, obj) {
		//concatena dias y this
		dias.push($(this).val());
	});
	//elimina nodos duplicados

	$.grep(diasSemana, function(el) {
        if ($.inArray(el, dias) == -1) diasTmp.push(el);
	});

	for(var i = 0; i < diasTmp.length; i++){
		opciones += "<option>" + diasTmp[i] + "</option> ";  
	}
	cajita = '<div class="form-group col-md-3"><div class="form-group"><label>Horarios</label><input type="text" name="horarioEntrada[]" class="form-control " value="'+$('#entrada').val()+'" readonly required></div></div>'; 
	cajita += '<div class="form-group col-md-3"><div class="form-group"><label></label><input type="text" name="horarioSalida[]" class="form-control" value="'+$('#entrada').val()+'" readonly></div></div>';
	cajita += '<div class="form-group col-md-5"><label class="control-label">Dias trabajados</label><input type="hidden" name="diasTrabajados2[]" value="'+$('#diasTrabajados').val()+'">"'+$('#diasTrabajados').val()+'"</div>';
	cajita += '<div class="form-group col-md-1"><a><i class="fa fa-minus eliminarFila" style="cursor:pointer" agregarFila()  onclick="eliminarHorario(this,\''+$('#diasTrabajados').val()+'\');" ></i></a></div>';
	cuadro = '<div class="form-group col-md-11 horarios">'+cajita+'</div>';
	$("#prueba").append(cuadro);
	$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});		
	$(".timepicker").timepicker({ showInputs: false });
	// console.log(dias);
	$("#diasTrabajados").html(opciones);
	$("#diasTrabajados").selectpicker("refresh");
}

function eliminarHorario(elemento, diasTmp){
	opciones = "";
	$(".loader").fadeIn("fast", function(){
		diasTmp = diasTmp.split(",");
		for(var i = 0; i < diasTmp.length; i++){
			index = dias.indexOf(diasTmp[i]);
			console.log(index);
			if (index > -1) {
    			dias.splice(index, 1);
			}
			opciones += "<option>" + diasTmp[i] + "</option>";  
		}
		$("#diasTrabajados").append(opciones);
		$("#diasTrabajados").selectpicker("refresh");
	    $(elemento).closest('div.horarios').remove();  
	    $(".loader").fadeOut("fast");
	});
}*/

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


/*function guardar(){
	if($("input[name='horarioEntrada']").length > 0){
		$(".loader").fadeIn("fast", function(){
			$("input[name='sim']").each(function(i, obj) {
				var tmp = $(this), tipoTmp = tmp.closest("td").next("td").find("input[name='tipo']").val();
				$.ajax({
			   	 	url: 'index.php?accion=guardar',
				    data: {icc : tmp.val(), almacen : $("#almacen").val(), tipo : tipoTmp}, 
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
	}
	else{
		$("#div_alert_modal").show();
		$("#p_alert_modal").html("No hay datos para guardar.");
	}
};*/

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




