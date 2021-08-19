$("#frmAcceso").on('submit', function(e)
{
    // console.log('hola');
	e.preventDefault();
	logina=$("#logina").val();
	clavea=$("#clavea").val();
    
	$.post("../ajax/login.php?op=verificar",
        {"logina":logina, "clavea":clavea},
        function(data)
        {
           if (data!="null")
            {
                // bootbox.alert("Usuario y/o Password incorrectos");
            
                console.log(data);
            	$(location).attr("href","empleados.php");
            }else{
            	bootbox.alert("Usuario y/o Password incorrectos");
            }
        });
})