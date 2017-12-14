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
                    <input type="hidden" name="idSolicitante" value="<?php echo $datosUsuario["numEmpleado"];?>">
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
                            <option value="1">Fijo</option>
                            <option value="2">Eventual</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label class="control-label">Edad</label>
                      <input type="number" class="form-control input-sm" maxlength="2" data-error="Es un campo obligatorio" name="Datos[edad]" required  id="edad">
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Sexo</label><br>
                        <label>
                          <input type="radio" name="datos[sexo]" class="flat-red" checked value="hombre">
                          Hombre
                        </label>
                        <label>
                          <input type="radio" name="datos[sexo]" class="flat-red" value="mujer">
                          Mujer
                        </label>
                        <label>
                          <input type="radio" name="r3" class="flat-red" value="indistinto">
                          Indistinto
                        </label>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Escolaridad</label>
                      <select class="form-control input-sm selectpicker" name="Datos[escolaridad]" data-error="Es un campo obligatorio" required="required" id="escolaridad">
                            <option value="1">Doctorado</option>
                            <option value="2">Maestria</option>                           
                            <option value="3">Universidad</option>
                            <option value="4">Preparatoria</option>
                            <option value="5">Secundaria</option>
                            <option value="6">Primaria</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Estado civil</label>
                      <select class="form-control input-sm selectpicker" name="Datos[estadoCivil]" data-error="Es un campo obligatorio" required="required" id="estadoCivil">                           
                            <option value="1">Soltero</option>
                            <option value="2">Comprometido/a</option>
                            <option value="3">Casado/a</option>
                            <option value="3">Divorciado/a</option>
                            <option value="3">Viudo/a</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Experiencia</label>
                      <select class="form-control input-sm selectpicker" name="Datos[experiencia]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                            <option value="1">ninguna</option>
                            <option value="2">6 meses</option>
                            <option value="3">1 año</option>
                            <option value="4">2 años</option>
                            <option value="5">3 años</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Imagen</label>
                        <select class="form-control input-sm selectpicker" name="idProductos[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required="required">                 
                          <option value="1">Presentable</option>
                          <option value="2">Aseado</option>
                          <option value="3">Traje</option>
                          <option value="4">Condicion saludable</option>
                          <option value="5">Sin tatuajes</option>
                          <option value="6">Sin percing</option>
                          <option value="7">Sin expansiones</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Talla</label>
                      <select class="form-control input-sm selectpicker" name="Datos[talla]" data-error="Es un campo obligatorio" required="required" id="talla">                           
                            <option value="1">indistinto</option>
                            <option value="2">5</option>
                            <option value="3">7</option>
                            <option value="4">9</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Lo entrevista cliente</label><br>
                        <label>
                          <input type="radio" name="r3" class="flat-red" checked>
                          si
                        </label>
                        <label>
                          <input type="radio" name="r3" class="flat-red">
                          no
                        </label>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="control-label">Conocimientos especificos</label>
                        <select class="form-control input-sm selectpicker" name="idConocimientos[]" multiple data-error="Es un campo obligatorio" data-live-search="true" required="required" id="conocimientos">             
                          <option value="1">Promotora de tiendas departamentales</option>
                          <option value="2">Manejo de herramientas para captura via webo dispositivo</option>
                          <option value="3">Promotoria en autoservicio y/o mayoreo</option>
                          <option value="4">Manejo de celular touch</option>
                        </select>
                    </div>
                    <style>
                      textarea {
                      resize: none;
                    }
                    </style>
                    <div class="form-group col-md-6">
                      <label>Otros</label>
                      <textarea class="form-control" rows="3" placeholder=""></textarea>
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
                  <div class="form-group col-md-6">
                    <label>Jornada</label><br>
                    <label>
                      <input type="checkbox" class="flat-red"  value="lunes" name="lunes" checked id="lunes">
                      Lun
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="martes" name="martes" checked id="martes">
                      Mar
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="miercoles" name="miercoles" checked id="miercoles">
                      Mie
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="jueves" name="jueves" checked id="jueves">
                      Jue
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="viernes" name="viernes" checked id="viernes">
                      Vie
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="sabado" name="sabado"  id="sabado" >
                      Sab
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="domingo" name="domingo"  id="domingo">Dom
                    </label>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Descanso</label><br>
                    <label>
                      <input type="checkbox" class="flat-red" value="lunesDescanso" name="lunesDescanso" id="lunesDescanso" disabled>Lun
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="martesDescanso" name="martesDescanso" id="martesDescanso" disabled>
                      Mar
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="miercolesDescanso" name="miercolesDescanso" id="miercolesDescanso" disabled>
                      Mie
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="juevesDescanso" name="juevesDescanso" id="juevesDescanso" disabled>
                      Jue
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="viernesDescanso" name="viernesDescanso" id="viernesDescanso" disabled>
                      Vie
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="sabadoDescanso" name="sabadoDescanso" checked id="sabadoDescanso" disabled>
                      Sab
                    </label>
                    <label>
                      <input type="checkbox" class="flat-red" value="domingoDescanso" name="domingoDescanso" checked id="domingoDescanso" disabled>
                      Dom
                    </label>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="bootstrap-timepicker">
                      <div class="form-group">
                        <label>Horarios</label>
                        <div class="input-group">
                          <input type="text" class="form-control timepicker">
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
                          <input type="text" class="form-control timepicker">
                          <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-5">
                    <label class="control-label">Dias trabajdos</label>
                    <select class="form-control input-sm selectpicker" multiple name="Datos[]" data-error="Es un campo obligatorio" required="required" id="diasTrabajados" readonly>
                      <option value="1">lunes</option>
                      <option value="2" selected="selected">martes</option>
                      <option value="3" selected="selected">miercoles</option>
                      <option value="4" selected="selected">jueves</option>
                      <option value="5" selected="selected">viernes</option>
                      <option value="6" disabled="disabled">sabado</option>
                      <option value="7" disabled="disabled">domingo</option>
                    </select>
                  </div>
                  <div class="form-group col-md-1">
                    <a><i class="fa fa-plus agregarFila" style="cursor:pointer" agregarFila()  onclick="agregarFila();" ></i></a>
                  </div>
                  <div id="prueba" class="form-group col-md-12">
                  </div>
                  <div class="form-group col-md-3">
                    <label class="control-label">Salario</label>
                    <input type="number" class="form-control input-sm" tabindex="1" maxlength="60" data-error="Es un campo obligatorio" name="Datos[salario]" required  id="salario" step="0.01" >
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
        <button  type="submit" id="modificar" class="btn btn-success btn-sm">Modificar</button>
      </div> 
    </form>
  </div>
</div>
