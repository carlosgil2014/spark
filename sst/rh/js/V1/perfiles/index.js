var contar = [], dias, diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
$(function () {
	variable = $("#div_alert");
 // alert(variable);
    $("#tblPerfiles").DataTable();
	$(".loader").fadeOut("slow"); 
	if (typeof variable !== 'undefined' && variable !== null) {
    	// setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});
	
function agregar(){
	dias = [];
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalPerfil").html(data);
    		$(".timepicker").timepicker({ showInputs: false });
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formAgregar').validator({focus:false});

				$(".diasTrabajados").change(function(){
            		x = $(this).val();
            		// console.log(x);
            		if (x != null) {
	            		if (x.indexOf("Lunes") == -1) {
	            			$('#lunes').prop("checked", false);
	            			$('#lunesDescanso').prop("checked", true);
	            		}else{
	            			$('#lunes').prop("checked", true);
	            			$('#lunesDescanso').prop("checked", false);
	            		}
	            		if (x.indexOf("Martes") == -1) {
	            			$('#martes').prop("checked", false);
	            			$('#martesDescanso').prop("checked", true);
	            		}else{
	            			$('#martes').prop("checked", true);
	            			$('#martesDescanso').prop("checked", false);
	            		}
	            		if (x.indexOf("Miércoles") == -1) {
	            			$('#miercoles').prop("checked", false);
	            			$('#miercolesDescanso').prop("checked", true);
	            		}else{
	            			$('#miercoles').prop("checked", true);
	            			$('#miercolesDescanso').prop("checked", false);
	            		}
	            		if (x.indexOf("Jueves") == -1) {
	            			$('#jueves').prop("checked", false);
	            			$('#juevesDescanso').prop("checked", true);
	            		}else{
	            			$('#jueves').prop("checked", true);
	            			$('#juevesDescanso').prop("checked", false);
	            		}
	            		if (x.indexOf("Viernes") == -1) {
	            			$('#viernes').prop("checked", false);
	            			$('#viernesDescanso').prop("checked", true);
	            		}else{
	            			$('#viernes').prop("checked", true);
	            			$('#viernesDescanso').prop("checked", false);
	            		}
	            		if (x.indexOf("Sábado") == -1) {
	            			$('#sabado').prop("checked", false);
	            			$('#sabadoDescanso').prop("checked", true);
	            		}else{
	            			$('#sabado').prop("checked", true);
	            			$('#sabadoDescanso').prop("checked", false);
	            		}
	            		if (x.indexOf("Domingo") == -1) {
	            			$('#domingo').prop("checked", false);
	            			$('#domingoDescanso').prop("checked", true);
	            		}else{
	            			$('#domingo').prop("checked", true);
	            			$('#domingoDescanso').prop("checked", true);
	            		}
	            	}else{
	            		$('#lunes').prop("checked", false);
	            		$('#martes').prop("checked", false);
	            		$('#miercole').prop("checked", false);
	            		$('#jueves').prop("checked", false);
	            		$('#viernes').prop("checked", false);
	            		$('#sabado').prop("checked", false);
	            		$('#domingo').prop("checked", false);
	            	}
				});

    	},
	});
    $("#modalPerfil").modal("show");
}
function agregarFila(){
	diasTmp = [], opciones = "";
	$('.diasTrabajados').each(function(i, obj) {
		dias = $.merge(dias,$(this).val());
	});
	dias = $.unique(dias);

	$.grep(diasSemana, function(el) {
        if ($.inArray(el, dias) == -1) diasTmp.push(el);
	});

	for(var i = 0; i < diasTmp.length; i++){
		opciones += "<option>" + diasTmp[i] + "</option> ";  
	}
	cajita = '<div class="form-group col-md-3"><div class="bootstrap-timepicker"><div class="form-group"><label>Horarios</label><div class="input-group"><input type="text" class="form-control timepicker" name="horariosEntrada[]"><div class="input-group-addon"><i class="fa fa-clock-o"></i></div></div></div></div></div>'; 
	cajita += '<div class="form-group col-md-3"><div class="bootstrap-timepicker"><div class="form-group"><label></label><div class="input-group"><input type="text" class="form-control timepicker" name="horariosSalida[]"><div class="input-group-addon"><i class="fa fa-clock-o"></i></div></div></div></div></div>';
	cajita += '<div class="form-group col-md-5"><label class="control-label">Dias trabajados</label><select class="form-control input-sm selectpicker diasTrabajados" name="diasTrabajados[]" multiple name="Datos[]" data-error="Es un campo obligatorio" required="required" id="diasTrabajados2">'+opciones+'</select></div>';
	cajita += '<div class="form-group col-md-1"><a><i class="fa fa-minus eliminarFila" style="cursor:pointer" agregarFila()  onclick="eliminarFila();" ></i></a></div>';
	cuadro = '<div class="form-group col-md-11" id="cuadro">'+cajita+'</div>';
	$("#prueba").append(cuadro);
	$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});		
	$(".timepicker").timepicker({ showInputs: false });
	$(".diasTrabajados").selectpicker("refresh");

}

function eliminarFila(){  
    $('#cuadro').remove()  
}

function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalSalario").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formEditar').validator({focus:false});
    	},
	});
    $("#modalSalario").modal("show");
}

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
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}
