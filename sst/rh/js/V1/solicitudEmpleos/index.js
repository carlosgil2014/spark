var contar = [], dias = [], diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
$(function () {
	variable = $("#div_alert");
 // alert(variable);
    $("#tblSolicitudEmpleos").DataTable();
	$(".loader").fadeOut("slow"); 
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    
});

function agregar(){
	dias = [];
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalSolicitudEmpleo").html(data);
    		$(".timepicker").timepicker({ showInputs: false, showMeridian: false});
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formAgregar').validator({focus:false});
    		$('#telefonoParticular').inputmask();
    		$('#telefonoRecados').inputmask();
    		$('#telefonoCelular').inputmask();
    		$('#telefonoFamiliar').inputmask();
    		$('#telefonoReferencia').inputmask();
    		$('#telefonoReferencia2').inputmask();
    		$('#telefonoReferencia3').inputmask();
    		$('#telefonoP').inputmask();
    		$('#telefonoM').inputmask();
    		$('#periodoReingreso').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#periodoReingreso').daterangepicker({
    			 autoUpdateInput: false});
    		$('#fechaInicioFin').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#fechaInicioFin').daterangepicker({
    			 autoUpdateInput: false});
    		$('#datosPersonales').hide();
    		$('#datosFamiliares').hide();
    		$('#referenciasPersonales').hide();
    		$('#preparacionAcademica').hide();
    		$('#datosGenerales').hide();
    		$('#conocimientosGenerales').hide();
    		$('#experienciaLaboral').hide();
    		$('#datosReingreso').hide();
			$('.requeridoPuesto').change(function(){
			  if(datosPuesto()){
			    $('#datosPersonales').show();
			  } else{
			    $('#datosPersonales').hide();
			  }
			});
			$('.datosPersonales').change(function(){
			  if(datosPersonales()){
			    $('#datosFamiliares').show();
			    $('#referenciasPersonales').show();
			  } else{
			    $('#datosFamiliares').hide();
			    $('#referenciasPersonales').hide();
			  }
			});
			$('.referenciasPersonales').change(function(){
			  if(referenciasPersonales()){
			    $('#preparacionAcademica').show();
			  } else{
			    $('#preparacionAcademica').hide();
			  }
			});
			$('.preparacionAcademica').change(function(){
			  if(preparacionAcademica()){
			    $('#datosGenerales').show();
			    $('#conocimientosGenerales').show();
			    $('#experienciaLaboral').show();
			    $('#datosReingreso').show();
			  } else{
			    $('#datosGenerales').hide();
			    $('#conocimientosGenerales').hide();
			   	$('#experienciaLaboral').hide();
			    $('#datosReingreso').hide();
			  }
			});

			$('.validarTelefonos').change(function(){
				$(this).each(function(){
	        	var tel = $(this).val().match( /\d+/g);
	        	if (tel===null){$('#mensaje').hide();}else{console.log('b'); tel = tel.join("");}
				if(tel.length === "undefined"){
				  	console.log('undefine');
				  }else if(tel.length != 10){
				    $('#mensaje').addClass('btn btn-danger').html('El telefono debe tener 10 digitos').show();
					return false;
				  }else if(tel.length <= 1){
				    $('#mensaje').hide();
				  }else{
				    $('#mensaje').hide();
				  }
        		});
			});
    	},
	});
	$("#modalSolicitudEmpleo").modal({backdrop: 'static', keyboard: false});
    $("#modalSolicitudEmpleo").modal("show");

}

function datosPuesto(){
	return ( ($('#sueldo').val() != '') && ($('#entrada').val() != '') && ($('#salida').val() != '') && ($('#puesto').val() != -1) );
}
function datosPersonales(){
	return ( ($('#nombres').val() != '') && ($('#apellidoPaterno').val() != '') && ($('#codigoPostal').val() != '') && ($('#calle').val() != '') && ($('#numeroInterior').val() != '')  && ($('#rfc').val() != '') && ($('#curp').val() != '') && ($('#telefonoCelular').val() != '') && ($('#correo').val() != '') );
}
function referenciasPersonales(){
	return ( ($('#nombreReferencia').val() != '') && ($('#telefonoReferencia').val() != '') && ($('#ocupacionReferencia').val() != '') && ($('#tiempoConocerlo').val() != '') );
}
function preparacionAcademica(){
	return ( ($('#escolaridad').val() != 0) && ($('#nombreEscuela').val() != '') && ($('#fechaInicioFin').val() != '') && ($('#anosCursados').val() != '') && ($('#tituloRecibido').val() != '') && ($('#preparacionAcademicaCarrera').val() != '') );
}


$(document).on("submit", "#formularioAgregar", function (e) {
	e.preventDefault();
	var allChecksBoxes = document.querySelectorAll('input[type="checkbox"]');
 	var chkVacio = [].filter.call(allChecksBoxes, function(el) {
	    return !el.checked
	});

	 if (allChecksBoxes.length == chkVacio.length) {
	    $('#mensaje').addClass('btn btn-danger').html('Debe escoger un horario').show();
		return false;
  	}else{
  		$('#mensaje').removeClass('btn btn-danger').html('').hide();
  	}

	$('.validarTelefonos').change(function(){
	$(this).each(function(){
    var tel = $(this).val().match( /\d+/g);
    console.log(tel);
    if (tel===null){$('#mensaje').hide();}else{console.log('b'); tel = tel.join("");}
		if(tel.length === "undefined"){
		console.log('undefine');
	}else if(tel.length != 10){
	$('#mensaje').addClass('btn btn-danger').html('El telefono debe tener 10 digitos').show();
		$(this).focus();
		return false;
	}else if(tel.length <= 1){
	    $('#mensaje').hide();
	}else{
	    $('#mensaje').hide();
		  }
		});
	});
      var frm= $(this).serialize();
       $.ajax({
       type:"POST",
       url: 'index.php?accion=guardar',
       data: frm,
       success: function(data){
	    	if(data == "OK") {
	          window.location.replace("index.php?accion=index&clase=success");
	        }else{
	        	//console.log(data);
	          window.location.replace("index.php?accion=index&clase=danger");
	        }
	       }
       })
});


function agregarFila(){
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
	cajita = '<div class="form-group col-md-3"><div class="form-group"><label>Horario de entrada</label><input type="text" name="horarioEntrada[]" class="form-control " value="'+$('#entrada').val()+'" readonly required></div></div>'; 
	cajita += '<div class="form-group col-md-3"><div class="form-group"><label>Horario de salida</label><input type="text" name="horarioSalida[]" class="form-control" value="'+$('#salida').val()+'" readonly></div></div>';
	cajita += '<div class="form-group col-md-5"><label class="control-label">Dias trabajados</label><input type="hidden" id="diasTrabajados2" name="diasTrabajados2[]" value="'+$('#diasTrabajados').val()+'">"'+$('#diasTrabajados').val()+'"</div>';
	cajita += '<div class="form-group col-md-1"><a><i class="fa fa-minus eliminarFila" style="cursor:pointer" agregarFila()  onclick="eliminarHorario(this,\''+$('#diasTrabajados').val()+'\');" ></i></a></div>';
	cuadro = '<div class="form-group col-md-11 horarios">'+cajita+'</div>';
	$("#prueba").append(cuadro);
	$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});		
	$(".timepicker").timepicker({ showInputs: false });
	$("#diasTrabajados").html(opciones);
	$("#diasTrabajados").selectpicker("refresh");
}

function eliminarHorario(elemento, diasTmp){
	opciones = "";
	$(".loader").fadeIn("fast", function(){
		diasTmp = diasTmp.split(",");
		for(var i = 0; i < diasTmp.length; i++){
			index = dias.indexOf(diasTmp[i]);
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
}

function modificar(id,cp){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id+'&cp='+cp,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalSolicitudEmpleo").html(data);
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    		$('#formEditar').validator({focus:false});
    		$(".timepicker").timepicker({ showInputs: false, showMeridian: false});
    		$('#telefonoParticular').inputmask();
    		$('#telefonoRecados').inputmask();
    		$('#telefonoCelular').inputmask();
    		$('#telefonoFamiliar').inputmask();
    		$('#telefonoReferencia').inputmask();
    		$('#telefonoReferencia2').inputmask();
    		$('#telefonoReferencia3').inputmask();
    		$('#telefonoP').inputmask();
    		$('#telefonoM').inputmask();
    		$('#fechaExperienciaLaboral1').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#fechaExperienciaLaboral1').daterangepicker({
    			 autoUpdateInput: false});
    		$('#fechaExperienciaLaboral2').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#fechaExperienciaLaboral2').daterangepicker({
    			 autoUpdateInput: false});
    		$('#fechaExperienciaLaboral3').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#fechaExperienciaLaboral3').daterangepicker({
    			 autoUpdateInput: false});
    		$('#fechaExperienciaLaboral4').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#fechaExperienciaLaboral4').daterangepicker({
    			 autoUpdateInput: false});
    		$('#periodoReingreso').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#periodoReingreso').daterangepicker({
    			 autoUpdateInput: false});
    		$('#fechaInicioFin').on('apply.daterangepicker', function(ev, picker) {
      		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  			});
    		$('#fechaInicioFin').daterangepicker({
    			 autoUpdateInput: false});
			var allChecksBoxes = document.querySelectorAll('input[type="checkbox"]');
		 	var chkVacio = [].filter.call(allChecksBoxes, function(el) {
			    return !el.checked
			});

			 if (allChecksBoxes.length == chkVacio.length) {
			    $('#mensaje').addClass('btn btn-danger').html('Debe escoger un horario').show();
				return false;
		  	}else{
		  		$('#mensaje').removeClass('btn btn-danger').html('').hide();
		  	}

			$('.validarTelefonos').change(function(){
			$(this).each(function(){
		    var tel = $(this).val().match( /\d+/g);
		    console.log(tel);
		    if (tel===null){$('#mensaje').hide();}else{console.log('b'); tel = tel.join("");}
				if(tel.length === "undefined"){
				console.log('undefine');
			}else if(tel.length != 10){
			$('#mensaje').addClass('btn btn-danger').html('El telefono debe tener 10 digitos').show();
				return false;
			}else if(tel.length <= 1){
			    $('#mensaje').hide();
			}else{
			    $('#mensaje').hide();
				  }
				});
			});
    	},
	});
	$("#modalSolicitudEmpleo").modal({backdrop: 'static', keyboard: false});
    $("#modalSolicitudEmpleo").modal("show");
}



$(document).on("submit", "#formularioModificar", function (e) {
	e.preventDefault();
	var allChecksBoxes = document.querySelectorAll('input[type="checkbox"]');
 	var chkVacio = [].filter.call(allChecksBoxes, function(el) {
	    return !el.checked
	});

	 if (allChecksBoxes.length == chkVacio.length) {
	    $('#mensaje').addClass('btn btn-danger').html('Debe escoger un horario').show();
		return false;
  	}else{
  		$('#mensaje').removeClass('btn btn-danger').html('').hide();
  	}

	$('.validarTelefonos').change(function(){
	$(this).each(function(){
    var tel = $(this).val().match( /\d+/g);
    console.log(tel);
    if (tel===null){$('#mensaje').hide();}else{console.log('b'); tel = tel.join("");}
		if(tel.length === "undefined"){
		console.log('undefine');
	}else if(tel.length != 10){
	$('#mensaje').addClass('btn btn-danger').html('El telefono debe tener 10 digitos').show();
		return false;
	}else if(tel.length <= 1){
	    $('#mensaje').hide();
	}else{
	    $('#mensaje').hide();
		  }
		});
	});
      var frm= $(this).serialize();
       $.ajax({
       type:"POST",
       url: 'index.php?accion=actualizar',
       data: frm,
       success: function(data){
	    	if(data == "OK") {
	          window.location.replace("index.php?accion=index&clase=success");
	        }else{
	        	//alert(data);
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
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}

var codigoExiste = "";
function cp(){
	var cp = $('#codigoPostal').val();
	if (cp=="") {
		cp = $('#codigoPostal').val('');
	}else{
		$.ajax({
   	 	url:   '../../../administrativo/view/representantes/index.php?accion=buscar&cp='+cp,
	    	type:  'post',

	    success:  function (data) {
	    	console.log(data);
	    	data = JSON.parse(data)
	    	if (data==="error") {
	    		$('#mensaje').addClass('btn btn-danger').html('No existe el código postal '+cp).show();
	    		$('#codigoPostal').val(codigoExiste);
	    		$('#opcionSi').hide();
        		$('#opcionNo').hide();
	    	}else{
	    		console.log('aa');
	    		$('#opcionSi').hide();
        		$('#opcionNo').hide();
	    		$('#mensaje').html('').hide().removeClass('btn btn-danger');
	    		$('#idEstado').val(data.idEstado);
	    		$('#delegacion').val(data.delegacion);
	    		$('#estado').val(data.estado);
	    		$('#region').val(data.region);
	    		codigoExiste = data.cp;
	    		colonias = "";
				for (var i = 0; i < data.colonias.length; i++) {
            		colonias += '<option value="' + data.colonias[i].idcp + '">' + data.colonias[i].asentamiento + '</option>';
    			}
    			$('#colonias').html(colonias);
    			$('#colonias').selectpicker("refresh");
	    	}
    	},
	});
	}	
}

function curp(){
	curp = $('#curp').val();
	var curp = curp.toUpperCase();
}

var idSolicitud,cp2;
function validarRfc(){
	rfc = $('#rfc').val();
	var rfc = rfc.toUpperCase();
	$('#rfc').val(rfc);
    if(rfc==""){
        cp = $('#rfc').val();
	}else{
        $(".loader").fadeIn("slow", function(){
    		$.ajax({
       	 	    url:   'index.php?accion=buscarRfc&rfc='+rfc,
    	    	type:  'post',
            success:  function (data) {
                data = JSON.parse(data);
        	if (data==="error") {
        		//$('#mensaje').addClass('btn btn-danger').html('No existe el RFC que ingreso.').show(100).delay(10000).hide(200);
        		$('#mensaje').html('').hide().removeClass('btn btn-danger').delay(0).hide(0);
        		$('#opcionSi').hide();
        		$('#opcionNo').hide(); 
        	}else{
        		rfcRepetido = data.rfc;
        		idSolicitud = data.idSolicitudEmpleo; 
        		cp2 = data.cpDatosPersonales
        		$('#mensaje').addClass('btn btn-danger').html('El RFC '+rfc+' ya existe, ¿desea actualizar los datos?').show();
        		$('#opcionSi').addClass('btn btn-success').html('Si').show();
        		$('#opcionNo').addClass('btn btn-danger').html('No').show();
        		$("#rfc").focus();
        		$('#rfc').val('');
        	}
    	    },
            });
            $(".loader").fadeOut("slow"); 
        });  
	}
}
function cambiarModal(opcion){
	if (opcion=="si") {
		console.log(idSolicitud,cp2);
		modificar(idSolicitud,cp2);
	}else{
		$('#mensaje').addClass('btn btn-success').hide();
		$('#opcionSi').addClass('btn btn-success').hide();
        $('#opcionNo').addClass('btn btn-danger').hide();
        $('#rfc').val('');
        $('#rfc').focus();
	}
}