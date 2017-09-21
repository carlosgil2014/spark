$(function () {
    variable = $("#div_alert");
    $("#tblSubcategorias").DataTable();
    $(".loader").fadeOut("slow");
    if (typeof variable !== 'undefined' && variable !== null) {
        setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregarSubCategoria(){
    $.ajax({
        url:   '../../view/subcategorias/index.php?accion=alta',
            type:  'post',
        success:  function (data) {
            $("#agregarSubCategoria").html(data);
            $('#formAgregar').validator({focus:false});

        },
    });
    $("#agregarSubCategoria").modal("show");
}

function modificarSubCategoria(idSubcategoria){
    $.ajax({
        url:   '../../view/subcategorias/index.php?accion=modificar&idSubcategoria='+idSubcategoria,
            type:  'post',
        success:  function (data) {
            $("#agregarSubCategoria").html(data);
            $('#formEditar').validator({focus:false});

        },
    });
    $("#agregarSubCategoria").modal("show");
}

function eliminarSubCategoria(idSubcategoria,categoria){
    //$("#bancoEliminar").html(categoria);
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idSubcategoria: idSubcategoria},
                url:   '../../view/subcategorias/index.php?accion=eliminar&idSubcategoria='+idSubcategoria,
                type:  'post',
                success:  function (data) {
                    console.log(data);
                    if(data == "OK")
                        window.location.replace("index.php?accion=index&activo=2");
                    else{
                        window.location.replace("index.php?accion=index&activo=2");
                    }
                },
                
            });
        });
    }); 
}