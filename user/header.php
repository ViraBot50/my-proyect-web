<?php  
if (session_status() === PHP_SESSION_NONE) 
  session_start();

if (isset($_SESSION['Id'])){
  
    if ($_SESSION['Rol']>2) 
      header("location: ../index.php?m=2");
}
else
  header("location: ../index.php?m=1");


?>





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/customise.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootswatch CSS (tema United) -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/united/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (con Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" media="screen" 
    href="../styles/jquery-confirm.css">

    <script src="../js/jquery-3.7.1.js"></script>


    <script src="../js/jquery-confirm.js"></script>


}

    <style>
@import url('https://fonts.googleapis.com/css2?family=Anton&family=Bungee+Tint&family=Gravitas+One&family=Oleo+Script:wght@400;700&family=Sigmar&display=swap');


@import url('https://fonts.googleapis.com/css2?family=Gravitas+One&display=swap');




  </style>


    <title>Index</title>
</head>
<body class="bg-secondary full-height-body">
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="home.php"><img src="../imagenes/logo.png" width="75em"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="home.php">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../index.php">Cerrar</a>
        </li>
        <? if ($_SESSION['Rol']==1){?>

                  <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuarios</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="../admin/rol.php">rol</a>
            <a class="dropdown-item" href="../admin/usuario.php">Usuarios</a>
          </div>
        </li>       



        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Productos/Ventas</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="../admin/catalogo_medidas.php">catalogo_medidas</a>
            <a class="dropdown-item" href="../admin/proveedor.php">Proveedor</a>
            <a class="dropdown-item" href="../admin/producto.php">producto</a>
            <a class="dropdown-item" href="../admin/producto_proveedor.php">Asignar proveedores a productos</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../admin/ventas.php">Ventas</a>
          </div>
        </li>

        

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Rentas/encargos</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="../admin/estatus.php">estatus</a>
            <a class="dropdown-item" href="../admin/salon.php">salon</a>
            <a class="dropdown-item" href="../admin/renta.php">renta</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../admin/encargos.php">Encargos</a>
          </div>
        </li>
      
        <?}?>  


        <li class="nav-item">
          <a class="nav-link" href="vender.php">Vender</a>
          </li>

          <li class="nav-item">
          <a class="nav-link" href="rentar.php">Rentar</a>
          </li>

          <li class="nav-item">
          <a class="nav-link" href="geneEncargo.php">Encargar</a>
          </li>
       
      </ul>
    </div>
      <span class="nav-item sigmar-regular">
        <a href="" class="">
        <i class="fa fa-pencil text-white"></i>
        </a>
        <?=$_SESSION['Nombre']." ".$_SESSION["Apellidos"]; ?>
        
      </span>
  </div>
</nav>





