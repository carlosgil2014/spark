$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblAsignaciones").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregar(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalAsignacion").html(data);
    		$('#formAgregar').validator({focus:false});
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    	},
	});
    $("#modalAsignacion").modal("show");
}

function agregarCliente(){
	$.ajax({
   	 	url:   'index.php?accion=altaPorClientes',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalAsignacion").html(data);
    		$('#formAgregar').validator({focus:false});
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    	},
	});
    $("#modalAsignacion").modal("show");
}

function modificar(id){
	$.ajax({
   	 	url:   'index.php?accion=modificar&id='+id,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalAsignacion").html(data);
    		$('#formEditar').validator({focus:false});
    		$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    	},
	});
    $("#modalAsignacion").modal("show");
}

function eliminar(idBanco, banco){
	$("#bancoEliminar").html(banco);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idBanco: idBanco},
		        url:   'index.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("index.php?accion=index");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}

function buscarImei(){
	var imei = $('#imei').val();
	if (imei=="") {
		imei = $('#imei').val('');
	}else{
		$.ajax({
   	 	url:   'index.php?accion=buscarImei&imei='+imei,
	    	type:  'post',
	    success:  function (data) {
		    	data = JSON.parse(data)
		    	if (data==="error") {
		    		$('#marca').val('');
		    		$('#modelo').val('');
		    	}else{
		    		$('#marca').val(data.marca);
		    		$('#modelo').val(data.model);
		    	}
    		},
		});
	}	
}	

function obtenerICC(){
	var idLinea = $('#idLinea').val();
		if (idLinea== 0) {
		idLinea = $('#idLinea').val('');
	}else{
		$.ajax({
   	 	url:   '../sims/index.php?accion=buscarICC&idLinea='+idLinea,
	    	type:  'post',
	    success:  function (data) {
	    		data = JSON.parse(data)
		    	if (data==="error") {
		    		$('#icc').val('');
		    	}else{
		    		$('#icc').val(data.icc);
		    		$('#idSim').val(data.idSim);
		    	}
    		},
		});
	}	
}


function añadirLineaSIM(valor){
	if($("#idLinea").val() == 0 || $("#imei").val() == 0) {
		return;
	}
	var idlinea = $('#idLinea option:selected').val(),idIMEI = $('#imei option:selected').val();
	var linea = $('#idLinea option:selected').text(), IMEI = $('#imei option:selected').text(), patt = new RegExp("[0-9]{10}"), res = patt.test(linea), patt1 = new RegExp("[0-9]{10}"), res1 = patt1.test(linea),patt2 = new RegExp("[0-9]{15}"),res3 = patt2.test(IMEI),patt3 = new RegExp("[0-9]{15}"),res4 = patt3.test(IMEI), repetido = 0;
	console.log(linea);
	if((res || res1) && linea.length == 10 ){
		$(".loader").fadeIn("fast", function(){
			$("input[name='lineas']").each(function(i, obj) {
				if($(this).val() === idlinea){
					repetido = 1;
				}
			});
			$("input[name='imeis']").each(function(i, obj) {
				if($(this).val() == idIMEI){
					repetido = 1;
				}
			});
			if(repetido == 0){
				$("#div_alert_modal").css("display", "none");
				$("#tablaLineaSim").append("<tr><td><input style='background:none; border:none;' value='"+linea+"' readonly><input type='hidden' name='lineas' value='"+idlinea+"'></td><td><input style='background:none; border:none;' value='"+IMEI+"' readonly><input type='hidden' name='imeis' value='"+idIMEI+"'></td><td><a style='cursor:pointer;' data-toggle='tooltip' onclick='eliminarFila(this);''><i class='fa fa-minus text-red'></i></a></td></tr>");  
			}
			else{
				$("#div_alert_modal").show();
				$("#p_alert_modal").html("La linea o IMEI ya existe en la tabla posterior.");
			}
	    	$(".loader").fadeOut("fast");
		});
	}
	else{
		if(variable == "botón"){
			$("#div_alert_modal").show();
			$("#p_alert_modal").html("La linea es incorrecta. Debe contener 10 dígitos.");
			$("#sim").val("").focus();
		}
	}
}

function eliminarFila(elemento){ 
	$(elemento).closest('tr').remove();  
}

function guardar(elemento){
	var valor = 5;
	if($("input[name='lineas']").length > 0 && $("input[name='imeis']").length > 0){
		$(".loader").fadeIn("fast", function(){
			$("input[name='lineas']").each(function(i, obj) {
				var tmp = $(this), imeiTmp = tmp.closest("td").next("td").find("input[name='imeis']").val();
				console.log(tmp);
				console.log(imeiTmp);
				$.ajax({
			   	 	url: 'index.php?accion=guardar',
				    data: {linea : tmp.val(), responsable : $("#idEmpleado").val(), imei : imeiTmp, cuenta : $("#cliente").val()}, 
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
}

function historial(id){
    $.ajax({
      'method': 'POST',
      'url': 'index.php?accion=historial',
      'data': 'id='+id,
    }).done(function(resultado){
    $("#modalAsignacion").html(resultado);
    $('#modalAsignacion').modal({
          show:true
        });
  });
}