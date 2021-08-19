var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })

   $("#imagenmuestra").hide();

}

//funcion limpiar
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

//funcion listar
function listar(){
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
			url:'../ajax/cliente.php?op=listar',
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
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/cliente.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
			console.log(datos);

     		// bootbox.alert(datos);
     		mostrarform(false);
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
            $("#clave").val("Digita una nueva contraseña");
            $("#id_cliente").val(data.id_cliente);
			$("#id_usuario").val(data.id_usuario);
		});
	
};


//funcion para desactivar

function desactivar(id_cliente, id_usuario){
	// console.log(id_usuario);
	
	// llamamos una funcion de ajax y enviamos parametros por post
	$.post("../ajax/cliente.php?op=desactivar", {id_cliente : id_cliente,id_usuario : id_usuario}, function(e){
		// bootbox.alert(e);
		console.log(e);
		tabla.ajax.reload();
	})
}

function activar(id_cliente,id_usuario){
	// llamamos una funcion de ajax y enviamos parametros por post
	$.post("../ajax/cliente.php?op=activar", {id_cliente : id_cliente,id_usuario : id_usuario}, function(e){
		// bootbox.alert(e);
		console.log(e);
		tabla.ajax.reload();
	});
	
}


init();