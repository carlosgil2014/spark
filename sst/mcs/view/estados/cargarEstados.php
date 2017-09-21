<?php 
foreach ($estados as $estado){
?>
    <option value="<?php echo $estado['idestado']?>"  <?php if ($estado["idestado"] == 57) echo "selected";?>><?php echo $estado["nombre"]?></option>
<?php
}
?>