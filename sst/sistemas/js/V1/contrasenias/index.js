$(function () {
   	$("#tblContrasenias").DataTable();
});

//
function editar(nombre,correo,contraseniacomp,contraseniacorreo,expira){
   
    $.ajax({url: "index.php?accion=editar", 

        success: function(result){
            $("#modalEditar").html(result);
            $("#modalEditar").modal('show');
            $("#modalNombre").val(nombre);
            $("#modalCorreo").val(correo);
            $("#modalContraseniaComp").val(contraseniacomp);
            $("#modalContraseniaCorreo").val(contraseniacorreo);
            $("#modalFechaExpira").val(expira);
        }});

}

$(document).on("change","#modalFechaCambio",function() {
    var d,m,a;
    var fecha = new Date($(this).val());
    var fechaExpiracion = new Date(fecha);
        fechaExpiracion.setDate(fechaExpiracion.getDate() + 91);

        d = fechaExpiracion.getDate();
        m = fechaExpiracion.getMonth() + 1;
        a = fechaExpiracion.getFullYear();

        if(m.toString().length == 1)
            m = "0"+ m;
        if(a.toString().length == 1)
            a = "0"+ a;
        fechaExpiracion = a + '-' + m + '-' + d;
    
        //console.log(fechaExpiracion);

    $("#modalFechaExpira").val(fechaExpiracion);
    
});


function guardar(){

   /* var correo;
    correo=$("#modalCorreo").val();
    
    $.ajax({

    });
    */

    var test;

    test = $("#formEditar").serialize();

    alert(test);
}
