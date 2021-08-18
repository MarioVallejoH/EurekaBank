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
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Empleados <button class="btn btn-primary" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opciones</th>
      <th>Apellidos</th>
      <th>Nombre</th>
      <th>Numero Documento</th>
      <th>Ciudad</th>
      <th>Fecha de creación</th>
      <th>Sucursal</th>
      <th>Estado</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Apellidos</th>
      <th>Nombre</th>
      
      <th>Numero Documento</th>
      <th>Ciudad</th>
      <th>Fecha de creación</th>
      <th>Sucursal</th>
      <th>Estado</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre(*):</label>
      <input class="form-control" type="hidden" name="id_empleado" id="id_empleado">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
      <input class="form-control" type="text" name="primer_apellido" id="primer_apellido" maxlength="30" placeholder="Primer apellido" required>
      <input class="form-control" type="text" name="segundo_apellido" id="segundo_apellido" maxlength="30" placeholder="Segundo apellido" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Numero de Documento(*): </label>
      <input type="text" class="form-control" name="num_documento" id="num_documento" placeholder="Documento" maxlength="20">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Ciudad(*): </label>
      <input class="form-control" type="text" name="ciudad" id="ciudad"  maxlength="30">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Dirección(*): </label>
      <input class="form-control" type="text" name="direccion" id="direccion"  maxlength="70">
    </div>
       <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Telefono(*): </label>
      <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Número de telefono">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Email(*): </label>
      <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="email">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Login(*):</label>
      <input class="form-control" type="text" name="login" id="login" maxlength="30" placeholder="nombre de usuario" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Contraseña(*):</label>
      <input class="form-control" type="text" name="clave" id="clave" maxlength="100" placeholder="Clave">
    </div>
    
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
  </form>
</div>
<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php';
 ?>
 <script src="scripts/empleados.js"></script>
 <?php 
}

ob_end_flush();
  ?>
