
$(function () {
    variable = $("#div_alert");
   	$("#tblContraseniasActivos").DataTable();
    $("#tblContraseniasBajas").DataTable();
    $("#tblContraseniasExpiradas").DataTable();
    $(".loader").fadeOut("slow");
    if (typeof variable !== 'undefined' && variable !== null) {
        setTimeout(function(){cerrar("div_alert");}, 3000);
    }

});

function fchExpira(){

var d,m,a;
var fecha = new Date();
var fechaExpiracion = new Date(fecha);
    fechaExpiracion.setDate(fechaExpiracion.getDate() + 90);

    d = fechaExpiracion.getDate();
    m = fechaExpiracion.getMonth() + 1;
    a = fechaExpiracion.getFullYear();

    if(m.toString().length == 1)
        m = "0"+ m;
    if(d.toString().length == 1)
        d = "0"+ d;
    
    return fechaExpiracion = a + '-' + m + '-' + d;
}

function hoy(){
    
    var hoy;
    var d,m,a;
    var fecha = new Date();
    var fechaActual = new Date();

        d = fechaActual.getDate();
        m = fechaActual.getMonth()+1;
        a = fechaActual.getFullYear();

        if(m.toString().length == 1)
            m = "0"+ m;
        if(d.toString().length == 1)
            d = "0"+ d;

        hoy = a + '-' + m + '-' + d;

        return hoy;
}


function editar(idsistemas,id,nombre,correo,contraseniacomp,contraseniacorreo,expira){
   
   //var hoy = hoy();
        
    $.ajax({url: "index.php?accion=editar", 

        success: function(result){
            $("#modal").html(result);
            $("#modal").modal('show');
            $("#modalIdSistemas").val(idsistemas);
            $("#modalId").val(id);
            $("#modalNombre").val(nombre);
            $("#modalCorreo").val(correo);
            $("#modalContraseniaComp").val(contraseniacomp);
            $("#modalContraseniaCorreo").val(contraseniacorreo);
            $("#modalFechaExpira").val(expira);
           // $("#modalFechaCambio").val(hoy());
         
            $('#formEditar').validator({focus:false});
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
    if(d.toString().length == 1)
        d = "0"+ d;
    
    fechaExpiracion = a + '-' + m + '-' + d;
  
  $("#modalFechaExpira").val(fechaExpiracion);
    
});



function agregar(){
    
  
    $.ajax({url: "index.php?accion=consultar", 

        success: function(result){
            $("#modal").html(result);
            $("#modal").modal('show');
            $("#modalFechaExpira").val(fchExpira());
            $("#modalFechaCambio").val(hoy());
            $('#formAgregar').validator({focus:false});
            
            $('.selectpicker').selectpicker({
                style: 'btn-success btn-sm',
                size: 4,
                noneSelectedText: 'Selecciona empleado',
                liveSearchPlaceholder:'Buscar',
                noneResultsText: '¡No existe empleado!',
                countSelectedText:'{0} elementos seleccionados'
                });
        }
    });

}

