$(function () {
       //agregar producto  
  //variable = $("#div_alert");
    $("#tblCel").DataTable();
  //$(".loader").fadeOut("slow");
  /*if (typeof variable !== 'undefined' && variable !== null) {
      setTimeout(function(){cerrar("div_alert");}, 3000);
    }*/
});

$( "#formularioAgregar" ).submit(function( event ) {
      event.preventDefault();
      var frm= $(this).serialize();
       $.ajax({
       type:"POST",
       url: 'index.php?accion=guardar',
       data: frm,
       success: function(data){
        $('#formularioAgregar')[0].reset();
        window.location.replace("index.php?accion=index");
        $('#resp').html('Se Agrego Correctamente El Status').show(200).delay(2500).hide(200);
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
            window.location.replace("index.php?accion=index");
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
    $('#Editar').modal({
          show:true,
          backdrop:'static'
        });
  });
  }

function cargarModelos(marca, idMarca){
  var modelos = $("#modelos"+idMarca);
  $(".loader").fadeIn("slow", function(){
    $.ajax(
    {
      data:{marca: marca.value},
        url:   "../modelos/index.php?accion=listar",
        type:  "post",
        success:  function (data) 
        {
        modelos.html(data);
        // modelos.selectpicker("refresh");
          $(".loader").fadeOut("slow");
        }
    });
  });
}

function seleccionarLinea(){
  sim = $('#sim').val();
  console.log(sim);
  if(sim==""){
        sim = $('#sim').val();
  }else{
    $(".loader").fadeIn("slow", function(){
  $.ajax({
        url:   'index.php?accion=buscarLinea&sim='+sim,
        type:  'post',
        success:  function (data) {
        data = JSON.parse(data)
              if (data==="error") {
                $('#idLinea').val('')
                $('#linea').val('');
              }else{
                $('#idLinea').val(data.linea);
                $('#linea').val(data.idLinea);
              }
            },
          });
            $(".loader").fadeOut("slow"); 
        });  
  }
}
