<?php 
foreach ($modelos as $modelo){
?>
    <option value="<?php echo $modelo['idModelo']?>" ><?php echo $modelo["modelo"]?></option>
<?php
}
?>