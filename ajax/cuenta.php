<?php 
require_once "../modelos/cuenta.php";
require_once "../modelos/clientes.php";

// verificar que se este logeado
if (strlen(session_id())<1) 
	session_start();

$cuenta = new cuenta();

$cliente = new cliente();

// $idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
// $idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
// $idusuario=$_SESSION["idusuario"];
// $tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
// $serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
// $num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
// $fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
// $impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
// $total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";





switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idventa)) {
		$rspta=$cuenta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]); 
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
        
	}
		break;
	

	case 'anular':
		$rspta=$cuenta->anular($idventa);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$cuenta->mostrar($idventa);
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		//recibimos el idventa
		$id=$_GET['id'];

		$rspta=$cuenta->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Articulo</th>
        <th>Cantidad</th>
        <th>Precio Venta</th>
        <th>Descuento</th>
        <th>Subtotal</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad.'</td>
			<td>'.$reg->precio_venta.'</td>
			<td>'.$reg->descuento.'</td>
			<td>'.$reg->subtotal.'</td></tr>';
			$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
		}
		echo '<tfoot>
         <th>TOTAL</th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th><h4 id="total">S/. '.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
       </tfoot>';
		break;

    case 'listar':

		// obtener el id del cliente enviado por post
		$id_cliente = isset($_POST["id_cliente"])? limpiarCadena($_POST["id_cliente"]):"";

		// en caso de que el cliente sea el que realiza la accion
		if(empty($id_cliente)){
			$rspta = $cliente->obtener_id($_SESSION['id_usuario']);
			$reg=$rspta->fetch_object();
			$id_cliente = $reg->id_cliente;
		}
		

		$rspta=$cuenta->listar_cuentas_cliente($id_cliente);
		$data=Array();
		// echo $rspta;
		while ($reg=$rspta->fetch_object()) {

			$data[]=array(
            "0"=>(($reg->estado_cta==1)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id_cta.')"><i class="fa fa-eye"></i></button>':''),
            "1"=>$reg->id_cta,
            "2"=>$reg->saldo_cta,
            "3"=>$reg->desc_mon,
            "4"=>$reg->fecha_creacion_cta,
            "5"=>$reg->num_mov_cuenta,
            "6"=>($reg->estado_cta==1)?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
            );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			// $rspta = $persona->listar();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
			}
			break;

		case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

				$rspta=$articulo->listarActivosVenta();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\','.$reg->precio_venta.')"><span class="fa fa-plus"></span></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>$reg->precio_venta,
            "6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
          
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