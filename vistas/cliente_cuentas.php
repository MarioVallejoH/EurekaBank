<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['rol']==3 OR $_SESSION['rol']==2) {

  ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Cuentas </h1>
            <div class="box-tools pull-right">
          
            </div>
          </div>
          <!--box-header-->
          <!--centro-->
          <div class="panel-body table-responsive" id="listadoregistros">
          <input class="form-control" type="hidden" name="id_cli" id="id_cli" value ="<?php echo $_GET['id_cliente'] ?> " >
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Número</th>
                <th>Saldo</th>
                <th>Moneda</th>
                <th>Fecha de creación</th>
                <th>Numero de movimientos</th>
                <th>Estado</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
              <th>Opciones</th>
                <th>Número</th>
                <th>Saldo</th>
                <th>Moneda</th>
                <th>Fecha de creación</th>
                <th>Numero de movimientos</th>
                <th>Estado</th>
              </tfoot>   
            </table>
          </div>

<!--fin centro-->
        </div>
      </div>
    </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/cliente_cuenta.js"></script>
 <?php 
}

ob_end_flush();
  ?>

