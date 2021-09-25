
// listener de el formulario esperando la accion submit para luego ejecutar una funcion
$("#frmAcceso").on('submit', function(e)
{
    // console.log('hola');
    // se previene la accion por defecto del formulario
	e.preventDefault();
    // sacamos las variables del html haciendo uso del id asignado
	logina=$("#logina").val();
	clavea=$("#clavea").val();

    // se envian por post los datos a ajax con una op=verificar
	$.post("../ajax/login.php?op=verificar",
        // datos a enviar
        {"logina":logina, "clavea":clavea},
        function(data)
        {
            // verificamos que la respuesta de la verificacion sea exitosa
            // console.log(data);
           if (data=="Exito")
            {
                //login exitoso
            
                console.log(data);
                // redirigimos a la vista home.php
                
            	$(location).attr("href","home.php");
            }else{

                // datos incorrectos
                console.log(data);
                
            	bootbox.alert("Usuario y/o Password incorrectos");
            }
        });
})