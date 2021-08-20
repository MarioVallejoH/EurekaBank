var tabla;

//funcion que se ejecuta al inicio
function init(){


   

   $("#formularioMov").on("submit",function(e){
		guardaryeditar(e);
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




function guardaryeditar(e){
	var id_cta = document.getElementById("id_cta").value;
	e.preventDefault();//no se activara la accion predeterminada 
	$("#btnGuardar").prop("disabled",true);
	var formData=new FormData($("#formularioMov")[0]);
	// console.log(id_cta);
	// console.log(formData);
	$.ajax({
		//mandamos el id de la cuenta por post
		url: "../ajax/cuenta.php?op=crearMovimiento&id_cta="+id_cta,
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos){
		   console.log(datos);

			bootbox.alert(datos);
			// mostrarform(false);
			tabla.ajax.reload();
		},
		error:function(e){
			console.log(e);
		}
	});

	limpiar();
}


//funcion limpiar
function limpiar(){

	$("#id_tipo_mov").val("");
	$("#importe_mov").val("");
	$("#cuenta_ref").val("");
}

//funcion mostrar formulario
function cargar_datos_cuenta(){
	var id_cta = document.getElementById("id_cta").value;
	// console.log('holis');
	// console.log(id_cta);
	$.post("../ajax/cuenta.php?op=mostrar",{id_cta : id_cta},
		function(data,status)
		{
			data=JSON.parse(data);
			// console.log(data);
			// mostrarform(true);

			$("#id_tipo_mon").val(data.id_mon);
			$("#id_tipo_mon").selectpicker('refresh');
			$("#saldo_cta").val(data.saldo_cta);
			$("#num_mov_cuenta").val(data.num_mov_cuenta);
			$("#fecha_hora").val(data.fecha_creacion_cta);
			$("#clave_cta").val(data.clave_cta);

		});
	// $.post("../ajax/venta.php?op=listarDetalle&id="+id_cta,function(r){
	// 	$("#detalles").html(r);
	// });
	
	//listamos los movimientos de la cuenta

	listar_movimientos(id_cta);
}



//funcion listar movimientos de la cuenta
function listar_movimientos(id_cta){
	// console.log('holis');
	tabla=$('#tblmovimientos').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/cuenta.php?op=listarMovimientos&id_cta='+id_cta,
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}



init();