var sumaPTPf, sumaCPf, sumaTPf;

function modalPrefactura(idPrefactura)
{ 
    $(".loader").fadeIn("slow", function(){
        $.ajax({
            data:{idPrefactura : idPrefactura},
            url:   'view/prefacturas/index.php?accion=modalIndexPf',
            type:  'post',
            success:  function (data) {
                $("#modalIndex").html(data);
                $("#clientesPf").selectpicker(parametros);
                $('[data-toggle="tooltip"]').tooltip();
                $(".loader").fadeOut("fast");
            },
        });
        $("#modalIndex").modal("show");
    });
}

$(document).on("click", "#modificarPrefactura", function() { 

  var tipoPrefactura = $("#tipoPrefactura").val();
  var detalle = $("#detalle");
  var idClientePrefactura = $("[name='Datos[idClientePrefactura]']");
  var descuento = $("#descuento");
  var motivoDescuento  = $("#motivoDescuento");
  var idPrefactura = $(this).val();
    $('#descuento').val($('#descuento').val().replace("$","").replace(/,/g,''));
    idClientePrefactura.prop("disabled",false);
    detalle.prop("readonly",false);
    descuento.prop("readonly",false);
    if(descuento.val() > 0 )
    motivoDescuento.prop("readonly",false);
    sumaPTPf = 0;sumaCPf = 0; sumaTPf = 0;
    if(tipoPrefactura == "cd"){
      $(".editablesPf").each(function() {
        var texto = $(this).find("td:eq(0)").text();
        var celdaConcepto = $(this).find("td:eq(0)");
        var tabla = $(this).attr("tipo");
        var idCotOsConcepto = $(this).attr("idCotOsConcepto");
        $(".loader").fadeIn("slow", function(){
          $.ajax({
              data:{idCotOsConcepto : idCotOsConcepto , tabla : tabla, idPrefactura : idPrefactura},
              url:   'view/prefacturas/index.php?accion=maximosConceptos',
              type:  'post',
              success:  function (data) {
                celdaConcepto.html("<input type='number' class='form-control text-center cantidadPf tool' max = '"+data+"' value='"+texto+"' data-toggle='tooltip'  data-placement='bottom' title='Disponibles: "+data+"' />");
                $('[data-toggle="tooltip"]').tooltip();
                $(".loader").fadeOut("fast");
              },
          });
        });
      });
    }
  $(this).html("Guardar");
  $(this).attr("id","guardarCambiosPrefactura");
  $(this).attr("value",idPrefactura);
});


$(document).on("keyup change", ".cantidadPf", function()
{
  var actual = parseFloat($(this).val());
    var precio = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
    var comision = parseFloat(($(this).closest('tr').attr('com')/100));
    var descuento = parseFloat($('#descuento').val().replace("$","").replace(/,/g,''));
    var subtotal = 1 + comision;
    var max = parseFloat($(this).attr('max'));
    var sumaPTPf = 0;sumaCPf = 0; sumaTPf = 0;
      if(isNaN(precio))
        precio = $(this).closest("tr").find("td:eq(2)").find("input.sumaPrecio").val();

    if(actual > max || actual <= 0){
      $(this).val(max);
      actual =  parseFloat($(this).val());
    }
      $(this).closest("tr").find("td:eq(3)").html(formatoMoneda(actual * precio ,"$"));
        $(this).closest("tr").find("td:eq(4)").html(formatoMoneda(actual * precio * comision,"$"));
        $(this).closest("tr").find("td:eq(5)").html(formatoMoneda(actual * precio * subtotal,"$"));

        $(".editablesPf").each(function() {
          sumaPTPf += parseFloat($(this).find("td:eq(3)").html().replace("$","").replace(/,/g,""));
          sumaCPf += parseFloat($(this).find("td:eq(4)").html().replace("$","").replace(/,/g,""));
          sumaTPf += parseFloat($(this).find("td:eq(5)").html().replace("$","").replace(/,/g,""));
        });

        $("#sumaPTPf").html(formatoMoneda(sumaPTPf,"$"));
        $("#sumaCPf").html(formatoMoneda(sumaCPf,"$"));
        $("#sumaTPf").html(formatoMoneda(sumaTPf,"$"));
        $("#sumaTt").html(formatoMoneda(sumaTPf - descuento,"$"));
});

$(document).on("click", "#guardarCambiosPrefactura", function() {
  var estado = $("#idEstado").val();
  var tipoPrefactura = $("#tipoPrefactura").val();
  var idPrefactura = $(this).val();
  var detalle = $("#detalle").val();
  var idClientePrefactura = $("[name='Datos[idClientePrefactura]']").val();
  var descuento = $("#descuento").val();
  var motivodescuento = $("#motivoDescuento").val();
  var total = $("#sumaTt").html().replace("$","").replace(/,/g,'');

  if(descuento == "")
    descuento = 0;
  if(comprobartablaPf())
  {
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          data:{idPrefactura : idPrefactura , detalle : detalle, idclienteprefactura: idClientePrefactura, descuento : descuento, motivodescuento : motivodescuento, total : total,estado:estado},
          url:   'view/prefacturas/index.php?accion=actualizarPrefactura',
          type:  'post',
          success:  function (data) {
            $(".editablesPf").each(function() {
              var datosConcepto = {}; 
              var comision = parseFloat(1 + ($(this).closest('tr').attr('com')/100));
              datosConcepto["idPrefacturaConcepto"] = $(this).attr("pfCon");
              datosConcepto["cantidad"] = $(this).find('td:eq(0)').find("input.cantidadPf").val();
              datosConcepto["precioUnitario"] = parseFloat($(this).closest('tr').find('td:eq(2)').html().replace("$","").replace(/,/g,''));
              datosConcepto["subtotal"] = (datosConcepto["cantidad"] * datosConcepto["precioUnitario"] * comision).toFixed(2);
              $.ajax({
                data:{datosConcepto : datosConcepto},
                url:   'view/prefacturas/index.php?accion=actualizarPrefacturaConcepto',
                type:  'post'
              });
            });
            $("modalIndex").modal("hide");
            $(".loader").fadeOut("fast");
            modalPrefactura(idPrefactura);
          },
      });
    });
  }
  else
    alert("Incorrecto");
});

function comprobartablaPf() {
  var tipoPrefactura = $("#tipoPrefactura").val();
  var vecesEachComprobar = 0, filasCorrectas = 0;
  var bandera = 1;
  var servicio = $("#servicio");
  if(tipoPrefactura == "sd"){
     if(!$.trim($("#detalle").val()))
      bandera = 0;
  }
  if($("#descuento").val() > 0)
     if(!$.trim($("#motivoDescuento").val()))
      bandera = 0;
 
      $(".editablesPf").each(function() {

        if($(this).find("input.cantidadPf").val() != '' && $(this).find("input.cantidadPf").val() != "0" && Math.floor($(this).find("input.cantidadPf").val()) == $(this).find("input.cantidadPf").val() && $.isNumeric($(this).find("input.cantidadPf").val()))
        {
          filasCorrectas++;
        }
          vecesEachComprobar++;

      });

  if(filasCorrectas == vecesEachComprobar && bandera == 1)
    return true;
  else
    return false;
} 

$(document).on('keyup change', "input#descuento", function() { 
    descuento = parseFloat($(this).val());
    var resta;
    var total = parseFloat($("#sumaTPf").html().replace("$","").replace(/,/g,''));
      if(!isNaN(descuento) && !isNaN(total))
      {
        if(descuento > 0 || descuento < 0)
          $("#motivoDescuento").attr("readonly",false);
        else{
          $("#motivoDescuento").attr("readonly",true);
          $("#motivoDescuento").val("");
        }
        resta = total - descuento;
          $("#sumaTt").html(formatoMoneda(resta,"$"));
      }
      else{ 
        $("#sumaTt").html(formatoMoneda(total,"$"));
      $("#motivoDescuento").attr("readonly",true);
      $("#motivoDescuento").val("");
      }
});

$(document).on('keyup', "input.cfdi", function() { 
  if($.trim($(this).val()))
    $('#asignarCfdi').prop('disabled',false);
  else
    $('#asignarCfdi').prop('disabled',true);
});

$(document).on('click', "button#asignarCfdi", function() { 
  idPrefactura = $(this).val();
  $(".loader").fadeIn("slow", function(){
    $.ajax({
        data:{cfdi : $('#cfdiPrefactura').val() , idPrefactura : idPrefactura , fechaCfdi: $('#fechaCfdi').val()},
        url:   'view/prefacturas/index.php?accion=asignarCfdi',
        type:  'post',
        success:  function (data) {
          modalPrefactura(idPrefactura);
        },
    });
  });
});