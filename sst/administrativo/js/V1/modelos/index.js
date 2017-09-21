$(function () {
    variable = $("#div_alert");
    $("#tblModelos").DataTable();
    $(".loader").fadeOut("slow");
    if (typeof variable !== 'undefined' && variable !== null) {
        setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function agregarModelo(){
    $.ajax({
        url:   '../../view/modelos/index.php?accion=alta',
            type:  'post',
        success:  function (data) {
            $("#agregarProducto").html(data);
            $('#formAgregar').validator({focus:false});

        },
    });
    $("#agregarProducto").modal("show");
}

function modificarModelo(idModelo){
    $.ajax({
        url:   '../../view/modelos/index.php?accion=modificar&idModelo='+idModelo,
            type:  'post',
        success:  function (data) {
            $("#agregarProducto").html(data);
            $('#formEditar').validator({focus:false});

        },
    });
    $("#agregarProducto").modal("show");
}

function eliminarModelo(idModelo,modelo){
    //$("#bancoEliminar").html(categoria);
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idModelo: idModelo},
                url:   '../../view/modelos/index.php?accion=eliminar&idModelo='+idModelo,
                type:  'post',
                success:  function (data) {
                    if(data == "OK")
                        window.location.replace("index.php?accion=index&activo=5");
                    else{
                        alert(data);
                    }
                },
                
            });
        });
    }); 
}