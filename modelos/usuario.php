<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
	class Usuario{


		//implementamos nuestro constructor
		public function __construct(){

		}

		// metodo insertar nuevo usuario

		public function insertar($nombre_usu,$contraseña_usu,$rol){
			$sql="INSERT INTO usuarios (nombre_usu,contraseña_usu,estado,id_rol) 
			VALUES ('$nombre_usu','$contraseña_usu','1','$rol')";
			// echo $sql;
			return ejecutarConsulta_retornarID($sql);
		}

		// funcion para editar un usuario

		public function editar($id_usuario,$nombre_usu,$contraseña_usu){
            

			$sql="UPDATE usuarios SET nombre_usu='$nombre_usu',contraseña_usu='$contraseña_usu' WHERE id_usuario='$id_usuario'";
			// echo $sql;
			return ejecutarConsulta($sql);
		}



	}

 ?>