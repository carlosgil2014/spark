var minutos = 0, temporizador, cuentaRegresiva;

$(document).ready(function (){
    // Incrementar la variable minutos cada minuto. 
    temporizador = setInterval(tiempoInactivo, 1000); // 1 segundo
    // setInterval(validarSesion, 1000);
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
        if((minutos == 300 || localStorage.sesion === "Inactiva") && $('#modalExpiracion').is(':visible') == false){ //Después de 5 minutos (300)
            mostrarAlerta();
            localStorage.sesion = "Inactiva";
        }
        if(minutos == 600){ // 10 minutos (600)
            localStorage.sesion = "Expirada";
        }
        if(localStorage.sesion === "Expirada") { //Después de 15 minutos
            cerrarSesion();
        }
    }
}

// function validarSesion(){
//     $.ajax({
//         url: '/sst/view/index.php?accion=validarSesion',
//         success:  function (data) {
//             if(data == "Expiró"){
//                 cerrarSesion();
//             }
//         },
//     });
// }

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

function eliminarFila(elemento){ 
    $(elemento).closest('tr').remove();  
}

function validarEnteroPositivo(elemento){ 
    tmp = $(elemento), valor = parseInt(Math.round(tmp.val()));
    (isNaN(valor) || valor < 1) ? tmp.val("") : tmp.val(""); tmp.val(valor);
    return true;
}

function validarDecimalPositivo(elemento){ 
    tmp = $(elemento), valor = parseFloat(tmp.val());
    //console.log(valor);
    if( isNaN(valor) || valor < 1){
        tmp.val("")
    }
}


function porcentajeBarra(elemento, porcentaje, html){
    elemento.css("width", porcentaje);
    elemento.html(html);
}

function validarInputsNumerico(nombre){
    resultado = true;
    $("input[name='"+nombre+"']").each(function(i, obj) {
        tmp = $.trim($(this).val());
        if(tmp === "" || tmp <= 0) resultado = false;
    });
    return resultado;
}