<?php 
// $imagen = imagecreatefromstring($datosUsuario['foto']);
// $imagen = imagescale($imagen, 45, 45);
// // start buffering
// ob_start();
// imagepng($imagen);
// $contenido =  ob_get_contents();
// ob_end_clean();
?>
<!-- Panel de usuario de la barra lateral -->
<div class="user-panel">
  	<div class="pull-left">
    	<img src="data:image;base64,<?php echo base64_encode($datosUsuario['foto']);?>" width="45" height="45" class="img-responsive img-circle" alt="Foto de Usuario">
    </div>
  	<div class="pull-left info">
    	<p><?php echo $datosUsuario["usuario"];?></p>
    	<!-- <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a> -->
  	</div>
</div>
<?php 
// imagedestroy($imagen);
?>