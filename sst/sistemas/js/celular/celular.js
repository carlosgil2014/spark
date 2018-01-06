$(function () {
  variable = $("#div_alert");
    $("#tblCel").DataTable();
  $(".loader").fadeOut("slow"); 
  if (typeof variable !== 'undefined' && variable !== null) {
      setTimeout(function(){cerrar("div_alert");}, 3000);
    }
    $('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});  
});

$( "#formularioAgregar" ).submit(function( event ) {
      event.preventDefault();
      var frm= $(this).serialize();
       $.ajax({
       type:"POST",
       url: 'index.php?accion=guardar',
       data: frm,
       success: function(data){
        if(data == "OK") {
          $('#formularioAgregar')[0].reset();
          window.location.replace("index.php?accion=index&clase=success");
          //$('#resp').html('Se Agrego Correctamente El Status').show(200).delay(2500).hide(200);
        }else{
          $('#formularioAgregar')[0].reset();
          window.location.replace("index.php?accion=index&clase=danger");
        }
       }
        })
    });

  function eliminarProducto(id){
//$("#celularEliminar").html(banco);
  $("#modalEliminar").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#eliminar", function (e) {
    $(".loader").fadeIn("slow", function(){
        $.ajax({
            data:{id: id},
            url:   'index.php?accion=eliminar',
            type:  'post',
            success:  function (data) {
            window.location.replace("index.php?accion=index&clase=success");
            },
            
        });
      });
  }); 
  }

function editarProducto(id){
    $.ajax({
      'method': 'POST',
      'url': 'index.php?accion=modificar',
      'data': 'id='+id,
    }).done(function(resultado){
    $("#Editar").html(resultado);
     $('.selectpicker').selectpicker({style: 'btn-success btn-sm',size: 4,noneSelectedText: 'Seleccionar un elemento', liveSearchPlaceholder:'Buscar',noneResultsText: '¡No existe el elemento buscado!',countSelectedText:'{0} elementos seleccionados',actionsBox:true,selectAllText: 'Seleccionar todos',deselectAllText: 'Deseleccionar todos'});
    $('#Editar').modal({
          show:true
        });
  });
}

function cargarModelos(marca, idMarca){
  var modelos = $("#modelos"+idMarca);
  console.log(marca.value);
  $(".loader").fadeIn("slow", function(){
    $.ajax(
    {
      data:{marca: marca.value},
        url:   "../modelos/index.php?accion=listar",
        type:  "post",
        success:  function (data) 
        {
        modelos.html(data);
        $('#modelos0').selectpicker("refresh");
        // modelos.selectpicker("refresh");
          $(".loader").fadeOut("slow");
        }
    });
  });
}


function historial(id){
    $.ajax({
      'method': 'POST',
      'url': 'index.php?accion=historial',
      'data': 'id='+id,
    }).done(function(resultado){
    $("#Editar").html(resultado);
    $('#Editar').modal({
          show:true,
          backdrop:'static'
        });
  });
}