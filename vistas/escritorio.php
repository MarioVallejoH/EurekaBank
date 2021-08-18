<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';

if ($_SESSION['rol']==1) {

 ?>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 
}

ob_end_flush();
  ?>

