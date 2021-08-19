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
		$id_cuentanew=ejecutarConsulta_retornarID($sql);
		$num_elementos=0;
		$sw=true;
		while ($num_elementos < count($idarticulo)) {

			$sql_detalle="INSERT INTO detalle_cuenta (id_cuenta,idarticulo,cantidad,precio_cuenta,descuento) VALUES('$id_cuentanew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_cuenta[$num_elementos]','$descuento[$num_elementos]')";

			ejecutarConsulta($sql_detalle) or $sw=false;

			$num_elementos=$num_elementos+1;
		}
		return $sw;
	}

	public function anular($id_cuenta){
		$sql="UPDATE cuenta SET estado='Anulado' WHERE id_cuenta='$id_cuenta'";
		return ejecutarConsulta($sql);
	}


	//implementar un metodopara mostrar los datos de unregistro a modificar
	public function mostrar($id_cuenta){
		$sql="SELECT v.id_cta,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_cuenta,v.impuesto,v.estado FROM cuenta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE id_cuenta='$id_cuenta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($id_cuenta){
		$sql="SELECT dv.id_cuenta,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_cuenta,dv.descuento,(dv.cantidad*dv.precio_cuenta-dv.descuento) as subtotal FROM detalle_cuenta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE dv.id_cuenta='$id_cuenta'";
		return ejecutarConsulta($sql);
	}

	//listar registros
	public function listar(){
		$sql="SELECT c.id_cta,DATE(c.fecha_creacion_cta) as fecha_creacion_cta,c.saldo_cta,c.estado_cta,c.num_mov_cuenta,
		m.desc_mon FROM cuentas c INNER JOIN tipo_moneda m ON m.id_mon=c.id_mon ORDER BY c.id_cta DESC";

		// echo $sql;

		return ejecutarConsulta($sql);
	}

	public function listar_cuentas_cliente($id_cliente){
		$sql="SELECT c.id_cta,DATE(c.fecha_creacion_cta) as fecha_creacion_cta,c.saldo_cta,c.estado_cta,
		c.num_mov_cuenta,m.desc_mon FROM cuentas c INNER JOIN tipo_moneda m ON m.id_mon=c.id_mon 
		WHERE c.id_cliente='$id_cliente' ORDER BY c.id_cta DESC";

		// echo $sql;

		return ejecutarConsulta($sql);
	}


	public function cuentacabecera($id_cuenta){
		$sql= "SELECT v.id_cuenta, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.impuesto, v.total_cuenta FROM cuenta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.id_cuenta='$id_cuenta'";
		return ejecutarConsulta($sql);
	}

	public function cuentadetalles($id_cuenta){
		$sql="SELECT a.nombre AS articulo, a.codigo, d.cantidad, d.precio_cuenta, d.descuento, (d.cantidad*d.precio_cuenta-d.descuento) AS subtotal FROM detalle_cuenta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.id_cuenta='$id_cuenta'";
			return ejecutarConsulta($sql);
	}


	}

 ?>
