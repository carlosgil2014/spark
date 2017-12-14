<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Alta de asignacion </b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Linea</label>
            <input type="text" name="linea" maxlength="10" pattern="[0-9]{10}" class="form-control input-sm" data-error="Es un campo obligatorio" required id="linea" placeholder="1234567890">
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">SIM</label>
            <select class="form-control input-sm selectpicker"  name="tipo" data-error="Es un campo obligatorio" data-live-search="true" id="tipo">
              <option value="">Seleccionar</option>
              <?php 
            foreach ($sims as $sim){
            echo '<option value="'.$sim['idSim'].'">'.$sim['icc'].'</option>';
            ?>
            <?php
            }
            ?>
            </select>
          </div>
        <!-- /.col-md-12 -->
        </div>
      </div>
      <div class="modal-footer">
        <div id="mensaje"></div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-success btn-sm">Guardar</button>
      </div> 
    </form>
  </div>
</div>
