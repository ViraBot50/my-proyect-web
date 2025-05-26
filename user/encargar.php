<?  
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // ✅ Se asegura de que la sesión esté iniciada
}


if (!isset($_SESSION['fecha']))
	header('location: geneEncargo.php?not=2');

include '../class/classEncargos.php';
include 'header.php';




$oCP=new classEncargos();
$data=null;

		$_numeRows=0;
		$data=$oCP->m_getRenta($_numeRows);	

		


?>
	
	<script>
		function m_borrar(id_producto){
		document.getElementById(id_producto).remove();
		}


		function eliminarProducto(event) {
  		const btn = event.target; 
  		const contenedor = btn.closest('.alert'); 
  		contenedor.classList.add('d-none'); 
		}

	</script>	






  <main class="bg-secondary p-3 scrollable-content">
    <div class="container" >

 
    		<div class="card border-primary mb-3" style="max-width: 80rem;">
  				<div class="card-header"> <? echo $oCP->m_geneTitulo($data->Arrendatario,$_SESSION['fecha']) ?> </div>
  				<div class="card-body scrollable-content">

  					
  					<div class="alert alert-success alert-dismissible fade show d-flex 										justify-content-between align-items-center d-none" role="alert" id='alert_product'>
    					<span id="msg">MSG</span>
    					<button type="button" class="btn-close ms-3"  aria-label="Cerrar" onclick="eliminarProducto(event)"></button>
  					</div>
 						
 						<label class="col-3 text-center">Cantidad</label>
  						<label class="col-3 text-center">Producto</label>
  						<label class="col-3 text-center">Precio Unitario</label>
  						<label class="col-3 text-center"></label>
 				<? 
 					if (isset($_POST['action']))
 						echo $oCP->m_action($_POST['action']);
 				?>		
  					<div class="scrollable-content" style="max-height: 20em; height: 20em; overflow-x: hidden;"> 
  						<form method="POST"  id="formulario" class="row" >
  							<? echo  $oCP->m_geneProductos($data->Id) ?>
  						</form>
  					</div>

  				</div>
			</div>
    </div>
  </main>


<footer class="footer bg-primary text-center ">
	<div class="row g-3 justify-content-center" style="width: 100%;">
	
	<?php   
		echo $oCP->m_mostProducts();
	?>


			<input class="col-2 lem-1" type="number" value="1" min="1" name="cantidad" placeholder="Cantidad a Comprar" id="cantComprar">

    	<button class="col-2 btn btn-warning lem-1" id="btnAgregar">Agregar</button>
 


    </div>



</footer>



	 <script src="../js/addProduct.js" type="module" defer></script>
	</body>
</html>