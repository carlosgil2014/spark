$(document).on('click','.imgDetalleCobrado', function()
{
	var idFactura=$(this).attr("value");
	//alert(idFactura);
	$.post("../controller/crudCobrado.php?accion=modalIndexCobrado",{idFactura:idFactura},function(data)
	{
		$("#IdModaldetalleCobrado").html(data);
    $('[data-toggle="tooltip"]').tooltip();
	});
});
$(document).on("click","#idParcialmente",function()
{
  
    $("div.pago").removeClass("hidden");
    $("#asignarPago").addClass("disabled");
    $("div.fechaPagoCompleto").addClass("hidden");

});
$(document).on("click","#idPagado",function()
{

    $("div.pago").addClass("hidden");
    $("#asignarPago").removeClass("disabled");
    $("div.fechaPagoCompleto").removeClass("hidden");

});
$(document).on("click","#idnoPagado",function()
{

    $("div.pago").addClass("hidden");
    $("#asignarPago").removeClass("disabled");
    $("div.fechaPagoCompleto").addClass("hidden");

});
$(document).on("click","#idCancelar",function()
{

    $("div.pago").addClass("hidden");
    $("#asignarPago").removeClass("disabled");
    $("div.fechaPagoCompleto").addClass("hidden");

});
$(document).on("keyup","#idPago",function()
{
  
  if(!$.trim($(this).val()))
  {
    $("#asignarPago").addClass("disabled");
  }
  else
  {
    $("#asignarPago").removeClass("disabled");
    var cantida=parseFloat($("#idPago").val());
    var idPf = $("#asignarPago").attr('value');
    var total = $(".pagoTotal").val();
    var detallePago = $(".detallePagoTotal").val();
    if(cantida>total)
      $("#idPago").val("");
    if(cantida>detallePago)
      $("#idPago").val("");
  }

});

$(document).on('click', "#asignarPago", function() 
{ 
  var datos = {}, ordenesServicio = "", preValor = $(this).attr("preValor"),idOrden = [];
  datos["edoPago"] = $("input[type='radio'][name='pagoPf']:checked").val();
  datos["idPf"] = $(this).attr('value');
  datos["pagoPf"] = $("#idPago").val();

  if(datos["edoPago"] == "pagado")
    datos["fechaPago"] = $("#idFechaPagoCompleto").val();
  else
    datos["fechaPago"] = $("#idFechaPago").val();
    
    if(datos["edoPago"] == "Cancelada")
    {
      $.ajax(
      {
        data: {datos:datos},
        url: '../controller/crudCobrado.php?accion=validarCancelacionPf',
        type: 'post',
        dataType : 'json',
        success : function(data)
        {
          if($.isArray(data))
          {
            for (var i = 0; i < data.length; i++) 
            {
              idOrden.push(data[i]["idorden"]);
              ordenesServicio = ordenesServicio+data[i]["ordenServicio"]+", ";
            }
            datos["idOrden"] = idOrden;
            $('#modalCobrado').modal('hide');
            $("#motivoCancelacionFactura").html('<p style="text-align: justify;"><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px 0;"></span>¡Al cancelar esta factura se cancelarán las siguintes ordenes de servicio!</p><p><textarea style="resize:none; border:none; width:100%; font-size:.7em;" disabled>'+ordenesServicio+'</textarea></p><p><textarea id="idMotivoCancelacionFactura" style="resize:none; width:100%; font-size: 8pt; height: 70px;"></textarea></p>')
            $("#motivoCancelacionFactura").dialog(
            {
              resizable: false,
              modal: true,
              buttons: 
              [
                {
                  text: "Aceptar",
                  id: "idbtnAceptar",
                  hidden: "hidden",
                  click: function()
                  {
                    $(this).dialog('close');
                    $(".loader").fadeIn("slow", function()
                    {
                      datos["motivoCancelacion"] = $("#idMotivoCancelacionFactura").val();
                      $.ajax(
                      {
                        data: {datos:datos},
                        url: '../controller/crudCobrado.php?accion=asignarPago',
                        type: 'post',
                        success : function(data)
                        {
                          if(data)
                          {
                            $.post("../controller/crudCobrado.php?accion=modalIndexCobrado",{idFactura:datos["idPf"]},function(data)
                            {
                              $("#IdModaldetalleCobrado").html(data);
                              $('[data-toggle="tooltip"]').tooltip();
                            });
                            $('#modalCobrado').modal('show');
                          }
                          $(".loader").fadeOut("fast");

                        }

                      });
                    });
                  }
                },
                {
                  text: "Cancelar",
                  id: "idbtnCancelar",
                  click: function()
                  {
                    $(this).dialog('close');
                    switch(preValor) 
                    {
                      case 'pagado':
                        $("#idPagado").prop("checked", true);
                        break;
                      case 'parcialmente':
                        $("#idParcialmente").prop("checked", true);
                        break;
                      case 'nopagado':
                        $("#idnoPagado").prop("checked", true);                        
                        break;
                      case 'Cancelada':
                        $("#idCancelar").prop("checked", true);
                        break;
                    }
                    $('#modalCobrado').modal('show');
                  }
                }

              ]
            });
            
          }
          else
          {
            $('#modalCobrado').modal('hide');
            $("#motivoCancelacionFactura").html('<textarea id="idMotivoCancelacionFactura" style="resize:none; width:100%; font-size: 8pt; height: 70px;"></textarea>');
            $("#motivoCancelacionFactura").dialog(
            {
              resizable: false,
              modal: true,
              buttons: 
              [
                {
                  text: "Aceptar",
                  id: "idbtnAceptar",
                  hidden: "hidden",
                  click: function()
                  {
                    datos["idOrden"] = "";
                    $(this).dialog('close');
                    $(".loader").fadeIn("slow", function()
                    {
                      datos["motivoCancelacion"] = $("#idMotivoCancelacionFactura").val();
                      $.ajax(
                      {
                        data: {datos:datos},
                        url: '../controller/crudCobrado.php?accion=asignarPago',
                        type: 'post',
                        success : function(data)
                        {
                          if(data)
                          {
                            $.post("../controller/crudCobrado.php?accion=modalIndexCobrado",{idFactura:datos["idPf"]},function(data)
                            {
                              $("#IdModaldetalleCobrado").html(data);
                              $('[data-toggle="tooltip"]').tooltip();
                            });
                            $('#modalCobrado').modal('show');
                          }
                          $(".loader").fadeOut("fast");

                        }

                      });
                    });
                  }
                },
                {
                  text: "Cancelar",
                  id: "idbtnCancelar",
                  click: function()
                  {
                    $(this).dialog('close');
                    switch(preValor) 
                    {
                      case 'pagado':
                        $("#idPagado").prop("checked", true);
                        break;
                      case 'parcialmente':
                        $("#idParcialmente").prop("checked", true);
                        break;
                      case 'nopagado':
                        $("#idnoPagado").prop("checked", true);                        
                        break;
                      case 'Cancelada':
                        $("#idCancelar").prop("checked", true);
                        break;
                    }
                    $('#modalCobrado').modal('show');
                  }
                }

              ]
            });
          }
        }
      });
    }
    else
    {
      if($("#idPagado").is(":checked"))
      {
         var total = $(".pagoTotal").val();
         if(total!=undefined)
         {
            datos["pagoPf"] = $(".pagoTotal").val();
         }
         else
         {
            datos["pagoPf"] = $(".detallePagoTotal").val();
         }
      }
      $(".loader").fadeIn("slow", function()
      {
        $.ajax(
        {
          data: {datos:datos},
          url: '../controller/crudCobrado.php?accion=asignarPago',
          type: 'post',
          success : function(data)
          {
            if(data)
            {
              $.post( "../controller/crudCobrado.php?accion=modalIndexCobrado",{  idFactura : datos["idPf"] },function(data)
              {
                $(".loader").fadeOut("fast");
                 $("#IdModaldetalleCobrado").html(data);
                
              });
            }
            else
              alert(data);
          }
        });
      });
    }
  });

$(document).on("keyup","#idMotivoCancelacionFactura",function(){
  if(!$.trim($(this).val()))
  {
    document.getElementById("idbtnAceptar").hidden = true;
    // $("#idbtnAceptar").button("disable");
  }
  else
  {
     document.getElementById("idbtnAceptar").hidden = false;
  }
});