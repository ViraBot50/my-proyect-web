<?php

include '../class/classDB.php';

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


   /*//cambiar
	function m_cobrar(){
		$html='';

		if (isset($_POST['producto'])){
			$date=date('Y-m-d H:i:s');
			$con="INSERT INTO ventas (Id_vendedor,id_producto,precio_venta,fecha_venta,cantidad) values ";
			
			foreach ($_POST['producto'] as $value){
				$con.="({$_SESSION['Id']},{$value['id_producto']},{$value['precVenta']},'{$date}',{$value['cantidad']}), ";
			}
			$con=substr($con, 0, -2);


			$this->queryIDU($con);

			$total=$this->retieve1("SELECT sum(precio_venta*cantidad) as total from ventas where fecha_venta='{$date}'");

			$html=$this->m_geneMensaje("El total a pagar es de ".$total->total);

		}else
			$html=$this->m_geneMensaje("Ingrese un producto a vender", "alert-danger");




		return $html;
	}*/

  
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





?>