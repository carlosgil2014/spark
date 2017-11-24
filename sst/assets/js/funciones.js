var minutos = 0, temporizador, cuentaRegresiva;

$(document).ready(function (){
    // Incrementar la variable minutos cada minuto. 
    temporizador = setInterval(tiempoInactivo, 1000); // 1 segundo

    //Reiniciar la variable minutos si hay actividad
    $(this).mousemove(function (e) {
        reiniciarTiempo();
    });
    $(this).keypress(function (e) {
        reiniciarTiempo();
    });

});

function tiempoInactivo(){
    minutos = minutos + 1;
    if (localStorage.sesion === null || minutos === 1) {    
        localStorage.sesion = "Activa";
    }
    else{
        if(localStorage.sesion === "Reiniciada"){
            minutos = 0;
            $("#modalExpiracion").modal('hide'); 
            $("#tiempoExpiracion").html("5 : 00");  
            clearInterval(cuentaRegresiva);   
        }
        if((minutos == 300 || localStorage.sesion === "Inactiva") && $('#modalExpiracion').is(':visible') == false){ //Después de 5 minutos
            mostrarAlerta();
            localStorage.sesion = "Inactiva";
        }
        if(minutos == 600){ // 10 minutos
            localStorage.sesion = "Expirada";
        }
        if(localStorage.sesion === "Expirada") { //Después de 15 minutos
            cerrarSesion();
        }
    }
}

function mostrarAlerta(){
    var min = 4, seg = 59;
    $("#modalExpiracion").modal("show");
    cuentaRegresiva = setInterval(function() {
        if(seg < 10) 
            seg = "0" + seg;
        $("#tiempoExpiracion").html(min + " : " + seg);
        seg--;
        if(seg === -1){min --; seg = 59;}
        if (min == 0 && seg == "00") {
            clearInterval(cuentaRegresiva);
        }
    }, 1000);
}

function reiniciarTiempo(){
    minutos = 0;
    localStorage.sesion = "Reiniciada";
    $("#modalExpiracion").modal('hide');
    $("#tiempoExpiracion").html("5 : 00");
    clearInterval(temporizador);
    clearInterval(cuentaRegresiva);
    temporizador = setInterval(tiempoInactivo, 1000);
}

function cerrarSesion() {
    localStorage.removeItem("minutos");
    window.location = '/sst/view/index.php?accion=logout';
}


function cerrar(id_elemento){
	document.getElementById(id_elemento).style.display="none";
}

function goBack() {
    window.history.back();
}