<?  
include '../class/classVender.php';
include 'header.php';

 
$oCP=new classVender();
?>
	 <script src="../controllers/vender.js" type="module"></script>

  <main class="bg-secondary p-3 " >
    <div class="container">
    		
    		<div class="card border-primary mb-3">
  				<div class="card-header">
  					<span class="row">
  						<span class="col-6">Productos a Comprar</span> 
  						<span class="col-4 text-end">Total=</span>
  						<span class="col-2 text-start money" id="c_total">0</span>
  					</span>
  				</div>
  				<div class="card-body">
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
  					 <div id="formulario" class="row" ></div>
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
 


    	<button  class="col-2 btn btn-success lem-1" type="submit"  name="action" value="cobrar" onclick="location.reload();">New</button>

    </div>

</footer>


	</body>
</html>