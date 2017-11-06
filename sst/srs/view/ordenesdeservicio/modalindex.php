<h4 class="modal-title">
<?php
if(date("d") <= 5){
    $mes = date("m");
    $mes = $mes - 1;
    if(strlen($mes) == 1)
      $mes = "0".$mes;
    $dia = '01';
    $fechaMinima = date("Y"."-".$mes."-".$dia);
  }
  else{
    $mes = date("m");
    $dia = '01';
    if(strlen($mes) == 1)
      $mes = "0".$mes;
    $fechaMinima = date("Y"."-".$mes."-".$dia);
  }
if($elaboroOrden ==1)
{
?>
&nbsp;OS-<?php   echo $resultadoOrden['clave']?>-<?php echo $resultadoOrden['anio']?>-<?php echo $resultadoOrden['norden']?> <small class="pull-right"> Elaboró: <?php echo $resultadoUsuario?></small>
<?php
}
?>
</h4>

<?php
if($resultadoOrden['estado']=='Autorizada')
{
?>
    <div class="form-group-inline pull-right" id="divCfdi"> 
        <input type="radio" name="ejecOr" value="ejecutandose" class="ejec"  <?php if($resultadoOrden['ejecucion']=='ejecutandose'){ ?> checked <?php } if($permisosUsuario['poliza'] == 1){} else{?>disabled<?php } ?> > Ejecutada&nbsp; &nbsp; 
        <input type="radio" name="ejecOr" value="noejecutandose" class="ejec" <?php if($resultadoOrden['ejecucion']=='noejecutandose'){ ?> checked <?php }  if($permisosUsuario["poliza"] == 1 ){} else{?>disabled<?php } ?> > No ejecutada&nbsp; &nbsp; 
            <?php
            if($permisosUsuario['poliza'] == 1)
            {
            ?>
                <button class="btn btn-info btn-xs btnGenerar" value="<?php echo $resultadoOrden['idorden'];?>" id="asignarEjec" disabled>Guardar</button>
            <?php
            }
        ?> 
    </div>
<?php
}
?> 

  <form class="form-inline">
      <div class="form-group" id="divFechaInicial">
        Fecha Inicial: 
        <input class="form-control" type="date" value="<?php echo $resultadoOrden["fechaInicial"];?>" id="fechaInicial" min ="<?php echo $fechaMinima;?>" <?php if($resultadoOrden["fechaInicial"] >= $fechaMinima || $resultadoOrden["estado"] == "Autorizada"){?> readonly <?php } ?>>
      </div>
      <div class="form-group" id="divFechaFinal">
        Fecha Final:
        <input class="form-control" type="date" min ="<?php echo $fechaMinima;?>" value="<?php echo $resultadoOrden["fechaFinal"];?>" id="fechaFinal" <?php if($resultadoOrden["fechaInicial"] >= $fechaMinima || $resultadoOrden["estado"] == "Autorizada"){?> readonly <?php } ?>>&nbsp;&nbsp;&nbsp;
      </div>
      <div id="alertFecha" class="form-group">
        <?php if($resultadoOrden["fechaInicial"] < $fechaMinima && $resultadoOrden["estado"] != "Autorizada"){?><span class='label label-danger'>Modificar fecha de orden de servicio.</span><?php } ?>
      </div>
  </form>

  <div class="form-group" id="divServicio">
      Servicio 
      <textarea class="form-control" style="resize:none;" id="servicio" readonly><?php echo $resultadoOrden['servicio'];?></textarea>
  </div>
  <?php
  if($resultadoOrden['estado']=='Autorizada')
  {
  ?>
  <div class="form-group-inline pull-left numPoliza" <?php if($resultadoOrden['ejecucion']=='noejecutandose'){ ?> hidden<?php } ?>>
      <label class="numPolizaActual">Número de póliza actual: <?php echo $resultadoOrden['numeropoliza']; ?></label>
      <br/>
      <label class="numFolioActual">Folio actual: <?php echo $resultadoOrden['folio']; ?></label>
  </div>

  <div class="form-group col-lg-offset-6 numPoliza" <?php if($resultadoOrden['ejecucion']=='noejecutandose'){ ?> hidden<?php } ?>>
        <div class="form-group-inline col-lg-5">
        <label>Número de póliza: </label>
        <input type="text" name="numeroPoliza" class="form-control" value="<?php if(!empty($resultadoOrden['numeropoliza'])){echo $resultadoOrden['numeropoliza'];}?>" id="numPoliza">
        </div>
        <div class="form-group-inline col-lg-5">
        <label>Folio: </label>
        <input type="text" name="numeroFolio" class="form-control" value="<?php if(!empty($resultadoOrden['folio'])){echo $resultadoOrden['folio'];}?>" id="numFolio">
        </div>
        <br><br>
  </div>
  <?php
  }
  ?>

  <div class="modal-body" >
        <table>
        <?php
        $cont=0;
        foreach($filaConceptosOrden as $filaConceptosOrden)
    {
        
        ?>
      <tr style='border-bottom: 0px;'>
              <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
              <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
              <td></td>
              <td></td>
              <td></td> 
              <td></td> 
              <td></td>                        
            </tr>
            <tr >
              <td align='left' class='col-xs-6 col-lg-3' name="tipoPlan" >
                <?php echo $filaConceptosOrden["tipoplan"];?>
              </td>
              <td class='col-xs-6 col-lg-5'align='left'><?php echo $filaConceptosOrden["tiposervicio"];?></td>
              <td></td>
              <td></td>
              <td></td> 
              <td></td> 
              <td></td> 
            </tr>
            <tr class='filaRubro'>
              <td align='center' class='col-xs-6 col-lg-1 Cantidad'> <b>Cantidad</b></td>
              <td align='left'   class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
              <td align='center' class='col-xs-6 col-lg-1 Concepto'> <b>P. Unitario</b> </td>
              <td align='center' class='col-xs-6 col-lg-1 Concepto'> <b>P. Total</b> </td>
              <td align='center' class='col-xs-6 col-lg-2 PUnitario'><b>Comisión</b></td>
              <td align='center' class='col-xs-6 col-lg-2 SubTotal'> <b>Sub_Total</b></td>
              <td align='center' class='col-xs-6 col-lg-2 SubTotal'></td>
            </tr>   
            <tr class='filaRubro editables' precioCon="<?php echo $precioConcepto[$cont]['precio']?>" com = "<?php echo $filaConceptosOrden['comision']?>" osCon="<?php echo $filaConceptosOrden['idordconcepto']?>" <?php if($filaConceptosOrden['idcotconcepto'] != NULL) echo "idCotPfConcepto = '".$filaConceptosOrden['idcotconcepto']."' tipo='cot'"; elseif ($filaConceptosOrden['idpfconcepto'] != NULL) echo "idCotPfConcepto = '".$filaConceptosOrden['idpfconcepto']."' tipo='pf'" ;?>>
              <td align='center'  class='col-xs-6 col-lg-1'  ><?php echo $filaConceptosOrden['cantidad'];?></td>
              <td align='left'  class='col-xs-6 col-lg-5'><?php echo $filaConceptosOrden['concepto']?></td>
              <td align='center'  class='col-xs-6 col-lg-2'><?php echo '$ '.number_format($filaConceptosOrden['precioUnitario'],2)?></td>
              <td align='center'  class='col-xs-6 col-lg-2'><?php echo '$ '.number_format($filaConceptosOrden['cantidad']*$filaConceptosOrden['precioUnitario'],2)?></td>
              <td align='center' ><a style='color:black; text-decoration:none;' data-toggle='tooltip'  data-placement='top' title='<?php echo $filaConceptosOrden['comision'];?>%'><?php echo '$ '.number_format($filaConceptosOrden['cantidad']*$filaConceptosOrden['precioUnitario'] *(1*($filaConceptosOrden['comision']/100)),2)?></a></td>
              <td align='center'><?php echo '$ '.number_format($filaConceptosOrden['total'],2)?></td>
              <td align='center'><a style='color:black; text-decoration:none;' data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php echo $folioCotPf[$cont];?>'>(Origen)</a></td>
            </tr>
            <tr align='left' class='filaRubro'><td></td><td class='col-xs-6 col-lg-5'><?php echo $filaConceptosOrden['descripcion']?></td>
            </tr>
            <tr><td style='background-color:#000; height:1px;'></td>
                <td style='background-color:#000; height:1px;'></td>
                <td style='background-color:#000; height:1px;'></td>
                <td style='background-color:#000; height:1px;'></td>
                <td style='background-color:#000; height:1px;'></td>
                <td style='background-color:#000; height:1px;'></td>
                <td style='background-color:#000; height:1px;'></td>
            </tr>
            <?php 
            $cont++;
        }
            ?>
            <tr><td><br/></td>
            </tr>
            <tr >
              <td > 
              </td >
              <td >
              </td>
              <td class='TipoOSmodal' align="center">Totales: 
              </td>
              <td class='TipoOSmodal' align="center" id="sumaPT">

                <?php 
                  echo '$ '.number_format($sumaConceptosOrden['totalPu'],2);
                ?>
              </td>
              <td class='TipoOSmodal'  align="center" id="sumaC">
                <?php 
                  echo '$ '.number_format($sumaConceptosOrden['totalCa'],2);
                ?>
              </td>
              <td class='TipoOSmodal'  align="center" id="sumaT">
                <?php 
                  echo '$ '.number_format($sumaConceptosOrden['totalT'],2);
                ?>
              </td>
              <td class='TipoOSmodal'></td>
            </tr>


        </table>
    </div>
<?php 

if($resultadoOrden['estado'] == 'Rechazada'){

?>
<label style='font-family:verdana; font-size:80%;' align="center">Rechazada por: <?php echo $resultadoOrden['motivo']?></label>
<?php
}
if($resultadoOrden['estado'] == 'Cancelada' ){

?>
<label style='font-family:verdana; font-size:80%;' align="center">Motivo de cancelación por: <?php echo $resultadoOrden['motivo']?></label>
<?php
}
?>
<div class="modal-footer">
<?php
if(($resultadoOrden["estado"]=="Por autorizar" || $resultadoOrden["estado"]=="Rechazada") && $resultadoPf['num'] == 0 && $resultadoOrden["realizo"] == $_SESSION["srs_usuario"] && $resultadoOrden["fechaInicial"] >= $fechaMinima)
{ 
?>
<button type="button" class="btn btn-success" id="modificarOrdenes" value="<?php echo $_POST['idOrden']?>" >Modificar</button>
<?php 
}
if($permisosUsuario['autorizar'] == 1 && $resultadoOrden["estado"]!="Autorizada") {
?>
<button type="button" class="btn btn-success" data-dismiss="modal" id="autorizar" value="<?php echo $_POST["idOrden"]?>" >Autorizar</button>
<?php 
}
?>
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>