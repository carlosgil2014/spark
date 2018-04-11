<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formularioModificar" role="form">
    <div class="modal-header">
      
      <div class="row">
       <div class="col-lg-4"> 
      <h4 class="modal-title" id="myModalLabel"><b>Modificar solicitud de empleo</b></h4>
      </div>
      <div class="col-lg-3"> 
        <select class="form-control input-sm selectpicker" name="Datos[estadoActividad]" id="estadoActividad">
        <option <?php if($solicitudEmpleo['estado']=='Activa'){ echo 'selected';} ?> value="Activa">Activa</option>
        <option <?php if($solicitudEmpleo['estado']=='Boletinada'){ echo 'selected';} ?> value="Boletinada">Boletinada</option>
        <option <?php if($solicitudEmpleo['estado']=='Inactiva'){ echo 'selected';} ?> value="Inactiva">Inactiva</option>        
        </select>
      </div>
      <div class="form-group col-md-2">
        <button type="button" onclick="modificarEstado(<?php echo $solicitudEmpleo['idSolicitudEmpleo']; ?>);" class="btn btn-success btn-sm" id="actualizarEstado">Actualizar estado</button>
      </div>
      <div class="col-lg-3">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button> 
      </div>
      </div>
      <div id="mensaje"></div> <div id="opcionSi" onclick="cambiarModal('si');"></div>
      <div id="opcionNo" onclick="cambiarModal('no');"></div>
      <div class="form-grop col-md-3">

      </div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-solid">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion2">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="false" class="collapsed">
                        1- Datos del puesto
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      <?php $diasTrabajados = explode(",", $solicitudEmpleo['diasTrabajados']); ?>
                      <div class="form-group col-md-8">
                        <label class="control-label">Disponibilidad</label>
                          <div>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Lunes', $diasTrabajados)){ echo 'checked';} ?> value="Lunes">
                              Lu
                            </label>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Martes', $diasTrabajados)){ echo 'checked';} ?> value="Martes" >
                              Ma
                            </label>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Miercoles', $diasTrabajados)){ echo 'checked';} ?> value="Miercoles">
                              Mie
                            </label>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Jueves', $diasTrabajados)){ echo 'checked';} ?> value="Jueves" >
                              Ju
                            </label>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Viernes', $diasTrabajados)){ echo 'checked';} ?> value="Viernes">
                              Vie
                            </label>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Sabado', $diasTrabajados)){ echo 'checked';} ?> value="Sabado" >
                              Sa
                            </label>
                            <label class="checkbox-inline">
                              <input type="checkbox" name="diasTrabajados[]" class="flat-red" <?php if(in_array('Domingo', $diasTrabajados)){ echo 'checked';} ?> value="Domingo" >
                              Do
                            </label>
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <div class="bootstrap-timepicker">
                          <label>Horario entrada</label>
                          <div class="input-group">
                            <input type="text" class="form-control timepicker"  id="entrada" name="Datos[horarioEntrada]" value="<?php echo $solicitudEmpleo['horarioEntrada'] ?>">
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
                            <input type="text" class="form-control timepicker"  id="salida" name="Datos[horarioSalida]" value="<?php echo $solicitudEmpleo['horarioSalida']; ?>">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Fecha de solicitud</label>
                        <input type="text" class="form-control input-sm" maxlength="6"  name="Datos[fechaSolicitud]"  id="fechaSolicitud" value="<?php echo $solicitudEmpleo['fechaSolicitud'];?>" readonly> 
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Puesto</label>
                        <select class="form-control input-sm selectpicker" data-live-search="true" name="Datos[puesto]" id="puesto">
                        <?php 
                        foreach ($puestos as $puesto){
                        ?>                            
                        <option  <?php if($puesto['idPuesto']==$solicitudEmpleo['puesto']){ echo 'selected';} ?> value="<?php echo $puesto['idPuesto']?>"><?php echo $puesto['nombre']?></option>
                        <?php
                        }
                        ?> 
                        </select> 
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Sueldo deseado</label>
                        <input type="number" class="form-control input-sm" step="0.01"   name="Datos[sueldo]" id="sueldo" required value="<?php echo $solicitudEmpleo['sueldo']; ?>" onkeypress="validarDecimalPositivo(this)">
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Experiencia de puesto</label>
                        <select class="form-control input-sm selectpicker" name="Datos[experienciaPuesto]" data-error="Es un campo obligatorio" required="required" id="experienciaPuesto">                           
                          <option <?php if($solicitudEmpleo['experienciaPuesto']=='1'){echo 'selected';}  ?> value="ninguna">Ninguna</option>
                          <option <?php if($solicitudEmpleo['experienciaPuesto']=='2'){echo 'selected';}  ?> value="6 meses">6 meses</option>
                          <option <?php if($solicitudEmpleo['experienciaPuesto']=='3'){echo 'selected';}  ?> value="1 año">1 año</option>
                          <option <?php if($solicitudEmpleo['experienciaPuesto']=='4'){echo 'selected';}  ?> value="2 años">2 años</option>
                          <option <?php if($solicitudEmpleo['experienciaPuesto']=='5'){echo 'selected';}  ?> value="3 años o más">3 años o más</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" class="collapsed" aria-expanded="false">
                        2- Datos personales
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-3">
                        <label class="control-label">R.F.C.</label>
                        <input type="text" tabindex="5" class="form-control input-sm" style="text-transform:uppercase;" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU"  onchange="validarRfc()" name="Datos[rfcDatosPersonales]" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones"  id="rfc" required value="<?php echo $solicitudEmpleo['rfc']; ?>" tabindex="1">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Nombre(s)</label>
                        <input type="text" class="form-control input-sm" maxlength="30"  name="Datos[nombresDatosPersonales]"   id="nombres" required value="<?php echo $solicitudEmpleo['nombresDatosPersonales']; ?>" tabindex="2">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Apellido paterno</label>
                        <input type="text" class="form-control input-sm" maxlength="30"  name="Datos[apellidoPaternoDatosPersonales]"   id="apellidoPaterno" required value="<?php echo $solicitudEmpleo['apellidoPaternoDatosPersonales']; ?>" tabindex="3">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Apellido materno</label>
                        <input type="text" class="form-control input-sm" maxlength="30"  name="Datos[apellidoMaternoDatosPersonales]"   id="apellidoMaterno" value="<?php echo $solicitudEmpleo['apellidoMaternoDatosPersonales']; ?>" tabindex="4">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Edad</label>
                        <input type="number" class="form-control input-sm" min="18"  max="60" name="Datos[edadDatosPersonales]"   id="edadDatosPersonales" placeholder="18" value="<?php echo $solicitudEmpleo['edad']; ?>" tabindex="5">
                      </div>  
                      <div class="form-group col-md-2">
                        <label class="control-label">Código postal</label>
                        <div class="input=-group">
                          <input type="number" id="codigoPostal" class="form-control input-sm" onchange="cp()" maxlength="5" class="form-control" name="Datos[cpDatosPersonales]"   placeholder="55500"  required value="<?php echo $solicitudEmpleo['cpDatosPersonales']; ?>" tabindex="6">
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Delegación/Municipio</label>
                        <input type="text" class="form-control input-sm" maxlength="40"  name="Datos[delegacionDatosPersonales]"  id="delegacion" readonly value="<?php echo $solicitudEmpleo['delegacion']; ?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Estado</label>
                        <input type="text" class="form-control input-sm" maxlength="40" name="Datos[estadoDatosPersonales]" id="estado"  readonly value="<?php echo $solicitudEmpleo['nombreEstado']; ?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Colonia</label>
                        <select class="form-control input-sm selectpicker" name="Datos[coloniaDatosPersonales]" data-live-search="true" id="colonias" required tabindex="7">
                          <?php foreach ($codigoPostales as $codigoPostal) { ?>
                            <option <?php if($codigoPostal['idcp']==$solicitudEmpleo['coloniaASentamiento']){ echo 'selected';} ?> value="<?php echo $codigoPostal['idcp']; ?>"><?php echo $codigoPostal['asentamiento']; ?></option>
                           <?php 
                          } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-5">
                        <label class="control-label">Calle</label>
                        <input type="text" class="form-control input-sm" maxlength="40"  name="Datos[calleDatosPersonales]" data-validate="true"  id="calle" placeholder="Jose Maria Velasco" required value="<?php echo $solicitudEmpleo['calleDatosPersonales']; ?>" tabindex="8">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">No. Interior</label>
                        <input type="text" class="form-control input-sm" maxlength="30"  name="Datos[noInteriorDatosPersonales]"  id="numeroInterior" placeholder="numero 101" required value="<?php echo $solicitudEmpleo['noInteriorDatosPersonales']; ?>" tabindex="9">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">No. Exterior</label>
                        <input type="text" class="form-control input-sm"  maxlength="30" name="Datos[noExteriorDatosPersonales]" placeholder="Primer piso" value="<?php echo $solicitudEmpleo['noExteriorDatosPersonales']; ?>" >
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Teléfono particular</label>
                        <input type="text" name="Datos[telefonoParticularDatosPersonales]" class="form-control validarTelefonos input-sm"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoParticular" data-mask value="<?php echo $solicitudEmpleo['telefonoParticular']; ?>" >
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Estado civil</label>
                        <select class="form-control input-sm selectpicker" name="Datos[estadoCivilDatosPersonales]"   id="estadoCivil" required>
                            <option <?php if($solicitudEmpleo['estadoCivil']=='Casado/a'){ echo 'selected';} ?> value="Casado/a">Casado/a</option>
                            <option <?php if($solicitudEmpleo['estadoCivil']=='Comprometido/a'){ echo 'selected';} ?> value="Comprometido/a">Comprometido/a</option>
                            <option <?php if($solicitudEmpleo['estadoCivil']=='Divorciado/a'){ echo 'selected';} ?> value="Divorciado/a">Divorciado/a</option>
                            <option <?php if($solicitudEmpleo['estadoCivil']=='Soltero/a'){ echo 'selected';} ?> value="Soltero/a">Soltero/a</option>
                            <option <?php if($solicitudEmpleo['estadoCivil']=='Viudo/a'){ echo 'selected';} ?> value="Viudo/a">Viudo/a</option>
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Estatura</label>
                        <input type="text" name="Datos[estaturaDatosPersonales]" class="form-control input-sm"  maxlength="4"  id="estatura" placeholder="1.70" value="<?php echo $solicitudEmpleo['estatura']; ?>" onkeypress="validarDecimalPositivo(this)">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Talla</label>
                        <select class="form-control input-sm selectpicker" name="Datos[tallaDatosPersonales]" id="talla">
                          <option <?php if($solicitudEmpleo['talla']=='Chica'){ echo 'selected';} ?> value="Chica">Chica</option>
                          <option <?php if($solicitudEmpleo['talla']=='Mediana'){ echo 'selected';} ?> value="Mediana">Mediana</option>
                          <option <?php if($solicitudEmpleo['talla']=='Grande'){ echo 'selected';} ?> value="Grande">Grande</option>
                        </select>
                      </div> 
                      <div class="form-group col-md-3">
                        <label class="control-label">Telefono de recados</label>
                        <input type="text" name="Datos[telefonoRecadosDatosPersonales]" class="form-control validarTelefonos input-sm"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoRecados" data-mask value="<?php echo $solicitudEmpleo['telefonoRecados']; ?>" >
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">CURP</label>
                        <input type="text" class="form-control input-sm"  maxlength="18" name="Datos[curpDatosPersonales]" placeholder="GICC120789ASD50" required value="<?php echo $solicitudEmpleo['curp']; ?>" style="text-transform:uppercase;">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Teléfono celular</label>
                        <input type="text" name="Datos[telefonoCelularDatosPersonales]" class="form-control validarTelefonos input-sm"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCelular" data-mask required value="<?php echo $solicitudEmpleo['telefonoCelular']; ?>" >
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Correo</label>
                        <input type="email" name="Datos[correoDatosPersonales]" class="form-control input-sm" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required value="<?php echo $solicitudEmpleo['correo']; ?>" >
                      </div>
                      <div class="form-group col-md-5">
                        <label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[LicenciaImssDatosPersonales]" class="flat-red" <?php if($solicitudEmpleo['immsLicencia']== 'Licencia de manejo'){ echo 'checked';} ?> value="Licencia de manejo">
                            Licencia de manejo
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[LicenciaImssDatosPersonales]" class="flat-red" <?php if($solicitudEmpleo['immsLicencia']== 'Numero de IMSS'){ echo 'checked';} ?> value="Numero de IMSS" required>
                            Numero de IMSS
                          </label>
                        </label>
                        <input type="text" maxlength="15" class="form-control input-sm" name="Datos[numeroLicenciaImssDatosPersonales]"   id="numeroLicenciaImss" value="<?php if(!empty($solicitudEmpleo['numeroLicenciaOImss'])){echo $solicitudEmpleo['numeroLicenciaOImss'];} ?>" >
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Sexo</label>
                        <select class="form-control input-sm selectpicker" name="Datos[sexo]" data-error="Es un campo obligatorio" required="required" id="sexo">
                          <option <?php if($solicitudEmpleo['sexo']== 'Hombre'){ echo 'selected';} ?> value="Hombre">Hombre</option>
                          <option <?php if($solicitudEmpleo['sexo']== 'Mujer'){ echo 'selected';} ?> value="Mujer">Mujer</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseThree" class="collapsed" aria-expanded="false">
                        3- Datos Familiares
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <table class="table table-hover table-bordered table-responsive table-condensed text-center">
                        <thead>
                          <tr class="bg-primary">
                            <th>#</th>
                            <th>Nombre completo</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Ocupacion</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Padre</td>
                            <td><input type="text" class="form-control input-sm" maxlength="40"  name="Datos[padreDatosFamiliares]" id="padreDatosFamiliares" value="<?php echo $solicitudEmpleo['nombrePadre'];?>" ></td>
                            <td><input type="text" name="Datos[direccionTelefonoPadreDatosFamiliares]" id="direccionP" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['direccionPadre'];?>"></td>
                            <td><input type="text" name="Datos[telefonoPadreDatosFamiliares]" id="telefonoP" class="form-control validarTelefonos input-sm" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask value="<?php echo $solicitudEmpleo['telefonoPadre'];?>"></td>
                            <td><input type="text" name="Datos[ocupacionPadreDatosFamiliares]" id="ocupacion" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['ocupacionPadre'];?>"></td>
                          </tr>
                          <tr>
                            <td>Madre</td>
                            <td><input type="text" name="Datos[madreDatosFamiliares]" id="madre" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['nombreMadre'];?>"></td>
                            <td><input type="text" name="Datos[direccionTelefonoMadreDatosFamiliares]" id="direccionM" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['direccionMadre'];?>"></td>
                            <td><input type="text" name="Datos[telefonoMadreDatosFamiliares]" id="telefonoM" class="form-control validarTelefonos input-sm" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask value="<?php echo $solicitudEmpleo['telefonoMadre'];?>"></td>
                            <td><input type="text" name="Datos[ocupacionMadreDatosFamiliares]" id="ocupacionM" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['ocupacionMadre'];?>"></td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="form-group col-md-4">
                        <label class="control-label">Nombre del esposo(a)</label>
                        <input type="text" name="Datos[nombreEsposoA]" class="form-control input-sm" maxlength="40" id="nombreEsposoA" placeholder="Aquiles Castro" value="<?php echo $solicitudEmpleo['nombreEsposoA'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Ocupacion</label>
                        <input type="text" name="Datos[ocupacion]" class="form-control input-sm" maxlength="40" id="ocupacion" placeholder="Programador" value="<?php echo $solicitudEmpleo['ocupacionEsposoA'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Escuela o empresa</label>
                        <input type="text" name="Datos[escuelaEmpresa]" class="form-control input-sm" maxlength="40" id="escuelaEmpresa" placeholder="UNAM" value="<?php echo $solicitudEmpleo['escuelaEmpresaEsposoA'];?>">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Edad</label>
                        <input type="number" min="18" max="50" name="Datos[edadDatosFamiliares]" class="form-control input-sm" maxlength="2" id="edad" placeholder="20" value="<?php echo $solicitudEmpleo['edadEsposoA'];?>" onkeypress="validarDecimalPositivo(this)">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Telefono</label>
                        <input type="text" name="Datos[telefonoFamiliar]" class="form-control validarTelefonos input-sm" id="telefonoFamiliar" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask value="<?php echo $solicitudEmpleo['telefonoEsposoA'];?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseFour" class="collapsed" aria-expanded="false">
                        4- Referencias personales que no sean familiares
                      </a>
                    </h4>
                  </div>
                  <div id="collapseFour" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <table class="table table-hover table-bordered table-responsive table-condensed text-center">
                        <thead class="thead-inverse">
                          <tr class="bg-primary">
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Ocupacion</th>
                            <th>Tiempo de conocerlo</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><input type="text" name="Datos[nombreReferencia]" id="nombreReferencia" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['nombreReferenciaUno'];?>"></td>
                            <td><input type="text" name="Datos[telefonoReferencia]" id="telefonoReferencia" class="form-control validarTelefonos input-sm" maxlength="40" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask value="<?php echo $solicitudEmpleo['telefonoReferenciaUno'];?>"></td>
                            <td><input type="text" name="Datos[ocupacionReferencia]" id="ocupacionReferencia" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['ocupacionReferenciaUno'];?>"></td>
                            <td><input type="text" name="Datos[tiempoConocerlo]" id="tiempoConocerlo" class="form-control input-sm" maxlength="40"  value="<?php echo $solicitudEmpleo['tiempoConocerloReferenciaUno'];?>"></td>
                          </tr>
                          <tr>
                            <td><input type="text" name="Datos[nombreReferencia2]" id="nombreReferencia2" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['nombreReferenciaDos'];?>"></td>
                            <td><input type="text" name="Datos[telefonoReferencia2]" class="form-control validarTelefonos input-sm" maxlength="40" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoReferencia2" data-mask value="<?php echo $solicitudEmpleo['telefonoReferenciaDos'];?>"></td>
                            <td><input type="text" name="Datos[ocupacionReferencia2]" id="ocupacionReferencia2" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['ocupacionReferenciaDos'];?>"></td>
                            <td><input type="text" name="Datos[tiempoConocerlo2]" id="tiempoConocerlo2" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['tiempoConocerloReferenciaDos'];?>"></td>
                          </tr>
                          <tr>
                            <td><input type="text" name="Datos[nombreReferencia3]" id="nombreReferencia3" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['nombreReferenciaTres'];?>"></td>
                            <td><input type="text" name="Datos[telefonoReferencia3]" class="form-control validarTelefonos input-sm" maxlength="40" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoReferencia3" data-mask value="<?php echo $solicitudEmpleo['telefonoReferenciaTres'];?>"></td>
                            <td><input type="text" name="Datos[ocupacionReferencia3]" id="ocupacionReferencia3" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['ocupacionReferenciaTres'];?>"></td>
                            <td><input type="text" name="Datos[tiempoConocerlo3]" id="tiempoConocerlo3" class="form-control input-sm" maxlength="40" value="<?php echo $solicitudEmpleo['tiempoConocerloReferenciaTres'];?>"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseFive" class="collapsed" aria-expanded="false">
                        5- Preparacion academica
                      </a>
                    </h4>
                  </div>
                  <div id="collapseFive" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-3">
                        <label class="control-label">Ultimo grado de estudios</label>
                        <select class="form-control input-sm selectpicker" name="Datos[escolaridad]" data-live-search="true" id="escolaridad" required="required">
                              <?php 
                                foreach ($escolaridades as $escolaridad){
                              ?>                                                          
                                <option <?php if($escolaridad['idEscolaridad']==$solicitudEmpleo['ultimoGradoEstudios']){ echo 'selected';} ?> value="<?php echo $escolaridad['idEscolaridad']?>"><?php echo $escolaridad['escolaridad']?></option>
                              <?php
                                }
                              ?>
                          </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Nombre de la escuela</label>
                        <input type="text" name="Datos[nombreEscuelaPreparacionaAcademica]" class="form-control input-sm" required value="<?php echo $solicitudEmpleo['nombreEscuela'];?>">
                      </div>
                      <div class="form-grop col-md-3">
                        <label class="control-label">Fecha inicio y fin</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="Datos[fechaInicioFin]" id="fechaInicioFin" class="form-control input-sm" required value="<?php echo $solicitudEmpleo['fecha'];?>">
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Años cursados</label>
                        <input type="number" name="Datos[anosPreparacionAcademica]"  class="form-control input-sm" required value="<?php echo $solicitudEmpleo['anosCursados'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Titulo recibido</label>
                        <input type="text" name="Datos[tituloRecibido]" class="form-control input-sm" required value="<?php echo $solicitudEmpleo['tituloRecibido'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Carrera en</label>
                        <input type="text" name="Datos[carrera]" class="form-control input-sm" required value="<?php echo $solicitudEmpleo['carrera'];?>">
                      </div>
                      <div class="form-group col-md-4">
                        <label clas="control-label">Estudios efectuando actualmente</label>
                        <input type="text" name="Datos[estudiosActuales]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['estudiosActualmente'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Escuela</label>
                        <input type="text" name="Datos[escuela]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['escuela'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Horario</label>
                        <input type="text" name="Datos[horario]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['horario'];?>">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Curso o carrera</label>
                        <input type="text" name="Datos[cursoCarrera]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['cursoCarrera'];?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseSix" class="collapsed" aria-expanded="false">
                        6- Datos generales
                      </a>
                    </h4>
                  </div>
                  <div id="collapseSix" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-4">
                        <label class="control-label">Automovil propio</label><br>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[automovilPropio]" class="flat-red" <?php if($solicitudEmpleo['automovilPropio']=='Si'){ echo 'checked';} ?> value="Si">
                            Si 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[automovilPropio]" class="flat-red" value="No" <?php if($solicitudEmpleo['automovilPropio']=='No'){ echo 'checked';} ?> >
                            No
                          </label>
                      </div>
                      <div class="form-group col-md-8">
                        <label class="control-label">¿Como se entero del empleo?</label><br>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[publicidadEmpleo]" class="flat-red"  value="Anuncio" <?php if($solicitudEmpleo['medioPublicidad']=='Anuncio'){ echo 'checked';} ?>>
                            Anuncio 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[publicidadEmpleo]" class="flat-red" value="Recomendacion" <?php if($solicitudEmpleo['medioPublicidad']=='Recomendacion'){ echo 'checked';} ?>>
                            Recomendacion
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[publicidadEmpleo]" class="flat-red" value="Otros" <?php if($solicitudEmpleo['medioPublicidad']=='Otros'){ echo 'checked';} ?>>
                            Otros 
                          </label>
                          <label class="radio-inline">
                            <input type="text" maxlength="15" class="form-control" id="inputdefault" name="Datos[otrosPublicidadEmpleo]" value="<?php echo $solicitudEmpleo['otroMedioPublicidad']; ?>" >
                        </label>                  
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven" class="collapsed" aria-expanded="false">
                        7- Conocimientos generales
                      </a>
                    </h4>
                  </div>
                  <div id="collapseSeven" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-3">
                        <label class="control-label">¿Domina ingles?</label><br>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[idioma]" class="flat-red" <?php if($solicitudEmpleo['ingles']=='Si'){ echo 'checked';} ?> value="Si">
                            Si 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[idioma]" class="flat-red" <?php if($solicitudEmpleo['ingles']=='No'){ echo 'checked';} ?> value="No">
                            No
                          </label>
                      </div>
                      <?php $conocimientosEspecificos = explode(",", $solicitudEmpleo['conocimientosEspecificos']); ?>
                      <div class="form-group col-md-4">
                        <label class="control-label">Conocimientos</label>
                        <select class="form-control input-sm selectpicker" multiple  name="conocimientos[]" data-error="Es un campo obligatorio" data-live-search="true" id="conocimiento">
                          <option data-hidden="true" <?php if($conocimientosEspecificos[0] == '' && count($conocimientosEspecificos)<=1){ echo 'selected';}?> value="NULL"></option>
                          <?php foreach ($conocimientos as $conocimiento) {
                          ?>
                          <option  <?php if(in_array($conocimiento['idConocimiento'], $conocimientosEspecificos)){echo 'selected';}?> value="<?php echo $conocimiento['idConocimiento'] ?>"><?php echo $conocimiento['conocimiento'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <?php $cadena = explode(",", $solicitudEmpleo['paquetesLenguajes']); ?>
                      <div class="form-group col-md-4">
                        <label class="control-label">Paquetes y/o lenguajes que domina</label>
                        <select class="form-control input-sm selectpicker" name="paquestesLenguajes[]" multiple data-error="Es un campo obligatorio" data-live-search="true" id="paquestesLenguajes">
                          <option data-hidden="true" <?php if($cadena[0] == '' && count($cadena)<=1){ echo 'selected';}?> value="NULL"></option>
                          <option  <?php if(in_array('Excel', $cadena)){echo 'selected';}?> value="Excel">Excel</option>
                          <option  <?php if(in_array('Power point', $cadena)){echo 'selected';}?> value="Power point">Power point</option>
                          <option  <?php if(in_array('Access', $cadena)){echo 'selected';}?> value="Access">Access</option>
                          <option  <?php if(in_array('Word', $cadena)){echo 'selected';}?> value="Word">Word</option>
                          <option  <?php if(in_array('Otra', $cadena)){echo 'selected';}?> value="Otra">Otra</option>
                        </select>                
                      </div>
                      <?php $cadenaHabilidades = explode(",", $solicitudEmpleo['habilidades']); ?>
                      <div class="form-group col-md-3">
                        <label class="control-label">Habilidades</label>
                        <select class="form-control input-sm selectpicker" name="habilidades[]" multiple data-error="Es un campo obligatorio" data-live-search="true"  id="habilidades">
                          <option data-hidden="true" <?php if($cadenaHabilidades[0] == '' && count($cadenaHabilidades)<=1){ echo 'selected';}?> value="NULL"></option>
                          <?php foreach ($habilidades as $habilidad) {?> 
                          <option <?php if(in_array($habilidad['idHabilidades'],$cadenaHabilidades)){ echo 'selected';} ?> value="<?php echo $habilidad['idHabilidades']; ?>"><?php echo $habilidad['habilidad']; ?></option>
                          <?php } ?>
                        </select>
                      </div> 
                      <div class="form-group col-md-5">
                        <label clas="control-label">Otros oficios que domine</label>
                        <input type="text" name="Datos[oficios]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['otrosOficios'];?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseEight" class="collapsed" aria-expanded="false">
                        8- Experiencia laboral
                      </a>
                    </h4>
                  </div>
                  <div id="collapseEight" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <table class="table table-hover table-bordered table-responsive table-condensed text-center">
                        <thead class="bg-primary">
                          <tr>
                            <th>Datos</th>
                            <th>Ultimo o actual</th>
                            <th>Anterior</th>
                            <th>Anterior</th>
                            <th>Anterior</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Nombre de la empresa</td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual1]" value="<?php echo $solicitudEmpleo['nombreEmpresa1'];?>"></td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual2]" value="<?php echo $solicitudEmpleo['nombreEmpresa2'];?>"></td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual3]" value="<?php echo $solicitudEmpleo['nombreEmpresa3'];?>"></td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual4]" value="<?php echo $solicitudEmpleo['nombreEmpresa4'];?>"></td>
                          </tr>
                          <tr>
                            <td>Experencia</td>
                            <td>  
                              <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral1]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                              <option <?php if($solicitudEmpleo['fecha1'] == '1'){ echo 'selected';} ?> value="1">Ninguna</option>
                              <option <?php if($solicitudEmpleo['fecha1'] == '2'){ echo 'selected';} ?> value="2">6 meses</option>
                              <option <?php if($solicitudEmpleo['fecha1'] == '3'){ echo 'selected';} ?> value="3">1 año</option>
                              <option <?php if($solicitudEmpleo['fecha1'] == '4'){ echo 'selected';} ?> value="4">2 años</option>
                              <option <?php if($solicitudEmpleo['fecha1'] == '5'){ echo 'selected';} ?> value="5">3 años o más</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral2]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                <option <?php if($solicitudEmpleo['fecha2'] == '1'){ echo 'selected';} ?> value="1">Ninguna</option>
                                <option <?php if($solicitudEmpleo['fecha2'] == '2'){ echo 'selected';} ?> value="2">6 meses</option>
                                <option <?php if($solicitudEmpleo['fecha2'] == '3'){ echo 'selected';} ?> value="3">1 año</option>
                                <option <?php if($solicitudEmpleo['fecha2'] == '4'){ echo 'selected';} ?> value="4">2 años</option>
                                <option <?php if($solicitudEmpleo['fecha2'] == '5'){ echo 'selected';} ?> value="5">3 años o más</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral3]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                <option <?php if($solicitudEmpleo['fecha3'] == '1'){ echo 'selected';} ?> value="1">Ninguna</option>
                                <option <?php if($solicitudEmpleo['fecha3'] == '2'){ echo 'selected';} ?> value="2">6 meses</option>
                                <option <?php if($solicitudEmpleo['fecha3'] == '3'){ echo 'selected';} ?> value="3">1 año</option>
                                <option <?php if($solicitudEmpleo['fecha3'] == '4'){ echo 'selected';} ?> value="4">2 años</option>
                                <option <?php if($solicitudEmpleo['fecha3'] == '5'){ echo 'selected';} ?> value="5">3 años o más</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral4]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                <option <?php if($solicitudEmpleo['fecha4'] == '1'){ echo 'selected';} ?> value="1">Ninguna</option>
                                <option <?php if($solicitudEmpleo['fecha4'] == '2'){ echo 'selected';} ?> value="2">6 meses</option>
                                <option <?php if($solicitudEmpleo['fecha4'] == '3'){ echo 'selected';} ?> value="3">1 año</option>
                                <option <?php if($solicitudEmpleo['fecha4'] == '4'){ echo 'selected';} ?> value="4">2 años</option>
                                <option <?php if($solicitudEmpleo['fecha4'] == '5'){ echo 'selected';} ?> value="5">3 años o más</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Puesto desempeñado</td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral1]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['puesto1'];?>"></td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral2]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['puesto2'];?>"></td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral3]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['puesto3'];?>"></td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral4]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['puesto4'];?>"></td>
                          </tr>
                          <tr>
                            <td>Motivo de su separacion</td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion1]"><?php echo $solicitudEmpleo['motivo1'];?></textarea></td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion2]"><?php echo $solicitudEmpleo['motivo2'];?></textarea></td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion3]"><?php echo $solicitudEmpleo['motivo3'];?></textarea></td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion4]"><?php echo $solicitudEmpleo['motivo4'];?></textarea></td>
                          </tr>
                          <tr>
                            <td>Nombre del jefe inmediato</td>
                            <td><input type="text" name="Datos[nombreJefeInmediato1]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefe1'];?>"></td>
                            <td><input type="text" name="Datos[nombreJefeInmediato2]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefe2'];?>"></td>
                            <td><input type="text" name="Datos[nombreJefeInmediato3]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefe3'];?>"></td>
                            <td><input type="text" name="Datos[nombreJefeInmediato4]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefe4'];?>"></td>
                          </tr>
                          <tr>
                            <td>Puesto del jefe inmediato</td>
                            <td><input type="text" name="Datos[puestoUltimoActual1]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['puestoJefe1'];?>"></td>
                            <td><input type="text" name="Datos[puestoUltimoActual2]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefePuesto2'];?>"></td>
                            <td><input type="text" name="Datos[puestoUltimoActual3]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefePuesto3'];?>"></td>
                            <td><input type="text" name="Datos[puestoUltimoActual4]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['jefePuesto4'];?>"></td>
                          </tr>
                          <tr>
                            <td>Telefono y ext.</td>
                            <td><input type="text" name="Datos[telefonoExtension1]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['telefono1'];?>"></td>
                            <td><input type="text" name="Datos[telefonoExtension2]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['telefono2'];?>"></td>
                            <td><input type="text" name="Datos[telefonoExtension3]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['telefono3'];?>"></td>
                            <td><input type="text" name="Datos[telefonoExtension4]" class="form-control input-sm" value="<?php echo $solicitudEmpleo['telefono4'];?>"></td>
                          </tr>
                          <tr>
                            <td>Sueldo diario</td>
                            <td><input type="number" name="Datos[sueldoDirario1]" class="form-control input-sm" step="0.01" value="<?php echo $solicitudEmpleo['sueldo1'];?>"></td>
                            <td><input type="number" name="Datos[sueldoDirario2]" class="form-control input-sm" step="0.01" value="<?php echo $solicitudEmpleo['sueldo2'];?>"></td>
                            <td><input type="number" name="Datos[sueldoDirario3]" class="form-control input-sm" step="0.01" value="<?php echo $solicitudEmpleo['sueldo3'];?>"></td>
                            <td><input type="number" name="Datos[sueldoDirario4]" class="form-control input-sm" step="0.01" value="<?php echo $solicitudEmpleo['sueldo4'];?>"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="datosReingreso">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseNine" class="collapsed" aria-expanded="false">
                        9- Datos reingreso (Termino)
                      </a>
                    </h4>
                  </div>
                  <div id="collapseNine" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-4">
                        <label class="control-label">¿Has trabajado anteriormete con nosotros?<br>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[reingreso]" class="flat-red" <?php if($solicitudEmpleo['reingreso']=='Si'){ echo 'checked';} ?> value="Si">
                            Si
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[reingreso]" class="flat-red" <?php if($solicitudEmpleo['reingreso']=='No'){ echo 'checked';} ?> value="No">
                            No
                          </label>
                        </label>
                      </div>
                      <?php $clientePromocion = explode(",", $solicitudEmpleo['idPromocion']); ?>
                      <div class="form-grop col-md-3">
                        <label class="control-label">Promocion</label>
                        <select class="form-control input-sm selectpicker" data-live-search="true" name="promocion[]" multiple  id="promocion">
                          <option data-hidden="true" <?php if($clientePromocion[0] == '' && count($clientePromocion)<=1){ echo 'selected';}?> value="NULL"></option>
                          <?php
                          foreach ($clientes as $cliente) {
                            ?>
                            <option <?php if(in_array($cliente['idclientes'], $clientePromocion)){echo 'selected';}?> value="<?php echo $cliente['idclientes'] ?>"><?php echo $cliente['nombreComercial'] ?></option>
                          <?php
                           } 
                           ?>
                        </select>
                      </div>
                      <div class="form-grop col-md-3">
                        <label class="control-label">Periodo</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="Datos[periodoReingreso]" id="periodoReingreso" class="form-control input-sm" value="<?php echo $solicitudEmpleo['periodo'];?>">
                        </div>
                      </div>
                      <div class="form-grop col-md-12">
                        <label class="control-label">Motivo de salida</label>
                        <textarea class="form-control" rows="2" name="Datos[motivoSalida]"><?php echo $solicitudEmpleo['motivoSalida'];?></textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <label class="control-label">Trabaja algun familia con nosotros
                          <label class="radio-inline">
                            <input type="radio" name="Datos[familiaresReingreso]" class="flat-red" <?php if($solicitudEmpleo['familiarTrabajando']=='Si'){ echo 'checked';} ?> value="Si">
                            Si
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[familiaresReingreso]" class="flat-red" <?php if($solicitudEmpleo['familiarTrabajando']=='No'){ echo 'checked';} ?> value="No">
                            No
                          </label>
                        </label>
                        <input type="text" maxlength="15" class="form-control input-sm" name="Datos[familiaresReingresoInformacion]"   id="familiaresReingresoInformacion" value="<?php echo $solicitudEmpleo['nombreFamiliarTrabajando'];?>">
                      </div>
                      <input type="hidden" name="Datos[idSolicitudEmpleoID]" value="<?php echo $_GET['id'];?>">   
                    </div>
                  </div>
      </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- /.col-md-12 -->
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button name="enviar" id="modificar" class="btn btn-success" >Modificar</button>
    </div>
    </form>
  </div>
</div>