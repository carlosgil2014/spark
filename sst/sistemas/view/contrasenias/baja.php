<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Baja Usuario</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
     <form id="formEditar" role="form" data-toggle="validator" action="index.php?accion=bajaEmpleado" method="POST">
      
      <div class="modal-body text-center">
          <input type="hidden" id="idEmpleadoBaja" name="idEmpleadoBaja" value="">
          Desea dar de baja a:
          <div id="modalNombre"></div>
        
      </div>

      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <button class="btn btn-danger pull-right" id="btnGuardar">Baja</button>

      </div>
    </form>
    
  </div>
</div>