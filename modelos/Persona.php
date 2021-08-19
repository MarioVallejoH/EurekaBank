<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
	class Persona{


		//implementamos nuestro constructor
		public function __construct(){

		}

		// metodo insertar nueva persona 

		public function insertar($nombre_per,$primer_ape_per,$segundo_ape_per,$cedula_per,$dir_resid_per, $ciudad_resid_per){
			$sql="INSERT INTO persona (nombre_per,primer_ape_per,segundo_ape_per,cedula_per,dir_resid_per,ciudad_resid_per) 
			VALUES ('$nombre_per','$primer_ape_per','$segundo_ape_per','$cedula_per','$dir_resid_per','$ciudad_resid_per')";
			// echo $sql;
			return ejecutarConsulta_retornarID($sql);
		}

		// funcion para editar persona

		public function editar($id_persona,$nombre_per,$primer_ape_per,$segundo_ape_per,$cedula_per,$dir_resid_per, $ciudad_resid_per){
			$sql="UPDATE persona SET nombre_per='$nombre_per', primer_ape_per='$primer_ape_per',segundo_ape_per='$segundo_ape_per',
			cedula_per='$cedula_per',dir_resid_per='$dir_resid_per',ciudad_resid_per='$ciudad_resid_per' WHERE id_persona='$id_persona'";
			return ejecutarConsulta($sql);
		}

		//funcion que verifica que la persona no exista, en caso de hacerlo retorna el id

		public function verificar($cedula_per){

			$sql="SELECT id_persona  FROM persona WHERE cedula_per='$cedula_per'";
			return ejecutarConsulta($sql);

		}
	}

 ?>
