<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Editar Usuarios</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="formEditar">
        <div class="row">
            <div class="col-md-4 form-group">
              <label for="">Nombre(s)</label>
              <input class="form-control" type="text" id="modalNombre" value="" readonly>
            </div>
            <div class="col-md-4 form-group">
              <label for="">Correo Agencia</label>
              <input type="text" name="correoAgencia" class="form-control" id="modalCorreo"  value="">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Contraseña Computadora</label>
              <input type="text" name="contraComp" class="form-control" id="modalContraseniaComp" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
              <label for="">Contraseña Correo</label>
              <input type="text" name="contraCorreo" class="form-control" id="modalContraseniaCorreo" value="">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Expiración</label>
              <input type="date" name="fchExpira" class="form-control" id="modalFechaExpira" value="" readonly>
            </div>
            <div class="col-md-4 form-group">
              <label for="">Fecha de Cambio</label>
              <input type="date" name="fchCambio" class="form-control" id="modalFechaCambio" value="">
            </div>  
        </div>
      </form>
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" onclick="guardar();">Guardar</button>
    </div>
  </div>
</div>