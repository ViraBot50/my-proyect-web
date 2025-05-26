<?
session_start();
include "header.php";
include 'class/classContAcceso.php';
$oContAcceso->accion("login");
?>




<div class="card text-white bg-primary mb-3 border-success container separete-top" style="max-width: 50%;">
  <div class="card-header">Login</div>
  <div class="card-body bg-complete">
    
  <form method="POST">
    <div>
      <div class="row mt-4 col-6">
            <label class="form-label col-3">User</label>
            <div class="col-9">
                <input type="email" name='Email' class="form-control" id="exampleInputEmail1"  placeholder="Enter email" required>
            </div>
      </div> 

      <div class="row mt-4 col-6">
            <label class="form-label col-3">Password</label>
            <div class="col-9">
                <input id="password" type="password" name='Clave' class="form-control" id="exampleInputEmail1"  placeholder="Enter password" required>
            </div>
      </div>

      

      <button class="enviar">Enviar</button>
    </div>
</form>



  </div>
</div>





            
                  
    </body>
</html>