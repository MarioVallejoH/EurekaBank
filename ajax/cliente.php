<?php 
session_start();
require_once "../modelos/clientes.php";
require_once "../modelos/Persona.php";
require_once "../modelos/usuario.php";

$cliente = new cliente();

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
		$telefono_cli    = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
		$correo_cli      = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
		$contraseña_usu  = isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
		$id_cliente     = isset($_POST["id_cliente"])? limpiarCadena($_POST["id_cliente"]):"";
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
				// para que realize la creacion del usuario y cliente
				$respta = 1;
			}else{
				// reportando el error en la creacion de la persona
				$respta = 0;
			}
			
		}
		if ($respta==1){
			$clavehash=hash("SHA256", $contraseña_usu);
			// verificamos si estamos editando o creando un cliente nuevo
			if (empty($id_cliente)) {
				// creacion de un nuevo usuario
				
				$id_usuario = $usuario->insertar($cedula_per,$clavehash,3);
				// verificamos que el usuario se halla creado
				if(!empty($id_usuario)){
					// creamos el cliente
					//sacamos el id de la sucursal almacenado en las variables de sesion

					$rspta=$cliente->insertar($correo_cli,$telefono_cli,$id_persona,$id_usuario );
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del cliente";
				}else{
					echo FALSE;
				}
				
			}else{
				echo $id_usuario;
				$clavehash=hash("SHA256", $contraseña_usu);
				$respta = $usuario->editar($id_usuario,$cedula_per,$clavehash);
				
				if($respta==1){
					$rspta=$cliente->editar($id_cliente,$correo_cli,$telefono_cli);
					echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
				}
				
			}
		}else{
			echo 'Hubo un error al registrar los datos de la persona.';
		}

	break;
	
	
	case 'mostrar':
		$id_cliente=isset($_POST["id_cliente"])? limpiarCadena($_POST["id_cliente"]):"";
		$rspta=$cliente->mostrar($id_cliente);
		// echo $rspta;
		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cliente->listar();
		$data=Array();

	while ($reg=$rspta->fetch_object()) {
		$data[]=array(
			"0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_cliente.')"><i class="fa fa-pencil"></i></button> <button class="btn btn-warning btn-xs" onclick="cuentas('.$reg->id_cliente.')"><i class="fa fa-table"></i></button>',
			"1"=>$reg->primer_ape_per." ".$reg->segundo_ape_per,
			"2"=>$reg->nombre_per,
			"3"=>$reg->cedula_per,
			"4"=>$reg->ciudad_resid_per
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

