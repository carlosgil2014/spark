$(function () {
	variable = $("#div_alert");
    $("#tblCategorias").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregarCategoria(){
	$.ajax({
   	 	url:   'index.php?accion=alta',
	    	type:  'post',
	    success:  function (data) {
    		$("#agregarCategoria").html(data);
    		$('#formAgregar').validator({focus:false});

    	},
	});
    $("#agregarCategoria").modal("show");
}

function modificarCategoria(idCategoria){
    console.log(idCategoria);
    $.ajax({
        url:   'index.php?accion=modificar&idCategoria='+idCategoria,
            type:  'post',
        success:  function (data) {
            $("#agregarCategoria").html(data);
            $('#formEditar').validator({focus:false});

        },
    });
    $("#agregarCategoria").modal("show");
}

function eliminarCategoria(idCategoria,categoria){
    //$("#categoriaEliminar").html("");
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idCategoria: idCategoria},
                url:   'index.php?accion=eliminar',
                type:  'post',
                success:  function (data) {
                    if(data == "OK")
                        window.location.replace("index.php?accion=index&activo=1");
                    else{
                        //$('#respuesta').html(data);
                        //$('#respuesta').html(data);
                        //$('#respuesta').toggle('slow');
                        //$('#div_alert').html(data);
                        window.location.replace("index.php?accion=index&activo=1");
                    }
                },
                
            });
        });
    }); 
}