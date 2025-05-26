<? 
include '../class/classEncargos.php';

$oCP=new classEncargos();

if (isset($_POST['fecha'])) 
	$oCP->m_action('veriEvento');



include 'header.php';


?>

	 <script src="../controllers/vender.js" type="module"></script>

<section class="container" id="c_main"> 


	<div class="card mb-3 separete-top" style="max-width: 100%;">
 						 <div class="card-header">Busqueda de encargos</div>
  							<div class="card-body">
  							

  									<?
  										if(isset($_GET['not']))

  											if ($_GET['not']==1)
													echo $oCP->m_geneMensaje("El salon no esta rentado ese dia","alert-warning");
												else
													echo $oCP->m_geneMensaje("No se ha seleccionado ninguna renta","alert-warning")
										?>

   							<form method="POST" class="row" id="formFecha">
  								<label class="col-3 text-center mb-3">Fecha del evento</label>
  								<input class="col-4 mb-3" name="fecha" required type="date" required>
  								<input type="hidden" name="accion" value="veriFecha">
  								<div class="col-3 mb-3">	
  									<button class="btn btn-success " type="button" onclick="a_obj.m_accion('veriFecha')" >Buscar productos</button>
  								</div>
  							</form>
  							</div>
					</div>
  

  </section>				



</html>