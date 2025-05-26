<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';

$oClassAdmin=new classAdmin("producto","SELECT 	Id,
												Nombre,
												Costo_Compra,
												Precio_venta,
												Cantidad_disponible,
												Cantidad_minima,
												(SELECT abreviatura from catalogo_medidas c where p.Id_medida=c.Id) as unidad
												from producto p");


	echo $oClassAdmin->accion("list");


?>
<script src="../controllers/admin.js"></script>
<script >
 a_table="producto";
 a_consulta = `SELECT Id,Nombre,Costo_Compra,Precio_venta,Cantidad_disponible,Cantidad_minima,(SELECT abreviatura from catalogo_medidas c where p.Id_medida=c.Id) as unidad from producto p`;
</script>
<?



?>