<?php 
	//incluir la conexion de base de datos
	require "../config/Conexion.php";
	class Sucursal{


		//implementamos nuestro constructor
	public function __construct(){

	}



	// obtener info de valores de IFT
	public function listar(){
		$sql="SELECT * FROM sucursales";
		return ejecutarConsulta($sql);
	}


	// aumentar el contador de cuentas de la sucursal
	public function incrementar_cuentas($id_sucursal){
		$sql="UPDATE sucursales s SET s.num_ctas_sucur=s.num_ctas_sucur+'1' WHERE id_sucursal='$id_sucursal'";
		return ejecutarConsulta($sql);
	}


	}

 ?>
