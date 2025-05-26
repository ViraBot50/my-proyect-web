<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';



$oClassAdmin=new classAdmin("usuario","SELECT 	Id,
												concat(Nombre,' ',primer_apellido,' ',segundo_apellido,'<br><small class=text-dark >',CASE WHEN Correo IS NULL THEN Telefonos ELSE Correo END,'</small>') as nombre,
												(SELECT rol from rol r where r.Id=Id_rol ) as rol,
												(CASE WHEN Fecha_nacimiento is null THEN '-----------------' else Fecha_nacimiento end) as Fecha_nacimiento,
												telefonos
												from usuario");


if (isset($_REQUEST['accion']))
	echo $oClassAdmin->accion($_REQUEST['accion']);
else
	echo $oClassAdmin->accion("list");



?>
<script src="../controllers/admin.js"></script>
<script >
 a_table="usuario";
 a_consulta = `SELECT Id, CONCAT(Nombre, ' ', primer_apellido, ' ', segundo_apellido, '<br><small class="text-dark">',CASE WHEN Correo IS NULL THEN Telefonos ELSE Correo END,'</small>') AS nombre,(SELECT rol FROM rol r WHERE r.Id = Id_rol) AS rol,(CASE WHEN Fecha_nacimiento IS NULL THEN '-----------------' ELSE Fecha_nacimiento END) AS Fecha_nacimiento,telefonos FROM usuario`;
</script>
<?



include "footer.php";

?>