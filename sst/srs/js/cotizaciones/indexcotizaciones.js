$(function()
{
    $('[data-toggle="tooltip"]').tooltip();
    var num = document.getElementById("IdtxtTotal").value;
    var num1 = num.replace(/[$,]/g,"");
    nn(num1);   
    $(".loader").fadeOut("fast");

});
$(".datosText").change(function()
{ 
  if($("#IdcmbClientes").val()!=null)
    var cliente=$("#IdcmbClientes").val().split("#");
  else
    cliente="";
  var tipoServicio=$("#IdcmbTipoServicio").val();
  if($("#fechaIn").val() > $('#fechaFin').val() || $('#fechaFin').val() < $('#fechaIn').val())
    {
      var fechaFin=$("#fechaIn").val();
      $("#fechaFin").val($("#fechaIn").val());
    }
    else
    {
      var fechaFin=$("#fechaFin").val();
    }
  $.post("crudCotizaciones.php?accion=listarDatos&nombreCliente="+cliente[0]+"&idCliente="+cliente[1]+"&fechaInicial="+$("#fechaIn").val()+"&fechaFinal="+fechaFin+"&servicio="+$("#IdtxtServicio").val()+"&tipoPlan="+$("#IdcmbTipoPlan").val()+"&tipoServicio="+tipoServicio);

});

$(".cargarConcepto").blur(function()
{
  var cliente=$("#IdcmbClientes").val().split("#");
  var tipoServicio=$("#IdcmbTipoServicio").val();
  //alert(cliente[1]);
  if(cliente[1] != "" && tipoServicio != null)
  {
    $.post("crudConceptos.php?accion=cargarConceptos",{idCliente:cliente[1],tipoServicio:tipoServicio},function(data)
    {
      $("#IdcmbTipoConcepto").html(data);
    });
  }
});

$("#IdcmbTipoConcepto").blur(function()
{
    var datoSeleccionado=$(this).val().split("-");
    if (datoSeleccionado!="--- Seleccione Concepto ---") 
    {
      $('.descripcionConcepto').removeClass('hidden');
      $.post("crudConceptos.php?accion=preciosFijos",{ concepto : datoSeleccionado[0] },function(data)
        {
          
            if(data==0)
            {
              $("#IdtxtPUnitario").val("");

              $("#IdtxtPUnitario").prop("readonly",false);
            }
            else
            {
              $("#IdtxtPUnitario").val(data);
              $("#IdtxtPUnitario").prop("readonly",true);
              $("#IdtxtPUnitario").css("background-color","white")
            }

          var punit =document.getElementById("IdtxtPUnitario").value;
          var cant = document.getElementById("IdtxtCantidad").value;
          var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
          
          var subtotal = parseFloat(punit * cant);
          
          var pCa = (valorComisionAgencia/100)*subtotal;
          var cA = subtotal+pCa;
        
            $("#IdtxtSubTotal1").val(cA.toFixed(2));
        });
    }
    else
    {
      $('.descripcionConcepto').addClass('hidden');      
    }
  

  });

 //Realiza calculos para obtener el subtotal con comision o sin comision al digitar un numero

  $("#IdtxtCantidad").keyup(function()
  {

      var punit =document.getElementById("IdtxtPUnitario").value;
      var cant = document.getElementById("IdtxtCantidad").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotal1").val(cA.toFixed(2));

  }); 

  $("#IdtxtPUnitario").keyup(function()
  {
    //alert("ok");

      var punit =document.getElementById("IdtxtPUnitario").value;
      var cant = document.getElementById("IdtxtCantidad").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotal1").val(cA.toFixed(2));
       
  }); 

  $("#IdtxtComisionAgencia").keyup(function()
  {
      var punit =document.getElementById("IdtxtPUnitario").value;
      var cant = document.getElementById("IdtxtCantidad").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotal1").val(cA.toFixed(2));

  }); 


  $("#IdtxtCantidad").on("change",function()
  {

      var punit =document.getElementById("IdtxtPUnitario").value;
      var cant = document.getElementById("IdtxtCantidad").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotal1").val(cA.toFixed(2));

  }); 

  $("#IdtxtPUnitario").on("change",function()
  {

      var punit =document.getElementById("IdtxtPUnitario").value;
      var cant = document.getElementById("IdtxtCantidad").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotal1").val(cA.toFixed(2));
      //alert("ok");
  }); 

  $("#IdtxtComisionAgencia").on("change",function()
  {
      var punit =document.getElementById("IdtxtPUnitario").value;
      var cant = document.getElementById("IdtxtCantidad").value;
      var valorComisionAgencia= document.getElementById("IdtxtComisionAgencia").value;
      
      var subtotal = parseFloat(punit * cant);
      
      var pCa = (valorComisionAgencia/100)*subtotal;
      var cA = subtotal+pCa;
      
      $("#IdtxtSubTotal1").val(cA.toFixed(2));

  });

var o=new Array("DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DICISÉIS", "DICISIETE", "DIECIOCHO", "DIECINUEVE", "VEINTE", "VEINTIUNO", "VEINTIDOS", "VEINTITRES", "VEINTICUTRO", "VEINTICINCO", "VEINTISEIS", "VEINTISIETE", "VEINTIOCHO", "VEINTINUEVE");
var u=new Array("CERO", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE");
var d=new Array("", "", "", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA");
var c=new Array("", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS");
var numFila=0;
var cantidadPrestIncen=0;

function nn(n)
{

  var n=parseFloat(n).toFixed(2); /*se limita a dos decimales, no sabía que existía toFixed() :)*/
  var p=n.toString().substring(n.toString().indexOf(".")+1); /*decimales*/
  var m=n.toString().substring(0,n.toString().indexOf(".")); /*número sin decimales*/
  var m=parseFloat(m).toString().split("").reverse(); /*tampoco que reverse() existía :D*/
  var t="";
 
 for (var i=0; i<m.length; i+=3)
  {
    var x=t;
    /*formamos un número de 2 dígitos*/
    var b=m[i+1]!=undefined?parseFloat(m[i+1].toString()+m[i].toString()):parseFloat(m[i].toString());
    /*analizamos el 3 dígito*/
    t=m[i+2]!=undefined?(c[m[i+2]]+" "):"";
    t+=b<10?u[b]:(b<30?o[b-10]:(d[m[i+1]]+(m[i]=='0'?"":(" Y "+u[m[i]]))));
    t=t=="CIENTO CERO"?"CIEN":t;
    if (2<i&&i<6)
      t=t=="UNO"?"MIL ":(t.replace("UNO","UN")+" MIL ");
    if (5<i&&i<9)
      t=t=="UNO"?"UN MILLÓN ":(t.replace("UNO","UN")+" MILLONES ");
    t+=x;
    //t=i<3?t:(i<6?((t=="uno"?"mil ":(t+" mil "))+x):((t=="uno"?"un millón ":(t+" millones "))+x));
  }
  t+=" PESOS "+p+"/100  M/N";
  /*correcciones*/
  t=t.replace("  "," ");
  t=t.replace(" CERO","");
  //t=t.replace("ciento y","cien y");
  //alert("Numero: "+n+"\nNº Dígitos: "+m.length+"\nDígitos: "+m+"\nDecimales: "+p+"\nt: "+t);
  //document.getElementById("esc").value=t;
  if(n!="NaN"){
  document.getElementById("IdtxtCantidadLetra").value=t;}
  else{
  document.getElementById("IdtxtCantidadLetra").value="";}

  // return t;
} 

function guardarCotizacion()
{
  var $datosCliente=$("#IdcmbClientes").val().split("#");
  $(".loader").fadeIn("slow", function()
  {
    $.ajax(
    {
      data: {idCmbCliente : $datosCliente[1]},
      url: "crudCotizaciones.php?accion=guardarCotizacion",
      type: 'post',
      success:  function (data) 
      {
        $(".loader").fadeOut("fast");
        $("#idDisabled").attr("class","disabled");
        $("#IdbtnGuardar").removeAttr("onclick");
        $("#idConfirmacion").html("<p>"+data+"</p>");
        $("#idConfirmacion").dialog(
        {
          resizable: false,
              modal: true,
              buttons: 
              {
                'Continuar': function() 
                {
                    $(this).dialog('close');
                    window.location.href="crudCotizaciones.php?accion=listarDatos";
                }
              }
        });
      }

    });
  });
  
}


$(".cargarConceptoMod").change(function()
{
  var cliente=$("#IdcmbClientes").val();
  var tipoServicio=$("#IdcmbTipoServicio").val();
  if(cliente != "" && tipoServicio != null)
  {
    $.post("crudConceptos.php?accion=cargarConceptos",{idCliente:cliente,tipoServicio:tipoServicio},function(data)
    {
      $("#IdcmbTipoConcepto").html(data);
    });
  }
});

$(".imgEliminar").on("click",function(){
      
      var idRubro = $(this).attr("value");
      var idCotizacion=$("#idCotizacion").val();
      //alert(idRubro+"-"+idCotizacion);
      $( "#confirmacion" ).dialog(
      {
        resizable: false,
        modal: true,
        buttons: 
        {
          'Borrar': function() 
          {
              $(this).dialog('close');
              document.location.href = "crudCotizaciones.php?accion=eliminarRubroModificacion&idRubro="+idRubro+"&idCotizacion="+idCotizacion;
          },
          'Cancelar': function() 
          {
              $(this).dialog('close');
          }
        }

       });
    
    });

/// al realizar cambios en servicio o en la fecha inicial o final
  $("#IdcmbClientes").on('change',function()
  {
    $("li.habilitar").removeAttr('class');
    $(".IdbtnGuardar").attr('onclick','guardarModCotizacion()');
    $(".IdbtnGuardar").attr('style','cursor:pointer;');
  });

  $("#IdtxtServicio").keyup(function(){

    $("li.habilitar").removeAttr('class');
    $(".IdbtnGuardar").attr('onclick','guardarModCotizacion()');
    $(".IdbtnGuardar").attr('style','cursor:pointer;');

  });

  $("#fechaInMod").on("change",function(){
    $("li.habilitar").removeAttr('class');
    $(".IdbtnGuardar").attr('onclick','guardarModCotizacion()');
    $(".IdbtnGuardar").attr('style','cursor:pointer;');

  });

  $("#fechaFinMod").on("change",function(){
    $("li.habilitar").removeAttr('class');
    $(".IdbtnGuardar").attr('onclick','guardarModCotizacion()');
    $(".IdbtnGuardar").attr('style','cursor:pointer;');

  })

  function guardarModCotizacion()
  {
    var idCotizacion=$("#idCotizacion").val();
    var servicio = $("#IdtxtServicio").val();
    var fInicial = $("#fechaInMod").val();
    var fFinal = $("#fechaFinMod").val();
    var idCliente = $("#IdcmbClientes").val();
    var clave_cliente = $("#claveClienteModCot").val();
    var idNcotizacion = $("#idNcotizacion").val();
    //alert(idCliente+"-"+servicio+"-"+fInicial+"-"+fFinal);
    $.post("crudCotizaciones.php?accion=guardarModificacionCot",{idCotizacion:idCotizacion,servicio:servicio,fInicial:fInicial,fFinal:fFinal,idCliente:idCliente,clave_cliente:clave_cliente, idNcotizacion: idNcotizacion}, function(data)
    {
      location.reload();
    });      
  }

  $(".datosTextMod").change(function()
{ 
  if($("#IdcmbClientes").val()!=null)
    var cliente=$("#IdcmbClientes").val().split("#");
  else
    cliente="";
  var tipoServicio=$("#IdcmbTipoServicio").val();
  if($("#fechaIn").val() > $('#fechaFin').val() || $('#fechaFin').val() < $('#fechaIn').val())
    {
      var fechaFin=$("#fechaIn").val();
      $("#fechaFin").val($("#fechaIn").val());
    }
    else
    {
      var fechaFin=$("#fechaFin").val();
    }

});