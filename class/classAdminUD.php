<?
//Clase para paginas de que generan formularios de solo actualizacion y borrado
include "../class/classDB.php";



class classAdmin extends ClassDB{
	private $a_table='';
	private $a_mainConsulta='';

	public function __construct($p_table="rol",$cons="SELECT * FROM rol"){
		$this->a_table=$p_table;
		$this->a_mainConsulta=$cons;	
	}

	function accion($cual){
		$html="";

			switch ($cual) {
				case 'list':$html=$this->muesTabla(); break;

				case 'insert':$html=$this->insert(); break;

				case 'update':$html=$this->update(); break;

				case 'edit':$html=$this->new($_REQUEST['Id']); break;

				case 'delete':$html=$this->delete(); break;

				case 'new':$html=$this->new(); break;
				
				default: $html=$cual." No esta Programado";
				break;
			}


		return $html;
	}

	

	function muesTabla(){
		
		$this->query($this->a_mainConsulta);
		$html='<div class="container" id="vista"><table class="table"><tr class="table-dark">';
		$html.='<div class="row"> <div class="gravitas-one-regular text-white">'.$this->a_table.'</div> </div>';
		
		for ($col=0; $col < $this->numeCampos; $col++)
		$html.='<th>'.$this->getNombreCampo($col)."</th>";
		$html.='<th colspan="2"></th>';
		
		$html.="</tr>";

			
			foreach ($this->registros as $tupla) {
					$html.='<tr class="table-light">';
					
				foreach($tupla as $valor){
					$html.="<td>".$valor."</td>";
				}

				$aux=$this->retieve1("SELECT * from vw_list".$this->a_table." WHERE Id=".$tupla["Id"]);

				$html.='<td width="14px"><i class="btn btn-xs btn-danger bi-trash" 
				data-bs-toggle="tooltip" data-bs-placement="right" title="Borrar" onClick="adminUD(\'delete\',\''.$aux->Id.'\',\''.$aux->description.'\')" ></i></td>'.
					   '<td width="14px"><i class="btn btn-xs btn-success bi-pencil-square" onClick="adminUD(\'edit\',\''.$tupla["Id"].'\' )" data-bs-toggle="tooltip" data-bs-placement="right" title="Editar"></i></td>';
				$html.="</tr>";
			}

	
		$html.='</table></div>';
	
		return $html;

	}


function new($IdRecord=-1){
	$html="";
	$v_objAux=new ClassDB();
	$consulta="";

            if($IdRecord != -1)

            	if ($this->a_table!="encargos")
                $consulta = "select * from {$this->a_table} where Id = ".$IdRecord."";
            	else 
            	$consulta="select * from {$this->a_table} where concat(Id_renta,Id_producto) = ".$IdRecord."";            
          
		

		$tupla = $this->retieve1($consulta); 



	    $html.='<div class="container my-sm-4" style="max-width: 70%;">
           		<div class="card">
                	<div class="card-header">
                    '.(($IdRecord!=-1)?"Actualizar ".$this->a_table:"Nuevo ".$this->a_table).'
                        </div>
                        <div class="card-body bg-complete">
                            <form method="POST" class="" id="formulario" onsubmit="return false;">';

           if ($this->a_table=='encargos')
           	$html.='<input type="hidden" name="Id" value='.$IdRecord.'>';
                            

    for ($v_campo=0; $v_campo < $this->numeCampos; $v_campo++) { 
  		$v_campName=$this->getNombreCampo($v_campo);
  		$v_flag=$this->getFlagsCampo($v_campo);
  		//$html.=$this->getFlagsCampo($v_campo)."<br>";


    	if($v_flag==49160 or $v_flag==53257 or 
    		$v_flag==53251 or $v_flag==53259 or $v_flag==49161
){

    		if ($IdRecord!=-1)
    			$html.= $this->m_geneList($v_campName,$v_objAux->m_getTablReference(
    				$this->a_table,$v_campName),$tupla->$v_campName);
    		else
    			$html.= $this->m_geneList($v_campName,$v_objAux->m_getTablReference(
    				$this->a_table,$v_campName));


    	}else

    		if ($v_campo!=0 and $this->getTypeCampo($v_campo)!=7) {
    	$value=($IdRecord!=-1)?$tupla->$v_campName:"";
    	$value = ($this->getTypeCampo($v_campo) == 12)? 
    	date('Y-m-d\TH:i', strtotime($value)): $value;
    	
  		$html.= '<div class="row separete-top">
                    <label class="label col-3">'.$v_campName.'</label>
                      <div class="col-9">';
                     
            if ($this->getTypeCampo($v_campo) != 252)
            	$html.='<input class="form-control" name="'.$v_campName.'" type="'.$this->setTipo($this->getTypeCampo($v_campo)).'" value="'.$value.'" >';
            else           
            	$html.='<textarea name="'.$v_campName.'" class="form-control">'.$value.'</textarea>';

        $html.='      </div>
                 </div>';
             }else if ($IdRecord!=-1){
  			 $html.= '<div class="row separete-top">
                    <label class="label col-3">'.$v_campName.'</label>
                      <div class="col-9">
                         <input class="form-control" name="'.$v_campName.'" type="'.$this->setTipo($this->getTypeCampo($v_campo)).'" value="'.$tupla->$v_campName.'" disabled>


                         	<input class="form-control" name="'.$v_campName.'" type="hidden" value="'.$tupla->$v_campName.'" >
                      </div>
                 </div>';
             }



    	}
    



    $html.= '
	<input name="accion" type="hidden" value='.(($IdRecord!=-1)?"update":"insert").'></input>
    <button class="btn btn-success" onClick="adminUD(\'inseUpdate\')">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>';


return $html;
        }



function m_geneList($p_campo,$p_tablReferencia,$p_campValor=-1){
	$v_objAux=new ClassDB();
	$v_consulta="SELECT * from vw_list".$p_tablReferencia;
	$html='<div class="row mt-4 col-6">';


	$v_objAux->query($v_consulta);

	$html.='
	<label class="form-label col-3">'.$p_campo.'</label>
	<select name="'.$p_campo.'" class="col-9" '.(($this->a_table=='encargos')?"disabled":"").'> ';
		foreach ($v_objAux->registros as $v_registro)
			$html.='<option value="'.$v_registro['Id'].'" '.(($v_registro['Id']==$p_campValor)?"selected":"").'>'.$v_registro['description'].'</option>';
			
		
	$html.='</select> </div>';

   	return $html;
}



        public function setTipo($tipo){
        	$resu="text";
        	switch ($tipo) {
        		case '246':

        		case '2':
        			$resu="number";
        			break;

        		case '10':
        			$resu="date";
        			break;

        		case '11':
        			$resu="time";
        			break;

        		case '12':
        			$resu="datetime-local";
        			break;


        		
        	}

        	return $resu;

        }
	


	function insert(){
		$this->retieve1("SELECT * FROM {$this->a_table}");
		$cad="INSERT INTO {$this->a_table} SET ";
		$v_contador=1;
		foreach($_POST as $campo => $valor){
			
			if ($campo!='accion' and $this->getTypeCampo($v_contador)==12)
				$cad.=$campo."='".date('Y-m-d H:i:s', strtotime($valor))."',";
			else if ($campo!='accion')

				if ($this->getTipoCampo($v_contador)!='numeric')
				$cad.=$campo."='".$valor."',";
				else
				$cad.=$campo."=".$valor.",";	


			$v_contador++;
		}

		$cad=substr($cad, 0,-1);
	
		$this->queryIDU($cad);
		return $this->muesTabla();
	}

	function delete()
	{
		if ($this->a_table!='encargos')
		$this->queryIDU("DELETE from {$this->a_table} where Id='{$_REQUEST['Id']}'");
		else
		$this->queryIDU("DELETE from {$this->a_table} WHERE concat(Id_renta,Id_producto)='{$_REQUEST['Id']}'");
		return $this->muesTabla();
	}


	function update(){
		$this->retieve1("SELECT * FROM {$this->a_table}");
		$cad="UPDATE {$this->a_table} SET ";
		$v_contador=1;



		foreach($_POST as $campo => $valor){
			
			if ($campo!='accion' and $campo!='Id'){

			if ($this->getTypeCampo($v_contador)==12)
				$cad.=$campo."='".date('Y-m-d H:i:s', strtotime($valor))."',";
			else  
				if ($this->getTipoCampo($v_contador)!='numeric')
				$cad.=$campo."='".$valor."',";
				else
				$cad.=$campo."=".$valor.",";	
				$v_contador++;
			}


		}

		$cad=substr($cad, 0,-1);
		
		if ($this->a_table!='encargos')
		$cad.=" WHERE Id=".$_REQUEST['Id'];
		else
		$cad.=" WHERE concat(Id_renta,Id_producto)=".$_REQUEST['Id'];	

		$this->queryIDU($cad);
		return $this->muesTabla();
	}


}


if (isset($_REQUEST['table'])){
	$objCreacion=new classAdmin($_REQUEST['table'],$_REQUEST['query']);
	echo $objCreacion->accion($_REQUEST['accion']);   
}




?>