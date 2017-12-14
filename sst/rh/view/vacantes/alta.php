<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar un nueva vacante</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <fieldset class="form-group col-md-12">
            <legend>Solicitante</legend>
          </fieldset>
          <div class="form-group col-md-3">
            <label class="control-label">Nombre(s)</label>
            <input type="text" class="form-control input-sm" tabindex="1" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" required  id="nombre" autofocus>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Paterno</label>
            <input type="text" class="form-control input-sm" maxlength="60" tabindex="2" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" required id="apellidoPaterno">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Materno</label>
            <input type="text" class="form-control input-sm" maxlength="60" tabindex="3" name="Datos[apellidoMaterno]">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Fecha de solicitud</label>
            <input type="date" class="form-control input-sm" maxlength="6" tabindex="4" onblur="menorDeEdad()" data-error="Es un campo obligatorio" name="Datos[fechaNacimiento]" required id="fechaNacimiento">
          </div>
          <div class="form-group col-md-3">
              <label class="control-label">Puestos</label>
              <select class="form-control input-sm selectpicker" tabindex="2" name="Datos[puesto]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="puesto">
                <?php 
                  foreach ($Puestos as $puesto){
                ?>                            
                  <option <?php $puesto['idPuesto'] ?> value="<?php echo $puesto['idPuesto']?>"><?php echo $puesto['puesto'] ?> </option>
                <?php
                  }
                ?>
              </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Plan</label>
            <select class="form-control input-sm selectpicker" tabindex="2" name="Datos[puesto]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="puesto">                      
                  <option value="1">fijo</option>
                  <option value="2">eventual</option>
              </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Edad</label>
            <input type="text" tabindex="6" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" data-validate="true" required id="calle">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Sexo</label>
            <input type="text" tabindex="7" class="form-control input-sm" maxlength="30" data-error="Es un campo obligatorio" name="Datos[noInterior]" required id="numeroInterior">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Escolaridad</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Escolaridad</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Estado civil</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Experiencia</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Conocimientos expecificos</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Imagen</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Talla</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Lo entrevista el cliente</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Otro</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <fieldset class="form-group col-md-12">
            <legend>Propuesta</legend>
          </fieldset>
          <div class="form-group col-md-2">
            <label class="control-label">Jornada</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Descanso</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Horario</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Sueldo</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Ayuda de auto</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Prestaciones de ley</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Uniforme</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Material</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Observaciones</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <fieldset class="form-group col-md-12">
            <legend>Funciones Generales</legend>
          </fieldset>
          <div class="form-group col-md-2">
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <fieldset class="form-group col-md-12">
            <legend>Conocimientos</legend>
          </fieldset>
          <div class="form-group col-md-2">
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <fieldset class="form-group col-md-12">
            <legend>Habilidades</legend>
          </fieldset>
          <div class="form-group col-md-2">
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <fieldset class="form-group col-md-12">
            <legend>Evaluaciones</legend>
          </fieldset>
          <div class="form-group col-md-2">
            <label class="control-label">Inteligencia</label>
            <input type="radio" name="vehicle" value="si"> Si<br>
            <input type="radio" name="vehicle" value="no" checked> No<br>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Personalidad</label>
            <input type="radio" name="vehicle" value="si"> Si<br>
            <input type="radio" name="vehicle" value="no" checked> No<br>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Comportamiento</label>
            <input type="radio" name="vehicle" value="si"> Si<br>
            <input type="radio" name="vehicle" value="no" checked> No<br>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Valores</label>
            <input type="radio" name="vehicle" value="si"> Si<br>
            <input type="radio" name="vehicle" value="no" checked> No<br>
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
