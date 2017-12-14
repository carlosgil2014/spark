var minutos = 0, temporizador, tiempo = {hora: 0, minuto: 0, segundo: 0};
$(document).ready(function () {
    // Incrementar la variable minutos cada minuto. 
    temporizador = setInterval(tiempoInactivo, 60000); // 1 minuto

    //Reiniciar la variable minutos si hay actividad
    $(this).mousemove(function (e) {
        reiniciarTiempo();
    });
    $(this).keypress(function (e) {
        reiniciarTiempo();
    });

});

function tiempoInactivo() {
    minutos = minutos + 1;
    if (localStorage.getItem("minutos") === null) {
        localStorage.setItem("minutos",minutos);
    }
    
    if(localStorage.getItem("minutos") == 20) { // Después de 15 minutos
        mostrarAlerta();
    }
    if(localStorage.getItem("minutos") == 40) { // Después de 15 minutos
        cerrarSesion();
    }
   
}

function mostrarAlerta() {
    $("#modalExpiracion").modal("show");
}

function reiniciarTiempo() {
    minutos = 0;
    $("#modalExpiracion").modal('hide');
    clearInterval(temporizador);
    temporizador = setInterval(tiempoInactivo, 60000);
}

function cerrarSesion() {
    localStorage.removeItem("minutos");
    window.location = '../controller/crudIndex.php?urlValue=logout';
}

