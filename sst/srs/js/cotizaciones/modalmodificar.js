////////Funcion para cargar los datos en el modal///////////////// 

$(document).on('click', "a.imgEditar", function() 
{ 

  var idcliente=$("#IdcmbClientes").val();
  //alert(idcliente);
  numFila = $(this).parents('tr').index() - 2; 
  $.post("crudConceptos.php?accion=cargarConceptos", { idCliente: idcliente ,tipoServicio: $('#Idtabla tr:eq('+numFila+') td:eq(1)').text() }, function(data)
  {
     $("#IdcmbTipoConceptoModal").html(data);
     cargarConcepto();
  });  

  $("#IdcmbTipoPlanModal").val($('#Idtabla tr:eq('+numFila+') td:eq(0)').text());

  $("#IdcmbTipoServicioModal").val($('#Idtabla tr:eq('+numFila+') td:eq(1)').text());

  $("#IdtxtCantidadModal").val($(this).parents('tr').find('td:eq(0)').text()); 

  function cargarConcepto()
  {
    //alert($('#Idtabla tr:eq('+(numFila+2)+') td:eq(1)').attr("value"));
    $("#IdcmbTipoConceptoModal").val($('#Idtabla tr:eq('+(numFila+2)+') td:eq(1)').attr("value"));

   var datoSeleccionado=$("#IdcmbTipoConceptoModal").val().split("-");
   //alert(datoSeleccionado[1]);
   if (datoSeleccionado!="--- Seleccione ---") 
    {
      $.post("crudConceptos.php?accion=preciosFijos",{concepto:datoSeleccionado[0]},function(data)
        {
          
          if(data==0)
          {

            $("#IdtxtPUnitarioModal").prop("readonly",false);
           
          }
          else
          {
            $("#IdtxtPUnitarioModal").val(data);
            $("#IdtxtPUnitarioModal").prop("readonly",true);
            $("#IdtxtPUnitarioModal").css("background-color","white")
          
          }
          
        });
     
    }
  }

  $("#IdtxtDescripcionConceptoModal").val($('#Idtabla tr:eq('+(numFila+3)+') td:eq(1)').text());

  //$("#IdcmbOrdenServicioMod").val($(this).parents('tr').find('td:eq(3)').text());
  
  $("#IdtxtPUnitarioModal").val(parseFloat($(this).parents('tr').find('td:eq(2)').html().replace(/[$,]/g,'')));

  var comisionAg = $(this).parents('tr').find('td:eq(4)').attr('data-original-title').split('%');

  //alert(comisionAg[0]);//
  $("#IdtxtComisionAgenciaModal").val(comisionAg[0]);
  
  //$("#IdtxtSubTotalModal").val(parseFloat($(this).parents('tr').find('td:eq(5)').html().substring(1).replace(/,/g,'')));
  $("#IdtxtSubTotalModal").val(parseFloat($(this).parents('tr').find('td:eq(5)').html().replace(/[$,]/g,'')));

  $("#IdCot").val($(this).parents('tr').find('td:eq(7)').text());



});

 $(document).on('change','#IdcmbTipoConceptoModal',function(e)
  { 
    var datoSeleccionado=$("#IdcmbTipoConceptoModal").val().split("-");
    //alert(datoSeleccionado);
    if (datoSeleccionado!="--- Seleccione ---") 
    {
      $('#IdtxtDescripcionConceptoModal').removeAttr('style');
      $('#IdlblDescripcionConceptoModal').removeAttr('style');
      $.post("crudConceptos.php?accion=preciosFijos",{concepto:datoSeleccionado[0]},function(data)
        {
          
          if(data==0)
          {
            $("#IdtxtPUnitarioModal").val("");

            $("#IdtxtPUnitarioModal").prop("readonly",false);
           
          }
          else
          {
            $("#IdtxtPUnitarioModal").val(data);
            $("#IdtxtPUnitarioModal").prop("readonly",true);
            $("#IdtxtPUnitarioModal").css("background-color","white")
          
          }
          
          var punit =document.getElementById("IdtxtPUnitarioModal").value;
          var cant = document.getElementById("IdtxtCantidadModal").value;
          var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
          
          var subtotal = parseFloat(punit * cant);
          
          var pCa = (valorComisionAgencia/100)*subtotal;
          var cA = subtotal+pCa;
          
          $("#IdtxtSubTotalModal").val(cA.toFixed(2));
          
        });
     
    }
    else
    {

      $('#IdtxtDescripcionConceptoModal').attr('style','display:none');
      $('#IdlblDescripcionConceptoModal').attr('style','display:none');
      
    }
  

  });

 $(document).on('change','#IdcmbTipoServicioModal',function()
 {
    var idcliente=$("#IdcmbClientes").val();
    //alert($("#IdcmbTipoServicioModal").val())
    $.post("crudConceptos.php?accion=cargarConceptos", { idCliente: idcliente ,tipoServicio: $("#IdcmbTipoServicioModal").val() }, function(data)
    {
       $("#IdcmbTipoConceptoModal").html(data);
    });

 });

 //////////Calcula el subtotal,iva y el total en el modal, para modificar los datos///////////

  $("#IdtxtCantidadModal").keyup(function()
  {

      var punit =document.getElementById("IdtxtCantidadModal").value;
      var cant = document.getElementById("IdtxtPUnitarioModal").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotalModal").val(cA.toFixed(2));
        

  }); 

  $("#IdtxtPUnitarioModal").keyup(function()
  {

      var punit =document.getElementById("IdtxtCantidadModal").value;
      var cant = document.getElementById("IdtxtPUnitarioModal").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotalModal").val(cA.toFixed(2));
       
  }); 

  $("#IdtxtComisionAgenciaModal").keyup(function()
  {

      var punit =document.getElementById("IdtxtCantidadModal").value;
      var cant = document.getElementById("IdtxtPUnitarioModal").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotalModal").val(cA.toFixed(2));
        

  });

   $("#IdtxtCantidadModal").on("change",function()
  {

      var punit =document.getElementById("IdtxtPUnitarioModal").value;
      var cant = document.getElementById("IdtxtCantidadModal").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotalModal").val(cA.toFixed(2));

  }); 

  $("#IdtxtPUnitarioModal").on("change",function()
  {

      var punit =document.getElementById("IdtxtPUnitarioModal").value;
      var cant = document.getElementById("IdtxtCantidadModal").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotalModal").val(cA.toFixed(2));
  
  }); 

  $("#IdtxtComisionAgenciaModal").on("change",function()
  {
      var punit =document.getElementById("IdtxtPUnitarioModal").value;
      var cant = document.getElementById("IdtxtCantidadModal").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgenciaModal").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotalModal").val(cA.toFixed(2));

  });

  $('#IdbtnEliminar').on('click',function(){
  
  $('a.imgEditar').attr('hidden','hidden');
  $('b.btnEditar').attr('hidden','hidden');
  $('a.imgEliminar').removeAttr('hidden');
  $('b.btnEliminar').removeAttr('hidden');
  

});

/////////Muestra el boton de editar//////////

$('#IdbtnModificar').on('click',function(){
  
  $('a.imgEliminar').attr('hidden','hidden');
  $('b.btnEliminar').attr('hidden','hidden');
  $('a.imgEditar').removeAttr('hidden');
  $('b.btnEditar').removeAttr('hidden');
 

});

