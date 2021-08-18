<?php 
session_start();
require_once "../modelos/empleados.php";

$empleado=new empleado();

$idempleado=isset($_POST["idempleado"])? limpiarCadena($_POST["idempleado"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':

	if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
		$imagen=$_POST["imagenactual"];
	}else{
		$ext=explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
			$imagen=round(microtime(true)).'.'. end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/empleados/".$imagen);
		}
	}

	//Hash SHA256 para la contraseña
	$clavehash=hash("SHA256", $clave);
	if (empty($idempleado)) {
		$rspta=$empleado->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del empleado";
	}else{
		$rspta=$empleado->editar($idempleado,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
	break;
	

	case 'desactivar':
	$rspta=$empleado->desactivar($idempleado);
	echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
	break;

	case 'activar':
	$rspta=$empleado->activar($idempleado);
	echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
	break;
	
	case 'mostrar':
	$rspta=$empleado->mostrar($idempleado);
	echo json_encode($rspta);
	break;

	case 'listar':
	$rspta=$empleado->listar();
	$data=Array();

	while ($reg=$rspta->fetch_object()) {
		$data[]=array(
			"0"=>(is_null($reg->fecha_baja_emp))?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->id_empleado.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->id_empleado.')"><i class="fa fa-check"></i></button>',
			"1"=>$reg->primer_apellido." ".$reg->segundo_apellido,
			"2"=>$reg->nombre,
			"3"=>$reg->num_documento,
			"4"=>$reg->ciudad,
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

	case 'permisos':
			//obtenemos toodos los permisos de la tabla permisos
	require_once "../modelos/Permiso.php";
	$permiso=new Permiso();
	$rspta=$permiso->listar();
//obtener permisos asigandos
	$id=$_GET['id'];
	$marcados=$empleado->listarmarcados($id);
	$valores=array();

//almacenar permisos asigandos
	while ($per=$marcados->fetch_object()) {
		array_push($valores, $per->idpermiso);
	}
			//mostramos la lista de permisos
	while ($reg=$rspta->fetch_object()) {
		$sw=in_array($reg->idpermiso,$valores)?'checked':'';
		echo '<li><input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
	}
	break;

	case 'verificar':
	//validar si el empleado tiene acceso al sistema
	$logina=$_POST['logina'];
	$clavea=$_POST['clavea'];
	//Hash SHA256 en la contraseña
	$clavehash=hash("SHA256", $clavea);

	// echo $clavehash;
	
	// se hace uso de el modelo de empleado para verificarlo
	$rspta=$empleado->verificar($logina, $clavehash);
	
	// verificamos si la consulta fue exitosa
	$fetch=$rspta->fetch_object();
	if (isset($fetch)) {
	// 	# Declaramos la variables de sesion
		$_SESSION['id_empleado']=$fetch->idempleado;
		$_SESSION['nombre']=$fetch->nombre_usu;
		$_SESSION['rol']=$fetch->rol;

	}

	// retornamos algo para reportar el login exitoso
	echo $fetch->nombre_usu;



	break;
	case 'salir':
	   //limpiamos la variables de la secion
	session_unset();

	  //destruimos la sesion
	session_destroy();
		  //redireccionamos al login
	header("Location: ../index.php");
	break;

	


	
}
?>

