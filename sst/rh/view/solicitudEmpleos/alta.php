<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formularioAgregar" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Solicitud de empleo</b></h4>
      <div id="mensaje"></div> <div id="opcionSi" onclick="cambiarModal('si');"></div>
      <div id="opcionNo" onclick="cambiarModal('no');"></div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-solid">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion2">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary" id="datosPuesto">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="false" class="collapsed">
                        1- Datos del puesto (Inicio)
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-8">
                        <label class="control-label">Disponibilidad</label>
                        <div>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Lunes">
                            Lu
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Martes" >
                            Ma
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Miercoles">
                            Mie
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Jueves" >
                            Jue
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" checked value="Viernes">
                            Vie
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Sabado" >
                            Sa
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="diasTrabajados[]" class="flat-red" value="Domingo" >
                            D
                          </label>
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <div class="bootstrap-timepicker">
                          <label>Horario entrada</label>
                          <div class="input-group">
                            <input type="text" class="form-control  timepicker"  id="entrada" name="Datos[horarioEntrada]">
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
                            <input type="text" class="form-control  timepicker"  id="salida" name="Datos[horarioSalida]">
                            <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Fecha de solicitud</label>
                        <input type="text" class="form-control input-sm" maxlength="6"  name="Datos[fechaSolicitud]"  id="fechaSolicitud" value="<?php echo date("Y")."-".date("m")."-".date("d");?>" readonly> 
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Puesto</label>
                        <select class="form-control requeridoPuesto input-sm selectpicker" data-live-search="true" name="Datos[puesto]" id="puesto">
                        <?php 
                        foreach ($puestos as $puesto){
                        ?>                            
                        <option  value="<?php echo $puesto['idPuesto']?>"><?php echo $puesto['nombre']?></option>
                        <?php
                        }
                        ?> 
                        </select> 
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Sueldo deseado</label>
                        <input type="number" class="form-control requeridoPuesto input-sm" onkeypress="validarDecimalPositivo(this)" step="0.01"  minlength="70" name="Datos[sueldo]"   id="sueldo" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Experiencia de puesto</label>
                        <select class="form-control input-sm selectpicker" name="Datos[experienciaPuesto]" data-error="Es un campo obligatorio" required="required" id="experienciaPuesto">                           
                          <option value="1">Ninguna</option>
                          <option value="2" selected="selected">6 meses</option>
                          <option value="3">1 año</option>
                          <option value="4">2 años</option>
                          <option value="5">3 años o más</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="datosPersonales">
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
                        <input type="text" class="form-control datosPersonales input-sm" style="text-transform:uppercase;" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU"  onchange="validarRfc()" name="Datos[rfcDatosPersonales]" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones"  id="rfc" required tabindex="1">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Nombre(s)</label>
                        <input type="text" class="form-control datosPersonales input-sm" maxlength="30"  name="Datos[nombresDatosPersonales]"   id="nombres" required tabindex="2">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Apellido paterno</label>
                        <input type="text" class="form-control datosPersonales input-sm" maxlength="30"  name="Datos[apellidoPaternoDatosPersonales]"   id="apellidoPaterno" required tabindex="3">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Apellido materno</label>
                        <input type="text" class="form-control input-sm" maxlength="30"  name="Datos[apellidoMaternoDatosPersonales]"   id="apellidoMaterno" tabindex="4">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Edad</label>
                        <input type="number" class="form-control input-sm" min="18" max="60" name="Datos[edadDatosPersonales]"   id="edadDatosPersonales" placeholder="18" required tabindex="5">
                      </div> 
                      <div class="form-group col-md-2">
                        <label class="control-label">Código postal</label>
                        <div class="input=-group">
                          <input type="number" id="codigoPostal" class="form-control input-sm" onchange="cp()" maxlength="5" class="form-control datosPersonales input-sm" name="Datos[cpDatosPersonales]" placeholder="55500"  required tabindex="6">
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Delegación/Municipio</label>
                        <input type="text" class="form-control input-sm" maxlength="40"  name="Datos[delegacionDatosPersonales]"  id="delegacion" readonly>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Estado</label>
                        <input type="text" class="form-control input-sm" maxlength="40" name="Datos[estadoDatosPersonales]" id="estado"  readonly>
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Colonia</label>
                        <select class="form-control datosPersonales input-sm selectpicker" name="Datos[coloniaDatosPersonales]" data-live-search="true" id="colonias" required tabindex="8">
                        </select>
                      </div>
                      <div class="form-group col-md-5">
                        <label class="control-label">Calle</label>
                        <input type="text" class="form-control datosPersonales input-sm" maxlength="40"  name="Datos[calleDatosPersonales]" data-validate="true"  id="calle" placeholder="Jose Maria Velasco" required tabindex="9">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">No. Interior</label>
                        <input type="text" class="form-control datosPersonales input-sm" maxlength="30"  name="Datos[noInteriorDatosPersonales]" tabindex="10" id="numeroInterior" placeholder="numero 101" required>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">No. Exterior</label>
                        <input type="text" class="form-control datosPersonales input-sm"  maxlength="30" name="Datos[noExteriorDatosPersonales]" placeholder="Primer piso">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Teléfono particular</label>
                        <input type="text" name="Datos[telefonoParticularDatosPersonales]" class="form-control validarTelefonos input-sm"  minlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoParticular" data-mask>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Estado civil</label>
                        <select class="form-control input-sm selectpicker" name="Datos[estadoCivilDatosPersonales]"   id="estadoCivil" required>
                            <option value="Casado/a">Casado/a</option>
                            <option value="comprometido/a">Comprometido/a</option>
                            <option value="Divorciado/a">Divorciado/a</option>
                            <option value="Soltero/a" selected="selected">Soltero/a</option>
                            <option value="Viudo/a">Viudo/a</option>
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Estatura</label>
                        <input type="text" name="Datos[estaturaDatosPersonales]" class="form-control input-sm"  maxlength="4"  id="estatura" placeholder="1.70" onkeypress="validarDecimalPositivo(this)">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Talla</label>
                        <select class="form-control input-sm selectpicker" name="Datos[tallaDatosPersonales]"  ="" id="talla">
                            <option value="Chica">Chica</option>
                            <option value="Mediana" selected="selected">Mediana</option>
                            <option value="Grande">Grande</option>
                          </select>
                      </div> 
                      <div class="form-group col-md-3">
                        <label class="control-label">Teléfono de recados</label>
                        <input type="text" name="Datos[telefonoRecadosDatosPersonales]" class="form-control validarTelefonos input-sm"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoRecados" data-mask>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">CURP</label>
                        <input type="text" class="form-control datosPersonales input-sm"  maxlength="18" name="Datos[curpDatosPersonales]" placeholder="GICC120789ASD50" required id="curp" tabindex="11" style="text-transform:uppercase;">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Teléfono celular</label>
                        <input type="text" name="Datos[telefonoCelularDatosPersonales]" required class="form-control validarTelefonos datosPersonales input-sm"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCelular" data-mask tabindex="12">
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Correo</label>
                        <input type="email" name="Datos[correoDatosPersonales]" class="form-control datosPersonales input-sm" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required id="correo" tabindex="13">
                      </div>
                      <div class="form-group col-md-5">
                        <label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[LicenciaImssDatosPersonales]" class="flat-red" checked value="Licencia de manejo">
                            Licencia de manejo
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[LicenciaImssDatosPersonales]" class="flat-red" value="Numero de IMSS" required>
                            Numero de IMSS
                          </label>
                        </label>
                        <input type="number" maxlength="15" class="form-control datosPersonales input-sm" name="Datos[numeroLicenciaImssDatosPersonales]"  id="numeroLicenciaImss">
                      </div>
                    <div class="form-group col-md-3">
                      <label class="control-label">Sexo</label>
                      <select class="form-control input-sm selectpicker" name="Datos[sexo]" data-error="Es un campo obligatorio" required="required" id="sexo">
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Indistinto">Indistinto</option>
                      </select>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="datosFamiliares">
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
                            <th>telefono</th>
                            <th>Ocupacion</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Padre</td>
                            <td><input type="text" class="form-control input-sm" maxlength="40"  name="Datos[padreDatosFamiliares]" id="padreDatosFamiliares"></td>
                            <td><input type="text" name="Datos[direccionTelefonoPadreDatosFamiliares]" id="direccionP" class="form-control input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[telefonoPadreDatosFamiliares]" id="telefonoP" class="form-control validarTelefonos input-sm" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask></td>
                            <td><input type="text" name="Datos[ocupacionPadreDatosFamiliares]" id="ocupacion" class="form-control input-sm" maxlength="40"></td>
                          </tr>
                          <tr>
                            <td>Madre</td>
                            <td><input type="text" name="Datos[madreDatosFamiliares]" id="madre" class="form-control input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[direccionTelefonoMadreDatosFamiliares]" id="direccionM" class="form-control input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[telefonoMadreDatosFamiliares]" id="telefonoM" class="form-control validarTelefonos input-sm" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask></td>
                            <td><input type="text" name="Datos[ocupacionMadreDatosFamiliares]" id="ocupacionM" class="form-control input-sm" maxlength="40"></td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="form-group col-md-4">
                        <label class="control-label">Nombre del esposo(a)</label>
                        <input type="text" name="Datos[nombreEsposoA]" class="form-control input-sm" maxlength="40" id="nombreEsposoA" placeholder="Aquiles Castro">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Ocupacion</label>
                        <input type="text" name="Datos[ocupacion]" class="form-control input-sm" maxlength="40" id="ocupacion" placeholder="Programador">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Escuela o empresa</label>
                        <input type="text" name="Datos[escuelaEmpresa]" class="form-control input-sm" maxlength="40" id="escuelaEmpresa" placeholder="UNAM">
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Edad</label>
                        <input type="number" min="18" max="60" name="Datos[edadDatosFamiliares]" class="form-control input-sm" id="edad" placeholder="18">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Telefono</label>
                        <input type="text" name="Datos[telefonoFamiliar]" class="form-control validarTelefonos input-sm" id="telefonoFamiliar" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="referenciasPersonales">
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
                            <td><input type="text" name="Datos[nombreReferencia]" id="nombreReferencia" class="form-control referenciasPersonales input-sm" maxlength="40" required tabindex="14"></td>
                            <td><input type="text" name="Datos[telefonoReferencia]" id="telefonoReferencia" class="form-control validarTelefonos referenciasPersonales input-sm" maxlength="40" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask required tabindex="15"></td>
                            <td><input type="text" name="Datos[ocupacionReferencia]" id="ocupacionReferencia" class="form-control referenciasPersonales input-sm" maxlength="40" required tabindex="16"></td>
                            <td><input type="text" name="Datos[tiempoConocerlo]" id="tiempoConocerlo" class="form-control referenciasPersonales input-sm" maxlength="40" required tabindex="17"></td>
                          </tr>
                          <tr>
                            <td><input type="text" name="Datos[nombreReferencia2]" id="nombreReferencia2" class="form-control referenciasPersonales input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[telefonoReferencia2]" class="form-control validarTelefonos referenciasPersonales input-sm" maxlength="40" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoReferencia2" data-mask></td>
                            <td><input type="text" name="Datos[ocupacionReferencia2]" id="ocupacionReferencia2" class="form-control referenciasPersonales input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[tiempoConocerlo2]" id="tiempoConocerlo2" class="form-control referenciasPersonales input-sm" maxlength="40"></td>
                          </tr>
                          <tr>
                            <td><input type="text" name="Datos[nombreReferencia3]" id="nombreReferencia3" class="form-control referenciasPersonales input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[telefonoReferencia3]" class="form-control validarTelefonos referenciasPersonales input-sm" maxlength="40" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoReferencia3" data-mask></td>
                            <td><input type="text" name="Datos[ocupacionReferencia3]" id="ocupacionReferencia3" class="form-control referenciasPersonales input-sm" maxlength="40"></td>
                            <td><input type="text" name="Datos[tiempoConocerlo3]" id="tiempoConocerlo3" class="form-control referenciasPersonales input-sm" maxlength="40"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="preparacionAcademica">
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
                        <select class="form-control preparacionAcademica input-sm selectpicker" name="Datos[escolaridad]" data-live-search="true" id="escolaridad" required="required" tabindex="18">
                              <?php 
                                foreach ($escolaridades as $escolaridad){
                              ?>                            
                                <option value="<?php echo $escolaridad['idEscolaridad']?>"><?php echo $escolaridad['escolaridad']?></option>
                              <?php
                                }
                              ?>
                          </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Nombre de la escuela</label>
                        <input type="text" name="Datos[nombreEscuelaPreparacionaAcademica]" class="form-control preparacionAcademica input-sm" required id="nombreEscuela" tabindex="19">
                      </div>
                      <div class="form-grop col-md-3">
                        <label class="control-label">Fecha inicio y fin</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="Datos[fechaInicioFin]" id="fechaInicioFin" class="form-control preparacionAcademica input-sm" required value="" tabindex="20">
                        </div>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label">Años cursados</label>
                        <input type="number" name="Datos[anosPreparacionAcademica]"  class="form-control preparacionAcademica input-sm" required id="anosCursados" tabindex="21">
                      </div>
                      <div class="form-group col-md-3">
                        <label class="control-label">Titulo recibido</label>
                        <input type="text" name="Datos[tituloRecibido]" class="form-control preparacionAcademica input-sm" required id="tituloRecibido" tabindex="22">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Carrera en</label>
                        <input type="text" name="Datos[carrera]" class="form-control preparacionAcademica input-sm" required id="preparacionAcademicaCarrera" tabindex="23">
                      </div>
                      <div class="form-group col-md-4">
                        <label clas="control-label">Estudios efectuando actualmente</label>
                        <input type="text" name="Datos[estudiosActuales]" class="form-control input-sm">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Escuela</label>
                        <input type="text" name="Datos[escuela]" class="form-control input-sm">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Horario</label>
                        <input type="text" name="Datos[horario]" class="form-control input-sm">
                      </div>
                      <div class="form-group col-md-3">
                        <label clas="control-label">Curso o carrera</label>
                        <input type="text" name="Datos[cursoCarrera]" class="form-control input-sm">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="datosGenerales">
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
                            <input type="radio" name="Datos[automovilPropio]" class="flat-red" checked value="Si">
                            Si 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[automovilPropio]" class="flat-red" value="No">
                            No
                          </label>
                      </div>
                      <div class="form-group col-md-8">
                        <label class="control-label">¿Como se entero del empleo?</label><br>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[publicidadEmpleo]" class="flat-red" checked value="Anuncio">
                            Anuncio 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[publicidadEmpleo]" class="flat-red" value="Recomendacion">
                            Recomendacion
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[publicidadEmpleo]" class="flat-red" value="Otros">
                            Otros 
                          </label>
                          <label class="radio-inline">
                            <input type="text" maxlength="15" class="form-control" id="inputdefault" name="Datos[otrosPublicidadEmpleo]"  >
                        </label>                  
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="conocimientosGenerales">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven" class="collapsed" aria-expanded="false">
                        7- Conocimientos
                      </a>
                    </h4>
                  </div>
                  <div id="collapseSeven" class="panel-collapse collapse" aria-expanded="false">
                    <div class="box-body">
                      <div class="form-group col-md-4">
                        <label class="control-label">¿Domina ingles?</label><br>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[idioma]" class="flat-red" checked value="Si" id="inglesSi">
                            Si 
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[idioma]" class="flat-red" value="No" id="inglesNo">
                            No
                          </label>
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Conocimientos especificos</label>
                        <select class="form-control input-sm selectpicker" multiple  name="conocimientos[]" data-error="Es un campo obligatorio" data-live-search="true" required id="conocimiento">
                          <option data-hidden="true" selected></option>
                          <?php foreach ($conocimientos as $conocimiento) {
                          ?>
                          <option value="<?php echo $conocimiento['idConocimiento']; ?>"><?php echo $conocimiento['conocimiento']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Paquetes y/o lenguajes que domina</label>
                        <select class="form-control conocimientosGenerales input-sm selectpicker" name="paquestesLenguajes[]" multiple data-error="Es un campo obligatorio" data-live-search="true" id="paquestesLenguajes">
                          <option data-hidden="true" selected></option>
                          <option  value="Excel">Excel</option>
                          <option  value="Power point">Power point</option>
                          <option  value="Access">Access</option>
                          <option  value="Word">Word</option>
                          <option  value="Otra">Otra</option>
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
                      <div class="form-group col-md-5">
                        <label clas="control-label">Otros oficios que domine</label>
                        <input type="text" name="Datos[oficios]" class="form-control input-sm">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary" id="experienciaLaboral">
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
                            <th>Experiencia</th>
                            <th>Anterior</th>
                            <th>Anterior</th>
                            <th>Anterior</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Nombre de la empresa</td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual1]"></td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual2]"></td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual3]"></td>
                            <td><input type="text" class="form-control input-sm" name="Datos[ultimoActual4]"></td>
                          </tr>
                          <tr>
                            <td>Experencia</td>
                            <td>  
                                <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral1]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                      <option value="1" selected="selected">Ninguna</option>
                                      <option value="2">6 meses</option>
                                      <option value="3">1 año</option>
                                      <option value="4">2 años</option>
                                      <option value="5">3 años o más</option>
                                </select>
                            </td>
                            <td>
                             <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral2]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                      <option value="1" selected="selected">Ninguna</option>
                                      <option value="2">6 meses</option>
                                      <option value="3">1 año</option>
                                      <option value="4">2 años</option>
                                      <option value="5">3 años o más</option>
                                </select>
                            </td>
                            <td>
                             <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral3]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                      <option value="1" selected="selected">Ninguna</option>
                                      <option value="2">6 meses</option>
                                      <option value="3">1 año</option>
                                      <option value="4">2 años</option>
                                      <option value="5">3 años o más</option>
                                </select>
                            </td>
                            <td>
                             <select class="form-control input-sm selectpicker" name="Datos[fechaExperienciaLaboral4]" data-error="Es un campo obligatorio" required="required" id="experiencia">                           
                                      <option value="1" selected="selected">Ninguna</option>
                                      <option value="2">6 meses</option>
                                      <option value="3">1 año</option>
                                      <option value="4">2 años</option>
                                      <option value="5">3 años o más</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Puesto desempeñado</td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral1]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral2]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral3]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[puestoExperienciaLaboral4]" class="form-control input-sm"></td>
                          </tr>
                          <tr>
                            <td>Motivo de su separacion</td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion1]"></textarea></td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion2]"></textarea></td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion3]"></textarea></td>
                            <td><textarea class="form-control" rows="3" name="Datos[motivoSeparacion4]"></textarea></td>
                          </tr>
                          <tr>
                            <td>Nombre del jefe inmediato</td>
                            <td><input type="text" name="Datos[nombreJefeInmediato1]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[nombreJefeInmediato2]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[nombreJefeInmediato3]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[nombreJefeInmediato4]" class="form-control input-sm"></td>
                          </tr>
                          <tr>
                            <td>Puesto del jefe inmediato</td>
                            <td><input type="text" name="Datos[puestoUltimoActual1]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[puestoUltimoActual2]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[puestoUltimoActual3]" class="form-control input-sm"></td>
                            <td><input type="text" name="Datos[puestoUltimoActual4]" class="form-control input-sm"></td>
                          </tr>
                          <tr>
                            <td>Telefono y ext.</td>
                            <td><input type="text" name="Datos[telefonoExtension1]" class="form-control validarTelefonos input-sm"></td>
                            <td><input type="text" name="Datos[telefonoExtension2]" class="form-control validarTelefonos input-sm"></td>
                            <td><input type="text" name="Datos[telefonoExtension3]" class="form-control validarTelefonos input-sm"></td>
                            <td><input type="text" name="Datos[telefonoExtension4]" class="form-control validarTelefonos input-sm"></td>
                          </tr>
                          <tr>
                            <td>Sueldo diario</td>
                            <td><input type="number" name="Datos[sueldoDirario1]" class="form-control input-sm" step="0.01" onkeypress="validarDecimalPositivo(this)"></td>
                            <td><input type="number" name="Datos[sueldoDirario2]" class="form-control input-sm" step="0.01" onkeypress="validarDecimalPositivo(this)"></td>
                            <td><input type="number" name="Datos[sueldoDirario3]" class="form-control input-sm" step="0.01" onkeypress="validarDecimalPositivo(this)"></td>
                            <td><input type="number" name="Datos[sueldoDirario4]" class="form-control input-sm" step="0.01" onkeypress="validarDecimalPositivo(this)"></td>
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
                            <input type="radio" name="Datos[reingreso]" class="flat-red" value="Si">
                            Si
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[reingreso]" class="flat-red" checked value="No">
                            No
                          </label>
                        </label>
                      </div>
                      <div class="form-grop col-md-3">
                        <label class="control-label">Promocion</label>
                        <select class="form-control input-sm selectpicker" data-live-search="true" name="promocion[]" multiple  id="promocion">
                          <option data-hidden="true" selected></option>
                          <?php
                          foreach ($clientes as $cliente) {
                            ?>
                            <option value="<?php echo $cliente['idclientes'] ?>"><?php echo $cliente['nombreComercial'] ?></option>
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
                          <input type="text" name="Datos[periodoReingreso]" id="periodoReingreso" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="form-grop col-md-12">
                        <label class="control-label">Motivo de salida</label>
                        <textarea class="form-control" rows="2" name="Datos[motivoSalida]"></textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <label class="control-label">Trabaja algun familia con nosotros
                          <label class="radio-inline">
                            <input type="radio" name="Datos[familiaresReingreso]" class="flat-red" value="Si">
                            Si
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="Datos[familiaresReingreso]" class="flat-red" checked value="No">
                            No
                          </label>
                        </label>
                        <input type="text" maxlength="15" class="form-control input-sm" name="Datos[familiaresReingresoInformacion]"   id="familiaresReingresoInformacion">
                      </div>  
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
      <button name="enviar" id="agregar" class="btn btn-success" >Agregar</button>
    </div>
    </form>
  </div>
</div>

<!--<div class="form-group col-md-2">
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
    <div class="form-group col-md-5">
      <label class="control-label">Dias trabajdos</label>
      <select class="form-control input-sm selectpicker"  name="diasTrabajados[]" multiple  id="diasTrabajados">
        <option selected="selected" value="Lunes">Lunes</option>
        <option selected="selected" value="Martes">Martes</option>
        <option selected="selected" value="Miércoles">Miércoles</option>
        <option selected="selected" value="Jueves">Jueves</option>
        <option selected="selected" value="Viernes">Viernes</option>
        <option value="Sábado">Sábado</option>
        <option value="Domingo">Domingo</option>
      </select>
    </div>
    <div class="form-group col-md-1">
      <a><i class="fa fa-plus agregarFila"  style="cursor:pointer" onclick="agregarFila();" ></i></a>
    </div>
    <div id="prueba"></div>
    -->