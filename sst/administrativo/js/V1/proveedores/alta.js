$(function () {
	
	variable = $("#div_alert");
	$('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    //Personalizar los campos telefónicos
	$("[data-mask]").inputmask();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }

    $('[data-toggle="tooltip"]').tooltip({
	    trigger : 'hover'
	});
	
});

$('input[name="tabs"]').click(function () {
    $(this).tab('show');
});


function validarDias(dias,tipo){
	var otro = $("#otro_" + tipo);
	if(dias.value == "Otro"){
		otro.prop("readonly",false);
		otro.prop("required",true);
		otro.val('');
		otro.focus();
	}
	else{
		otro.prop("readonly",true);
		otro.prop("required",false);
		otro.val(dias.value);
		dias.focus();
	}	
}

function cargarEstados(pais){
	var estados = $("#estados");

	$(".loader").fadeIn("slow", function(){
		$.ajax(
		{
			data:{pais: pais.value},
	    	url:   "../estados/index.php?accion=listar",
	    	type:  "post",
	    	success:  function (data) 
	    	{
				estados.html(data);
				estados.selectpicker("refresh");
	    		$(".loader").fadeOut("slow");
	    	}
		});
	});


	
}