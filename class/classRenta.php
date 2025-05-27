<?php

if (!isset($_SESSION['Id']))
	session_start();
 
include '../class/classDB.php';


class classRenta extends classDB{
	


 function constructor (){
	}


	function m_action($event='')
	{
		$html='';
		switch ($event) {

			case 'geneFormRenta':$html=$this->m_geneFormRenta(); break;

			case 'insert_user':$html=$this->m_inseUser(); break;

			case 'insert_renta':$html=$this->m_inseRenta(); break;


		}

		return $html;
	}





	private function m_creaComponente($p_idProduct,$p_idVenta,$p_precVenta,$p_cantDisponible,$p_nombre,$p_cantComprar){
		$html= '<div id="'.$p_idProduct.'" class="producto-container">'.
    			'<input type="number" name="producto['.$p_idProduct.'][cantidad]" value="'.$p_cantComprar.'" max="'.$p_cantDisponible.'" class="col-3 btn" onchange="a_obj.m_update()">'.
                '<label class="col-3 text-center">'.$p_nombre.'</label>'.
                '<input type="text" name="producto['.$p_idProduct.'][precVenta]" value="'.$p_precVenta.'" class="col-3 btn" readonly>'.
                '<label class="col-3 text-center separete-top">'.
                    '<button class="btn btn-danger" type="button" onclick="a_obj.m_borrar('.$p_idProduct.')">'.
                        '<i class="fa fa-trash"></i>'.
                    '</button>'.
                '</label>'.
                '<input type="" value="v_'.$p_idVenta.'"></input>'.
            '</div>';
		return $html;
	}



	private function m_inseRenta(){
		$msg='El salon ya esta rentado en ese dia';

		$this->query("SELECT 1 from renta where id_estatus=1 and fecha_evento='{$_POST['fecha_evento']}'");



		if ($this->numeRegistros>0)
			$msg=$this->m_geneMensaje($msg,"alert-warning");
		else{

			$this->queryIDU("INSERT INTO renta set id_salon={$_POST['Salon']}, id_usuario={$_POST['Usuario']}, fecha_contrato='{$_POST['fecha_contrato']}', fecha_evento='{$_POST['fecha_evento']}', enganche={$_POST['enganche']}, precio={$_POST['precio']}");
			
			$msg=$this->m_geneMensaje("Renta registrada con exito");
		}

			

		return $msg.$this->m_geneFormRenta();

	}






	private function m_inseUser()
	{
		$v_msg='';
		$this->query("SELECT * FROM usuario where lower(concat(nombre,primer_apellido,segundo_apellido)) like lower(concat('{$_POST['nombre']}','{$_POST['primer_apellido']}','{$_POST['segundo_apellido']}'))");

		if ($this->numeRegistros>0){
		 $v_msg=$this->m_geneMensaje("El interesado ya esta registrado","alert-warning");
		 $_GET['accion']=null;
		}else{
		 $v_msg=$this->m_geneMensaje("interesado Registrado con exito");
		 $this->queryIDU("INSERT INTO usuario set nombre='{$_POST['nombre']}', primer_apellido='{$_POST['primer_apellido']}', segundo_apellido='{$_POST['segundo_apellido']}', telefonos='{$_POST['telefono']}'");
		}

		//sleep(1);


		return $v_msg.$this->m_geneFormRenta();
	}



	private function m_geneFormRenta()
	{
		$html='	 
					<div class="row m-3">
						'.$this->m_geneListado("Usuario","SELECT Id,concat(Nombre,' ',primer_apellido,' ',segundo_apellido,' (',Telefonos,')') as description from usuario order by description asc").$this->m_geneListado("Salon","SELECT * from vw_listSalon").'
					</div>
				';

		return $html;

	}





	private function m_geneListado($nombTabla,$query){
		$id=-1;
		if(isset($_GET['accion']) and $_GET['accion']!=null and $nombTabla=="Usuario"){
			$consulta=$this->retieve1("SELECT max(id) as max from usuario");
			$id=$consulta->max;
		}


		$html='<label class="col-2 text-center">'.$nombTabla.'</label>
				<select name="'.$nombTabla.'" class="col-4">';
		$this->query($query);
		

		foreach ($this->registros as $registro)
			$html.='<option value="'.$registro['Id'].'" '.(($id==$registro['Id'])?'selected':'').'>'.$registro['description'].'</option>';
			
		
		$html.='</select>';


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


if (isset($_GET['accion'])){
	$obj=new classRenta();
	echo $obj->m_action($_GET['accion']);
}




?>