<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';

$oClassAdmin=new classAdmin("salon","select * from salon");


if (isset($_REQUEST['accion']))
	echo $oClassAdmin->accion($_REQUEST['accion']);
else
	echo $oClassAdmin->accion("list");
?>
<script src="../controllers/admin.js"></script>
<script >
 a_table="salon";
 a_consulta = `select * from salon`;
</script>
<?
include "footer.php";




?>