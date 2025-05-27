<?  
if (session_status() === PHP_SESSION_NONE) 
    session_start();  


include '../class/classEncargos.php';
include 'header.php';


$oCP=new classEncargos();
$data=null;

		$_numeRows=0;
		$data=$oCP->m_getRenta($_numeRows);	

		
?>
	<script src="../controllers/encargar.js" type="module"></script>

  <main class="bg-secondary p-3 scrollable-content">
    <div class="container" >

 
    		<div class="card border-primary mb-3" style="max-width: 80rem;">
  				<div class="card-header"> <? echo $oCP->m_geneTitulo($data->Arrendatario,$data->fecha_evento) ?> </div>
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
  					<div class="scrollable-content" style="max-height: 18em; height: 18em; overflow-x: hidden;"> 
  						<form  id="formulario" class="row" >
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

    	<button class="col-2 btn btn-warning lem-1" id="btnAgregar" onclick="a_obj.m_AgregarCompra()">Agregar</button>
 


    </div>



</footer>



	</body>
</html>