<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $datosUsuario["nombre"];?>/Clientes</h4>
    </div>
    <div class="modal-body">
        <table class="table" style="font-size:8pt">
                <?php
                $cont = 0;
                $i = 0;
                    foreach($datosClientes as $cliente )                
                    { 
                        if($cont == 0)
                        {
                ?>
                    <tr>
                <?php
                        }  
                ?>

                        <td class="<?php if(in_array($cliente["idclientes"],$datos)){echo 'success';}else{echo 'danger';}?>" >
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="checkCliente" name="clientesCheck" value="<?php echo $cliente['idclientes']?>" <?php if(in_array($cliente["idclientes"],$datos)){echo 'checked';}?> /><?php echo $cliente["cliente"]." (".$cliente["clave_cliente"].")";?>
                                </label>
                            </div>
                        </td>
                <?php    
                        $cont++;
                        $i++;
                        if($cont==5){
                            $cont=0;
                        }

                    }
                ?>
            </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btnGuardarClientes" value="<?php echo $_POST['idUsuario']?>">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
</div>