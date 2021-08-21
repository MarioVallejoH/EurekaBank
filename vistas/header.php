 <?php 
if (strlen(session_id())<1) 
  session_start();

  ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- definimos el titulo -->
  <title>EurekaBank | Inicio</title>
  <!-- definimos el icono -->
  <link rel="icon"  href="../favicon.ico"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->

  <link rel="stylesheet" href="../public/css/font-awesome.min.css">

  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <!-- Morris chart --><!-- Daterange picker -->
<!-- DATATABLES-->
<link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
<link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
<link rel="stylesheet" href="../public/css/bootstrap-select.min.css">

</head>
<body class="hold-transition skin-white sidebar-mini">
<div>

  <header class="main-header">
    <!-- Logo -->
    
    <!-- href basado en el rol de el usuario -->
    <a class="logo" href= 'home.php'>
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>E</b>B</span>
      
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Eureka</b>Bank</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">NAVEGACIÓM</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../files/images/Img.png" class="user-image" alt="User Image">
              <span><?php echo $_SESSION['nombre']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../files/images/Img.png" class="img-fluid" alt="User Image">
               
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                
                <div class="pull-right">
                  <a href="../ajax/login.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <br>
      
      
          <?php 
            if ($_SESSION['rol']==1) {
            echo '<li><a href="empleados.php"><i class="fa  fa-user (alias)"></i> <span>Empleados</span></a>
              </li>';
            }
          ?>
          <?php 
            if ($_SESSION['rol']==2) {
            echo '<li><a href="clientes.php"><i class="fa  fa-user (alias)"></i> <span>Clientes - Datos </span></a>
              </li>';
            }
          ?>

          <?php 
            if ($_SESSION['rol']==3) {
            echo '<li><a href="cliente_cuentas.php"><i class="fa  fa-table (alias)"></i> <span>Cuentas - Cliente </span></a>
              </li>';
            }
          ?>

        </br>
            
        
      </ul>
    </section>
  <!-- /.sidebar -->
</aside>