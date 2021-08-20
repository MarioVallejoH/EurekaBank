var tabla;

//funcion que se ejecuta al inicio
function init(){
   listar();

}

//funcion listar
function listar(){
	// console.log('holis');
	var id_cliente = document.getElementById("id_cli").value;
	// console.log('../ajax/cuenta.php?op=listar_cuentas_cliente&id_cliente='+id_cliente);
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