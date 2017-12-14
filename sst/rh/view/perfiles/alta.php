<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar un nuevo perfil</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="panel-group" id="accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                  1- Datos de perfil</a>
                </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="form-group col-md-3">
                      <label class="control-label">Solicitante</label>
                      <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[solicitante]" required  id="solicitante" value="<?php echo $datosUsuario["nombre"];?>" readonly>
                    </div>
                    <input type="hidden" name="Datos[idSolicitante]" value="<?php echo $datosUsuario["numEmpleado"];?>">
                    <div class="form-group col-md-3">
                      <label class="control-label">Fecha de solicitud</label>
                      <input type="text" class="form-control input-sm" maxlength="6" data-error="Es un campo obligatorio" name="Datos[fechaSolicitud]" required id="fechaSolicitud" value="<?php echo date("Y")."-".date("m")."-".date("d");?>" readonly> 
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Puestos</label>
                        <select class="form-control input-sm selectpicker" tabindex="2" name="Datos[puesto]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="puesto">
                          <?php 
                            foreach ($Puestos as $puesto){
                          ?>                            
                            <option <?php $puesto['idPuesto'] ?> value="<?php echo $puesto['idPuesto']?>"><?php echo $puesto['puesto'] ?> </option>';
                          <?php
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Plan</label>
                        <select class="form-control input-sm selectpicker" name="Datos[plan]" data-error="Es un campo obligatorio"  required="required" id="plan">                           
                            <option value="fijo">Fijo</option>
                            <option value="eventual">Eventual</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label class="control-label">Edad</label>
                      <input type="number" class="form-control input-sm" maxlength="2" data-error="Es un campo obligatorio" name="Datos[edad]" required  id="edad">
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Sexo</label><br>
                        <label>
                          <input type="radio" name="Datos[sexo]" class="flat-red" checked value="hombre">
                          Hombre
                        </label>
                        <label>
                          <input type="radio" name="Datos[sexo]" class="flat-red" value="mujer">
                          Mujer
                        </label>
                        <label>
                          <input type="radio" name="Datos[sexo]" class="flat-red" value="indistinto">
                          Indistinto
                        </label>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Escolaridad</label>
                      <select class="form-control input-sm selectpicker" name="Datos[escolaridad]" data-error="Es un campo obligatorio" required="required" id="escolaridad">
                            <?php 
                              foreach ($perfiles as $perfil){
                            ?>                            
                              <option value="<?php echo $perfil['idEscolaridad']?>"><?php echo $perfil['escolaridad']?></option>';
                            <?php
                              }
                            ?>
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
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Experiencia</label>
                      <select class="form-control input-sm selectpicker" name="Datos[experiencia]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                            <option value="ninguna">ninguna</option>
                            <option value="6 meses" selected="selected">6 meses</option>
                            <option value="1 año">1 año</option>
                            <option value="2 años">2 años</option>
                            <option value="5 años">3 años</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Imagen</label>
                        <select class="form-control input-sm selectpicker" name="imagen[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required="required">                 
                          <option value="presentable" selected="selected">Presentable</option>
                          <option value="aseado" selected="selected">Aseado</option>
                          <option value="traje">Traje</option>
                          <option value="condicion saludable">Condicion saludable</option>
                          <option value="sin tatuajes">Sin tatuajes</option>
                          <option value="sin percing">Sin percing</option>
                          <option value="sin expansiones">Sin expansiones</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Talla</label>
                      <select class="form-control input-sm selectpicker" name="Datos[talla]" data-error="Es un campo obligatorio" required="required" id="talla">                           
                            <option value="indistinto">indistinto</option>
                            <option value="5">5</option>
                            <option value="7">7</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Lo entrevista cliente</label><br>
                        <label>
                          <input type="radio" name="Datos[entrevista]" class="flat-red" checked value="si">
                          si
                        </label>
                        <label>
                          <input type="radio" name="Datos[entrevista]" class="flat-red" value="no">
                          no
                        </label>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="control-label">Conocimientos especificos</label>
                        <select class="form-control input-sm selectpicker" name="conocimientos[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required="required" id="conocimientos">             
                          <option value="1" selected="selected">Promotora de tiendas departamentales</option>
                          <option value="2" >Manejo de herramientas para captura via webo dispositivo</option>
                          <option value="3">Promotoria en autoservicio y/o mayoreo</option>
                          <option value="4" selected="selected">Manejo de celular touch</option>
                        </select>
                    </div>
                    <style>
                      textarea {
                      resize: none;
                    }
                    </style>
                    <div class="form-group col-md-6">
                      <label>Otros</label>
                      <textarea class="form-control" rows="3" placeholder="" name="Datos[otros]"></textarea>
                    </div>  
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                  2- Propuesta</a>
                </h4>
              </div>
              <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                  <div class="form-group col-md-3">
                    <div class="bootstrap-timepicker">
                      <div class="form-group">
                        <label>Horarios</label>
                        <div class="input-group">
                          <input type="text" class="form-control timepicker" name="horariosEntrada[]">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="bootstrap-timepicker">
                      <div class="form-group">
                        <label></label>
                        <div class="input-group">
                          <input type="text" class="form-control timepicker" name="horariosSalida[]">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-5">
                    <label class="control-label">Dias trabajdos</label>
                    <select class="form-control input-sm selectpicker diasTrabajados" name="diasTrabajados[]" multiple name="Datos[]" data-error="Es un campo obligatorio" required="required"  readonly>
                      <option selected="selected">Lunes</option>
                      <option selected="selected">Martes</option>
                      <option selected="selected">Miércoles</option>
                      <option selected="selected">Jueves</option>
                      <option selected="selected">Viernes</option>
                      <option>Sábado</option>
                      <option>Domingo</option>
                    </select>
                  </div>
                  <div class="form-group col-md-1">
                    <a><i class="fa fa-plus agregarFila" style="cursor:pointer" onclick="agregarFila();" ></i></a>
                  </div>
                  <div id="prueba" class="form-group col-md-12">
                  </div>
                  <div class="form-group col-md-3">
                    <label class="control-label">Sueldo</label>
                    <input type="number" class="form-control input-sm" tabindex="1" maxlength="60" data-error="Es un campo obligatorio" name="Datos[sueldo]" required  id="sueldo" step="0.01" >
                  </div>
                  <div class="form-group col-md-3">
                      <label class="control-label">Ayuda de auto</label><br>
                        <label>
                          <input type="radio" name="Datos[ayuda]" class="flat-red" checked value="si">
                          si
                        </label>
                        <label>
                          <input type="radio" name="Datos[ayuda]" class="flat-red" value="no">
                          no
                        </label>
                  </div>
                  <div class="form-group col-md-2">
                      <label class="control-label">Prestaciones de ley</label><br>
                        <label>
                          <input type="radio" name="Datos[prestaciones]" class="flat-red" checked value="si">
                          si
                        </label>
                        <label>
                          <input type="radio" name="Datos[prestaciones]" class="flat-red" value="no">
                          no
                        </label>
                  </div>
                  <div class="form-group col-md-2">
                      <label class="control-label">Uniforme</label><br>
                        <label>
                          <input type="radio" name="Datos[uniforme]" class="flat-red" checked value="si">
                          si
                        </label>
                        <label>
                          <input type="radio" name="Datos[uniforme]" class="flat-red" value="no">
                          no
                        </label>
                  </div>
                  <div class="form-group col-md-6">
                      <label>Observaciones</label>
                      <textarea class="form-control" rows="3" placeholder="" name="Datos[observaciones]"></textarea>
                  </div>
                  <div class="form-group col-md-6">
                      <label class="control-label">Habilidades</label>
                        <select class="form-control input-sm selectpicker" name="habilidades[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required="required" id="habilidades">             
                          <option value="facilidad de palabra" selected="selected">Facilidad de palabra</option>
                          <option value="2">Buen negociador  para espacios adicionales</option>
                          <option value="3">Ejecucion de la operacion en pdv</option>
                          <option value="4">Actitud de servicio</option>
                        </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Evaluaciones</label><br>
                    <label>
                      <input type="checkbox" class="flat-red"  value="cleaver" name="personalidad[]"  checked id="cleaver">
                      Cleaver
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="personalidad" name="personalidad[]" checked id="personalidad">
                      Personalidad
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="excel" name="personalidad[]" checked id="excel">
                      Excel
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="ppt" name="personalidad[]" checked id="ppt">
                      PPT
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="word" name="personalidad[]" checked id="word">
                      Word
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="otra" name="personalidad[]"  id="otra">
                      Otra
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>          

        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div  id="mensaje" ></div>
        <button id="cerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button  type="submit" id="agregar" class="btn btn-success btn-sm">Agregar</button>
      </div> 
    </form>
  </div>
</div>
