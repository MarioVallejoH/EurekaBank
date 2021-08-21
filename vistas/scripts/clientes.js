var tabla;

//funcion que se ejecuta al inicio
function init(){
   //ocultamos el formulario
   mostrarform(false);
   listar();
   // listener de el formulario esperando la accion submit para luego ejecutar una funcion
   $("#formulario").on("submit",function(e){
	   // funcion a ejecutar
   		guardaryeditar(e);
   })

}

// mostrar informacion de la cuenta
function cuentas(id_cliente){
	// enviamos el id de la cuenta para poder listar sus datos
	$(location).attr("href","cliente_cuentas.php?id_cliente="+id_cliente);
}

//funcion limpiar, resetea los campos del formulario
function limpiar(){

	$("#id_usuario").val("");
	$("#nombre").val("");
	$("#primer_apellido").val("");
	$("#segundo_apellido").val("");
	$("#num_documento").val("");
	$("#ciudad").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#id_cliente").val("");
}

//funcion mostrar formulario
function mostrarform(flag){

	limpiar();

	// mostramos u ocultamos elementos de la vista en base a el booleano flag
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
	// ocultamos el formulario
	mostrarform(false);
}

//funcion listar que carga datos a la tabla tbllistado usando datatables con ajax
// documentacion https://datatables.net/examples/ajax/
function listar(){
	tabla=$('#tbllistado').dataTable({

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
			// solicitamos a cliente.php enviando por get la op=listar que nos liste los registros
			url:'../ajax/cliente.php?op=listar',
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

//funcion para guardaryeditar clientes
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 

	 // desabilitamos el boton guardar durante la transaccion
     $("#btnGuardar").prop("disabled",true);

	 //obtenemos los datos almacenados en el formulario con id
     var formData=new FormData($("#formulario")[0]);

	 // usando ajax enviamos el formulario para ser registrado
     $.ajax({
     	url: "../ajax/cliente.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,
		// funcion que se ejecuta en caso de exito al registrar el formulario
     	success: function(datos){
			console.log(datos);

     		bootbox.alert(datos);
     		mostrarform(false);
			 // recargamos la tabla para que sean visibles los registros
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(id_cliente){
	// llamamos una funcion de ajax y enviamos parametros por post
	$.post("../ajax/cliente.php?op=mostrar",{id_cliente : id_cliente},
		function(data,status)
		{
			// console.log(data);
			data=JSON.parse(data);
			// hacemos que se muestre el formulario
			mostrarform(true);
			// console.log(data.nombre);
			// precargamos datos pertenecientes al cliente en los campos de texto
			$("#nombre").val(data.nombre_per);
			$("#primer_apellido").val(data.primer_ape_per);
			$("#segundo_apellido").val(data.segundo_ape_per);
            $("#num_documento").val(data.cedula_per);
            $("#ciudad").val(data.ciudad_resid_per);
            $("#direccion").val(data.dir_resid_per);
            $("#telefono").val(data.telefono_cli);
            $("#email").val(data.correo_cli);
            $("#login").val(data.nombre_usu);
            $("#clave").val("");
            $("#id_cliente").val(data.id_cliente);
			$("#id_usuario").val(data.id_usuario);
		});
	
};


// IMPORTANTE estas dos funciones no se usan actualmente, pero podrian ser necesarias


//funcion para desactivar un cliente

function desactivar(id_cliente, id_usuario){
	// console.log(id_usuario);
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			// llamamos una funcion de ajax y enviamos parametros por post
	// llamamos una funcion de ajax y enviamos parametros por post
			$.post("../ajax/cliente.php?op=desactivar", {id_cliente : id_cliente,id_usuario : id_usuario}, function(e){
				// bootbox.alert(e);
				console.log(e);

				// recargamos la tabla para hacer efectivo en la vista el cambio hecho en la consulta
				tabla.ajax.reload();
			})
		}
	})
}
// funcion para activar un cliente
function activar(id_cliente,id_usuario){
	// llamamos una funcion de ajax y enviamos parametros por post
	$.post("../ajax/cliente.php?op=activar", {id_cliente : id_cliente,id_usuario : id_usuario}, function(e){
		// bootbox.alert(e);
		console.log(e);
		// recargamos la tabla para hacer efectivo en la vista el cambio hecho en la consulta
		
		tabla.ajax.reload();
	});
	
}


init();