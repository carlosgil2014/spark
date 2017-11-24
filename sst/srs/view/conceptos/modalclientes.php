<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header" id="IdModalClientes">
            <label>Clientes relacionados con: <?php echo $datosConcepto['nombreRubro']?></label>
        </div>
        <div class="modal-body" >
            <table class="table" style="font-size:8pt">
                <?php
                $cont = 0;
                $i = 0;
                    foreach($datosCliente as $cliente )                
                    { 
                        if($cont == 0)
                        {
                ?>
                    <tr>
                <?php
                        }  
                ?>

                        <td class="<?php if($clienteRelacionado[$i]>0){echo 'success';}else{echo 'danger';}?>" >
                            <div class="checkbox">
                                <label><input type="checkbox" class="checkCliente" name="clientesCheck" cl="<?php echo $cliente['idclientes']?>" <?php if($clienteRelacionado[$i]>0){echo 'checked';}?> /><?php echo $cliente["cliente"];?></label>
                            </div>
                        </td>
                <?php    
                        $cont++;
                        $i++;
                        if($cont==2){
                            $cont=0;
                        }

                    }
                ?>
            </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="guardarRelaciones"  con= "<?php echo $datosConcepto['id']?>" nom= "<?php echo $datosConcepto['nombreRubro']?>" pre= "<?php echo $datosConcepto['precio']?>" cat= "<?php echo $datosConcepto['categoria']?>">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>