<?php $prefactura = $datos;?>
<div class="modal-header" style="padding-top:0px;">
  <div class="row">
    <h5 style="text-align:left;float:left; width:50%; display: inline-block;"><?php echo ($prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoA" || $prefactura["estado"] == "ConciliadoR" || $prefactura["estado"] == "ConciliadoC") ? "CL": "PF";?>-<?php echo $prefactura["clave"];?>-<?php echo $prefactura["anio"];?>-<?php echo $prefactura["nprefactura"];?></h5>
    <h6 style="text-align:right;float:right;width:50%; display: inline-block;">Elaboró: <?php echo $nombre;?></h6>
  </div>
  <?php if($prefactura["estado"] != "Conciliado"){?>
  <div class="row">
    <h6 style="text-align:left;float:left; width:30%; display: inline-block;" >Facturar a: <small><?php echo $razonSocial;?></small></h6>
    <?php 
    if($resultados["prefacturas"]["cfdi"]==1){
    ?>
    <div class="form-inline" style="text-align:right;float:right;width:70%; display: inline-block;">
      <div class="form-group">
        <small>
          <?php 
          if($prefactura["fechacfdi"] == "0000-00-00"){
            echo "Fecha";
          }else{
            echo "Fecha registrada";
          }
          ?>
        </small>
        <input type="date" class="form-control input-sm text-center" id="fechaCfdi" value="<?php if($prefactura["fechacfdi"] == "0000-00-00"){
            echo date('Y-m-d');
          }else{
            echo $prefactura["fechacfdi"];
          }
          ?>">
      </div>
      <div class="form-group" id="divCfdi">
        <small> 
          <?php 
          if(empty($prefactura["cfdi"])){
            echo "CFDI";
          }else{
            echo "CFDI registrado";
          }
          ?>
        </small>
        <input type="text" class="form-control input-sm text-center cfdi" id="cfdiPrefactura" value="<?php 
          if(empty($prefactura["cfdi"])){
            echo "";
          }else{
            echo $prefactura["cfdi"];
          }
          ?>">
      </div>
      <button type="submit" class="btn btn-info btn-xs" id="asignarCfdi" value="<?php echo $idPrefactura;?>" disabled>Asignar</button>
    </div>
  <?php
  }
  ?>
  </div>
  <?php
  }
  ?>
  <div class="row">
    <select class="form-control input-sm" name="Datos[idClientePrefactura]" required disabled>
      <?php 
      foreach ($datosCliente as $cliente)
      {
          if(isset($prefactura["idclienteprefactura"])){
              if($prefactura["idclienteprefactura"] != $cliente['idclientes']) {
          ?>
              <option value="<?php echo $cliente['idclientes'] ?>"><?php echo ($cliente["cliente"]);?></option>
          <?php
              }
              else
              {
          ?>
              <option value="<?php echo $cliente['idclientes'] ?>" selected><?php echo ($cliente["cliente"]);?></option>
          <?php
              }
          }
          else{
          ?>
              <option value="<?php echo $cliente['idclientes'] ?>"><?php echo ($cliente["cliente"]);?></option>
          <?php
          }
      }
      ?>
    </select>
  </div>
</div>
<div class="modal-body">
  <div class="row">
    <input id="tipoPrefactura" value="<?php echo $prefactura['tipo']?>" hidden>
    <input id="idEstado" value="<?php echo $prefactura["estado"];?>" hidden="">
    <table>
      <?php
      $totalPu = 0;
      $totalC = 0;
      $totalT = 0;
      $rubroTmp = 0;
      foreach ($datosConceptos as $concepto){
          if($concepto['idprefacturaconcepto'] != $rubroTmp){
            $tmpPu = floatval($concepto['precio']) * floatval($concepto['cantidad']);
            $tmpC =  floatval($concepto['cantidad']) *  floatval($concepto['precio']) * floatval((1*($concepto['comision']/100)));
            $tmpT = $tmpPu + $tmpC;
            $totalPu += $tmpPu;
            $totalC += $tmpC;
            if($prefactura["tipo"] == "cd"){
      ?>
        <tr class="TipoPlan">
          <th class="col-lg-2 text-center">Tipo Plan</th>
          <th class="col-lg-2 text-center">Tipo Servicio</th>
          <th class="col-lg-2 text-center"></th>
          <th class="col-lg-2 text-center"></th>
          <th class="col-lg-2 text-center"></th>
          <th class="col-lg-2 text-center"></th>
          <th class="text-center"></th>
        </tr>
        <tr class="filaRubro">
          <td class="text-center"><?php echo $concepto["tipoplan"];?></td>
          <td class="text-center"><?php echo $concepto["tiposervicio"];?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="Cantidad">
          <th class="text-center">Cantidad</th>
          <th class="text-center">Concepto</th>
          <th class="text-center">Precio</th>
          <th class="text-center">Precio Total</th>
          <th class="text-center">Comisión</th>
          <th class="text-center"> Subtotal</th>
          <th class="text-center"></th>
        </tr>
        <tr class="filaRubro editablesPf" com = "<?php echo $concepto['comision']?>" pfCon="<?php echo $concepto['idprefacturaconcepto']?>" <?php if($concepto['idcotconcepto'] != NULL) echo "idCotOsConcepto = '".$concepto['idcotconcepto']."' tipo='cot'"; elseif ($concepto['idordconcepto'] != NULL) echo "idCotOsConcepto = '".$concepto['idordconcepto']."' tipo='os'" ;?>>
          <td class="text-center"><?php echo $concepto["cantidad"];?></td>
          <td class="text-center"><?php echo $concepto["concepto"];?></td>
          <td class="text-center"><?php echo "$ ".number_format($concepto["precio"],2);?></td>
          <td class="text-center"><?php echo "$ ".number_format($concepto["precio"] * $concepto["cantidad"],2);?></td>
          <td class="text-center"><a href="#" style='color:black; text-decoration:none;' data-toggle='tooltip'  data-placement='top' title='<?php echo $concepto['comision'];?>%'><?php echo "$ ".number_format($concepto["precio"] * $concepto["cantidad"] * ($concepto["comision"]/100),2);?></a></td>
          <td class="text-center"><?php echo "$ ".number_format($concepto["total"],2);?></td>
          <?php 
          // Saber el origen por concepto, es decir si proviene de una cotización o de una orden de servicio.
          if($concepto["tipo"] == 'abc'){ //Saber de que cotización proviene la orden de servicio
            $origen = "COT-".$concepto["clave_cliente"]."-".$concepto["anioCot"]."-".$concepto["ncotizacion"];
            if(!is_null($concepto["norden"])){//Saber de que cotización proviene la orden de servicio
              $folio = ($prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoA" || $prefactura["estado"] == "ConciliadoR" || $prefactura["estado"] == "ConciliadoC") ? "CL": "PF";
              $origen.= " <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> OS-".$concepto["clave_cliente"]."-".$concepto["anioOs"]."-".$concepto["norden"]."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> ".$folio."-".$concepto["clave_cliente"]."-".$concepto["anio"]."-".$concepto["nprefactura"];
            }
              
          }
          else{
            $origen = "";
            foreach($datosConceptos as $datosTmp){
              if($concepto["idprefacturaconcepto"] == $datosTmp["idprefacturaconcepto"]){
                $origen .= "COT-".$concepto["clave_cliente"]."-".$concepto["anioCot"]."-".$concepto["ncotizacion"]." <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> PF-".$concepto["clave_cliente"]."-".$concepto["anio"]."-".$concepto["nprefactura"]."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> OS-".$datosTmp["clave_cliente"]."-".$datosTmp["anioOs"]."-".$datosTmp["norden"]."<br>";
              }


            }
          }
          ?> 
          <td class="text-center"><a href="#" style='color:black; text-decoration:none;' data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php echo $origen;?>'>Detalles</a></td>
        </tr>
        <tr  class="filaRubro">
          <td></td>
          <td class="text-justify col-lg-3"><?php echo $concepto['descripcion']?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>  
        <tr>
          <td style='background-color:#000; height:1px;'></td>
          <td style='background-color:#000; height:1px;'></td>
          <td style='background-color:#000; height:1px;'></td>
          <td style='background-color:#000; height:1px;'></td>
          <td style='background-color:#000; height:1px;'></td>
          <td style='background-color:#000; height:1px;'></td>
          <td style='background-color:#000; height:1px;'></td>
        </tr>
      <?php
          }
        }
        $rubroTmp = $concepto["idprefacturaconcepto"];
      }
      $totalT = $totalPu + $totalC ;
      ?>
      <tr>
        <td><br/></td>
      </tr>
      <tr>
        <td class="col-lg-2"></td>
        <td class="col-lg-2"></td>
        <td class="TipoOSmodal col-lg-2" align="center">Totales: </td>
        <td class="TipoOSmodal col-lg-2"  align="center" id="sumaPTPf" ><?php echo '$ '.number_format($totalPu,2);?></td>
        <td class="TipoOSmodal col-lg-2"  align="center" id="sumaCPf" ><?php echo '$ '.number_format($totalC,2);?></td>
        <td class="TipoOSmodal col-lg-2"  align="center" id="sumaTPf" ><?php echo '$ '.number_format($totalT,2);?></td>
        <td class="TipoOSmodal">&nbsp;</td>
      </tr>
      <tr>
        <td><br/></td>
      </tr>
      <tr>
        <td><label>Motivo descuento</label></td>
        <td colspan="3">
          <textarea class="form-control" style="resize:none;" id="motivoDescuento" readonly><?php echo $prefactura["motivodescuento"];?></textarea>
        </td>
        <td class="TipoOSmodal" style="background-color:#FFFFFF;color:#000000;" align="center">Descuento</td>
        <td class="TipoOSmodal" style="background-color:#FFFFFF;color:#000000;" align="center"><input class="form-control input-sm text-center" id="descuento" value="<?php echo '$ '.number_format($prefactura["descuento"],2);?>" readonly/></td>
        <td ></td>
      </tr>
      <tr>
        <td><br/></td>
      </tr>
    </table>
  </div>
  <div class="row" align="center">
    <h5 style="text-align:right;float:right;width:20%; display: inline-block;text-align:center;"><label>Total: </label><label id="sumaTt"><?php echo " $ ".number_format($totalT - $prefactura["descuento"],2);?></label></h5>
  </div>
  <div class="row">
    <label>Detalle</label>
    <textarea class="form-control" style="resize:none;" id="detalle" readonly><?php echo $prefactura["detalle"];?></textarea>
  </div>
</div>
<div class="modal-footer">
  <?php
  if(($prefactura["estado"] == "Por facturar" || $prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoR") && $prefactura["realizo"] == $usuario){
  ?>
  <button type="button" class="btn btn-success" id="modificarPrefactura" value="<?php echo $idPrefactura;?>">Modificar</button>
  <?php 
  }
  ?>
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>