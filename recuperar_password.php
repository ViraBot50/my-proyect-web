<?
include "header.php";
include "class/classContAcceso.php";
echo $oContAcceso->accion("retrievePwd");
?>


<div class="card text-white bg-primary mb-3 border-success container separete-top" style="max-width: 50%;">
  <div class="card-header">Recuperar Contraseña</div>
  <div class="card-body bg-complete">
    
    <form method="POST">
    <div class="container">
      <div class="row mt-4 col-6">
            <label class="form-label col-3">Correo</label>
            <div class="col-9">
                <input type="email" name='Email' class="form-control" id="exampleInputEmail1"  placeholder="Enter correo">
            </div>
      </div> 

     <!-- <div class="row mt-4 col-6">
            <label class="form-label col-3">Captcha</label>
            <div class="col-9">
                <input type="text" name='Captcha' class="form-control" id="exampleInputEmail1"  placeholder="Enter captcha">
            </div>
      </div> 

     -->

      

      <button class="enviar">Enviar</button>
    </div>
</form>


  </div>
</div>









</body>
</html>