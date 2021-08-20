var tabla;

//funcion que se ejecuta al inicio
function init(){

	$("#formularioregistros").on("submit",function(e){
		guardaryeditar(e);
		$('#myModal').modal('toggle'); //or  $('#IDModal').modal('hide');
		return false;
	});
	mostrarform(false);
	listar();

	//cargamos los items al select tipo_mon
	$.post("../ajax/cuenta.php?op=selectTipoMon", function(r){
	// console.log(r);
	$("#id_tipo_mon").html(r);
	$('#id_tipo_mon').selectpicker('refresh');
});

}


// funcion para mostrar y ocultar el formulario
function mostrarform(flag){
	// limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

// para limpiar los datos en el formulario de creacion de cuentas
function limpiar(){


	$("#id_tipo_mon").val("");
	$('#id_tipo_mon').selectpicker('refresh');
	$("#importe_mov").val("");
	$("#sald_cta").val("");
	$("#clave_cta").val("");
}

function guardaryeditar(e){
	var id_cliente = document.getElementById("id_cli").value;
	e.preventDefault();//no se activara la accion predeterminada 
	$("#btnGuardar").prop("disabled",true);
	var formData=new FormData($("#formulario")[0]);
	// console.log(id_cliente);
	// console.log(formData);
	$.ajax({
		//mandamos el id de la cuenta por post
		url: "../ajax/cuenta.php?op=crearCuenta&id_cliente="+id_cliente,
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos){
		   console.log(datos);

			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		},
		error:function(e){
			console.log(e);
		}
	});

	limpiar();
}

//funcion listar
function listar(){
	// console.log('holis');
	var id_cliente = document.getElementById("id_cli").value;

	tabla=$('#tbllistado').dataTable({
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
			url:'../ajax/cuenta.php?op=listar&id_cliente='+id_cliente,
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


// mostrar informacion de la cuenta
function mostrar(id_cta){
	// enviamos el id de la cuenta para poder listar sus datos
	$(location).attr("href","cuenta.php?id_cta="+id_cta);
}


//funcion para desactivar
function anular(id_cta){
	// bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
	// 	if (result) {
	// 		$.post("../ajax/cuenta.php?op=anular", {id_cta : id_cta}, function(e){
	// 			bootbox.alert(e);
	// 			tabla.ajax.reload();
	// 		});
	// 	}
	// })
}

//funcion para activar
function activar(id_cta){
	// bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
	// 	if (result) {
	// 		$.post("../ajax/cuenta.php?op=anular", {id_cta : id_cta}, function(e){
	// 			bootbox.alert(e);
	// 			tabla.ajax.reload();
	// 		});
	// 	}
	// })
}



init();