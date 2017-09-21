$(function () {
    variable = $("#div_alert");
    $("#tblProductos").DataTable();
    $(".loader").fadeOut("slow");
    if (typeof variable !== 'undefined' && variable !== null) {
        setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregarProducto(){
    $.ajax({
        url:   '../../view/productos/index.php?accion=alta',
            type:  'post',
        success:  function (data) {
            $("#agregarProducto").html(data);
            $('#formAgregar').validator({focus:false});

        },
    });
    $("#agregarProducto").modal("show");
}

function modificarProducto(idProducto){
    $.ajax({
        url:   '../../view/productos/index.php?accion=modificar&idProducto='+idProducto,
            type:  'post',
        success:  function (data) {
            $("#agregarProducto").html(data);
            $('#formEditar').validator({focus:false});

        },
    });
    $("#agregarProducto").modal("show");
}

function eliminarProducto(idProducto,producto){
    //$("#bancoEliminar").html(categoria);
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idProducto: idProducto},
                url:   '../../view/productos/index.php?accion=eliminar&idProducto='+idProducto,
                type:  'post',
                success:  function (data) {
                    if(data == "OK")
                        window.location.replace("index.php?accion=index&activo=3");
                    else{
                        alert(data);
                    }
                },
                
            });
        });
    }); 
}