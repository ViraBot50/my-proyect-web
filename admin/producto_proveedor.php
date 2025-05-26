<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';

$oClassAdmin=new classAdmin("producto_proveedor","SELECT Id,(SELECT p.Nombre from producto p where pp.Id_producto=p.Id) as producto,(SELECT pr.Proveedor from proveedor pr where pp.Id_proveedor=pr.Id) as proveedor from producto_proveedor pp");
echo $oClassAdmin->accion("list");

?>
<script src="../controllers/admin.js"></script>
<script >
 a_table="producto_proveedor";
 a_consulta = "SELECT Id,(SELECT p.Nombre from producto p where pp.Id_producto=p.Id) as producto,(SELECT pr.Proveedor from proveedor pr where pp.Id_proveedor=pr.Id) as proveedor from producto_proveedor pp";
</script>
<?
include "footer.php";



?>