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
	$("#nombre").val("");
    $("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idusuario").val("");
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
			url:'../ajax/usuario.php?op=listar',
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
     	url: "../ajax/usuario.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(id_empleado){
	$.post("../ajax/usuario.php?op=mostrar",{id_empleado : id_empleado},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			console.log(data.nombre);
			$("#nombre").val(data.nombre);
			$("#primer_apellido").val(data.primer_apellido);
			$("#segundo_apellido").val(data.segundo_apellido);
            $("#num_documento").val(data.num_documento);
            $("#ciudad").val(data.ciudad);
            $("#direccion").val(data.direccion);
            $("#telefono").val(data.telefono_emp);
            $("#email").val(data.correo_emp);
            $("#login").val(data.nombre_usu);
            $("#clave").val("Digita una nueva contraseña");
            $("#id_empleado").val(data.id_empleado);
		});
	
};


//funcion para desactivar
function desactivar(id_empleado, id_usuario){
	// console.log(id_usuario);
	// bootbox.confirm("¿Esta seguro de desactivar este empleado?", function(result){
		// if (result) {
	$.post("../ajax/usuario.php?op=desactivar", {id_empleado : id_empleado,id_usuario : id_usuario}, function(e){
		// bootbox.alert(e);
		console.log(e);
		tabla.ajax.reload();
		// 	});
		// }
	})
}

function activar(id_empleado,id_usuario){
	// bootbox.confirm("¿Esta seguro de activar este empleado?" , function(result){
	// 	if (result) {
			$.post("../ajax/usuario.php?op=activar", {id_empleado : id_empleado,id_usuario : id_usuario}, function(e){
				// bootbox.alert(e);
				console.log(e);
				tabla.ajax.reload();
			});
	// 	}
	// })
}


init();