$(document).on("click",".imgDetalleCot",function()
{ 
	//alert();
    var idCotizacion=$(this).attr("value");
    //alert(idCotizacion);
    $.post( "../controller/crudCotizaciones.php?accion=modalIndexCot",{  idCotizacion : idCotizacion },function(data)
    {
    	 
       	$("#IdModalCotizacion").html(data);
       	$('[data-toggle="tooltip"]').tooltip();
    });
});

$(document).on("click","#idBtnModificar",function()
{
    var idCotizacion = $(this).val();
    //$.post("../controller/crudCotizaciones.php?accion=modificarCotizacion&idCotizacion="+idCotizacion);
    document.location.href="../controller/crudCotizaciones.php?accion=modificarCotizacion&idCotizacion="+idCotizacion;
    
});

