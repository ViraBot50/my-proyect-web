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

			case 'veriFecha':$html=$this->m_veriFecha(); break;

			case 'insertVenta': $html=$this->m_inseEncargo(); break;

			case 'geneFormRenta':$html=$this->m_geneFormRenta(); break;

			case 'borrarVenta': $this->m_borrEncargo(); break;

			case 'update': $html=$this->m_update(); break;

		}

		return $html;
	}


		function m_geneTitulo($nombre,$fecha){
			$v_total=$this->retieve1("SELECT coalesce(sum(cantidad*Precio_venta),0) as total from encargos e where id_renta={$this->a_idRenta}")->total;


		$html= '<div class="row">  
					<div class="col-2 fw-bold">Arrendatario:</div>
					<div class="col-5 ">'.$nombre.'</div>
					<div class="col-3 text-end">Total=</div>	
					<div class="col-2 text-begin money" id="c_total">'.(int)$v_total.'</div>						
				</div>
				<div class="row">  
					<div class="col-2 fw-bold text-center">Fecha:</div>
					<div class="col-10">'.$fecha.'</div>					
				</div>';

		return $html;
	}




	public function m_geneProductos($id_encargo){
		$html='';

		$this->query("SELECT (SELECT Nombre from producto p where e.id_producto=p.id) as Nombre,e.* from encargos e where id_renta={$_SESSION['Id_renta']}");

		foreach ($this->registros as $producto) {
    $id = $producto['Id_producto'];
    $nombre = $producto['Nombre'];
    $precio = $producto['Precio_venta'];
    $cantidad = $producto['Cantidad'];

    $html .= $this->m_creaComponente($id,$precio,$nombre,$cantidad);
}



		return $html;

	}



	public function m_getRenta(&$p_numeRows){
		$v_respuesta= $this->retieve1("SELECT r.Id,(SELECT concat(nombre,' ',primer_apellido,' ',segundo_apellido) from usuario u where r.id_usuario=u.id) as Arrendatario,fecha_evento from renta r where Id={$_SESSION['Id_renta']}");
		$this->a_idRenta=$v_respuesta->Id;
		$p_numeRows= $this->numeRegistros;
		return $v_respuesta;
	}



	private function m_veriFecha(){
		 $v_aux=$this->retieve1("SELECT r.Id,(SELECT concat(nombre,' ',primer_apellido,' ',segundo_apellido) from usuario u where r.id_usuario=u.id) as Arrendatario from renta r where r.id_estatus=1 and r.fecha_evento='{$_POST['fecha']}'");
	
		if ($this->numeRegistros>0){
			echo $_POST['fecha'];
			$_SESSION['Id_renta']=$v_aux->Id;
		}else 
			echo "0";

	}


	private function m_update(){
		$this->queryIDU("UPDATE encargos set cantidad={$_POST['cantidad']} where id_renta={$_SESSION['Id_renta']} and Id_producto={$_POST['Id']}");
	}


	private function m_borrEncargo()
	{
		$this->queryIDU("DELETE FROM encargos where id_renta='{$_SESSION['Id_renta']}' and id_producto={$_POST['Id']}");
	}


	private function m_inseEncargo(){
		$html=$this->m_creaComponente($_POST['id_producto'],$_POST['Precio_venta'],$_POST['nombre'],$_POST['cantidad']);

		$this->queryIDU("INSERT into encargos set id_renta={$_SESSION['Id_renta']}, Id_producto={$_POST['id_producto']}, cantidad={$_POST['cantidad']}, Precio_venta={$_POST['Precio_venta']}");


		return $html;
	}
	


	private function m_creaComponente($p_idProduct,$p_precVenta,$p_nombre,$p_cantComprar){
		$html= '<div id="'.$p_idProduct.'" class="producto-container">'.
    			'<input type="number" name="producto['.$p_idProduct.'][cantidad]" value="'.(int)$p_cantComprar.'"  class="col-3 btn no-spin" onchange="a_obj.m_update(this.parentElement)"  onfocus="a_obj.setPrevio(this.parentElement)" min="1">'.
                '<label class="col-3 text-center">'.$p_nombre.'</label>'.
                '<input type="text" name="producto['.$p_idProduct.'][precVenta]" value="'.(int)$p_precVenta.'" class="col-3 btn" readonly>'.
                '<label class="col-3 text-center separete-top">'.
                    '<button class="btn btn-danger" type="button" onclick="a_obj.m_accion(\'borrarVenta\','.$p_idProduct.')">'.
                        '<i class="fa fa-trash"></i>'.
                    '</button>'.
                '</label>'.
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
	$obj=new classEncargos();
	echo $obj->m_action($_POST['accion']);
}






?>