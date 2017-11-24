<?php 

    if(date("d") <= 5){

        $mes = date("m");

        $mes = $mes - 1;

        $dia = '01';

        $fechaMinima = date("Y"."-".$mes."-".$dia);

    }

    else{

        $mes = date("m");

        $dia = '01';

        $fechaMinima = date("Y"."-".$mes."-".$dia);

    }



?>

<div class="modal-header">

        <div class="row">

            <div class="col-lg-2">

                <h6 class="modal-title">Orden de servicio</h6>

            </div>

        </div> 

        <div class="row">

            <div class="col-lg-6">

                <label>Servicio</label>

            </div>

            <div class="col-lg-3">

                <label>Fecha Inicial</label>

            </div>

            <div class="col-lg-3">

                <label>Fecha Final</label>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <textarea type="text" style="resize:none;" class="form-control input-sm" name="Datos[servicio]" required> </textarea>

            </div>

            <div class="col-lg-3">

                <input type="date" class="form-control input-sm" name="Datos[fechaInicialOrden]" min="<?php echo $fechaMinima;?>" required>

            </div>

            <div class="col-lg-3">

                <input type="date" class="form-control input-sm" name="Datos[fechaFinalOrden]" min="<?php echo $fechaMinima;?>" required>

            </div>

        </div>

</div>

<div class="modal-body">

    <form>

        <table id="IdtablaOrden"  style="width:100%; "  cellpadding="10">

            <tbody>

                <?php 

                $totalPu = 0;

                $totalC = 0;

                $totalT = 0;

                for($i = 0; $i < count($datos); $i++)

                {
                    if($activo != "pf"){

                        $tmpPu = floatval($datos[$i]['precio']) * floatval($datos[$i]['maximo']);

                        $tmpC =  floatval($datos[$i]['maximo']) *  floatval($datos[$i]['precio']) * floatval((1*($datos[$i]['comisionagencia']/100)));

                        $tmpT = $tmpPu + $tmpC;

                        $totalPu += $tmpPu;

                        $totalC += $tmpC;

                        $cantidad = $datos[$i]["maximo"];

                        $precio = $datos[$i]["precio"];

                    }

                    else{

                        if($datos[$i]['cantidad'] > 0){

                        $precioTmp = $datos[$i]['maximo'] / (1+($datos[$i]['comisionagencia']/100));

                        $tmpPu = floatval($precioTmp) * 1; //floatval($datos[$i]['cantidad'])

                        $tmpC =  1 *  floatval($precioTmp) * floatval((1*($datos[$i]['comisionagencia']/100)));

                        $tmpT = $tmpPu + $tmpC;

                        $totalPu += $tmpPu;

                        $totalC += $tmpC;

                        $cantidad = $datos[$i]['cantidad'];

                        $precio = $datos[$i]["precio"];

                        $minIf = floatval($tmpT-.05);
                        
                        $maxIf = floatval($tmpT+.05);

                            if(floatval($datos[$i]['maximo']) <= floatval($minIf) || floatval($datos[$i]['maximo']) >= floatval($maxIf)){

                                $cantidad = "";

                                $totalPu = "0.00";

                                $totalC = "0.00";

                                $tmpT = "0.00";

                                $tmpPu = "0.00";

                                $precio = 0.00;

                            }



                        }

                        else{

                           $precioTmp = $datos[$i]['maximo'] / (1+($datos[$i]['comisionagencia']/100));

                            $tmpPu = floatval($precioTmp) * 1; //floatval($datos[$i]['cantidad'])

                            $tmpC =  1 *  floatval($precioTmp) * floatval((1*($datos[$i]['comisionagencia']/100)));

                            $tmpT = $tmpPu + $tmpC;

                            $totalPu += $tmpPu;

                            $totalC += $tmpC;

                            $cantidad = 1;

                            $precio = str_replace(",","",number_format($precioTmp,2));

                            $minIf = floatval($tmpT-.05);
                            
                            $maxIf = floatval($tmpT+.05);

                                if(floatval($datos[$i]['maximo']) <= floatval($minIf) || floatval($datos[$i]['maximo']) >= floatval($maxIf)){

                                    $cantidad = "";

                                    $totalPu = "0.00";

                                    $totalC = "0.00";

                                    $tmpT = "0.00";

                                    $tmpPu = "0.00";

                                    $precio = 0.00;

                                }



                        }

                    }

                   

                ?>

                    <tr style='border-bottom: 0px;'>

                        <td align='center' class='col-xs-6 col-lg-4 TipoPlan'> <b>TIPO DE PLAN</b></td>

                        <td align='center' class='col-xs-6 col-lg-3 TipoServicio'> <b>TIPO DE SERVICIO</b></td>

                        <td align='center' class='col-xs-6 col-lg-1 TipoPlan' colspan="4"> <b>DESCRIPCION DEL CONCEPTO (OPCIONAL)</b></td>

                    </tr>

                    <tr align='center'>

                        <td class='col-xs-6 col-lg-4'>

                            <?php

                            if($activo == "pf")

                            {

                            // $cantidad = "";

                            // $totalPu = "0.00";

                            // $totalC = "0.00";

                            // $tmpT = "0.00";

                            // $tmpPu = "0.00";

                    

                            ?>

                            <select class="form-control input-sm tp" style="">

                            <?php 

                                $arrTiposPlan = array("Promotoría o Merchandiser","Demostración o Impulso de ventas","Administración de nómina");

                                foreach ($arrTiposPlan as $tp)

                                    {

                                        if($datos[$i]["tipoplan"] != $tp) {

                                    ?>

                                        <option value="<?php echo $tp; ?>"><?php echo $tp;?></option>

                                    <?php

                                        }

                                        else

                                        {

                                    ?>

                                        <option value="<?php echo $tp; ?>" selected><?php echo $tp;?></option>

                                    <?php

                                        }

                                    }

                            ?>

                            </select>

                            <?php

                            }

                            else

                            echo $datos[$i]["tipoplan"];   

                            ?>

                        </td>

                        <td class='col-xs-6 col-lg-3'>

                            <?php

                            if($activo == "pf")

                            {

                            ?>

                            <select class="form-control input-sm ts" >

                            <?php 

                                $arrTiposServicio = array("Gestión de personal (Nómina)","Compras de Bienes o Servicios","Coordinación y/o Consultoría","Gastos y/o Viáticos");

                                foreach ($arrTiposServicio as $ts)

                                    {
                                    if($datos[$i]["tiposervicio"] != $ts) {

                                    ?>

                                        <option value="<?php echo $ts; ?>"><?php echo $ts;?></option>

                                    <?php

                                        }

                                        else

                                        {

                                    ?>

                                        <option value="<?php echo $ts; ?>" selected><?php echo $ts;?></option>

                                    <?php

                                        }


                                    }

                            ?>

                            </select>

                            <?php 

                            } 

                            else

                            echo $datos[$i]["tiposervicio"];  

                            ?>

                        </td>

                        <td colspan="4">

                            <textarea class="form-control descripcion" style="width:100%; resize:none;" rows="1">
                            <?php if(isset($datos[$i]["descrip"])) echo $datos[$i]["descrip"];?></textarea>

                        </td>

                    </tr>

                    <tr >

                        <td align='center' class='col-xs-6 col-lg-1 Cantidad'><b>Cantidad</b></td>

                        <td align='left' class='col-xs-6 col-lg-4 Concepto'> <b>Concepto</b></td>

                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>

                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>

                        <td align='center'  class='col-xs-6 col-lg-2 PUnitario'><b>Comisión</b></td>

                        <td align='center' class='col-xs-6 col-lg-4 SubTotal'><b>Subtotal</b></td>

                    </tr>   

                    <tr align='center' id_rubro="<?php echo $datos[$i]["id_rubro"];?>" class='filaRubro editables rubro_<?php echo $i;?>' dis = "<?php echo $datos[$i]["maximo"];?>" com="<?php echo $datos[$i]["comisionagencia"];?>" tp = "<?php echo $datos[$i]["tipoplan"];?>" i="<?php echo $i;?>" ts = "<?php echo $datos[$i]["tiposervicio"];?>" idcon = "<?php echo $datos[$i]["idconcepto"];?>">

                        <td align='center' class='col-xs-6 col-lg-1' ><input type="number" class = "form-control input-sm cantidad text-center" value = "<?php echo $cantidad;?>" max="<?php echo $datos[$i]["maximo"];?>" required></td>

                        <td align='left'   class='col-xs-6 col-lg-4' >

                            <?php

                            if($activo == "pf")

                            {

                            ?>

                                <select class="form-control input-sm concepto" >
                                    <option selected><?php echo $datos[$i]['concepto'];?></option>
                                </select>

                            <?php 

                            }

                            else{

                                echo $datos[$i]['concepto']; 

                            }

                            ?>

                        </td>

                        <td align='center' class='col-xs-6 col-lg-2'>

                            <?php 

                                if($datos[$i]['precioConcepto'] != "0.00"){

                                    echo "$".number_format($precio,2); 


                                }

                                else

                                {

                                //     if($activo == "pf")

                                //         $precio = 0.00;

                                	if($activo == "pf"){
                                		if($datos[$i]['precioConcepto'] != "0.00"){
                                			$precioTemporal =  round($tmpPu,2);
                               			}
                               			else{
                                            $minIfTmp = floatval(($cantidad * $precio)-.05);
                                            $maxIfTmp = floatval(($cantidad * $precio)+.05);

                                            if(floatval($tmpPu) <= floatval($minIfTmp) || floatval($tmpPu) >= floatval($maxIfTmp))
                                			    $precioTemporal = round($tmpPu,2);
                                            else
                                                $precioTemporal = $precio;
                               			}
                                	}
                                	else{
                                		$precioTemporal = $precio;
                                	}


                            ?>
                                    <input type="number" class="form-control input-sm text-center sumaPrecio" step="0.01" value="<?php echo $precioTemporal;;?>" <?php echo $datos[$i]["maximo"];?>>
                            <?php

                                }

                            ?>

                        </td>

                        <td align='center' class='col-xs-6 col-lg-2'>$<?php echo number_format($tmpPu,2);?></td>

                        <td align='center'>

                            <?php

                            if($activo == "pf")

                            {

                            ?>

                            <input data-toggle='tooltip' class = "form-control input-sm text-center tool comision" type = "number" data-placement='bottom' title='<?php echo $datos[$i]['comisionagencia'];?> %' value="<?php echo $datos[$i]['comisionagencia'];?>">

                            <?php 

                            } 

                            else{

                            ?>

                            <a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $datos[$i]['comisionagencia'];?> %'>$ <?php echo number_format($tmpC,2);?> 

                            </a>

                            <?php

                            }

                            ?>

                        </td>

                        <td>

                            $ <?php echo number_format($tmpT,2);?>

                        </td>

                    </tr>

                    <tr>

                        <td>
                        <?php 
                        if($datos[$i]['precioConcepto'] == "0.00"){
                        ?>
                            <span style="cursor:pointer;" onclick="clonarFila(this);" class="glyphicon glyphicon-plus" aria-hidden="true"></span></td>
                        <?php
                        }
                        else{
                        ?>
                        &nbsp;
                        <?php    
                        }
                        ?>
                    </tr>

                <?php

                }

                $totalT += ($totalPu + $totalC);

                ?>

                    <tr>

                        <td></td>

                        <td></td>

                        <td class='col-xs-6 col-lg-1 TipoOSmodal' align="center">Totales: </td>

                        <td class='col-xs-6 col-lg-3 TipoOSmodal'  align="center" id="sumaPT" ><?php echo '$ '.number_format($totalPu,2);?></td>

                        <td class='col-xs-6 col-lg-3 TipoOSmodal'  align="center" id="sumaC" ><?php echo '$ '.number_format($totalC,2);?></td>

                        <td class='col-xs-6 col-lg-3 TipoOSmodal'  align="center" id="sumaT" ><?php echo '$ '.number_format($totalT,2);?></td>

                    </tr>

                    <tr>

                        <td><br></td>

                    </tr>

            </tbody>

        </table>

        <input id="importe" value="<?php echo number_format($totalT,2)?>" hidden>

    </form>

</div>

<div class="modal-footer">

    <button type="button" class="btn btn-primary btn-sm" id="btnGuardar">Guardar</button>

    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>

</div>