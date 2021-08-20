<?php 
	//incluir la conexion de base de datos
	require "../config/Conexion.php";
	class TipoMov{


		//implementamos nuestro constructor
	public function __construct(){

	}

	//listar registros
	public function listar(){
		
		// se hace para no permitirle al usuario cancelar una cuenta

		if($_SESSION['rol']==3){
			$sql="SELECT * FROM tipo_movimiento WHERE id_tipo_mov!='1' AND id_tipo_mov!='2' AND id_tipo_mov!='5' AND id_tipo_mov!='7' AND id_tipo_mov!='8'";
		}else{
			$sql="SELECT * FROM tipo_movimiento WHERE id_tipo_mov!='1' AND id_tipo_mov!='5' AND id_tipo_mov!='7' AND id_tipo_mov!='8'";
		}
		
		

		// echo $sql;

		return ejecutarConsulta($sql);
	}


	}

 ?>
