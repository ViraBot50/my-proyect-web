<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';

$oClassAdmin=new classAdmin("catalogo_medidas","select * from catalogo_medidas");
	echo $oClassAdmin->accion("list");


 ?>
<script src="../controllers/admin.js"></script>
<script >
 a_table="catalogo_medidas";
 a_consulta = `select * from catalogo_medidas`;
</script>
<?
include "footer.php";


?>