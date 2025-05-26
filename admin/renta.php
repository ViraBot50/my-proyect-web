<?php
session_start();

if (isset( $_SESSION['Id']) ){

	if ($_SESSION['Rol']!=1)
		header("location: ../index.php?m=2");


}else
	header("location: ../index.php?m=1");


include './header.php';
include '../class/classAdminUD.php';

$oClassAdmin=new classAdmin("renta","SELECT	Id, 
											(SELECT direccion from salon s where r.Id_salon=s.Id) as salon, 
											(SELECT concat(Nombre,' ',primer_apellido,' ',segundo_apellido,'<br><small class=text-dark>',u.telefonos,'</small>') from usuario u where u.id=r.id_usuario) as Arrendatario,
											fecha_evento,
											(SELECT estatus e from estatus e where r.id_estatus=e.id) as estatus,
											enganche,
											precio
											from renta r");


	echo $oClassAdmin->accion("list");



?>
<script src="../controllers/adminUD.js"></script>
<script >
 a_table="renta";
 a_consulta=`SELECT r.Id,(SELECT direccion from salon s where r.Id_salon=s.Id) as salon,(SELECT CONCAT(u.Nombre, ' ', u.primer_apellido, ' ', u.segundo_apellido, '<br><small class="text-dark">',u.Telefonos,'</small>') from usuario u where u.Id=r.id_usuario) AS arrendatario,fecha_evento,(SELECT estatus e from estatus e where r.id_estatus=e.id) as estatus,enganche,precio FROM renta r`

</script>
<?
include "footer.php";

?>