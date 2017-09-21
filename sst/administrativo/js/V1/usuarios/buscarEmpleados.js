$(document).ready(function(){
    $("#empleados").DataTable();
	$(".loader").fadeOut("slow"); 
});

function goBack() 
{
    window.history.back();
}


function crearUsuario(idEmpleado, nombre){
    $("#empleadoNombre").html(nombre);
    $("#modalContinuar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#continuar", function (e) {
        window.location.replace("index.php?accion=alta&idEmpleado="+idEmpleado);
    }); 
}


function cerrar(id_elemento)
{
	document.getElementById(id_elemento).style.display="none";
}