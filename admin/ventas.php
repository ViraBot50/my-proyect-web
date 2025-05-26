<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdminUD.php';

$oClassAdmin=new classAdmin("ventas","SELECT 	Id,
												(SELECT concat(Nombre,' ',primer_apellido,'<br><small class=text-dark >',Correo,'</small>') from usuario u where v.Id_vendedor=u.Id) as Vendedor,
												(SELECT Nombre from Producto p where v.Id_producto=p.Id) as Producto,
												precio_venta,
												fecha_venta,
												cantidad
												from ventas v");


if (isset($_REQUEST['accion']))
	echo $oClassAdmin->accion($_REQUEST['accion']);
else
	echo $oClassAdmin->accion("list");


?>
<script src="../controllers/adminUD.js"></script>
<script >
 a_table="ventas";
 a_consulta = `SELECT Id,(SELECT concat(Nombre,' ',primer_apellido,'<br><small class=text-dark >',Correo,'</small>') from usuario u where v.Id_vendedor=u.Id) as Vendedor,(SELECT Nombre from Producto p where v.Id_producto=p.Id) as Producto,precio_venta,fecha_venta,cantidad from ventas v`;

</script>
<?
include "footer.php";


?>