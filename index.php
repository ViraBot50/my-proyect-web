<?php  

session_start();
session_destroy();
include './header.php';


if (isset($_GET['m']))

	switch ($_GET['m']) {
		case '1':
				echo "<h2 class='bg bg-warning'>No se logeo</h2>";
			break;

		case '2':
				echo "<h2 class='bg bg-danger'>No eres un administrador, tu intento quedo registrado en la base de datos</h2>";
		
		default:
		
			break;
	}

?>

	<div class="container text-center">
    <img src="imagenes/logo.png" width="50%"></a>
	</div>


	</body>
</html>
