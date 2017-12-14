<?php 
	class directorio
	{
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function listar(){
   			$datos = array();
   			$consulta="SELECT d.idUsuario,d.region,d.idDirectorio as id ,d.telefono,d.telefonoSecundario,d.telefonoExtencion,d.telefonoAlterno,d.telefonoCasa,e.empleados_nombres,e.empleados_apellido_paterno,e.empleados_apellido_materno,p.puesto,e.empleados_correo,p.idPuesto,Rg.region FROM tblDirectorio d inner JOIN spar_empleados e ON d.idUsuario=e.empleados_id LEFT JOIN tblUsuarios u ON e.empleados_id=u.usuarios_empleados_id LEFT JOIN tblPuestos p on e.empleados_puesto=p.idPuesto LEFT JOIN tblEstados Es on e.empleados_estado=Es.idestado INNER JOIN tblRegiones Rg ON Es.region=Rg.idRegion where e.empleados_vigente=1";
   			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				//echo $consulta;
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
  		
   		   		
//funcion para$idinformacion
   		public function informacion($id){
			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
   			$consulta="SELECT d.telefonoAlterno,d.telefonoCasa,d.idDirectorio,s.empleados_numero_empleado,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,s.empleados_correo,d.telefono,d.telefonoSecundario,d.telefonoExtencion,p.puesto,Es.nombre as nombreEstados,u.usuarios_foto,Rg.region FROM tblDirectorio d LEFT JOIN spar_empleados s ON s.empleados_id=d.idUsuario LEFT JOIN tblUsuarios u ON u.usuarios_empleados_id=s.empleados_id INNER JOIN tblPuestos p ON p.idPuesto=s.empleados_puesto INNER JOIN tblEstados Es ON s.empleados_estado=Es.idestado INNER JOIN tblRegiones Rg ON Es.region=Rg.idRegion where d.idDirectorio=$id";
   			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return $resultado->fetch_assoc();
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		
//funcion de hacer una consulta para guardar la informacion
   		public function guardar($id,$telefono,$ext,$cel,$telCasa,$telAlterno,$region){
			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$telefono = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($telefono))));
			$ext = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($ext))));
			$cel = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cel))));
			$telCasa = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($telCasa))));
			$telAlterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($telAlterno))));
			$region = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($region))));
			$activo=1;
			$errores = 0;
			$errorResultado = "";
			
			if (empty($id)) {
				$errores ++;
				$errorResultado .= "El campo usuario no puede estar vacío. <br>";
				}
				$resultado="";
			if($errores === 0){
					$consulta1 = "SELECT * FROM tblDirectorio WHERE idUsuario=$id";
					$resultados=$this->conexion->query($consulta1); 
					if ($resultados->num_rows==0) 
					{ 
					$consulta = "INSERT INTO tblDirectorio(idUsuario,telefono,telefonoSecundario,telefonoExtencion,telefonoAlterno,telefonoCasa,region,activo) SELECT * FROM (SELECT '$id' AS idUsuario, '$telefono' AS telefono, '$cel' AS telefonoSecundario, '$ext' AS telefonoExtencion, '$telAlterno' AS telefonoAlterno, '$telCasa' AS telefonoCasa, '$region' AS region, '$activo' AS activo) AS tmp WHERE NOT EXISTS (SELECT idUsuario FROM tblDirectorio WHERE idUsuario = '$id') LIMIT 1";
						$resultado = $this->conexion->query($consulta);
					}else{
						$consulta = "UPDATE tblDirectorio SET telefono='$telefono',telefonoSecundario='$ext',telefonoExtencion='$cel',telefonoAlterno='$telAlterno',telefonoCasa='$telCasa',region=$region,activo=1 where idUsuario=$id";
						$resultado = $this->conexion->query($consulta);
					}
				if($resultado){
			  		if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "errrrrorrr";
				}
				else{
					return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
			}
			else{
				return $errorResultado;
			}
		}
//funcion para actualizar los registros
		public function actualizar($id,$telefono,$ext,$cel,$telCasa,$telAlterno){
			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$telefono = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($telefono))));
			$ext = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($ext))));
			$cel = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($cel))));
			$telCasa = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($telCasa))));
			$telAlterno = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($telAlterno))));
			$errores = 0;
			$errorResultado = "";
			if (empty($id)) {
				$errores ++;
				$errorResultado .= "El campo usuario no puede estar vacío. <br>";
			}
			if($errores === 0){
				$consulta = "UPDATE tblDirectorio SET telefono='$telefono',telefonoSecundario='$cel',telefonoExtencion='$ext',telefonoAlterno='$telAlterno',telefonoCasa='$telCasa',activo=1 where idDirectorio=$id";
  				$resultado = $this->conexion -> query($consulta);
				if($resultado){
				  	if($this->conexion->affected_rows === 1)
						return "OK";
					else 
						return "No se realizaron cambios. <br>";	
				}
				else{
					echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			}
			else{
				return $errorResultado;
			}
		}
		

   		public function eliminar($id){
			$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
			$consulta="UPDATE tblDirectorio SET activo=0 WHERE idDirectorio =$id";
			echo $consulta;
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				return "OK";
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}



   	public function buscarEmpleados(){
        $errores = 0;
        if($errores === 0){
           $consulta = "SELECT Rg.region,e.empleados_id,CONCAT(e.empleados_nombres,' ',e.empleados_apellido_paterno,' ',e.empleados_apellido_materno) AS nombre,e.empleados_rfc,e.empleados_numero_empleado,Es.nombre as estadoNombre,Es.idestado as estadoNombres, dr.activo,p.puesto from spar_empleados e INNER JOIN tblEstados Es ON Es.idestado=e.empleados_estado INNER JOIN tblRegiones Rg ON Es.region=Rg.idRegion left join tblDirectorio dr ON e.empleados_id=dr.idUsuario INNER JOIN tblPuestos p ON p.idPuesto=e.empleados_puesto where not exists (select * from tblDirectorio d where d.activo=1 and e.empleados_id = d.idUsuario) and e.empleados_vigente=1";
           $resultado = $this->conexion->query($consulta);
           if($resultado){
              while ($filaTmp = $resultado->fetch_assoc()) {
                 $datosEmpleados[] = $filaTmp;
              }
           }
           else
              echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

           return $datosEmpleados;
        }
        else
           return $errorResultado;
    }

    public function verProveedor($id){
    	$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
        $errores = 0;
        if($errores === 0){
           $consulta = "SELECT p.rfc,p.razonSocial,p.apellidoPaterno,p.apellidoMaterno,p.nombreComercial,p.calle,p.noInterior,p.noInterior,p.noExterior,p.colonia,p.delegacion,p.estado,p.cp,p.telefonoContactoPrincipal,p.telefonoContactoSecundario,p.telefonoContactoOtro,p.tipoProveedor,p.noCuentaProveedor,p.clabeProveedor,p.nombreContacto FROM tblProveedores p WHERE idproveedor=$id";
           $resultado = $this->conexion->query($consulta);
           if($resultado){
              while ($filaTmp = $resultado->fetch_assoc()) {
                 $datosEmpleados = $filaTmp;
              }
           }
           else
              echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

           return $datosEmpleados;
        }
        else
           return $errorResultado;
    }

    public function verCliente($id){
    	$id = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($id))));
        $errores = 0;
        if($errores === 0){
           $consulta = "SELECT c.tipo, c.rfc, c.razonSocial,c.nombres,c.apellidoPaterno,c.apellidoMaterno, c.nombreComercial, c.calle, c.noInterior, c.noExterior, c.colonia, c.delegacion, c.pais, c.estado, c.cp, c.nombreContacto, c.telefonoContactoPrincipal, c.telefonoContactoSecundario, c.telefonoContactoOtro FROM tblClientes c WHERE c.idclientes = $id";
           $resultado = $this->conexion->query($consulta);
           if($resultado){
              while ($filaTmp = $resultado->fetch_assoc()) {
                 $datosEmpleados = $filaTmp;
              }
           }
           else
              echo $this->conexion->errno . " : " . $this->conexion->error . "\n";

           return $datosEmpleados;
        }
        else
           return $errorResultado;
    }

    public function bajaDirectorio(){
   			$datos = array();
   			$borrar="DELETE d FROM tblDirectorio d LEFT JOIN spar_empleados s ON d.idUsuario=s.empleados_id where 91<=DATEDIFF(CURDATE(),s.empleados_fecha_baja)";
   			$resultado2 = $this->conexion->query($borrar);
   			$consulta="SELECT s.empleados_id,s.empleados_numero_empleado,s.empleados_nombres,s.empleados_apellido_paterno,s.empleados_apellido_materno,s.empleados_correo,d.telefono,d.telefonoExtencion,d.telefonoSecundario,d.telefonoAlterno,d.telefonoCasa,r.region,s.empleados_fecha_baja,DATEDIFF(CURDATE(),s.empleados_fecha_baja) as diasRestantes FROM spar_empleados s INNER JOIN tblDirectorio d ON d.idUsuario=s.empleados_id INNER JOIN tblEstados Es ON Es.idestado=d.region INNER JOIN tblRegiones r On r.idRegion=Es.region WHERE s.empleados_vigente=0";
   			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				//echo $consulta;
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   	}
    	/*public function listarRepresentante(){
   			$datos = array();
   			$consulta="SELECT idReprecentantes, reprecentante_nombres, reprecentante_apellido_paterno, reprecentante_apellido_materno, reprecentante_vigente, reprecentante_correo, reprecentate_empresa,Es.nombre,rg.region FROM tblReprecentantes r inner join tblEstados Es ON Es.idestado=r.reprecentante_estado inner join tblRegiones rg on rg.idRegion=Es.region";
   			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				//echo $consulta;
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}*/

	public function __destruct() 
      	{
				mysqli_close($this->conexion);
  	   	}	


   }

   
?>