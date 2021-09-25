var tabla;

//funcion que se ejecuta al inicio
function init(){

	
   
	// listener al evento submit del formulario de movimientos para luego realizar una accion
   $("#formularioMov").on("submit",function(e){
	   // funcion que procesa el formulario
		guardaryeditar(e);

		// cerramos el modal donde se encuentra el formulario de movimientos
		$('#myModal').modal('toggle'); //or  $('#IDModal').modal('hide');
		return false;
   });

   //cargamos los items al select tipo_mon
   $.post("../ajax/cuenta.php?op=selectTipoMon", function(r){
		// console.log(r);
		$("#id_tipo_mon").html(r);
		$('#id_tipo_mon').selectpicker('refresh');
	});

	//cargamos los items al select tipo_mov
	$.post("../ajax/cuenta.php?op=selectTipoMov", function(r){
		// console.log(r);
		$("#id_tipo_mov").html(r);
		$('#id_tipo_mov').selectpicker('refresh');
	});

	cargar_datos_cuenta();

}



// funcion con la que se procesan los datos obtenidos de el formulario formularioMov
function guardaryeditar(e){
	// obtenemos el id de la cuenta previamente cargado en un input tipe=hidden 
	var id_cta = document.getElementById("id_cta").value;
	e.preventDefault();//no se activara la accion predeterminada 
	// desabilitamos el boton guardar temporalmente
	$("#btnGuardar").prop("disabled",true);

	// obtenemos los datos de el formulario y los guardamos en una variable
	var formData=new FormData($("#formularioMov")[0]);
	// console.log(id_cta);
	// console.log(formData);

	// enviamos los datos con ajax para ser registrados en el modelo de movimientos
	$.ajax({
		//mandamos el id de la cuenta por post

		// notese que enviamos el id_cta por GET en la url del ajax
		url: "../ajax/cuenta.php?op=crearMovimiento&id_cta="+id_cta,
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos){
			 
		//console.log(datos);
			// notificamos al usuario del exito de la transaccion
			bootbox.alert(datos);

			// recargamos la tabla de movimientos para que se liste el nuevo movimiento
			tabla.ajax.reload();
		},
		// funcion que se ejecuta en caso de error
		error:function(e){
			console.log(e);
		}
	});

	limpiar();
}


//funcion limpiar que resetea los campos seleccionados en la vista
function limpiar(){

	$("#id_tipo_mov").val("");
	$("#importe_mov").val("");
	$("#cuenta_ref").val("");
}

//funcion mostrar formulario
function cargar_datos_cuenta(){

	// obtenemos el id_cta previamente cargado en un input type=hidden en la vista
	var id_cta = document.getElementById("id_cta").value;

	// usando post enviamos el id_cta para obtener los datos de la cuenta de una funcion usando ajax
	$.post("../ajax/cuenta.php?op=mostrar",{id_cta : id_cta},
		// si es exitosa la transaccionse se ejecuta esto
		function(data,status)
		{
			// pareamos los datos provenientes del ajax
			data=JSON.parse(data);
			// console.log(data);
			// mostrarform(true);

			// cargamos los datos optenidos directamente a cada elemento haciendo uso de su ID
			$("#id_tipo_mon").val(data.id_mon);
			$("#id_tipo_mon").selectpicker('refresh');
			$("#saldo_cta").val(data.saldo_cta);
			$("#num_mov_cuenta").val(data.num_mov_cuenta);
			$("#fecha_hora").val(data.fecha_creacion_cta);
			$("#clave_cta").val(data.clave_cta);

			// console.log(data.estado_cta);

			if(data.estado_cta==0){
				$("#btnAgregarArt").hide();
			}else{
				$("#btnAgregarArt").show();
				// console.log('here')
			}
			

		});
	// listamos los movimientos que tiene la cuenta
	listar_movimientos(id_cta);
}


//funcion que carga datos a la tabla tbllistado usando datatables con ajax
// documentacion https://datatables.net/examples/ajax/
function listar_movimientos(id_cta){

	// la tabla tblmovimientos es la tabla que tiene los movimientos de la cuenta
	tabla=$('#tblmovimientos').dataTable({
		// parametros opcionales para cargar la tabla
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		// seleccionamos los botones disponibles para cargar con la tabla,
		// el funcionamiento de los botones se encuentra en la documentacion
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			// solicitamos a ajax enviando por get la op=listarMovimientos que nos liste los registros
			// adicional enviamos el id_cta por GET
			url:'../ajax/cuenta.php?op=listarMovimientos&id_cta='+id_cta,
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar datos de mas reciente a menos reciente
	}).DataTable();
}


// funcion que se ejecuta al cargar el script
init();