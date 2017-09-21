$(function () {
    variable = $("#div_alert");
    $("#tblMarcas").DataTable();
    $(".loader").fadeOut("slow");
    if (typeof variable !== 'undefined' && variable !== null) {
        setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregarMarca(){
    $.ajax({
        url:   '../../view/marcas/index.php?accion=alta',
            type:  'post',
        success:  function (data) {
            $("#agregarProducto").html(data);
            $('#formAgregar').validator({focus:false});

        },
    });
    $("#agregarProducto").modal("show");
}

function modificarMarca(idMarca){
    $.ajax({
        url:   '../../view/marcas/index.php?accion=modificar&idMarca='+idMarca,
            type:  'post',
        success:  function (data) {
            $("#agregarProducto").html(data);
            $('#formEditar').validator({focus:false});

        },
    });
    $("#agregarProducto").modal("show");
}

function eliminarMarca(idMarca,marca){
    //$("#bancoEliminar").html(marca);
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idMarca: idMarca},
                url:   '../../view/marcas/index.php?accion=eliminar&idMarca='+idMarca,
                type:  'post',
                success:  function (data) {
                    if(data == "OK")
                        window.location.replace("index.php?accion=index&activo=4");
                    else{
                        alert(data);
                    }
                },
                
            });
        });
    }); 
}