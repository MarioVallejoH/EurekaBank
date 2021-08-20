<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Cliente{


	//implementamos nuestro constructor
	public function __construct(){

	}

	//metodo insertar registro
	public function insertar($correo_cli,$telefono_cli,$id_persona,$id_usuario){
		// obtener id de la sucursal asociada al usuario logeado
		
		
		$sql="INSERT INTO clientes (correo_cli,telefono_cli,id_persona,id_usuario) 
		VALUES ('$correo_cli','$telefono_cli','$id_persona','$id_usuario')";
		// echo $sql;
		return ejecutarConsulta($sql);
		

		
		
	}

	public function editar($id_cliente,$correo_cli,$telefono_cli){

		
		
		$sql="UPDATE clientes SET correo_cli='$correo_cli',telefono_cli='$telefono_cli' 
		WHERE id_cliente='$id_cliente'";
		$rspta = ejecutarConsulta($sql);
		
		return $rspta;
	}
	public function desactivar($id_cliente,$id_usuario){
		$date = date('Y-m-d');
		$sql ="UPDATE usuarios SET estado='0' WHERE id_usuario='$id_usuario'; UPDATE clientes SET fecha_baja_emp='$date' WHERE id_cliente='$id_cliente'";
		// return $sql;
		return ejecutarConsultas($sql);
	}
	public function activar($id_cliente,$id_usuario){
		$sql ="UPDATE usuarios SET estado='1' WHERE id_usuario='$id_usuario'; UPDATE clientes SET fecha_baja_emp=NULL WHERE id_cliente='$id_cliente'";
		// return $sql;
		return ejecutarConsultas($sql);
	}

	//metodo para mostrar registros
	public function mostrar($id_cliente){
		$sql="SELECT p.nombre_per,p.primer_ape_per,p.segundo_ape_per ,p.cedula_per ,p.ciudad_resid_per,
		c.id_cliente,c.telefono_cli, c.correo_cli,u.nombre_usu,u.id_usuario,u.estado,p.dir_resid_per 
		FROM persona p INNER JOIN clientes c ON c.id_persona=p.id_persona INNER JOIN usuarios u 
		ON u.id_usuario=c.id_usuario WHERE c.id_cliente='$id_cliente'";
		// return $sql;
		return ejecutarConsultaSimpleFila($sql);
	}

	//listar registros
	public function listar(){
		$sql="SELECT p.nombre_per,p.primer_ape_per,p.segundo_ape_per,p.cedula_per,p.ciudad_resid_per,
		c.id_cliente,c.id_usuario,u.estado FROM persona p INNER JOIN clientes c ON c.id_persona=p.id_persona 
		INNER JOIN usuarios u ON u.id_usuario=c.id_usuario WHERE u.id_rol='3'";
		// echo $sql;
		return ejecutarConsulta($sql);
	}

	public function obtener_id($id_usuario){

		$sql="SELECT id_cliente  FROM clientes WHERE id_usuario='$id_usuario'";

		// echo $sql;
		return ejecutarConsulta($sql);

	}

	
	}

 ?>
