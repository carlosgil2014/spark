<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formularioAgregar" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Datos de un nuevo perfil</b></h4>
    </div>
    <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-4">
                <label class="control-label">Nombre de perfil</label>
                <input type="text" class="form-control input-sm" name="Datos[nombrePerfil]" id="nombrePerfil" required>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Clientes</label>
                <select class="form-control input-sm selectpicker" name="Datos[cliente]" data-live-search="true" required="required" id="escolaridad">
                <?php 
                  foreach ($clientes as $cliente){
                ?>                            
                  <option value="<?php echo $cliente['idclientes']?>"><?php echo $cliente['nombreComercial']?></option>';
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
                  <option value="<?php echo $puesto['idPuesto']; ?>"><?php echo $puesto['nombre']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-2">
                  <label class="control-label">Sueldo (Diario)</label>
                  <input type="number" class="form-control input-sm" name="Datos[salario]" id="salario" min="0" step="0.01" pattern="^[0-9]+">
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Edad mínima</label>
                <input type="number" class="form-control input-sm" maxlength="2" data-error="Es un campo obligatorio" name="Datos[edad]" required  id="edad" min="18" max="50">
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Edad máxima</label>
                <input type="number" class="form-control input-sm" maxlength="2" data-error="Es un campo obligatorio" name="Datos[edadMaxima]" required  id="edadMaxima" min="18" max="50">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Sexo</label>
                <select class="form-control input-sm selectpicker" name="Datos[sexo]" data-error="Es un campo obligatorio" required="required" id="sexo">
                  <option value="Hombre">Hombre</option>
                  <option value="Mujer">Mujer</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Opcional</label><br>
                <label class="checkbox-inline">
                  <input type="checkbox" name="Datos[opcional]" class="flat-red" value="indistinto">
                  Indistinto
                </label>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Escolaridad mínima</label>
                <select class="form-control input-sm selectpicker" name="Datos[escolaridad]" data-error="Es un campo obligatorio" required="required" id="escolaridad">
                <?php 
                  foreach ($perfiles as $perfil){
                ?>                            
                  <option <?php if($perfil['escolaridad'] == 'Preparatoria'){ echo 'selected';} ?> value="<?php echo $perfil['idEscolaridad']?>"><?php echo $perfil['escolaridad']?></option>';
                <?php
                  }
                ?>
                </select>
              </div>
              <div class="form-group col-md-8">
                <label class="control-label">Días trabajados  <i class="fa fa-pencil-square-o" onclick="diasSemana('semana');"></i>L-V<i class="fa fa-pencil-square-o" onclick="diasSemana('finSemana');"></i>S-D</label>
                <div>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Lunes" id="lunes">
                    Lunes
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Martes" id="martes">
                    Martes
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Miercoles" id="miercoles">
                    Miércoles
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Jueves" id="jueves">
                    Jueves
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Viernes" id="viernes">
                    Viernes
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Sabado" id="sabado">
                    Sábado
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Domingo" id="domingo">
                    Domingo
                  </label>
                </div>
              </div>
              <div class="form-group col-md-2">
                  <div class="bootstrap-timepicker">
                      <label>Horario entrada</label>
                      <div class="input-group">
                        <input type="text" class="form-control timepicker"  id="entrada" name="horariosEntrada[]">
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
                      <input type="text" class="form-control timepicker"  id="salida" name="horariosSalida[]">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                    </div>
                </div>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Experiencia</label>
                <select class="form-control input-sm selectpicker" name="Datos[experiencia]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                      <option value="ninguna">Ninguna</option>
                      <option value="6 meses" selected="selected">6 meses</option>
                      <option value="1 año">1 año</option>
                      <option value="2 años">2 años</option>
                      <option value="3 años o más">3 años o más</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Estado civil</label>
                <select class="form-control input-sm selectpicker" name="Datos[estadoCivil]" data-error="Es un campo obligatorio" required="required" id="estadoCivil">
                    <option value="casado/a">Casado/a</option>
                    <option value="comprometido/a">Comprometido/a</option>
                    <option value="divorciado/a">Divorciado/a</option>
                    <option value="soltero/a" selected="selected">Soltero/a</option>
                    <option value="viudo/a">Viudo/a</option>
                    <option value="Indistinto">Indistinto</option>
                  </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Imagen</label>
                  <select class="form-control input-sm selectpicker" name="imagen[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required>                 
                    <option value="presentable" selected="selected">Presentable</option>
                    <option value="aseado" selected="selected">Aseado</option>
                    <option value="traje">Traje</option>
                    <option value="condicion saludable">Condición saludable</option>
                    <option value="sin tatuajes">Sin tatuajes</option>
                    <option value="sin percing">Sin percing</option>
                    <option value="sin expansiones">Sin expansiones</option>
                  </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Talla</label>
                <select class="form-control input-sm selectpicker" name="Datos[talla]" data-error="Es un campo obligatorio" required="required" id="talla">
                      <option value="indistinto">Indistinto</option>
                      <option value="Chica">Chica</option>
                      <option value="Mediana">Mediana</option>
                      <option value="Grande">Grande</option>
                  </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Lo entrevista cliente</label>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[entrevista]" class="flat-red" checked value="Si">
                      Si
                    </label>
                  </div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[entrevista]" class="flat-red" value="No">
                      No
                    </label>
                  </div>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Conocimientos específicos</label>
                <select class="form-control input-sm selectpicker" multiple  name="conocimientos[]" data-error="Es un campo obligatorio" data-live-search="true" required id="conocimiento">
                  <option data-hidden="true" selected></option>
                  <?php foreach ($conocimientos as $conocimiento) {
                  ?>
                  <option value="<?php echo $conocimiento['idConocimiento']; ?>"><?php echo $conocimiento['conocimiento']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Habilidades</label>
                <select class="form-control input-sm selectpicker" name="habilidades[]" multiple data-error="Es un campo obligatorio" data-live-search="true"  id="habilidades">
                  <option data-hidden="true" selected></option>
                  <?php foreach ($habilidades as $habilidad) {?> 
                  <option value="<?php echo $habilidad['idHabilidades']; ?>"><?php echo $habilidad['habilidad']; ?></option>
                  <?php } ?>
                </select>
              </div> 
              <div class="form-group col-md-3">
                <label class="control-label">Evaluaciones</label>
                <select class="form-control input-sm selectpicker" name="evaluaciones[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required="required" id="evaluaciones" class="claseCheckBox">
                  <option  value="cleaver" selected="selected">Cleaver</option>
                  <option  value="Personalidad" selected="selected">Personalidad</option>
                </select>                
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Paquetes o lenguajes</label>
                <select class="form-control input-sm selectpicker" name="paquetesLenguajes[]" multiple  data-live-search="true" id="paquetesLenguajes" required>
                  <option data-hidden="true"></option>
                  <option  value="Word" selected="selected">Word</option>
                  <option  value="Excel" selected="selected">Excel</option>
                  <option  value="Power point" selected="selected">Power point</option>
                </select>                
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Prestaciones de ley</label>
                <div class="col-md-6">
                  <label class="radio-inline">
                    <input type="radio" name="Datos[prestaciones]" class="flat-red" checked value="Si">
                    Si
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="radio-inline">
                    <input type="radio" name="Datos[prestaciones]" class="flat-red" value="No">
                    No
                  </label>
                </div>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Ayuda de auto</label>
                <div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[ayudaAuto]" class="flat-red" value="Si">
                      Si
                    </label>
                  </div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[ayudaAuto]" class="flat-red" checked value="No">
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
                      <input type="radio" name="Datos[uniforme]" class="flat-red" value="Si">
                      Si
                    </label>
                  </div>
                  <div class="col-md-6">
                    <label class="radio-inline">
                      <input type="radio" name="Datos[uniforme]" class="flat-red" checked value="No">
                      No
                    </label>
                  </div>
                </div>
              </div>
            </div>
        <!-- /.col-md-12 -->
    </div>
    <div class="modal-footer">
      <div id="mensaje"></div>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button name="enviar" id="agregar" class="btn btn-success" >Agregar</button>
    </div>
    </form>
  </div>
</div>