<?php 
session_start();
require_once "../modelos/login.php";

$login =new login();


switch ($_GET["op"]) {

	case 'verificar':
        //validar si el empleado tiene acceso al sistema
        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];
        //Hash SHA256 en la contraseña
        $clavehash=hash("SHA256", $clavea);

        // echo $clavehash;
        
        // se hace uso de el modelo de login para verificarlo
        $rspta=$login->verificar($logina, $clavehash);
        
        // verificamos si la consulta fue exitosa
        $fetch=$rspta->fetch_object();
        if (isset($fetch)) {
        // 	# Declaramos la variables de sesion
            $_SESSION['id_usuario']=$fetch->id_usuario;
            $_SESSION['nombre']=$fetch->nombre_usu;
            $_SESSION['rol']=$fetch->rol;

        }

        // retornamos algo para reportar el login exitoso
        echo isset($fetch);


	break;
	case 'salir':
	   //limpiamos la variables de la secion
        session_unset();

        //destruimos la sesion
        session_destroy();
            //redireccionamos al login
        header("Location: ../index.php");
	break;
	
}
?>