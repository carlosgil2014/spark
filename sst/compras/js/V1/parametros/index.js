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
    $("#tblProductos").DataTable();
    $("#tblServicios").DataTable();
    $("#tblUnidades").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});


function agregarProducto(){
	$.ajax({
   	 	url: '../productos/index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    		$('#formAgregar').validator({focus:false});
    		$('#clientes').selectpicker(parametros);
    	},
	});
    $("#modalParametros").modal("show");
}

function modificarProducto(idProducto){
	$.ajax({
   	 	url: '../productos/index.php?accion=modificar&idProducto='+idProducto,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    		$('#formEditar').validator({focus:false});
    		$('#clientes').selectpicker(parametros);
    	},
	});
    $("#modalParametros").modal("show");
}

function eliminarProducto(idProducto, producto){
	$.ajax({
   	 	url: '../productos/index.php?accion=confirmacion&idProducto='+idProducto+'&producto='+producto,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    	},
	});
    $("#modalParametros").modal("show");
}

function agregarServicio(){
	$.ajax({
   	 	url: '../servicios/index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    		$('#formAgregar').validator({focus:false});
    		$('#clientes').selectpicker(parametros);
    	},
	});
    $("#modalParametros").modal("show");
}

function modificarServicio(idServicio){
	$.ajax({
   	 	url: '../servicios/index.php?accion=modificar&idServicio='+idServicio,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    		$('#formEditar').validator({focus:false});
    		$('#clientes').selectpicker(parametros);
    	},
	});
    $("#modalParametros").modal("show");
}

function eliminarServicio(idServicio, servicio){
	$.ajax({
   	 	url: '../servicios/index.php?accion=confirmacion&idServicio='+idServicio+'&servicio='+servicio,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    	},
	});
    $("#modalParametros").modal("show");
}

function agregarUnidad(){
	$.ajax({
   	 	url: '../unidades/index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    		$('#formAgregar').validator({focus:false});
    	},
	});
    $("#modalParametros").modal("show");
}

function modificarUnidad(idUnidad){
	$.ajax({
   	 	url: '../unidades/index.php?accion=modificar&idUnidad='+idUnidad,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    		$('#formEditar').validator({focus:false});
    	},
	});
    $("#modalParametros").modal("show");
}

function eliminar(idUnidad, unidad){
	$.ajax({
   	 	url: '../unidades/index.php?accion=confirmacion&idUnidad='+idUnidad+'&unidad='+unidad,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalParametros").html(data);
    	},
	});
    $("#modalParametros").modal("show");
}