$(function () {
	variable = $("#div_alert");
    $("#tblclaseMexico").DataTable();
	$(".loader").fadeOut("slow");
	if (typeof variable !== 'undefined' && variable !== null) {
    	setTimeout(function(){cerrar("div_alert");}, 3000);
    }
});

function ver(id){
    $.ajax({
        url:   'index.php?accion=verDatos&id='+id,
            type:  'post',
        success:  function (data) {
            $("#modalModificar").html(data);
            $('#formModificar').validator({focus:false});

        },
    });
    $("#modalModificar").modal("show");
}

function verProveedor(id){
    $.ajax({
        url:   'index.php?accion=verProveedor&id='+id,
            type:  'post',
        success:  function (data) {
            $("#modalModificar").html(data);
            $('#formModificar').validator({focus:false});

        },
    });
    $("#modalModificar").modal("show");
}

function verCliente(id){
    $.ajax({
        url:   'index.php?accion=verCliente&id='+id,
            type:  'post',
        success:  function (data) {
            $("#modalModificar").html(data);
            $('#formModificar').validator({focus:false});

        },
    });
    $("#modalModificar").modal("show");
}

function agregarUsuario(id,estado){
	$.ajax({
   	 	url:   'index.php?accion=alta&id='+id+'&estado='+estado,
	    	type:  'post',
	    success:  function (data) {
    		$("#agregar").html(data);
    		$('#formAgregar').validator({focus:false});
            $("#conmutador").inputmask();
            $("#telefonoExtension").inputmask();
            $("#telefonoCelular").inputmask();
            $("#telefonoCasa").inputmask();
            $("#telefonoAlterno").inputmask();
            $("#conmutador").keyup(function(){
                var tel = $("#conmutador").val().match( /\d+/g);
                tel = tel.join("");
                if (tel=="null") {
                    $("#telefonoExtension").attr("readonly","readonly");
                    $('#telefonoExtension').val('');
                }else if(tel.length === "undefined"){
                    $("#telefonoExtension").attr("readonly","readonly");
                    $('#telefonoExtension').val('');
                }else if(tel.length==10){
                    $("#telefonoExtension").removeAttr("readonly");
                }else{
                    $("#telefonoExtension").attr("readonly","readonly");
                    $('#telefonoExtension').val('');  
                }
            });

    	},
	});
            $("#agregar").modal("show");
}



function modificar(id){
    $.ajax({
        url:   'index.php?accion=modificar&id='+id,
            type:  'post',
        success:  function (data) {
            $("#modalModificar").html(data);
            $('#formModificar').validator({focus:false});
            $("#telefono").inputmask();
            $("#telfonoExt").inputmask();
            $("#telfonoCel").inputmask();
            $("#telfonoCasa").inputmask();
            $("#telAlterno").inputmask();
            $("#telefono").keyup(function(){
                var tel = $("#telefono").val().match( /\d+/g);
                tel = tel.join("");
                if (tel=="null") {
                    $("#telfonoExt").attr("readonly","readonly");
                    $('#telfonoExt').val('');
                }else if(tel.length === "undefined"){
                    $("#telfonoExt").attr("readonly","readonly");
                    $('#telfonoExt').val('');
                }else if(tel.length==10){
                    $("#telfonoExt").removeAttr("readonly");
                }else{
                    $("#telfonoExt").attr("readonly","readonly");
                    $('#telfonoExt').val('');  
                }
            });
        },
    });
    $("#modalModificar").modal("show");
}

function eliminar(id){
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{id: id},
                url:   'index.php?accion=eliminar',
                type:  'post',
                success:  function (data) {
                    console.log(data);
                    if(data == "OK")
                        window.location.replace("index.php?accion=index");
                    else{
                        window.location.replace("index.php?accion=index");
                    }
                },
                
            });
        });
    }); 
}

$("#agregar").submit(function(){
   var conmutador1 = $("#conmutador").val();
   var extension1 = $("#telefonoExtension").val();
   var celular = $("#telefonoCelular").val();
   var teleCasa = $("#telefonoCasa").val();
   var teleAlterno = $("#telefonoAlterno").val();
    if(conmutador1=="" && celular == "" && teleCasa=="" && teleAlterno==""){
        $("#mensaje").addClass("alert alert-danger").html('<strong>Tiene que ingresar  un numero telefónico</strong>');
        return false;
    }
});

$("#modalModificar").submit(function(){
   var conmutador = $("#telefono").val();
   var extension = $("#telfonoExt").val();
   var cel = $("#telfonoCel").val();
   var telCasa = $("#telfonoCasa").val();
   var telAlterno = $("#telAlterno").val();
    if(conmutador=="" && cel == "" && telCasa=="" && telAlterno==""){
        $("#mensajeModificar").addClass("alert alert-danger").html('<strong>Tiene que ingresar un numero telefónico</strong>');
        return false;
    }
});


