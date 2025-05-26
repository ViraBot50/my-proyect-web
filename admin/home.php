<?php
session_start();

if (isset($_SESSION['Id'])){
	if ($_SESSION['Rol']!=1) 
		header("location: ../index.php?m=2");
}
else
	header("location: ../index.php?m=1");

//$hi=var_dump($_SESSION);
//echo $hi;
//echo "<br>".$_SESSION['Nombre']." ".$_SESSION['Id'];

include 'header.php';




?>
<div class="container text-center">
    <img src="../imagenes/logo.png" width="50%"></a>
	</div>

</body>
</htmq>