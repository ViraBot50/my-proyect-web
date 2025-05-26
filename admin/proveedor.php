<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");
 

}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdmin.php';

$oClassAdmin=new classAdmin('proveedor',"select * from proveedor");



	echo $oClassAdmin->accion("list");

 ?>
<script src="../controllers/admin.js"></script>
<script >
 a_table="proveedor";
 a_consulta = `select * from proveedor`;
  setInterval("m_reflesh()",2000);

</script>
<?
include "footer.php";



?>