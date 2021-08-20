<?php 
	//incluir la conexion de base de datos
	require "../config/Conexion.php";
	class TipoMon{


		//implementamos nuestro constructor
	public function __construct(){

	}

	//listar registros
	public function listar(){
		$sql="SELECT * FROM tipo_moneda";

		// echo $sql;

		return ejecutarConsulta($sql);
	}


	}

 ?>
