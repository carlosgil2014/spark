$(function () {
	variable = $("#div_alert");
    // alert(variable);
    $("#tblBancos").DataTable();
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
    		$("#modalBanco").html(data);
    		$('#formAgregar').validator({focus:false});

    	},
	});
    $("#modalBanco").modal("show");
}

function modificar(idBanco){
	$.ajax({
   	 	url:   'index.php?accion=modificar&idBanco='+idBanco,
	    	type:  'post',
	    success:  function (data) {
    		$("#modalBanco").html(data);
    		$('#formEditar').validator({focus:false});

    	},
	});
    $("#modalBanco").modal("show");
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