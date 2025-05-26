<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdminUD.php';

$oClassAdmin=new classAdmin("encargos","SELECT 	concat(Id_renta,Id_producto) as Id,
												(SELECT concat((SELECT concat(Nombre,' ',primer_apellido) from usuario u where r.id_usuario=u.Id),'<br><small class=text-dark >',Fecha_evento,'</small>') from renta r where 
													e.Id_renta=r.Id) as renta,
												(SELECT Nombre from producto p where e.Id_producto=p.Id) as producto,
												Cantidad,
												precio_venta
												from encargos e");


	echo $oClassAdmin->accion("list");


?>
<script src="../controllers/adminUD.js"></script>
<script >
 a_table="encargos";
 a_consulta = `SELECT concat(Id_renta,Id_producto) as Id,(SELECT concat((SELECT concat(Nombre,' ',primer_apellido) from usuario u where r.id_usuario=u.Id),'<br><small class=text-dark>',Fecha_evento,'</small>') from renta r where e.Id_renta=r.Id) as renta,(SELECT Nombre from producto p where e.Id_producto=p.Id) as producto,Cantidad,precio_venta from encargos e`;

</script>
<?
include "footer.php";


?>