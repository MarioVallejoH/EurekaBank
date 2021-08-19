<?php 
session_start();
require_once "../modelos/empleado.php";

$empleado=new empleado();




switch ($_GET["op"]) {
	case 'guardaryeditar':
	
	// $nombre_per=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
	// $cedula_per=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
	// $primer_ape_per=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
	// $telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
	// $email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
	// $login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
	// $clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
	// $id=isset($_POST["id_empleado"])? limpiarCadena($_POST["id_empleado"]):"";
	// $id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
	//Hash SHA256 para la contraseña
	



	$clavehash=hash("SHA256", $clave);
	if (empty($id_empleado)) {
		$rspta=$empleado->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del empleado";
	}else{
		$rspta=$empleado->editar($idempleado,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
	break;
	

	case 'desactivar':
		$id_empleado=isset($_POST["id_empleado"])? limpiarCadena($_POST["id_empleado"]):"";
		$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
		$rspta=$empleado->desactivar($id_empleado,$id_usuario);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
	break;

	case 'activar':
		$id_empleado=isset($_POST["id_empleado"])? limpiarCadena($_POST["id_empleado"]):"";
		$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
		$rspta=$empleado->activar($id_empleado,$id_usuario);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
	break;
	
	case 'mostrar':
		$id_empleado=isset($_POST["id_empleado"])? limpiarCadena($_POST["id_empleado"]):"";	
		$rspta=$empleado->mostrar($id_empleado);
		// echo $rspta;
		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$empleado->listar();
		$data=Array();

	while ($reg=$rspta->fetch_object()) {
		$data[]=array(
			"0"=>(is_null($reg->fecha_baja_emp))?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->id_empleado.','.$reg->id_usuario.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->id_empleado.','.$reg->id_usuario.')"><i class="fa fa-check"></i></button>',
			"1"=>$reg->primer_ape_per." ".$reg->segundo_ape_per,
			"2"=>$reg->nombre_per,
			"3"=>$reg->cedula_per,
			"4"=>$reg->ciudad_resid_per,
			"5"=>$reg->fecha_creacion_emp,
			"6"=>$reg->nombre_sucur,
			"7"=>(is_null($reg->fecha_baja_emp))?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
		);
	}

	$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
	echo json_encode($results);
	break;

	
}
?>

