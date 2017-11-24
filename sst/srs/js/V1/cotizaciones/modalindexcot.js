function modalCotizacion(idCotizacion)
{ 
    $(".loader").fadeIn("slow", function(){
        $.ajax({
            data:{idCotizacion : idCotizacion},
            url:   'view/cotizaciones/index.php?accion=modalIndexCot',
            type:  'post',
            success:  function (data) {
                $("#modalIndex").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $(".loader").fadeOut("fast");
            },
        });
        $("#modalIndex").modal("show");
    });
}

