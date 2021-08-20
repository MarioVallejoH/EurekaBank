<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if (!empty($_SESSION['rol'])) {

 ?>
    <div class="content-wrapper">
    <!-- Main cotntent -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Cuenta No. <?php echo $_GET['id_cta'] ?></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
      
    <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="">Moneda:</label>
      <input class="form-control" type="hidden" name="id_cta" id="id_cta" value ="<?php echo $_GET['id_cta'] ?> " >
      <select name="id_tipo_mon" id="id_tipo_mon" class="form-control selectpicker" data-live-search="true" required readonly>
        
      </select>

      <label for="">Saldo: </label>
      <input class="form-control" type="text" name="saldo_cta" id="saldo_cta" maxlength="7" placeholder="0" readonly>
    </div>
      <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="">Fecha de creación: </label>
      <input class="form-control" type="text" name="fecha_hora" id="fecha_hora" readonly>
    </div>
    <div class="form-group col-lg-4 col-md-4 col-xs-6">
      <label for="">Numero de movimientos: </label>
      <input class="form-control" type="text" name="num_mov_cuenta" id="num_mov_cuenta" maxlength="7" placeholder="0" readonly >
    </div>
    
    <div class="form-group col-lg-2 col-md-2 col-xs-6">
      
    </div>
    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <a data-toggle="modal" href="#myModal">
       <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Nuevo Movimiento</button>
     </a>
    </div>
<div class="form-group col-lg-12 col-md-12 col-xs-12">
     <table id="tblmovimientos" class="table table-striped table-bordered table-condensed table-hover">
       <thead style="background-color:#A9D0F5">
        <th>Numero</th>
        <th>Fecha de creación</th>
        <th>Tipo de movimiento</th>
        <th>Acción</th>
        <th>Importe</th>
        <th>Cuenta referencia</th>
        <th>Codigo Empleado</th>
        <th>Estado</th>
       </thead>
       <tfoot>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
       </tfoot>
       <tbody>
         
       </tbody>
     </table>
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

  <!--Modal-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 80% !important;">
      <div class="modal-content">
        <div class="modal-header">
        
        <h3 class="modal-title">Nuevo movimiento</h3>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="" name="formularioMov" id="formularioMov" method="POST">
            <div>
              <label for="">Tipo de movimiento:</label>
              <select name="id_tipo_mov" id="id_tipo_mov" class="form-control selectpicker" data-live-search="true" required readonly>
              
              </select>
            </div>
            <div>
              <label for="">Importe: </label>
              <input class="form-control" type="number" name="importe_mov" id="importe_mov" maxlength="7" placeholder="0">
            </div>
            <div>
              <label for="">Cuenta de referencia: </label>
              <input class="form-control" type="number" name="cuenta_ref" id="cuenta_ref" maxlength="7" placeholder="0">
            </div>
          </div>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button class="btn btn-primary" type="submit" id="btnGuardar" ><i class="fa fa-save"></i>  Guardar</button>
            <button class="btn btn-danger"  type="button" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/cuenta.js"></script>
 <?php 
}

ob_end_flush();
  ?>

