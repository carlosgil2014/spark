$(document).ready(function(){
    variable = $("#div_alert");
    $("#empleados").DataTable();
    $(".loader").fadeOut("slow"); 
    if (typeof variable !== 'undefined' && variable !== null) {
        setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function actualizarModulo(idUsuario, nombre, valor, columna){
    $("#empleadoNombre").html(nombre);
    $("#modulo").html(columna.toUpperCase());
    $("#modalActualizarModulo").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#continuar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idUsuario : idUsuario, columna : columna, valor : valor},
                url:   'index.php?accion=actualizarModulo',
                type:  'post',
                success:  function (data) {
                    if(data === "OK"){
                        $("#p_alert").html("Se actualizó el estado correctamente.");
                        $("#clase_alert").attr("class","alert alert-success");
                        window.location.replace("index.php?accion=index");
                    }
                    else{
                        $("#p_alert").html(data);
                        $("#clase_alert").attr("class","alert alert-danger");
                    }
                    $("#div_alert").css("display","block");
                    $(".loader").fadeOut("fast");
                },
                
            });
        });
    }); 
}
