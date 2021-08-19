<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Usuario{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
	$sql="INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion) VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
	//return ejecutarConsulta($sql);
	 $id_empleadonew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($permisos)) {

	 	$sql_detalle="INSERT INTO usuario_permiso (id_empleado,idpermiso) VALUES('$id_empleadonew','$permisos[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function editar($id_empleado,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
	$sql="UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',cargo='$cargo',login='$login',clave='$clave',imagen='$imagen' 
	WHERE id_empleado='$id_empleado'";
	 ejecutarConsulta($sql);

	 //eliminar permisos asignados
	 $sqldel="DELETE FROM usuario_permiso WHERE id_empleado='$id_empleado'";
	 ejecutarConsulta($sqldel);

	 	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($permisos)) {

	 	$sql_detalle="INSERT INTO usuario_permiso (id_empleado,idpermiso) VALUES('$id_empleado','$permisos[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
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
	$sql="SELECT p.nombre,p.primer_apellido,p.segundo_apellido,p.num_documento,p.ciudad,e.fecha_creacion_emp,e.fecha_baja_emp,s.nombre_sucur,
	e.id_empleado,e.telefono_emp, e.correo_emp,u.nombre_usu,p.direccion FROM persona p INNER JOIN empleados e ON e.id_persona=p.id_persona 
	INNER JOIN sucursales s ON s.id_sucur=e.id_sucur INNER JOIN usuarios u ON u.id_usuario=e.id_usuario WHERE e.id_empleado='$id_empleado'";
	// return $sql;
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT p.nombre,p.primer_apellido,p.segundo_apellido,p.num_documento,p.ciudad,e.fecha_creacion_emp,e.fecha_baja_emp,s.nombre_sucur,
	e.id_empleado,e.id_usuario FROM persona p INNER JOIN empleados e ON e.id_persona=p.id_persona INNER JOIN sucursales s ON s.id_sucur=e.id_sucur";
	return ejecutarConsulta($sql);
}

//metodo para listar permmisos marcados de un usuario especifico
public function listarmarcados($id_empleado){
	$sql="SELECT * FROM usuario_permiso WHERE id_empleado='$id_empleado'";
	return ejecutarConsulta($sql);
}

//funcion que verifica el acceso al sistema

public function verificar($login,$clave){

	$sql="SELECT id_usuario,nombre_usu,id_rol AS rol  FROM usuarios WHERE nombre_usu='$login' AND contraseña_usu='$clave' AND estado='1'";
	 return ejecutarConsulta($sql);

}
}

 ?>
