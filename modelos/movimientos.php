<?php 
	//incluir la conexion de base de datos
	require "../config/Conexion.php";
	class Movimientos{


		//implementamos nuestro constructor
	public function __construct(){

	}

	//metodo insertar registro
	public function insertar($importe_mov,$cuenta_ref_mov,$fecha_creacion_mov,$id_empleado,$id_cta,$id_tipo_mov){

		// verificamos si existe cuenta de ref y si el tipo de mov la requiere
		// echo $id_tipo_mov;
		if($id_tipo_mov=='6' AND $cuenta_ref_mov!=''){
			
			$sql="INSERT INTO movimientos (importe_mov,cuenta_ref_mov,fecha_creacion_mov,id_empleado,id_cta,id_tipo_mov,
				estado_mov) VALUES ('$importe_mov','$cuenta_ref_mov','$fecha_creacion_mov','$id_empleado','$id_cta',
				'$id_tipo_mov','1')";
			$id_mov = ejecutarConsulta_retornarID($sql);
			// verificamos el exito del registro
			if(!empty($id_mov)){

				// actualizamos el saldo de la cuenta
				$sql = "UPDATE cuentas c SET saldo_cta = c.saldo_cta-'$importe_mov',c.num_mov_cuenta=c.num_mov_cuenta+'1' WHERE c.id_cta='$id_cta'";
				// echo $sql;
				// verificamos el exito de la consulta
				if(ejecutarConsulta($sql)){
					// sumamos el saldo quitado a la nueva cuenta
					$sql = "UPDATE cuentas c SET c.saldo_cta = c.saldo_cta+'$importe_mov' WHERE c.id_cta='$cuenta_ref_mov'";
					// echo $sql;
					$resp = ejecutarConsulta($sql);
					if($resp){
						echo $resp;
					}else{

						// devolvemos el saldo quitado
						$sql = "UPDATE cuentas c SET c.saldo_cta = c.saldo_cta+'$importe_mov',c.num_mov_cuenta=c.num_mov_cuenta-'1' WHERE c.id_cta='$id_cta'";
						// echo $sql;

						if(ejecutarConsulta($sql)){

							// cancelamos el movimiento
							$sql = "UPDATE movimientos m SET m.estado_mov='0' WHERE m.id_mov='$id_mov'";
							$rspta = ejecutarConsulta($sql);

							echo $rspta?'Movimiento cancelado exitosamente':'Exito al cancelar el movimiento';
						}else{
							echo 'Error al devolver el saldo a su estado inicial';
						}

						
					}
					
				}else{
					// cancelamos el movimiento 
					$sql = "UPDATE movimientos m SET m.estado_mov='0' WHERE m.id_mov='$id_mov'";
					$rspta = ejecutarConsulta($sql);

					echo $rspta?'Movimiento cancelado exitosamente':'Exito al cancelar el movimiento';
				}
			}else{
				// echo $sql;
				echo "Error al registrar el movimiento";
			}
		}else{
			$sql="INSERT INTO movimientos (importe_mov,cuenta_ref_mov,fecha_creacion_mov,id_empleado,id_cta,id_tipo_mov,
				estado_mov) VALUES ('$importe_mov',NULL,'$fecha_creacion_mov','$id_empleado','$id_cta',
				'$id_tipo_mov','1')";
			$id_mov = ejecutarConsulta_retornarID($sql);

			
			// verificamos el exito de el registro
			if(!empty($id_mov)){

				// verificamos el tipo de movimiento (ingreso)
				if($id_tipo_mov==1 OR $id_tipo_mov==3){
					
					$sql = "UPDATE cuentas c SET saldo_cta = c.saldo_cta+'$importe_mov',c.num_mov_cuenta=c.num_mov_cuenta+'1' WHERE c.id_cta='$id_cta'";
					// verificamos el exito de la consulta
					$resp = ejecutarConsulta($sql);
					// echo $sql;
					// echo $resp;
					if($resp){
						
						echo $resp;

					}else{
						// cancelamos el movimiento 
						$sql = "UPDATE movimientos m SET m.estado_mov='0' WHERE m.id_mov='$id_mov'";
						$rspta = ejecutarConsulta($sql);

						echo $rspta?'Movimiento cancelado exitosamente':'Exito al cancelar el movimiento';
					}

				// salida
				}else{
					$sql = "UPDATE cuentas c SET saldo_cta = c.saldo_cta-'$importe_mov',c.num_mov_cuenta=c.num_mov_cuenta+'1' WHERE c.id_cta='$id_cta'";
					// echo $sql;
					$resp = ejecutarConsulta($sql);
					// echo $resp;
					// verificamos el exito de la consulta
					if($resp){
						
						echo $resp;

					}else{
						// cancelamos el movimiento 
						$sql = "UPDATE movimientos m SET m.estado_mov='0' WHERE m.id_mov='$id_mov'";
						$rspta = ejecutarConsulta($sql);

						echo $rspta?'Movimiento cancelado exitosamente':'Exito al cancelar el movimiento';
					}
				}
				
				
			}else{
				// echo $id_mov;
				
				echo " Error al registrar el movimiento ";
			}
		}
	}

	public function iFT($importe_mov,$fecha_creacion_mov,$id_empleado,$id_cta){
		$sql="INSERT INTO movimientos (importe_mov,cuenta_ref_mov,fecha_creacion_mov,id_empleado,id_cta,id_tipo_mov,
			estado_mov) VALUES ('$importe_mov',NULL,'$fecha_creacion_mov','$id_empleado','$id_cta',
			'8','1')";
		$id_mov = ejecutarConsulta_retornarID($sql);

		
		// verificamos el exito de el registro
		if(!empty($id_mov)){

				// el IFT no cuenta como movimiento, asi que no lo sumamos
				$sql = "UPDATE cuentas c SET saldo_cta = c.saldo_cta-'$importe_mov' WHERE c.id_cta='$id_cta'";
				// echo $sql;
				$resp = ejecutarConsulta($sql);
				// echo $resp;
				// verificamos el exito de la consulta
				if($resp){
					
					echo $resp;

				}else{

					$sql = "UPDATE movimientos m SET m.estado_mov='0' WHERE m.id_mov='$id_mov'";
					$rspta = ejecutarConsulta($sql);

					echo $rspta?' Movimiento cancelado exitosamente ':' Exito al cancelar el movimiento ';
				
				}
			// actualizamos el saldo de la cuenta
			
		}else{
			// echo $id_mov;
			
			echo "Error al registrar el movimiento";
		}
		
	

		// echo $sql;
		//return ejecutarConsulta($sql);
		return ejecutarConsulta($sql);
	}


	//listar registros

	public function listarMovimentos($id_cta){
		$sql="SELECT m.id_mov,m.fecha_creacion_mov,m.importe_mov,m.cuenta_ref_mov,m.estado_mov,t.nombre_mov,t.accion_tipo_mov,e.id_empleado
		FROM movimientos m INNER JOIN tipo_movimiento t ON t.id_tipo_mov=m.id_tipo_mov INNER JOIN empleados e 
		ON e.id_empleado=m.id_empleado WHERE m.id_cta='$id_cta'";
		// echo $sql;
		return ejecutarConsulta($sql);
	}

	// obtener info de valores de IFT
	public function info_IFT($id_mon){
		$sql="SELECT valor FROM costos WHERE id_mon='$id_mon'";
		// echo $sql;
		return ejecutarConsulta($sql);
	}


	}

 ?>
