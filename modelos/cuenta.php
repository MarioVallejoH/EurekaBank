<?php 
	//incluir la conexion de base de datos
	require "../config/Conexion.php";
	class Cuenta{


		//implementamos nuestro constructor
	public function __construct(){

	}

	//metodo insertar registro
	public function insertar($saldo_cta,$fecha_creacion_cta,$clave_cta,$id_mon,$id_empleado,$id_cliente,$id_sucursal){
		$sql="INSERT INTO cuentas (saldo_cta,fecha_creacion_cta,estado_cta,num_mov_cuenta,clave_cta,id_mon,id_empleado,
			id_cliente,id_sucursal) VALUES ('$saldo_cta','$fecha_creacion_cta','1','1','$clave_cta','$id_mon','$id_empleado',
			$id_cliente,'$id_sucursal')";
		// echo $sql;
		return ejecutarConsulta_retornarID($sql);;
	}

	public function desactivar($id_cta,$id_empleado){

		$date = date('Y-m-d h:i:s');
		

		$sql="INSERT INTO movimientos (importe_mov,cuenta_ref_mov,fecha_creacion_mov,id_empleado,id_cta,id_tipo_mov,
				estado_mov) VALUES ('0',NULL,'$date','$id_empleado','$id_cta',
				'2','1')";
		$id_mov = ejecutarConsulta_retornarID($sql);

		if(!empty($id_mov)){

			

			$sql="UPDATE cuentas SET estado_cta='0' WHERE id_cta='$id_cta'";
			// echo $sql;
			$rspta = ejecutarConsulta($sql);

			if ($rspta){
				return "Cuenta anulada correctamente";
			}else{

				$sql = "UPDATE movimientos m SET m.estado_mov='0' WHERE m.id_mov='$id_mov'";
				$rspta = ejecutarConsulta($sql);

				// echo $rspta?'Movimiento cancelado exitosamente':'Exito al cancelar el movimiento';

				return "No se pudo anular la cuenta";
			}
		}else{
			return "Error al registrar el movimiento.";
		}

	}

	// public function activar($id_cta, $id_empleado, $id_){
	// 	$sql="UPDATE cuentas SET estado_cta='1' WHERE id_cta='$id_cta'";
	// 	return ejecutarConsulta($sql);
	// }

	//funcion para obtener el saldo, tipo de moneda y num_mov_cuenta
	public function info($id_cta){
		$sql="SELECT saldo_cta,id_mon,num_mov_cuenta FROM cuentas WHERE id_cta='$id_cta'";
		return ejecutarConsulta($sql);
	}


	//implementar un metodo para mostrar los datos de unregistro a modificar
	public function mostrar($id_cta){
		$sql="SELECT c.id_cta,c.fecha_creacion_cta,c.saldo_cta,c.estado_cta,
		c.num_mov_cuenta,m.desc_mon,m.id_mon,c.clave_cta FROM cuentas c INNER JOIN tipo_moneda m ON m.id_mon=c.id_mon 
		WHERE c.id_cta='$id_cta'";
		// echo $sql;
		return ejecutarConsultaSimpleFila($sql);
	}

	//listar registros
	public function listar(){
		$sql="SELECT c.id_cta,c.fecha_creacion_cta,c.saldo_cta,c.estado_cta,c.num_mov_cuenta,
		m.desc_mon FROM cuentas c INNER JOIN tipo_moneda m ON m.id_mon=c.id_mon ORDER BY c.id_cta DESC";

		// echo $sql;

		return ejecutarConsulta($sql);
	}

	public function listar_cuentas_cliente($id_cliente){
		$sql="SELECT c.id_cta,c.fecha_creacion_cta,c.saldo_cta,c.estado_cta,
		c.num_mov_cuenta,m.desc_mon FROM cuentas c INNER JOIN tipo_moneda m ON m.id_mon=c.id_mon 
		WHERE c.id_cliente='$id_cliente' ORDER BY c.id_cta DESC";

		// echo $sql;

		return ejecutarConsulta($sql);
	}

	


	}

 ?>
