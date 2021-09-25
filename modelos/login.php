<?php 
    //incluir la conexion de base de datos
    require "../config/Conexion.php";
    class Login{


        //implementamos nuestro constructor
        public function __construct(){

        }

        //funcion que verifica el acceso al sistema

        public function verificar($login,$clave){

            # last AND condition is for restrict Client login
            $sql="SELECT id_usuario,nombre_usu,id_rol AS rol  FROM usuarios WHERE nombre_usu='$login' AND contraseña_usu='$clave' AND estado='1' AND id_rol<>'3'";
            $rspta = ejecutarConsulta($sql);

            // return $sql;
            if(!empty($rspta)){
                if(mysqli_num_rows($rspta)!=0){
                    return $rspta;
                }else{
                    return "No se encontraron usuarios";
                }
                // return $rspta;
            }else{
                return 'Error en la consulta: '.$sql;
            }
            

        }
    }

?>
