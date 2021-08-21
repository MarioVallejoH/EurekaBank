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
            <!-- cargamos el boton agrega en funcion al tipo de usuario logeado (solo empleados) -->
            <h1 class="box-title">Cuentas   <?php echo $_SESSION['rol']==2?'<button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>':''?></h1>
            <div class="box-tools pull-right">
          
            </div>
          </div>
          <!--box-header-->
          <!--centro-->
          
          <div class="panel-body table-responsive" id="listadoregistros">
          <input class="form-control" type="hidden" name="id_cli" id="id_cli" value ="<?php echo empty($_GET['id_cliente'])?'':$_GET['id_cliente'] ?> " >
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
            </table>
          </div>
          <?php 
              if($_SESSION['rol']==2){
                echo '
                <div class="panel-body" style="height: 400px;" id="formularioregistros">
                  <form action="" name="formulario" id="formulario" method="POST">
                      
                    <div class="form-group col-lg-4 col-md-4 col-xs-12">
                      <label for="">Moneda:</label>
                      <select name="id_tipo_mon" id="id_tipo_mon" class="form-control form-select" data-live-search="true" required >
                        <option selected>Seleccione un tipo de moneda</option>
                      </select>

                      <label for="">Saldo: </label>
                      <input class="form-control" type="text" name="saldo_cta" id="saldo_cta" maxlength="7" placeholder="0" >
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-xs-12">
                      <label for="">Clave: </label>
                      <input class="form-control" type="text" name="clave_cta" id="clave_cta" maxlength="4" placeholder="1234"  required >
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
                      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                  </form>
                </div>';
              }
          
          ?>

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

