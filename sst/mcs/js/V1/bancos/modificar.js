$(function () {
	variable = $("#div_alert");
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function eliminar(idBanco, banco){
	$("#bancoEliminar").html(banco);
	$("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
		$(".loader").fadeIn("slow", function(){
	    	$.ajax({
		        data:{idBanco: idBanco},
		        url:   'crudBancos.php?accion=eliminar',
		        type:  'post',
		        success:  function (data) {
		        	if(data == "OK")
						window.location.replace("crudBancos.php?accion=index");
					else{
						alert(data);
					}
		        },
	        	
		    });
	    });
	});	
}