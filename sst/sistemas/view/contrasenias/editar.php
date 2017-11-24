<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Editar Usuarios</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
     <form id="formEditar" role="form" data-toggle="validator" action="index.php?accion=actualizar" method="POST">
      <div class="modal-body">
     
        <div class="row">
          <input type="hidden" id="modalIdSistemas" name="datos[idsistemasempleado]">
          <input type="hidden" id="modalId" name="datos[id]">
           
            <div class="col-md-4 form-group">
              <label for="">Nombre(s)</label>
              <input class="form-control" type="text" id="modalNombre" value="" readonly>
            </div>
            <div class="col-md-4 form-group">
              <label for="modalCorreo" class="control-label">Correo Agencia</label>
              <input type="email" name="datos[correoAgencia]" class="form-control" id="modalCorreo" placeholder="Email" data-error="Ingrese un correo valido" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
              <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-4 form-group">
              <label for="">Contraseña Computadora</label>
              <input type="text" name="datos[contraComp]" class="form-control" id="modalContraseniaComp" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
              <label for="modalContraseniaCorreo">Contraseña Correo</label>
              <input type="text" name="datos[contraCorreo]" class="form-control" id="modalContraseniaCorreo" value="" required>
            </div>
            <div class="col-md-4 form-group">
              <label for="modalFechaExpira">Expiración</label>
              <input type="date" name="datos[fchExpira]" class="form-control" id="modalFechaExpira" value="" readonly>
            </div>
            <div class="col-md-4 form-group">
              <label for="modalFechaCambio">Fecha de Cambio</label>
              <input type="date" name="datos[fchCambio]" class="form-control" id="modalFechaCambio" data-error="Ingrese una fecha" value="" required>
               <div class="help-block with-errors"></div>
            </div>  
        </div>
              
    </div>
  
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    <button class="btn btn-success pull-right" id="btnGuardar">Guardar</button>

    </div>
    </form>
    
  </div>
</div>