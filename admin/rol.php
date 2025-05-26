<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';
?>
<script src="../controllers/admin.js"></script>
<?

$oClassAdmin=new classAdmin();


if (isset($_REQUEST['accion']))
	echo $oClassAdmin->accion($_REQUEST['accion']);
else
	echo $oClassAdmin->accion("list");



include "footer.php";

?>