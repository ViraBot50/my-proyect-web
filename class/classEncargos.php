<?php

include '../class/classDB.php';

if (!isset($_SESSION['Id']))
	session_start();
 


class classEncargos extends classDB{

 function constructor (){
	}


	function m_action($event='')
	{
		$html='hello';
		switch ($event) {

			case 'insertVenta': $html=$this->m_inseVenta(); break;

			case 'geneFormRenta':$html=$this->m_geneFormRenta(); break;

			case 'borrarVenta': $this->m_borrVenta(); break;

			case 'update': $html=$this->m_update(); break;

		}

		return $html;
	}


	private function m_update(){
		$v_restaurar=$this->retieve1("SELECT * from ventas where fecha_venta='{$_POST['fecha_venta']}'");
		$this->queryIDU("UPDATE ventas set cantidad={$_POST['cantidad']} where fecha_venta='{$_POST['fecha_venta']}'");
		$this->queryIDU("UPDATE producto set Cantidad_disponible=Cantidad_disponible-{$_POST['diferencia']} where Id={$v_restaurar->id_producto}");

		return var_dump($v_restaurar);
	}


	private function m_borrVenta()
	{

		$v_restaurar=$this->retieve1("SELECT * from ventas where fecha_venta='{$_POST['fecha_venta']}'");
		$this->queryIDU("DELETE FROM ventas where fecha_venta='{$_POST['fecha_venta']}'");
		$this->queryIDU("UPDATE producto set Cantidad_disponible=Cantidad_disponible+{$v_restaurar->cantidad} where Id={$v_restaurar->id_producto}");
		//var_dump($v_restaurar);
		//return $_POST['fecha_venta'];
	}


	private function m_inseVenta(){
		date_default_timezone_set('America/Mexico_City');
		$v_fechRegistro=date('Y-m-d H:i:s');
		$html=$this->m_creaComponente($_POST['id_producto'],$v_fechRegistro,$_POST['Precio_venta'],$_POST['Cantidad_disponible'],$_POST['nombre'],$_POST['cantidad']);

		$this->queryIDU("INSERT INTO ventas set Id_vendedor={$_SESSION['Id']}, Id_producto={$_POST['id_producto']}, Precio_venta={$_POST['Precio_venta']}, fecha_venta='".date('Y-m-d H:i:s')."',cantidad={$_POST['cantidad']}");


		return $html;
	}


	private function m_creaComponente($p_idProduct,$p_fechRegistro,$p_precVenta,$p_cantDisponible,$p_nombre,$p_cantComprar){
		$html= '<div id="'.$p_idProduct.'" class="producto-container">'.
    			'<input type="number" name="producto['.$p_idProduct.'][cantidad]" value="'.$p_cantComprar.'" max="'.$p_cantDisponible.'" class="col-3 btn no-spin" onchange="a_obj.m_update(this.parentElement)"  onfocus="a_obj.setPrevio(this.parentElement)" min="1">'.
                '<label class="col-3 text-center">'.$p_nombre.'</label>'.
                '<input type="text" name="producto['.$p_idProduct.'][precVenta]" value="'.$p_precVenta.'" class="col-3 btn" readonly>'.
                '<label class="col-3 text-center separete-top">'.
                    '<button class="btn btn-danger" type="button" onclick="a_obj.m_accion(\'borrarVenta\','.$p_idProduct.')">'.
                        '<i class="fa fa-trash"></i>'.
                    '</button>'.
                '</label>'.
                '<input type="hidden" value="'.$p_fechRegistro.'"></input>'.
            '</div>';
		return $html;
	}







	private function m_geneMensaje($p_msg, $p_type="alert-info"){
		$html = ' 	<div class="alert '.$p_type.' alert-dismissible fade show d-flex 						justify-content-between align-items-center" role="alert">
    					<span>'.$p_msg.'</span>
    					<button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  					</div>';

  		return $html;
	}




	function m_mostProducts(){
		$html="";
		$this->query("SELECT Id,Nombre,Precio_venta,Cantidad_disponible from producto where Cantidad_disponible>0");

		$html.='<select class="col-4" id="products">
				<option disabled>Productos</option>';


		foreach ($this->registros as $producto) 
				
				$html.='<option data-id="'.$producto["Id"].'"
								data-precio-venta="'.$producto["Precio_venta"].'"
								data-cantidad-disponible="'.$producto["Cantidad_disponible"].'"
						>
						'.$producto["Nombre"].'
				</option>';

		$html.='</select>';


		return $html;
	}


	




	
	

}


if (isset($_POST['accion'])){
	$obj=new classVender();
	echo $obj->m_action($_POST['accion']);
}




/*
class classEncargos extends classDB{
	

	function m_action($event='')
	{
		$html='';
		switch ($event) {
			case 'cobrar':$html=$this->m_cobrar(); break;

			case 'rentar':$html=$this->m_geneFormRenta(); break;

			case 'insert_user':$html=$this->m_inseUser(); break;

			case 'veriEvento':$this->m_veriEvento(); break;
		}

		return $html;
	}



	private function m_veriEvento(){
		$v_respuesta= $this->retieve1("SELECT r.Id,(SELECT concat(nombre,' ',primer_apellido,' ',segundo_apellido) from usuario u where r.id_usuario=u.id) as Arrendatario from renta r where r.id_estatus=1 and r.fecha_evento='{$_POST['fecha']}'");
		
		if ($this->numeRegistros>0){
			session_start();
			$_SESSION['fecha']=$_POST['fecha'];
			header("location: ./encargar.php");
		}else 
			header("location: ./geneEncargo.php?not=1");


	}



	public function m_getRenta(&$p_numeRows){
		$v_respuesta= $this->retieve1("SELECT r.Id,(SELECT concat(nombre,' ',primer_apellido,' ',segundo_apellido) from usuario u where r.id_usuario=u.id) as Arrendatario from renta r where r.id_estatus=1 and r.fecha_evento='{$_SESSION['fecha']}'");
		$p_numeRows= $this->numeRegistros;
		return $v_respuesta;
	}



  
	public function m_geneMensaje($p_msg, $p_type="alert-info"){
		$html = ' 	<div class="alert '.$p_type.' alert-dismissible fade show d-flex 										justify-content-between align-items-center" role="alert">
    					<span>'.$p_msg.'</span>
    					<button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  					</div>';

  		return $html;
	}



	public function m_geneProductos($id_encargo){
		$html='';

		$this->query("SELECT  (SELECT Nombre from producto p where e.id_producto=p.id) as Nombre,e.* from encargos e where id_renta={$id_encargo}");

		foreach ($this->registros as $producto) {
    $id = $producto['Id_producto'];
    $nombre = $producto['Nombre'];
    $precio = $producto['Precio_venta'];
    $cantidadMax = $producto['Cantidad'];

    $html .= '<div id="'.$id.'" class="producto-container">'.
    			'<input type="number" name="producto['.$id.'][cantidad]" value="1" max="'.$cantidadMax.'" class="col-3 btn">'.
                '<input type="hidden" name="producto['.$id.'][id_producto]" value="'.$id.'" readonly class="col-3 btn">'.
                '<label class="col-3 text-center">'.$nombre.'</label>'.
                '<input type="text" name="producto['.$id.'][precVenta]" value="'.$precio.'" class="col-3 btn" readonly>'.
                '<label class="col-3 text-center separete-top">'.
                    '<button class="btn btn-danger" type="button" onclick="m_borrar('.$id.')">'.
                        '<i class="fa fa-trash"></i>'.
                    '</button>'.
                '</label>'.
            '</div>';
}



		return $html;

	}




	function m_mostProducts(){
		$html="";
		$this->query("SELECT Id,Nombre,Precio_venta,Cantidad_disponible from producto where Cantidad_disponible>0");

		$html.='<select class="col-4" id="products">
				<option disabled>Productos</option>';


		foreach ($this->registros as $producto) 
				
				$html.='<option data-id="'.$producto["Id"].'"
								data-precio-venta="'.$producto["Precio_venta"].'"
						>
						'.$producto["Nombre"].'
				</option>';

		$html.='</select>';


		return $html;
	}



	function m_geneTitulo($nombre,$fecha){
		$html= '<div class="row">  
					<div class="col-2 fw-bold">Arrendatario:</div>
					<div class="col-10 ">'.$nombre.'</div>					
				</div>
				<div class="row">  
					<div class="col-2 fw-bold text-center">Fecha:</div>
					<div class="col-10">'.$fecha.'</div>					
				</div>';

		return $html;
	}




}


*/


?>