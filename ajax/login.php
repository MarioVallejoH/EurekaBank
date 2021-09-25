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
        // echo($rspta);

        if (!is_string($rspta)){
            // echo $rspta;
            // verificamos si la consulta fue exitosa
            $fetch=$rspta->fetch_object();
            if (isset($fetch)) {
            // 	# Declaramos la variables de sesion
                $_SESSION['id_usuario']=$fetch->id_usuario;
                $_SESSION['nombre']=$fetch->nombre_usu;
                $_SESSION['rol']=$fetch->rol;

                // basados en el rol, preguntamos por los nombres de el usuario
                
                if($_SESSION['rol']==1){
                    // usamos el modelo de sucursal para obtener el nombre de la sucursal
                    require_once "../modelos/sucursales.php";
                    $suc = new sucursal();
                    $rspta=$suc->info($_SESSION['id_usuario']);
                    $reg=$rspta->fetch_object();
                    //verificamos exito en la consulta
                    if (isset($reg)){
                        // asignamos el nombre a la variable de sesion nombre
                        $_SESSION['nombre']=$reg->nombre_sucur;
                    }
                    // echo $_SESSION['nombre'];

                }elseif($_SESSION['rol']==2){
                    
                    // usamos el modelo de empleado para obtener sus nombres y apellidos
                    require_once "../modelos/empleado.php";
                    $emp = new empleado();
                    $rspta=$emp->info($_SESSION['id_usuario']);
                    $reg=$rspta->fetch_object();
                    //verificamos exito en la consulta
                    if (isset($reg)){
                        // asignamos el nombre a la variable de sesion nombre
                        $_SESSION['nombre']=$reg->nombre_per.' '.$reg->primer_ape_per.' '.$reg->segundo_ape_per;
                    }
                    // echo $_SESSION['nombre'];
                }
                // elseif($_SESSION['rol']==3){
                    // usamos el modelo de cliente para obtener sus nombres y apellidos
                    // require_once "../modelos/clientes.php";
                    // $cli = new cliente();
                    // $rspta=$cli->info($_SESSION['id_usuario']);
                    // $reg=$rspta->fetch_object();
                    // verificamos exito en la consulta
                    // if (isset($reg)){
                        // asignamos el nombre a la variable de sesion nombre
                        // $_SESSION['nombre']=$reg->nombre_per.' '.$reg->primer_ape_per.' '.$reg->segundo_ape_per;
                    // }
                // }
                // retornamos algo para reportar el login exitoso
                echo 'Exito';
                
            }else{
                echo "Error el fetch_object()";
            }

            
        }else{
            echo $rspta;
        }
        


	break;
	case 'salir':
	   //limpiamos la variables de la secion
        session_unset();

        //destruimos la sesion
        session_destroy();
        mysqli_close($conexion);
            //redireccionamos al login
        header("Location: ../index.php");
	break;
	
}
?>