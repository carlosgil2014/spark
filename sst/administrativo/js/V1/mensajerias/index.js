$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblMensajeria").DataTable();
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
    		$("#modalMensajeria").html(data);
    		$('#formAgregar').validator({focus:false});

    	},
	});
    $("#modalMensajeria").modal("show");
}

function modificar(idMensajeria,nomMensajeria,urlMsj){
	$.ajax({
   	 	url:   'index.php?accion=modificar',
   	 	type:  'post',
	    success:  function (data) {
    		$("#modalMensajeria").html(data);
    		$("#idMensajeria").val(idMensajeria);
    		$("#nomMensajeria").val(nomMensajeria);
    		$("#urlMensajeria").val(urlMsj);
    		console.log(urlMsj);
    		$('#formEditar').validator({focus:false});

    	},
	});
    $("#modalMensajeria").modal("show");
}

function eliminar(idMensajeria,nomMensajeria){
	$("#mensajeriaEliminar").html(nomMensajeria);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idMensajeria},
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