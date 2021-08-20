<?php 
	//incluir la conexion de base de datos
	require "../config/Conexion.php";
	class Cuenta{


		//implementamos nuestro constructor
	public function __construct(){

	}

	//metodo insertar registro
	public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_cuenta,$idarticulo,$cantidad,$precio_cuenta,$descuento){
		$sql="INSERT INTO cuentas (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_cuenta,estado) VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_cuenta','Aceptado')";
		//return ejecutarConsulta($sql);
		$id_ctanew=ejecutarConsulta_retornarID($sql);
		$num_elementos=0;
		$sw=true;
		while ($num_elementos < count($idarticulo)) {

			$sql_detalle="INSERT INTO detalle_cuenta (id_cta,idarticulo,cantidad,precio_cuenta,descuento) VALUES('$id_ctanew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_cuenta[$num_elementos]','$descuento[$num_elementos]')";

			ejecutarConsulta($sql_detalle) or $sw=false;

			$num_elementos=$num_elementos+1;
		}
		return $sw;
	}

	public function anular($id_cta){
		$sql="UPDATE cuenta SET estado='Anulado' WHERE id_cta='$id_cta'";
		return ejecutarConsulta($sql);
	}


	public function saldo($id_cta){
		$sql="SELECT saldo_cta FROM cuentas WHERE id_cta='$id_cta'";
		return ejecutarConsulta($sql);
	}


	//implementar un metodo para mostrar los datos de unregistro a modificar
	public function mostrar($id_cta){
		$sql="SELECT c.id_cta,c.fecha_creacion_cta,c.saldo_cta,c.estado_cta,
		c.num_mov_cuenta,m.desc_mon,m.id_mon FROM cuentas c INNER JOIN tipo_moneda m ON m.id_mon=c.id_mon 
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
