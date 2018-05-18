<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formularioModificar" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificacion de perfil</b></h4>
    </div>
    <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-4">
                <label class="control-label">Nombre de perfil</label>
                <input type="text" class="form-control input-sm" name="Datos[nombrePerfil]" id="nombrePerfil" required  value="<?php echo $perfil['nombrePerfil']; ?>">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Clientes</label>
                <select class="form-control input-sm selectpicker" name="Datos[cliente]" data-live-search="true" required="required" id="cliente">
                <?php 
                  foreach ($clientes as $cliente){
                ?>                            
                  <option <?php if($perfil['idCliente'] == $cliente['idclientes']){ echo 'selected';} ?> value="<?php echo $cliente['idclientes']?>"><?php echo $cliente['nombreComercial']?></option>';
                <?php
                  }
                ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Puesto</label>
                <select class="form-control input-sm selectpicker" name="Datos[puesto]" data-error="Es un campo obligatorio" data-live-search="true" required id="puesto">
                  <?php foreach ($puestos as $puesto) {
                  ?>

                  <option <?php if($perfil['idPuesto'] == $puesto['idPuesto']){ echo 'selected';} ?> value="<?php echo $puesto['idPuesto']; ?>"><?php echo $puesto['nombre']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-2">
                  <label class="control-label">Sueldo (Diario)</label>
                  <input type="number" class="form-control input-sm decimal" name="Datos[salario]" id="salario" value="<?php echo $perfil['salario']; ?>" min="0" step="0.01" pattern="^[0-9]+" required onkeypress="validarDecimalPositivo(this)">
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Edad mínima</label>
                <input type="number" class="form-control input-sm" maxlength="2" data-error="Es un campo obligatorio" name="Datos[edad]" required  id="edad" value="<?php echo $perfil['edad']; ?>"  min="18" max="50">
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Edad máxima</label>
                <input type="number" class="form-control input-sm" maxlength="2" data-error="Es un campo obligatorio" name="Datos[edadMaxima]" required  id="edadMaxima" value="<?php echo $perfil['edadMaxima']; ?>" min="18" max="50">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Sexo</label>
                <select class="form-control input-sm selectpicker" name="Datos[sexo]" data-error="Es un campo obligatorio" required="required" id="sexo">
                  <option <?php if($perfil['sexo'] == 'Hombre'){ echo 'selected';} ?> value="Hombre">Hombre</option>
                  <option <?php if($perfil['sexo'] == 'Mujer'){ echo 'selected';} ?> value="Mujer">Mujer</option>
                  <option <?php if($perfil['sexo'] == 'Indistinto'){ echo 'selected';} ?> value="Indistinto">Indistinto</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Escolaridad mínima</label>
                <select class="form-control input-sm selectpicker" name="Datos[escolaridad]" data-error="Es un campo obligatorio" required="required" id="escolaridad">
                <?php 
                  foreach ($escolaridades as $escolaridad){
                ?>                            
                  <option <?php if($escolaridad['idEscolaridad'] == $perfil['perfilEscolaridad']){ echo 'selected';} ?> value="<?php echo $escolaridad['idEscolaridad']?>"><?php echo $escolaridad['escolaridad']?></option>
                <?php
                  }
                ?>
                </select>
              </div>
              <?php $cadena = explode(",", $perfil['diasTrabajados']); ?>
              <div class="form-group col-md-8">
                <label class="control-label">Días trabajados&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="radio" name="dias"  id="semana" onclick="diasSemana('semana');" checked>L-V&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="dias" id="finSemana" onclick="diasSemana('finSemana');">S-D
                <div>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Lunes', $cadena)){echo 'checked';}?> value="Lunes" id="lunes">
                    Lunes
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red"  value="Martes" <?php if(in_array('Martes', $cadena)){echo 'checked';}?> id="martes">
                    Martes
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Miercoles" <?php if(in_array('Miercoles', $cadena)){echo 'checked';}?> id="miercoles">
                    Miércoles
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red"  value="Jueves" <?php if(in_array('Jueves', $cadena)){echo 'checked';}?> id="jueves">
                    Jueves
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red"  value="Viernes" <?php if(in_array('Viernes', $cadena)){echo 'checked';}?> id="viernes">
                    Viernes
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Sabado" <?php if(in_array('Sabado', $cadena)){echo 'checked';}?> id="sabado">
                    Sábado
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Domingo" <?php if(in_array('Domingo', $cadena)){echo 'checked';}?> id="domingo">
                    Domingo
                  </label>
                </div>
              </div>
              <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                    <label>Horario entrada</label>
                    <div class="input-group">
                      <input type="text" class="form-control timepicker"  id="entrada" name="horariosEntrada[]" value=" <?php echo $perfil['horarioEntrada']; ?> ">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                    </div>
                </div>
              </div>
              <div class="form-group col-md-2">
                <div class="bootstrap-timepicker">
                  <label>Horario salida</label>
                  <div class="input-group">
                    <input type="text" class="form-control timepicker"  id="salida" name="horariosSalida[]" value=" <?php echo $perfil['horarioSalida']; ?> ">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Experiencia</label>
                <select class="form-control input-sm selectpicker" name="Datos[experiencia]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                  <option <?php if($perfil['experiencia']=='1'){echo 'selected';}  ?> value="1">Ninguna</option>
                  <option <?php if($perfil['experiencia']=='2'){echo 'selected';}  ?> value="2">6 meses</option>
                  <option <?php if($perfil['experiencia']=='3'){echo 'selected';}  ?> value="3">1 año</option>
                  <option <?php if($perfil['experiencia']=='4'){echo 'selected';}  ?> value="4">2 años</option>
                  <option <?php if($perfil['experiencia']=='5'){echo 'selected';}  ?> value="5">3 años o más</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Estado civil</label>
                <select class="form-control input-sm selectpicker" name="Datos[estadoCivil]" data-error="Es un campo obligatorio" required="required" id="estadoCivil">
                    <option <?php if($perfil['estadoCivil']=='Casado/a'){echo 'selected';}  ?> value="Casado/a">Casado/a</option>
                    <option <?php if($perfil['estadoCivil']=='Comprometido/a'){echo 'selected';}  ?> value="Comprometido/a">Comprometido/a</option>
                    <option <?php if($perfil['estadoCivil']=='Divorciado/a'){echo 'selected';}  ?> value="Divorciado/a">Divorciado/a</option>
                    <option <?php if($perfil['estadoCivil']=='Soltero/a'){echo 'selected';}  ?> value="Soltero/a" selected="selected">Soltero/a</option>
                    <option <?php if($perfil['estadoCivil']=='Viudo/a'){echo 'selected';}  ?> value="Viudo/a">Viudo/a</option>
                    <option <?php if($perfil['estadoCivil']=='Indistinto'){echo 'selected';}  ?> value="Indistinto">Indistinto</option>
                  </select>
              </div>
              <?php $cadena = explode(",", $perfil['imagen']); ?>
              <div class="form-group col-md-3">
                <label class="control-label">Imagen</label>
                <select class="form-control input-sm selectpicker" name="imagen[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required>                 
                  <option <?php if(in_array('Presentable', $cadena)){echo 'checked';}?> value="Presentable" selected="selected">Presentable</option>
                  <option <?php if(in_array('Aseado', $cadena)){echo 'checked';}?> value="Aseado" selected="selected">Aseado</option>
                  <option <?php if(in_array('Traje', $cadena)){echo 'checked';}?> value="Traje">Traje</option>
                  <option <?php if(in_array('Condición saludable', $cadena)){echo 'checked';}?> value="Condición saludable">Condición saludable</option>
                  <option <?php if(in_array('Sin tatuajes', $cadena)){echo 'checked';}?> value="Sin tatuajes">Sin tatuajes</option>
                  <option <?php if(in_array('Sin percing', $cadena)){echo 'checked';}?> value="Sin percing">Sin percing</option>
                  <option <?php if(in_array('Sin expansiones', $cadena)){echo 'checked';}?> value="Sin expansiones">Sin expansiones</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Talla</label>
                <select class="form-control input-sm selectpicker" name="Datos[talla]" data-error="Es un campo obligatorio" required="required" id="talla">
                  <option <?php if($perfil['talla']=='Indistinto'){ echo 'selected'; } ?> value="Indistinto">Indistinto</option>
                  <option <?php if($perfil['talla']=='Chica'){ echo 'selected'; } ?> value="Chica">Chica</option>
                  <option <?php if($perfil['talla']=='Mediana'){ echo 'selected'; } ?> value="Mediana">Mediana</option>
                  <option <?php if($perfil['talla']=='Grande'){ echo 'selected'; } ?> value="Grande">Grande</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Lo entrevista cliente</label>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[entrevista]" class="flat-red" <?php if($perfil['entrevistaCliente']=='Si'){ echo 'checked';} ?> value="Si">
                      Si
                    </label>
                  </div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[entrevista]" class="flat-red" value="No" <?php if($perfil['entrevistaCliente']=='No'){ echo 'checked';} ?>>
                      No
                    </label>
                  </div>
              </div>
              <?php $cadenaConocimietos = explode(",", $perfil['conocimientosEspecificos']); ?>
              <div class="form-group col-md-3">
                <label class="control-label">Conocimientos específicos</label>
                <select class="form-control input-sm selectpicker" multiple name="conocimientos[]" data-error="Es un campo obligatorio" data-live-search="true" id="conocimiento">
                  <option data-hidden="true" <?php if($cadenaConocimietos[0] == '' && count($cadenaConocimietos)<=1){ echo 'selected';}?> value="NULL"></option>
                  <?php foreach ($conocimientos as $conocimiento) {
                  ?>
                  <option <?php if(in_array($conocimiento['idConocimiento'],$cadenaConocimietos)){ echo 'selected';} ?> value="<?php echo $conocimiento['idConocimiento']; ?>"><?php echo $conocimiento['conocimiento'];?></option>
                  <?php } ?>
                </select>
              </div>
              <?php $cadenaHabilidades = explode(",", $perfil['habilidades']); ?>
              <div class="form-group col-md-3">
                <label class="control-label">Habilidades</label>
                <select class="form-control input-sm selectpicker" name="habilidades[]" multiple data-error="Es un campo obligatorio" data-live-search="true"  id="habilidades">
                  <option data-hidden="true" <?php if($cadenaHabilidades[0] == '' && count($cadenaHabilidades)<=1){ echo 'selected';}?> value="NULL"></option>        
                  <?php foreach ($habilidades as $habilidad) {?> 
                  <option <?php if(in_array($habilidad['idHabilidades'],$cadenaHabilidades)){ echo 'selected';} ?> value="<?php echo $habilidad['idHabilidades']; ?>"><?php echo $habilidad['habilidad']; ?></option>
                  <?php } ?>
                </select>
              </div> 
              <?php $cadenaEvaluaciones = explode(",", $perfil['evaluaciones']); ?>
              <div class="form-group col-md-3">
                <label class="control-label">Evaluaciones</label>
                <select class="form-control input-sm selectpicker" name="evaluaciones[]" multiple data-error="Es un campo obligatorio" data-live-search="true" id="evaluaciones" class="claseCheckBox">
                  <option data-hidden="true" <?php if($cadenaEvaluaciones[0] == '' && count($cadenaEvaluaciones)<=1){ echo 'selected';}?> value="NULL"></option> 
                  <option <?php  if(in_array('Cleaver',$cadenaEvaluaciones)){ echo 'selected';} ?> value="Cleaver">Cleaver</option>
                  <option <?php  if(in_array('Personalidad',$cadenaEvaluaciones)){ echo 'selected';} ?> value="Personalidad">Personalidad</option>
                </select>                
              </div>
              <?php $cadenaPaquetes = explode(",", $perfil['paquetes']); ?>
              <div class="form-group col-md-3">
                <label class="control-label">Paquetes o lenguajes</label>
                <select class="form-control input-sm selectpicker" name="paquetesLenguajes[]" multiple  data-live-search="true" id="paquetesLenguajes">
                  <option data-hidden="true" <?php if($cadenaPaquetes[0] == '' && count($cadenaPaquetes)<=1){ echo 'selected';}?> value="NULL"></option> 
                  <option  <?php  if(in_array('Word',$cadenaPaquetes)){ echo 'selected';} ?> value="Word" >Word</option>
                  <option  <?php  if(in_array('Excel',$cadenaPaquetes)){ echo 'selected';} ?> value="Excel">Excel</option>
                  <option  <?php  if(in_array('Power point',$cadenaPaquetes)){ echo 'selected';} ?> value="Power point">Power point</option>
                </select>                
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Prestaciones de ley</label>
                <div class="col-md-6">
                  <label class="radio-inline">
                    <input type="radio" name="Datos[prestaciones]" class="flat-red" value="Si" <?php if($perfil['prestacionesLey']=='Si'){ echo 'checked';} ?> >
                    Si
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="radio-inline">
                    <input type="radio" name="Datos[prestaciones]" class="flat-red" value="No" <?php if($perfil['prestacionesLey']=='No'){ echo 'checked';} ?>>
                    No
                  </label>
                </div>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Ayuda de auto</label>
                <div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[ayudaAuto]" class="flat-red" value="Si" <?php if($perfil['ayudaAuto']=='Si'){ echo 'checked';} ?> >
                      Si
                    </label>
                  </div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[ayudaAuto]" class="flat-red" value="No" <?php if($perfil['ayudaAuto']=='No'){ echo 'checked';} ?> >
                      No
                    </label>
                  </div>
                </div>  
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Uniforme</label>
                <div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[uniforme]" class="flat-red" value="Si" <?php if($perfil['uniforme']=='Si'){ echo 'checked';} ?>>
                      Si
                    </label>
                  </div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[uniforme]" class="flat-red" value="No" <?php if($perfil['uniforme']=='No'){ echo 'checked';} ?>>
                      No
                    </label>
                  </div>
                </div>
              </div>
              <input type="hidden" name="Datos[idPerfil]" value="<?php echo $_GET['id'];?>">
            </div>
        <!-- /.col-md-12 -->
    </div>
    <style>
      .rectangular {
        border: 0px;
        border-radius: 0px;
      }
    </style>
    <div class="modal-footer">
      <div id="mensaje"></div>
      <button type="button" class="btn btn-default rectangular" data-dismiss="modal">Cerrar</button>
      <button name="enviar" id="modificar" class="btn btn-success rectangular" >Modificar</button>
    </div>
    </form>
  </div>
</div>