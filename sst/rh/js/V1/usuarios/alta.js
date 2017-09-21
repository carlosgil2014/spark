var formAgregar;
$(document).ready(function(){
	$("#clientes").multiselect( {noneSelectedText: 'Seleccione mínimo un cliente',selectedList: 2,
        classes: 'my-select'});
    $( "#respuesta" ).dialog({
        autoOpen: false,
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
        "OK": function() {
          $( this ).dialog( "close" );
        }
      }
    });
	$(".loader").fadeOut("slow"); 
    // The event listener for the file upload
    if($("#importarCsv").length > 0)
        document.getElementById('importarCsv').addEventListener('change', upload, false);
    if($("#formAgregar").length > 0){
        formAgregar = $("#formAgregar").detach();
    }
});

function agregarCuenta(){
  if(formAgregar){
    formAgregar.insertAfter("#divAgregar");
    formAgregar = null;
    $(this).attr("class","btn btn-block btn-flat btn-sm btn-danger");
    $(this).html("Cancelar");
  } else {
    formAgregar = $("#formAgregar").detach();
    $(this).attr("class","btn btn-block btn-flat btn-sm btn-success");
    $(this).html("Agregar Cuenta");
  }
};

function eliminarCuenta(idFila, idEmpleado, banco, cuenta){
    $("#numeroCuentaEliminar").html(banco +" "+cuenta);
    $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
        $(".loader").fadeIn("slow", function(){
            $.ajax({
                data:{idFila : idFila, idEmpleado : idEmpleado},
                url:   'crudEmpleadosGastos.php?accion=eliminar',
                type:  'post',
                success:  function (data) {
                    if(data == "OK")
                        window.location.replace("crudEmpleadosGastos.php?accion=modEmpleado&idEmpleado="+idEmpleado+"&clase=success");
                    else{
                        alert(data);
                        window.location.replace("crudEmpleadosGastos.php?accion=modEmpleado&idEmpleado="+idEmpleado);
                    }
                },
                
            });
        });
    }); 
}

$(document).on("submit","#formGuardar",function(){
	var Datos = {};

	Datos["nombres"] = $("[name='Datos[nombres]']").val();
	Datos["apellidop"] = $("[name='Datos[apellidop]']").val();
	Datos["apellidom"] = $("[name='Datos[apellidom]']").val();
	Datos["banco"] = $("[name='Datos[banco]']").val();
    Datos["cuenta"] = $("[name='Datos[cuenta]']").val();
    Datos["clabe"] = $("[name='Datos[clabe]']").val();
    Datos["rfc"] = $("[name='Datos[rfc]']").val();
    var arrClientes = $('#arrClientes').text();
    var obj = JSON.parse(arrClientes);
    var opciones ="";

    $(".loader").fadeIn("slow", function(){
    	$.ajax({
            data:{Datos:Datos},
            url:   'crudEmpleadosGastos.php?accion=guardarEmpleado',
            type:  'post',
            success:  function (data) 
            {
                if(data == "El empleado ya existe")
                {
                    $( "#txtMsjAviso" ).html('<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> ¡'+data+'!');
                    $("#modalAviso").modal();
                }
                else
                {
                    for(var i = 0 ; i < obj.length ; i++)
                    {
                        opciones = opciones + "<option value='"+obj[i].idcliente+"'>"+obj[i].clave_cliente+"</option>";
                    }
                    $(".list").append(
                        "<tr><td align='center'>"+Datos["nombres"]+"<input type='text' name='Datos[nombres][]' value='"+Datos["nombres"]+"' hidden></td><td align='center'>"+Datos["apellidop"]+"<input type='text' name='Datos[apellidop][]' value='"+Datos["apellidop"]+"' style='text-transform:uppercase' hidden></td><td align='center'>"+Datos["apellidom"]+"<input type='text' name='Datos[apellidom][]' value='"+Datos["apellidom"]+"' style='text-transform:uppercase' hidden></td><td align='center'>"+Datos["banco"]+"<input type='text' name='Datos[banco][]' value='"+Datos["banco"]+"' style='text-transform:uppercase' hidden></td><td align='center'>"+Datos["cuenta"]+"<input type='text' name='Datos[cuenta][]' value='"+Datos["cuenta"]+"' style='text-transform:uppercase' hidden></td><td align='center'>"+Datos["rfc"]+"<input type='text' name='Datos[rfc][]' value='"+Datos["rfc"]+"' style='text-transform:uppercase' hidden></td><td align='center'>"+Datos["clabe"]+"<input type='text' name='Datos[clabe][]' value='"+Datos["clabe"]+"' style='text-transform:uppercase' hidden></td><td align='center'><select class='clientes'  multiple='multiple' name='Datos[cl][]' required >"+opciones+"</select></td><td><input type='text' name='Datos[comentario][]' value='' hidden></td><td align='center'><a><i class='fa fa-minus elimarFilaEmpleado' style='cursor:pointer' title='Eliminar fila'></i></a></td></tr>");
                    $(".clientes").multiselect( {nonSelectedText: 'Seleccione mínimo un cliente',selectedList: 2,classes: 'my-select'});
                    $("#idBtnGuardar").removeAttr("disabled");
                }
                // $("#btnGuardar").attr("disabled", true);
                $(".loader").fadeOut("fast");
            },
            error:function (data) {
                $("#respuesta").html("<p>"+data+"</p>");
                $("#respuesta").dialog("open");
            	$(".loader").fadeOut("fast");
            } 	
        });
    });
});
$(document).on("click","#btnReset",function(){
     $("#btnGuardar").removeAttr("disabled");
})

$(document).on("submit","#formGuardarMod",function()
{
    var Datos = {};
    Datos["idEmpleado"] = $("[name='Datos[idEmpleado]']").val();
    Datos["nombres"] = $("[name='Datos[nombres]']").val();
    Datos["apellidop"] = $("[name='Datos[apellidop]']").val();
    Datos["apellidom"] = $("[name='Datos[apellidom]']").val();
    Datos["banco"] = $("[name='Datos[banco]']").val();
    Datos["cuenta"] = $("[name='Datos[cuenta]']").val();
    Datos["clabe"] = $("[name='Datos[clabe]']").val();
    Datos["rfc"] = $("[name='Datos[rfc]']").val();

    $(".loader").fadeIn("slow", function(){
        $.ajax({
            data:{Datos:Datos},
            url:   'crudEmpleadosGastos.php?accion=guardarModEmpleado',
            type:  'post',
            success:  function (data) {
                $("#txtMsj").html("<p>"+data+"</p>");
                $("#avisoEmpleados").modal();
                $(".loader").fadeOut("fast");
            },
            error:function (data) {
                $("#txtMsj").html("<p>"+data+"</p>");
                $("#avisoEmpleados").modal();
                $(".loader").fadeOut("fast");
            }   
        });
    });
});
$(document).on("submit","#formGuardarEmpleados",function()
{
    $( "#txtMsjConf" ).html('<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><span class="sr-only">Error:</span> ¡Continuar para guardar empleados!');
    $( "#modalConfirmacion" ).unbind().modal({ backdrop: 'static', keyboard: false }).one('click', '#confAceptada', function (e) 
    {
        var Datos = {};
        if($("[name='Datos[nombres][]']").length > 0)
            Datos["nombres"] = [];
        $("[name='Datos[nombres][]']").each(function()
        {
            Datos["nombres"].push($(this).val());
        });
        if($("[name='Datos[apellidop][]']").length > 0)
            Datos["apellidop"] = [];
        $("[name='Datos[apellidop][]']").each(function()
        {
            Datos["apellidop"].push($(this).val());
        });
        if($("[name='Datos[apellidom][]']").length > 0)
            Datos["apellidom"] = [];
        $("[name='Datos[apellidom][]']").each(function()
        {
            Datos["apellidom"].push($(this).val());
        })
        if($("[name='Datos[banco][]']").length > 0)
            Datos["banco"] = [];
        $("[name='Datos[banco][]']").each(function()
        {
            Datos["banco"].push($(this).val());
        })
        if($("[name='Datos[cuenta][]']").length > 0)
            Datos["cuenta"] = [];
        $("[name='Datos[cuenta][]']").each(function()
        {
            Datos["cuenta"].push($(this).val());
        })
        if($("[name='Datos[rfc][]']").length > 0)
            Datos["rfc"] = [];
        $("[name='Datos[rfc][]']").each(function()
        {
            Datos["rfc"].push($(this).val());
        })
        if($("[name='Datos[banco][]']").length > 0)
            Datos["banco"] = [];
        $("[name='Datos[banco][]']").each(function()
        {
            Datos["banco"].push($(this).val());
        })
        if($("[name='Datos[clabe][]']").length > 0)
            Datos["clabe"] = [];
        $("[name='Datos[clabe][]']").each(function()
        {
            Datos["clabe"].push($(this).val());
        })
        if($("[name='Datos[comentario][]']").length > 0)
            Datos["comentario"] = [];
        $("[name='Datos[comentario][]']").each(function()
        {
            Datos["comentario"].push($(this).val());
        })
        if($("[name='Datos[cl][]']").length > 0)
            Datos.clientes = [];
        $("[name='Datos[cl][]']").each(function()
        {
            Datos.clientes.push($(this).val());
        })
        // alert(JSON.stringify(Datos));
        $.ajax(
        {
            data:{Datos:Datos},
            url:   'crudEmpleadosGastos.php?accion=guardarEmpleadosCargados',
            type:  'post',
            success:  function (data)
            {
                $("#txtMsjAviso").html("<p>"+data+"</p>");
                $("#modalAviso").modal();
                $(".list").html("");
                $("#idBtnGuardar").attr("disabled","disabled");
                $("#idBtnLimpiar").attr("disabled","disabled");
                $("#importarCsv").val("");
                $(".loader").fadeOut("fast");
            },
            error:function (data) 
            {
                $("#respuesta").html("<p>"+data+"</p>");
                $("#respuesta").dialog("open");
                $(".loader").fadeOut("fast");
            }
        });
    });
    $("#respuesta").dialog("open");

});
function goBack() 
{
    window.history.back();
}
$("#cuenta").keypress(function(e){

     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
     {
        $(".only_number_cuenta").html("Solo Numeros.").show().fadeOut("slow");
        return false;
    }
});
$("#clabe").keypress(function(e){

     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
     {
        $(".only_number_clabe").html("Solo Numeros.").show().fadeOut("slow");
        return false;
    }
});

// Method that reads and processes the selected file
function upload(evt) 
{
    var extFormat = $("#importarCsv").val().split(".").pop().toLowerCase();
    if($.inArray(extFormat,["csv"]) == -1)
    {
        alert("Revisar archivo, debe ser (.csv)");
        return false;
    }
    else
    {

        var arrClientes = $('#arrClientes').text();
        var obj = JSON.parse(arrClientes);
        var opciones = "",cellCsvData = [],
        nombre = ['Nombre','nombre','NOMBRE'],
        apellidoP = ['Apellido Paterno','Apellido paterno','apellido paterno','APELLIDO PATERNO'],
        apellidoM = ['Apellido Materno','Apellido materno','apellido materno','APELLIDO MATERNO'],
        banco = ['Banco','banco','BANCO'],
        cuenta = ['Cuenta','cuenta','CUENTA'],
        rfc = ['Rfc','rfc','RFC'],
        clabe = ['Clabe','clabe','CLABE'];
        if(obj.length > 0)
        {
            for(var i = 0 ; i < obj.length ; i++)
            {
                opciones = opciones + "<option value='"+obj[i].idcliente+"'>"+obj[i].clave_cliente+"</option>";
            }
        }
        $(".loader").fadeIn("slow", function()
        {
            var file = evt.target.files[0];
            var reader = new FileReader();
            reader.readAsText(file);
            reader.onload = function(event) 
            {
                var rowCsvData = event.target.result.split("\n");
                var headers = rowCsvData[0].split(",");
                //alert($.inArray(headers[6],clabe))
                if(headers.length == 7 && $.inArray(headers[0],nombre) != -1 && $.inArray(headers[1],apellidoP) != -1 && $.inArray(headers[2],apellidoM) != -1 && $.inArray(headers[3],banco) != -1 && $.inArray(headers[4],cuenta) != -1 && $.inArray(headers[5],rfc) != -1)
                {
                    for(var i = 1 ; i < rowCsvData.length ; i++)
                    {
                        if(rowCsvData[i] != "")
                        {
                            cellCsvData.push(rowCsvData[i].split(","));
                        }

                    }
                    validarEmpleados(cellCsvData,opciones);
                    $("#idBtnGuardar").removeAttr("disabled");
                    $("#idBtnLimpiar").removeAttr("disabled");
                }
                else
                {
                    $("#respuesta").html("<p>¡Verificar que el archivo cumpla con el formato!</p>");
                    $("#respuesta").dialog("open");
                    $("#importarCsv").val("");   
                }
            };
            reader.onerror = function() {
                $(".loader").fadeOut("fast");
                alert('Incapaz de leer archivo.. ' + file.fileName);
                $("#idBtnGuardar").attr("disabled","disabled");
            };
        });
    }
}
function validarEmpleados(Datos,opciones)
{
    $.ajax(
    {
        data:{Datos:Datos},
        url:   'crudEmpleadosGastos.php?accion=validarEmpleados',
        type:  'post',
        success:  function (data) 
        {
            var obj = JSON.parse(data);
            for(var i = 0 ; i < obj.length ; i++)
            {
                $(".list").delay("slow").append("<tr id='trprin'><td align='center'>"+obj[i].nombre.toUpperCase()+"<input type='text' name='Datos[nombres][]' value='"+obj[i].nombre.toUpperCase()+"' hidden></td><td align='center'>"+obj[i].apellidop.toUpperCase()+"<input type='text' name='Datos[apellidop][]' value='"+obj[i].apellidop.toUpperCase()+"' style='text-transform:uppercase' hidden></td><td align='center'>"+obj[i].apellidom.toUpperCase()+"<input type='text' name='Datos[apellidom][]' value='"+obj[i].apellidom.toUpperCase()+"' style='text-transform:uppercase' hidden></td><td align='center'>"+obj[i].banco.toUpperCase()+"<input type='text' name='Datos[banco][]' value='"+obj[i].banco.toUpperCase()+"' style='text-transform:uppercase' hidden></td><td align='center'>"+obj[i].cuenta+"<input type='text' name='Datos[cuenta][]' value='"+obj[i].cuenta+"' style='text-transform:uppercase' hidden></td><td align='center'>"+obj[i].rfc.toUpperCase()+"<input type='text' name='Datos[rfc][]' value='"+obj[i].rfc.toUpperCase()+"' style='text-transform:uppercase' hidden></td><td align='center'>"+obj[i].clabe+"<input type='text' name='Datos[clabe][]' value='"+obj[i].clabe+"' style='text-transform:uppercase' hidden></td><td align='center'><select class='clientes'  multiple='multiple' name='Datos[cl][]' required >"+opciones+"</select></td><td align='cenetr'>"+obj[i].comentario+"<input type='text' name='Datos[comentario][]' value='"+obj[i].comentario+"' hidden></td><td align='center'><a><i style='cursor:pointer;' class='elimarFilaEmpleado fa fa-minus' title='Eliminar fila'></a></td></tr>");
                $(".clientes").multiselect( {nonSelectedText: 'Seleccione mínimo un cliente',selectedList: 2,classes: 'my-select'});
            }
            $(".loader").fadeOut("fast");
        }
    });   
}
$(document).on("click",".elimarFilaEmpleado", function()
{
    var fila = $(this).closest("tr");
    fila.remove();
    if($(".elimarFilaEmpleado").length === 0)
    {
        $("#importarCsv").val("");
        $("#idBtnGuardar").attr("disabled","disabled");
    }
    
});

function cerrar(id_elemento)
{
    document.getElementById(id_elemento).style.display="none";
}