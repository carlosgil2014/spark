<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formEditar" method="POST" role="form" action="index.php?accion=actualizar&id=<?php echo $_GET['id'];?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Modificar linea</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Linea</label>
            <input type="text" name="linea" maxlength="10" pattern="[0-9]{10}" class="form-control input-sm" data-error="Es un campo obligatorio" required id="linea" placeholder="1234567890" value="<?php echo $linea['linea']; ?>">
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="idLinea" value="<?php echo $linea['idLinea']; ?>">
          <input type="hidden" name="compararSim" value="<?php echo $linea['IDSIM']; ?>">
          <div class="form-group col-md-12">
            <label class="control-label">SIM</label>
            <select class="form-control input-sm selectpicker"  name="simId" data-error="Es un campo obligatorio" data-live-search="true" id="simId">
              <?php if(!empty($linea['IDSIM'])){ ?>
                <option value="<?php echo $linea['IDSIM'];?>"><?php echo $linea['ICC'];?>(Actual)</option>
              <?php }else{?>
              <option value="0">Seleccione un ICC</option>
              <?php } ?>
              <?php 
            foreach ($sims as $sim){
            ?>
            <option value="<?php echo $sim['idSim']; ?>"><?php echo $sim['icc']; ?></option>
            <?php
            }
            ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-warning">Actualizar</button>
      </div> 
    </form>
  </div>
</div>