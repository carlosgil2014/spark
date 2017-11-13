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
  $tipo = "DV";
  if(strpos($resultadoOrden["estado"],"Devolucion") === false){
      $tipo = "OS";
  }
?>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <div class="row">
        <div class="form-group col-md-4 col-sm-12 col-xs-12">
          <?php   echo $tipo."-".$resultadoOrden['clave']?>-<?php echo $resultadoOrden['anio']?>-<?php echo $resultadoOrden['norden']?>
        </div>
        <?php 
        if($resultadoOrden["fechaInicial"] < $fechaMinima && $permisosUsuario['autorizar'] == 1 && $resultadoOrden["estado"] != "Autorizada"){
        ?>
        <div class="form-group col-md-4 col-sm-12 col-xs-12" id="div_nota" >
          <div class="alert alert-warning text-center" style="padding: 5px;">
            <p>En caso de autorizar, verifique las fechas</p>
          </div>
        </div>
        <?php
        }
        ?>
        <div class="form-group <?php 
        if($resultadoOrden["fechaInicial"] >= $fechaMinima || $permisosUsuario['autorizar'] != 1 || $resultadoOrden["estado"] == "Autorizada"){
        ?> col-md-offset-4 <?php } ?> col-md-4 text-right hidden-sm hidden-xs">
          <?php echo $resultadoUsuario["nombre"];?>
        </div>
        <div class="form-group col-xs-12  visible-sm visible-xs">
          <?php echo $resultadoUsuario["nombre"];?>
        </div>
      </div>
      <div class= "row">
        <div class="form-group col-md-3 col-xs-6">
          <label>De </label>
          <input type="date" class="form-control input-sm" value="<?php echo $resultadoOrden["fechaInicial"];?>" id="fechaInicial" min ="<?php echo $fechaMinima;?>" <?php if($resultadoOrden["fechaInicial"] >= $fechaMinima || $resultadoOrden["estado"] == "Autorizada"){?> readonly <?php } ?>>
        </div>
        <div class="form-group col-md-offset-6 col-md-3 col-xs-6">
          <label>Hasta</label>
          <input class="form-control input-sm" type="date" min ="<?php echo $fechaMinima;?>" value="<?php echo $resultadoOrden["fechaFinal"];?>" id="fechaFinal" <?php if($resultadoOrden["fechaInicial"] >= $fechaMinima || $resultadoOrden["estado"] == "Autorizada"){?> readonly <?php } ?>>
        </div>
      </div>
      <div class= "row">
        <div class="form-group col-md-6 col-xs-12">
          <label>Servicio </label>
          <input class="form-control input-sm" id="servicio" value="<?php echo $resultadoOrden['servicio'];?>" readonly>
        </div>
        <?php
        if($resultadoOrden['estado']=='Autorizada'){
        ?>
        <div class="form-group col-md-6 col-xs-12 text-right" id="divCfdi">
            <label>&nbsp;</label>
            <div>
              <label class="radio-inline"> <input type="radio" name="ejecOr" class="ejec" value="ejecutandose" <?php if($resultadoOrden['ejecucion']=='ejecutandose'){ ?> checked <?php } if($permisosUsuario['poliza'] != 1){?> disabled <?php } ?> >Ejecutada</label>
              <label class="radio-inline"><input type="radio" name="ejecOr" class="ejec" value="noejecutandose" <?php if($resultadoOrden['ejecucion']=='noejecutandose'){ ?> checked <?php }  if($permisosUsuario["poliza"] != 1 ){?> disabled <?php } ?> >No ejecutada</label>
            </div>
        </div>
       
        <?php
        }
        ?>
      </div>
      <?php
      if($resultadoOrden['estado']=='Autorizada'){
      ?>
      <div class= "row numPoliza" <?php if($resultadoOrden['ejecucion']=='noejecutandose'){ ?> hidden<?php } ?>>
        <div class="form-group col-md-3 col-xs-6">
          <label>Póliza actual</label>
          <input class="form-control input-sm" value="<?php echo $resultadoOrden['numeropoliza']; ?>" readonly>
        </div>
        <div class="form-group col-md-3 col-xs-6">
          <label>Folio actual </label>
          <input class="form-control input-sm" value="<?php echo $resultadoOrden['folio']; ?>" readonly>
        </div>
        <div class="form-group col-md-2 col-xs-5">
          <label>Póliza</label>
        <input type="text" name="numeroPoliza" class="form-control input-sm" value="<?php if(!empty($resultadoOrden['numeropoliza'])){echo $resultadoOrden['numeropoliza'];}?>" id="numPoliza">
        </div>
        <div class="form-group col-md-3 col-xs-5">
          <label>Folio</label>
        <input type="text" name="numeroFolio" class="form-control input-sm" value="<?php if(!empty($resultadoOrden['folio'])){echo $resultadoOrden['folio'];}?>" id="numFolio">
        </div>
        <div class="form-group col-md-1 col-xs-2 text-right">
          <label>&nbsp;</label>
          <?php
          if($permisosUsuario['poliza'] == 1){
          ?>
          <div>
            <button class="btn btn-success btn-flat btn-sm btnGenerar" value="<?php echo $resultadoOrden['idorden'];?>" id="asignarEjec" disabled><i class="fa fa-arrow-circle-right"></i></button>
          </div>
          <?php
          }
          ?>
        </div> 
      </div>
      <?php 
      }
      ?>
      <div class="row">
        <div class="form-group col-md-4 col-md-offset-4" id="div_alert" style="display:none;">
          <div class="alert alert-danger" style="padding: 5px;"> <a onclick="cerrar('div_alert')" style="cursor: pointer;" class="pull-right"><i class="fa fa-close"></i></a>
            <p id="p_alert"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-body" style="height: 300px; overflow-y: auto;">
      <div class="table-responsive">
          <table class="table table-bordered table-condensed small ">
            <tr class="text-center bg-primary">
              <td>Cantidad</td>
              <td>Concepto</td>
              <td>Precio Unitario</td>
              <td>Total</td>
              <td>Comisión</td>
              <td>Subtotal</td>
              <td></td>
            </tr>  
        <?php
        $cont=0; 
        foreach($filaConceptosOrden as $filaConceptosOrden)
        {
        ?>
        <!-- <tr class="text-center">
                  <td>Tipo de Plan</td>
                  <td colspan="2"><?php echo $filaConceptosCot['tipoplan'];?></td>
                  <td colspan="1">Tipo de Servicio</td>
                  <td colspan="3"><?php echo $filaConceptosCot['tiposervicio'];?></td>
              </tr>--> 
          <tr class='filaRubro editables text-center' precioCon="<?php echo $precioConcepto[$cont]['precio']?>" com = "<?php echo $filaConceptosOrden['comision']?>" osCon="<?php echo $filaConceptosOrden['idordconcepto']?>" <?php if($filaConceptosOrden['idcotconcepto'] != NULL) echo "idCotPfConcepto = '".$filaConceptosOrden['idcotconcepto']."' tipo='cot'"; elseif ($filaConceptosOrden['idpfconcepto'] != NULL) echo "idCotPfConcepto = '".$filaConceptosOrden['idpfconcepto']."' tipo='pf'" ;?>>
            <td><?php echo $filaConceptosOrden['cantidad'];?></td>
            <td><?php echo $filaConceptosOrden['concepto']?></td>
            <td><?php echo '$ '.number_format($filaConceptosOrden['precioUnitario'],2)?></td>
            <td><?php echo '$ '.number_format($filaConceptosOrden['cantidad']*$filaConceptosOrden['precioUnitario'],2)?></td>
            <td style='color:black; text-decoration:none;' data-toggle='tooltip' data-container="body" data-placement='top' title='<?php echo $filaConceptosOrden['comision'];?>%'><?php echo '$ '.number_format($filaConceptosOrden['cantidad']*$filaConceptosOrden['precioUnitario'] *(1*($filaConceptosOrden['comision']/100)),2)?></td>
            <td><?php echo '$ '.number_format($filaConceptosOrden['total'],2)?></td>
            <td><a style='cursor: pointer;' data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php echo $folioCotPf[$cont];?>'><i class="fa fa-search"></i></a></td>
          </tr>  
          <?php
            $cont++;
            if(!empty($filaConceptosOrden['descripcion'])){
          ?>  
          <tr>
            <td></td>
            <td colspan="6"><?php echo $filaConceptosOrden['descripcion'];?></td>
          </tr>
          <?php
          } 
        }
        ?>
          <tr class="text-center active">
            <td></td>
            <td></td>
            <td></td>
            <td id="sumaPT"><?php echo '$ '.number_format($sumaConceptosOrden['totalPu'],2);?></td>
            <td id="sumaC"><?php echo '$ '.number_format($sumaConceptosOrden['totalCa'],2);?></td>
            <td id="sumaT"><?php echo '$ '.number_format($sumaConceptosOrden['totalT'],2);?></td>
            <td></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="modal-footer">
    <?php
    if($resultadoOrden['estado'] == 'Rechazada' || $resultadoOrden['estado'] == 'Cancelada' || $resultadoOrden['estado'] == 'DevolucionR' || $resultadoOrden['estado'] == 'DevolucionC' ){
    ?>
      <div class="row">
        <div class=" col-sm-6">
          <div class="alert alert-danger text-left">
              <?php echo $resultadoOrden['motivo']?>
          </div>
        </div>
      </div>
    <?php 
    } 
    ?>

      <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
    <?php
    if(($resultadoOrden["estado"]=="Por autorizar" || $resultadoOrden["estado"]=="Rechazada") && $resultadoPf['num'] == 0 && $resultadoOrden["realizo"] == $datosUsuario["usuario"])
    { 
    ?>
    <button type="button" class="btn btn-success btn-sm btn-flat" id="modificarOrdenes" value="<?php echo $_POST['idOrden']?>" >Modificar</button>
    <?php 
    }
    if($permisosUsuario['autorizar'] == 1 && $resultadoOrden["estado"]!="Autorizada") {
    ?>
      <button type="button" class="btn btn-success btn-sm btn-flat" id="autorizar" onclick="autorizarOrden('<?php echo $_POST["idOrden"]?>')" >Autorizar</button>
    <?php 
    }?>
    </div>  
  </div>
</div>













