<div class="modal-dialog" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=eliminar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Eliminar Producto</b></h4>
      </div>
      <div class="modal-body">
        <p>¿Eliminar el producto <b><?php echo $_GET["producto"];?></b>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-danger btn-sm">Eliminar</button>
      </div> 
    </form>
  </div>
</div>
