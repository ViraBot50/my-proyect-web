<?  
include 'header.php';
include '../class/classRenta.php';
$obj=new classRenta();
?>

	<script src="../controllers/rentar.js"></script>
	 

	<section class="p-3 m-3" id="sec_rentar">
		<div class="bg-light form-control" id="formulario" onsubmit="return false;" >
		<h2>Rentar</h2>
		<form id="form_renta" method="POST">
			<span id="dinamic_data">
		<? 
				echo $obj->m_action("geneFormRenta");
		?>
			</span>
		<div class="row m-3">
			<label class="col-2 text-center">Fecha Contrato</label>
			<input type="date" name="fecha_contrato" class="col-4" required form="form_renta" 
			value="<?php echo date('Y-m-d'); ?>">
			
		
			<label class="col-2 text-center">Fecha Evento</label>
			<input type="date" name="fecha_evento" class="col-4" required form="form_renta">
		</div>

		<div class="row m-3">
			<label class="col-2 text-center">Enganche</label>
			<input type="number" name="enganche" class="col-4" required form="form_renta">

			<label class="col-2 text-center">Precio</label>
			<input type="number" name="precio" class="col-4" required form="form_renta">

		</div>

		<div class="row">
			<div class="col-12 text-center">
			<button class="btn btn-dark lem-3" form="form_renta" name="action" value="rentar" type="button" onclick="control('insert_renta')">Agregar</button>
			
			<button type="button" class="btn btn-success lem-3" onclick="m_addUsers()">Agregar Arrendatario</button>
			</div>

		</div>

		</form>
	</section>


	<section class="p-3 m-3 d-none" id="sec_add">
		<div class="bg-light form-control" >
		<form method="POST" id="form_usuario" onsubmit="return false;">
		<h2>Agregar Arrendatario</h2>
		
 
		<div class="row m-3">
			<label class="col-2 text-center">Nombre</label>
			<input class="col-4" type="text" required placeholder="Nombre" name="nombre">
		
			<label class="col-2 text-center">Primer Apellido</label>
			<input class="col-4" type="text" required placeholder="Primer Apellido" name="primer_apellido">
		</div>

		<div class="row m-3">
			<label class="col-2 text-center">Segundo Apellido</label>
			<input class="col-4" type="text" required placeholder="Segundo Apellido" name="segundo_apellido">
		
			<label class="col-2 text-center">Telefono</label>
			<input class="col-4" type="phone" required placeholder="Telefono" name="telefono">


		</div>

		<div class="row">
			<div class="col-12 text-center">
			<button class="btn btn-dark lem-3" type="button" onclick="control('insert_user')">Agregar</button>
			
			<button type="button" class="btn btn-success lem-3" onclick="m_addUsers()">Rentar</button>
			</div>

		</div>

		</form>	
		</div>
	</section>








	</body>
</html>