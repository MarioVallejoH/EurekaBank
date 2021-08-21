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
    <!DOCTYPE html>

    <div class="content-wrapper">
    <!-- Main content padding-->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">

        <!-- cargar fondo blanco al contenido -->
          <div class="box-body">

            <div class="">
            <div class="row justify-content-center">
            <p>
              
                <img src="../files/images/e-corp .png" style='width:100%;' border="0" alt="Null">
              
            </p>
              <div class="col-md-6 text-center mb-5">
                  <h2 class="heading-section">EurekaBank</h2>
                </div>
              </div>
              <!-- <div class="row justify-content-center">
              Creado en el año 2021 con la finalidad de brindar financiamiento especial 
              al sector agrícola del país, EurekaBank se ha convertido en la entidad financiera 
              líder en el sector debido a sus excelentes planes de financiación para campesinos 
              y empresas agrícolas. 
              </div> -->
            </div>

            </div>
      </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

</body>
</html>
  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 
 <?php 
}

ob_end_flush();
  ?>

