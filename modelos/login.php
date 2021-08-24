<?php 
    //incluir la conexion de base de datos
    require "../config/Conexion.php";
    class Login{


        //implementamos nuestro constructor
        public function __construct(){

        }

        //funcion que verifica el acceso al sistema

        public function verificar($login,$clave){

            $sql="SELECT id_usuario,nombre_usu,id_rol AS rol  FROM usuarios WHERE nombre_usu='$login' AND contraseña_usu='$clave' AND estado='1'";
            return ejecutarConsulta($sql);

        }
    }

?>
