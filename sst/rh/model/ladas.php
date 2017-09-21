<?php 
	
	require_once('../db/conectadb.php');

	class ladas
	{
    		protected $acceso;
    		protected $conexion;

      		public function __construct() 
      		{
      			$this->acceso = new accesoDB(); 
       		 	$this->conexion = $this->acceso->conDB();
         	}	

      		public function listarEstados($lada1,$lada2){

         			if(isset($_POST['lada1'])){
         				$lada1 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($lada1))));
                     $lada2 = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($lada2))));

                     $consulta = "SELECT lada,nombre,localidad,municipio FROM tblLadas  INNER JOIN tblEstados ON estado=idestado WHERE lada=$lada1 OR lada=$lada2 GROUP BY nombre";
                     
                     $resultado = $this->conexion->query($consulta);

                     if($resultado){
                     return $resultado;
                     }
      				
         			}
        		}


              	
   }
   
?>	
