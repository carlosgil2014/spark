var parametros = {
          style: 'btn-info  btn-flat btn-sm',
          size: '5',
          noneSelectedText: 'Seleccionar un cliente', 
          liveSearchPlaceholder:'Buscar',
          noneResultsText: '¡No existe el cliente buscado!',
          countSelectedText:'{0} Clientes seleccionados',
          actionsBox:true,
          selectAllText: 'Seleccionar todos',
          deselectAllText: 'Deseleccionar todos'
        }
var formPrincipal = $("#formPrincipal"), divTablaPrincipal = $("#COPC"), tituloTablaPrincipal = $("#tituloTablaPrincipal"), estadoTemporal = "", idCotOrdPfTmp = 0;
$(document).ready(function() {
    $('#clientes').selectpicker(parametros);

  $(document).on("click",".imgClonar",function() { 
    idCotizacion = $(this).attr("value");
    $( "#confirmacion" ).dialog(
      {
          resizable: false,modal: true,
          buttons: 
          [{
              text:"Continuar",id:"idbtnContinuarOS",
              click: function(){
                  $.post( "../controller/crudCotizaciones.php?accion=clonarCotizacion",{idCotizacion : idCotizacion},function(data)
                    { 
                      $( "#folioNuevo" ).html(data);
                      $( "#folioNuevo" ).dialog(
                        {
                            resizable: false,modal: true,
                            buttons: 
                            [{
                                text:"Continuar",id:"idbtnContinuarOS",
                                click: function(){
                                  $(this).dialog("close");
                                }
                              }
                            ],
                            close: function() {
                              $(this).dialog('close');
                            }
                        });
                    });
                $(this).dialog("close");
              }
            },
            {
              text:"Cancelar",id:"idbtnCancelarOS",
              click: function(){
                $(this).dialog('close');
              }
            }
          ],
          close: function() {
            $(this).dialog('close');
          }
      });
  });
  $(".loader").fadeOut("slow");
});

function formatoMoneda(n, simbolo) {
    return simbolo + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}


function saldosPorFacturar(li, año){
  if($(li).attr("class") != "active"){
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          url:   'index.php?accion=saldosPorFacturar&anio='+año,
            type:  'post',
          success:  function (data) {
            $(li).find("b").html(data);
            // alert(data);
            $(".loader").fadeOut("fast");
          },
      });
    });
  }
  else{
    $(li).find("b").html("");
  }
}

function osPorRealizar(li, año){
  if($(li).attr("class") != "active"){
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          url:   'index.php?accion=osPorRealizar&anio='+año,
            type:  'post',
          success:  function (data) {
            $(li).find("b").html(data);
            // alert(data);
            $(".loader").fadeOut("fast");
          },
      });
    });
  }
  else{
    $(li).find("b").html("");
  }
}

function tablaPrincipal(tmpTabla, estado){ //Obtener tabla COT/OS/PF/FAC 
  var tmpTabla, fechaInicial, fechaFinal, idClientes = [], estado,tabla;
  fechaInicial = $("input[name='Datos[fechaInicial]']").val();
  fechaFinal = $("input[name='Datos[fechaFinal]']").val();
  idClientes = $("select[name='Datos[idCliente][]']").val();
  if($(this).children("span").eq(1).html() != '0'){
    $(".loader").fadeIn("slow", function(){
      $.ajax({
          data: {idClientes : idClientes, tmpTabla : tmpTabla, fechaInicial : fechaInicial, fechaFinal : fechaFinal, estado : estado},
          url:   'index.php?accion=tablaPrincipal',
          type:  'post',
          success:  function (data) {
            tituloTablaPrincipal.html(tmpTabla +" / "+ estado)
            divTablaPrincipal.html(data);
            tabla = $("#tablaPrincipal").DataTable(
              {
                responsive: true,
                columnDefs: [{ type: 'natural', targets: '_all' },{ "width": "30%", "targets": 2}],
                fixedColumns: true
              });
            var nNodes = tabla.rows().nodes();
            $('.selectpicker',nNodes).selectpicker({style: 'btn-flat btn-xs'});  
            $('.selectpicker',nNodes).on('shown.bs.select', function (e) {
              estadoTemporal = $(this).val();
            });
            $(".loader").fadeOut("fast");
          },
      });
    });
  }
  else{
    alert("No existen resultados.");
  }
}

function cambiarEstado(idCotOrdPf, tabla, elemento, fechaInicial, fechaFinal, estadoActual){ //Autorizar/Rechazar/Cancelar/Por autorizar 

  var f = new Date(), mes = f.getMonth()+1, dia = f.getDate(), hoy = f.getFullYear() + '-' + (mes<10 ? '0' : '') + mes + '-' + (dia<10 ? '0' : '') + dia, fechaMinima, fila = $(this).closest("tr"), motivo, estado = $(elemento).val();
    estadoTemporal = ((estadoTemporal == "" && idCotOrdPfTmp != idCotOrdPf ) ? estadoActual : estadoTemporal);
  if(dia <= '5'){
    mes = mes - 1;
    dia = '1';
    fechaMinima = f.getFullYear() + '-' + (mes<'10' ? '0' : '') + mes + '-' + (dia<'10' ? '0' : '') + dia;
  }
  else{
    dia = '1';
    fechaMinima = f.getFullYear() + '-' + (mes<'10' ? '0' : '') + mes + '-' + (dia<'10' ? '0' : '') + dia;
  }

  if(estado == "Rechazada" || estado == "Cancelada" || estado == "DevolucionR" || estado == "DevolucionC"){
    $("#modalMotivo").unbind().modal({ backdrop: "static", keyboard: false }).one("click", "#continuar", function (e) {
      motivo = $('#motivoText').val();
      $(".loader").fadeIn("slow", function(){
        $.ajax({
            data:{idCotOrdPf : idCotOrdPf,estado : estado,motivo : motivo, tabla : tabla,fechaInicial:fechaInicial,fechaFinal:fechaFinal},
            url:   'index.php?accion=accionCotOrd',
            type:  'post',
            success:  function (data) {
              $("#motivoText").val("");
              if(tabla == "Cotizaciones")
                $("#cot"+idCotOrdPf).html(data);
              else
                $("#ord"+idCotOrdPf).html(data);
              
              estadoTemporal = estado;
              idCotOrdPfTmp = ((idCotOrdPf != idCotOrdPfTmp) ? idCotOrdPf : idCotOrdPfTmp);
              $('[data-toggle="popover"]').popover(); 
              $(".loader").fadeOut("slow");
            },
        });
      });
    }).one("click", "#cancelar", function (e) {
      if(idCotOrdPf == idCotOrdPfTmp || estadoTemporal != estadoActual){
        $(elemento).val(estadoTemporal);
      }
      else{
        $(elemento).val(estadoActual);
      }
      $(elemento).selectpicker("refresh");
    }); 
  }
  else
  {
    if(fechaMinima <= fechaInicial || estado != "Autorizada" || tabla == "Cotizaciones" || tabla == "Prefacturas")
    {
      motivo = "";
      $(".loader").fadeIn("slow", function()
        {
        $.ajax(
        {
          data:{idCotOrdPf : idCotOrdPf,estado : estado,motivo : motivo, tabla : tabla,fechaInicial:fechaInicial,fechaFinal:fechaFinal},
              url:   'index.php?accion=accionCotOrd',
              type:  'post',
              success:  function (data) 
              {
                estadoTemporal = estado;
                idCotOrdPfTmp = ((idCotOrdPf != idCotOrdPfTmp) ? idCotOrdPf : idCotOrdPfTmp);
                $(".loader").fadeOut("slow");
              }
        });
      });
    }
    else
    {
      idOrden = idCotOrdPf;
      modalOrden(idOrden);
      $(elemento).val(estadoActual);
      $(elemento).selectpicker("refresh");
    }
  }
};