<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Empleado{


	//implementamos nuestro constructor
	public function __construct(){

	}

	//metodo insertar registro
	public function insertar($correo_emp,$telefono_emp,$id_persona,$id_usuario){
		// obtener id de la sucursal asociada al usuario logeado
		$date = date('Y-m-d');
		$id_usu_suc = $_SESSION['id_usuario'];
		$sql = "SELECT id_sucursal FROM sucursales WHERE id_usuario='$id_usu_suc'";
		$rspta = ejecutarConsulta($sql);
		$fetch=$rspta->fetch_object();
		if(!empty($fetch->id_sucursal)){
			$sql="INSERT INTO empleados (correo_emp,telefono_emp,id_persona,id_sucursal,id_usuario,fecha_creacion_emp) 
			VALUES ('$correo_emp','$telefono_emp','$id_persona','$fetch->id_sucursal','$id_usuario','$date')";
			// echo $sql;
			return ejecutarConsulta($sql);
		}else{
			echo "Sucursal no encontrada";
		}

		
		
	}

	public function editar($id_empleado,$correo_emp,$telefono_emp){

		
		
		$sql="UPDATE empleados SET correo_emp='$correo_emp',telefono_emp='$telefono_emp' WHERE id_empleado='$id_empleado'";
		$rspta = ejecutarConsulta($sql);
		
		return $rspta;
	}
	public function desactivar($id_empleado,$id_usuario){
		$date = date('Y-m-d');
		$sql ="UPDATE usuarios SET estado='0' WHERE id_usuario='$id_usuario'; UPDATE empleados SET fecha_baja_emp='$date' WHERE id_empleado='$id_empleado'";
		// return $sql;
		return ejecutarConsultas($sql);
	}
	public function activar($id_empleado,$id_usuario){
		$sql ="UPDATE usuarios SET estado='1' WHERE id_usuario='$id_usuario'; UPDATE empleados SET fecha_baja_emp=NULL WHERE id_empleado='$id_empleado'";
		// return $sql;
		return ejecutarConsultas($sql);
	}

	//metodo para mostrar registros
	public function mostrar($id_empleado){
		$sql="SELECT p.nombre_per,p.primer_ape_per,p.segundo_ape_per ,p.cedula_per ,p.ciudad_resid_per,e.fecha_creacion_emp,e.fecha_baja_emp,s.nombre_sucur,
		e.id_empleado,e.telefono_emp, e.correo_emp,u.nombre_usu,u.id_usuario,u.estado,p.dir_resid_per FROM persona p INNER JOIN empleados e ON e.id_persona=p.id_persona 
		INNER JOIN sucursales s ON s.id_sucursal=e.id_sucursal INNER JOIN usuarios u ON u.id_usuario=e.id_usuario WHERE e.id_empleado='$id_empleado'";
		// return $sql;
		return ejecutarConsultaSimpleFila($sql);
	}

	//listar registros
	public function listar(){
		$sql="SELECT p.nombre_per,p.primer_ape_per,p.segundo_ape_per,p.cedula_per,p.ciudad_resid_per,e.fecha_creacion_emp,e.fecha_baja_emp,s.nombre_sucur,
		e.id_empleado,e.id_usuario,u.estado FROM persona p INNER JOIN empleados e ON e.id_persona=p.id_persona INNER JOIN sucursales s ON s.id_sucursal=e.id_sucursal
		INNER JOIN usuarios u ON u.id_usuario=e.id_usuario WHERE e.id_empleado!='1'";
		return ejecutarConsulta($sql);
	}

	//obtener el id del empleado actualmente logueado
	public function obtener_id($id_usuario){

		$sql="SELECT id_empleado,id_sucursal  FROM empleados WHERE id_usuario='$id_usuario'";
		// echo $sql;
		return ejecutarConsulta($sql);

	}

	public function info($id_usuario){
		$sql="SELECT p.nombre_per,p.primer_ape_per,p.segundo_ape_per FROM empleados e 
		INNER JOIN persona p ON p.id_persona=e.id_persona WHERE e.id_usuario='$id_usuario'";
		// echo $sql;
		return ejecutarConsulta($sql);
	}

	
}

 ?>
