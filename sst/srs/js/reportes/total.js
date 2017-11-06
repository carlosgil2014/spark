var divTablaPrincipal = $("#COPC"), seldes;
$(document).ready(function(){
    $(".loader").fadeOut("slow");
});

$(document).on("click",".dropdown-menu label",function(e) { //Evitar que se cierre el "Dropdownlist"
        e.stopPropagation();
});

$(document).on("click",".seldesClientes",function() { // Seleccionar y deseleccionar todos los clientes
  seldes = $(this).attr("value");
  $.each( $("input[name='idClientes[]']"), function() {
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

$(document).on("click",".campos",function() { // Ver los campos seleccionados
  tmp = $(this).is(":checked");
  celda = $(this).closest("td").index();
  campo = $(this).closest("td").index() +1;
  if(tmp){
    $(this).closest("tr").find('td:eq('+celda+')').attr("class","text-center success");
    $(this).closest("tr").find('td:eq('+campo+')').attr("class","text-center success");
  }
  else{
    $(this).closest("tr").find('td:eq('+celda+')').attr("class","text-center danger");
    $(this).closest("tr").find('td:eq('+campo+')').attr("class","text-center danger");
  }
});

$(document).on("click", "#btnBuscar", function()
{
  var tmpTabla, fechaInicial, fechaFinal, idClientes = [], estado,tabla;

  tmpTabla = "Ordenes";
  fechaInicial = $("input[name='fechaInicial']").val();
  fechaFinal = $("input[name='fechaFinal']").val();
  estado = "Autorizada";
  $("input[name='idClientes[]']:checked").each(function()
  {idClientes.push(parseInt($(this).val()));});
  if(idClientes.length > 0)
    $(".loader").fadeIn("slow", function(){
      $.post( "../controller/crudPrincipal.php?accion=tablaPrincipal",{idClientes : idClientes, tmpTabla : tmpTabla, 
        fechaInicial : fechaInicial, fechaFinal : fechaFinal, estado : estado},function(data)
        {
            divTablaPrincipal.html(data);
            tabla = $("#tablaPrincipal").DataTable(
              {
                responsive: true,
                columnDefs: [{ type: 'natural', targets: '_all' }]
              });
            var nNodes = tabla.rows().nodes();
            $("[data-toggle='popover']",nNodes).popover(); 
            $(".loader").fadeOut("fast");
            tabla.columns([5,7]).visible( false, false );
            if(nNodes.length > 0 ){
              $("#btnExportar").attr("class","btn btn-sm btn-success");
              $("#tablaCampos").attr("class","");
            }
            else{

              $("#btnExportar").attr("class","btn btn-sm btn-success hidden");
              $("#tablaCampos").attr("class","table-responsive hidden");
            }
        });
    });
  else{
    alert("No se han seleccionado clientes.");
  }

});

$(document).on("click", "#btnExportar", function()
{
  var tmpTabla, fechaInicial, fechaFinal, idClientes = [], campos = [], estado,tabla;

  fechaInicial = $("input[name='fechaInicial']").val();
  fechaFinal = $("input[name='fechaFinal']").val();
  $("input[name='idClientes[]']:checked").each(function()
  {idClientes.push(parseInt($(this).val()));});
  $("input[name='campos[]']:checked").each(function()
  {campos.push($(this).val());});
  if(idClientes.length > 0)
    $(".loader").fadeIn("slow", function(){
      $.ajax({
        method: "POST",
        url:   "crudReportes.php?accion=reporteTotal",
        data: {idClientes : idClientes,fechaInicial : fechaInicial, fechaFinal : fechaFinal,campos : campos}, 
        success:  function (data) {
          // divTablaPrincipal.html(data);
          $(".loader").fadeOut("fast");
        }
      });
    });
  else{
    alert("No se han seleccionado clientes.");
  }

});