<?php 
session_start();
require_once "../modelos/empleado.php";
require_once "../modelos/Persona.php";
require_once "../modelos/usuario.php";

$empleado = new empleado();

$persona  = new persona();

$usuario  = new usuario();




switch ($_GET["op"]) {
	case 'guardaryeditar':
		// sacamos las variables de el formulario enviado por post
		$nombre_per      = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
		$primer_ape_per  = isset($_POST["primer_apellido"])? limpiarCadena($_POST["primer_apellido"]):"";
		$segundo_ape_per = isset($_POST["segundo_apellido"])? limpiarCadena($_POST["segundo_apellido"]):"";
		$ciudad_resid_per= isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";
		$dir_resid_per   = isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
		$cedula_per      = isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
		$telefono_emp    = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
		$correo_emp      = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
		$contraseña_usu  = isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
		$id_empleado     = isset($_POST["id_empleado"])? limpiarCadena($_POST["id_empleado"]):"";
		$id_usuario      = isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
		//Hash SHA256 para la contraseña
		// verificamos si la cedula ya esta registrada en el sistema
		$verificar_persona = $persona->verificar($cedula_per);
		$fetch = $verificar_persona->fetch_object();
		
		if(isset($fetch)){
			// si es asi actualizamos los datos de la persona
			$id_persona = $fetch->id_persona;
			$respta = $persona->editar($fetch->id_persona,$nombre_per,$primer_ape_per,$segundo_ape_per,$cedula_per,$dir_resid_per, $ciudad_resid_per);
			
		}else{
			// si no es asi creamos una nueva persona y 
			$id_persona = $persona->insertar($nombre_per,$primer_ape_per,$segundo_ape_per,$cedula_per,$dir_resid_per, $ciudad_resid_per);
			// verificamos el exito de la consulta
			// echo $id_persona;
			if(!empty($id_persona)){
				// para que realize la creacion del usuario y empleado
				$respta = 1;
			}else{
				// reportando el error en la creacion de la persona
				$respta = 0;
			}
			
		}
		if ($respta==1){
			$clavehash=hash("SHA256", $contraseña_usu);
			// verificamos si estamos editando o creando un empleado nuevo
			if (empty($id_empleado)) {
				// creacion de un nuevo usuario
				$id_usuario = $usuario->insertar($cedula_per,$clavehash,2);
				
				// verificamos que el usuario se halla creado
				if(!empty($id_usuario)){
					// echo $id_usuario;
					// creamos el empleado
					//sacamos el id de la sucursal almacenado en las variables de sesion

					$rspta=$empleado->insertar($correo_emp,$telefono_emp,$id_persona,$id_usuario );
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del empleado";
				}else{
					echo FALSE;
				}
				
			}else{
				// echo $id_usuario;
				$clavehash=hash("SHA256", $contraseña_usu);
				$respta = $usuario->editar($id_usuario,$cedula_per,$clavehash);
				
				if($respta==1){
					$rspta=$empleado->editar($id_empleado,$correo_emp,$telefono_emp);
					echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
				}
				
			}
		}else{
			echo 'Hubo un error al registrar los datos de la persona.';
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
			"0"=>(is_null($reg->fecha_baja_emp) OR $reg->estado==1)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->id_empleado.','.$reg->id_usuario.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_empleado.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->id_empleado.','.$reg->id_usuario.')"><i class="fa fa-check"></i></button>',
			"1"=>$reg->primer_ape_per." ".$reg->segundo_ape_per,
			"2"=>$reg->nombre_per,
			"3"=>$reg->cedula_per,
			"4"=>$reg->ciudad_resid_per,
			"5"=>$reg->fecha_creacion_emp,
			"6"=>$reg->nombre_sucur,
			"7"=>(is_null($reg->fecha_baja_emp) AND $reg->estado==1)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

