////////////////////////////////////Script para que los campos de las tablas conceptos y subconceptos sean editables 

$.fn.editable.defaults.mode = "popover";
$.fn.editable.defaults.send = "always";
var Tipo //Saber si la variable seleccionada es un concepto o un subconcepto
var Id; //Saber que concepto o subconcepto está seleccionado
var NombreConcepto; //Saber nombre concepto
var clientes=[];

$( document ).ready(function() {
	var error = variablesURL("error");
});
	
$("#TablaConceptos").dataTable({
            responsive: true 
	});

$(".editaConcepto").editable({
	type: "text",
	pk:"1",
	title: "Nuevo nombre",
	url: "../controller/crudConceptos.php?accion=actualizarNombre"
});

$(".editaPrecio").editable({
	type: "text",
	pk:"1",
	title: "Nuevo precio",
	url: "../controller/crudConceptos.php?accion=actualizarPrecio"
});

$(document).on("click", "#IdcmbClientes", function() {
	clientes.push($(this).val());
	for(var i = 0; i < clientes.length; i++)
	{
		//alert(clientes[i]);
	}
});



$(document).on("click", "a", function() {
	Id = $(this).attr("data-pk");
	Tipo = $(this).attr("name");
		$(".editaConcepto").editable({
			type: "text",
			pk:"1",
			title: "Nuevo nombre",
			url: "../controller/crudConceptos.php?accion=actualizarNombre"
		});

		$(".editaPrecio").editable({
			type: "text",
			pk:"1",
			title: "Nuevo precio",
			url: "../controller/crudConceptos.php?accion=actualizarPrecio"
		});
			
});

$(document).on("change","#idPrecioConcepto", function() {
		if($(this).val() != "Fijo"){

			$("#idPrecioConceptotxt").addClass("form-control input-sm hidden");
			$("#idPrecioConceptotxt").attr("required",false);
		}
		else
		{
			$("#idPrecioConceptotxt").removeClass("form-control input-sm hidden").addClass("form-control input-sm");
			$("#idPrecioConceptotxt").attr("required",true);
		}
});

$(document).on("click",".relacionar", function() {
	var id = $(this).val();
	$.post( "../controller/crudConceptos.php?accion=modalClientes", { idConcepto: id }, function(data){
		$("#modalClientes").html(data);
	});
});

$(document).on("click",".checkCliente", function() {

	if($(this).prop("checked")==true)
		$(this).parents("td").attr("class","success");
	else
		$(this).parents("td").attr("class","danger");

	//alert("Cliente:"+$(this).attr("cl") + "Concepto: "+$(this).attr("con"));
});

 
$(document).on("click","#guardarConcepto", function() {
	var bandera = 1;
	if($("input[name='Datos[idCliente][]']:checked").length <= 0 || $.trim($("#IdNombreConcepto").val()) == "" || $.trim($("#tipoServicio").val()) == "" || $.trim($("#idPrecioConcepto").val()) == ""){
		bandera = 0;
	}
	if($("#idPrecioConcepto").val() != "Fijo") 
		$("#idPrecioConceptotxt").val("")
	else
		if($.trim($("#idPrecioConceptotxt").val()) == "")
			bandera = 0;
	if(bandera == 1)
		$("#formGuardarConcepto").submit();
	else
		alert("Datos a guardar incorrectos.");
});

$(document).on("click","#guardarRelaciones", function() {
	var clientes = [];
	var estados = [];
	var id = $(this).attr("con");
	var nombre = $(this).attr("nom");
	var precio = $(this).attr("pre");
	var categoria = $(this).attr("cat");
		$("input[name=clientesCheck]").each(function () {
			clientes.push($(this).attr("cl"));
			if(this.checked)
			estados.push("Activo");
			else
			estados.push("Inactivo");
		});
		$.post( "../controller/crudConceptos.php?accion=guardarRelacion", {id : id , nombre : nombre, precio : precio, categoria :categoria, clientes : clientes, estados : estados }, function(data){
			$.post( "../controller/crudConceptos.php?accion=modalClientes", { idConcepto: id }, function(data){
				$("#modalClientes").html(data);
				$("#modalClientes").modal("show");
				$("#guardarRelaciones").attr("class","btn btn-success");
				$("#guardarRelaciones").html("Correcto");
				setTimeout(function(){ 
				$("#guardarRelaciones").attr("class","btn btn-primary");
				$("#guardarRelaciones").html("Guardar"); }, 2000);
			});
		});
});


$(document).on("click",".dropdown-menu label",function(e) { //Evitar que se cierre el "Dropdownlist"
        e.stopPropagation();
});

$(document).on("click",".seldesClientes",function() { // Seleccionar y deseleccionar todos los clientes
  seldes = $(this).attr("value");
  $.each( $("input[name='Datos[idCliente][]']"), function() {
    if(seldes == 0)
      $(this).prop("checked","checked");
    else
      $(this).prop("checked",false);
  });
    if(seldes == 0)
      seldes = 1;
    else
      seldes = 0;
});

function variablesURL(variableBuscar) {
    var url = decodeURIComponent(window.location.search.substring(1)),
        variables = url.split("&"),
        datosVariable,
        i;
    for (i = 0; i < variables.length; i++) {
        datosVariable = variables[i].split("=");

        if (datosVariable[0] === variableBuscar) {
         	datosVariable[1] === "1" ? alert("El concepto ya existe.") : datosVariable[1];
         	datosVariable[1] === "0" ? alert("Concepto guardado.") : datosVariable[1];
        }
    }
};

////////////////////////////////////////////////////////////////////////////////////////