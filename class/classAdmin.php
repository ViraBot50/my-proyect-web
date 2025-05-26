<?
//session_start();//usada para todo recurso que va a inciar sesiones 
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
		$ObjAux=new ClassDB();
		$this->query($this->a_mainConsulta);
		$html='<div class="container" id="vista"><table class="table"><tr class="table-dark">';
		$html.='<div class="row"> <div class="gravitas-one-regular text-white">'.$this->a_table.'</div> </div>';
		
		for ($col=0; $col < $this->numeCampos; $col++)
		$html.='<th>'.$this->getNombreCampo($col)."</th>";
		$html.='<th colspan="2"><i class="btn btn-xs btn-danger bi-plus-circle-fill" data-bs-toggle="tooltip" data-bs-placement="right" title="Agregar nuevo"" onClick="admin(\'new\')"></th>';
		
		$html.="</tr>";

			
			foreach ($this->registros as $tupla) {
					$html.='<tr class="table-light">';
					
				foreach($tupla as $valor){
					$html.="<td>".$valor."</td>";
				}

				$description=$this->retieve1("SELECT description from vw_list".$this->a_table." WHERE Id=".$tupla["Id"])->description;


				$html.='<td width="14px"><i class="btn btn-xs btn-danger bi-trash" onClick="admin(\'delete\',\''.$tupla["Id"].'\',\''.$description.'\')" data-bs-toggle="tooltip" data-bs-placement="right" title="Borrar"></i></td>'.
					   '<td width="14px"><i class="btn btn-xs btn-success bi-pencil-square" onClick="admin(\'edit\',\''.$tupla["Id"].'\' )" data-bs-toggle="tooltip" data-bs-placement="right" title="Editar"></i></td>';
				$html.="</tr>";
			}

	
		$html.='</table></div>';
	
		return $html;
	}


function new($IdRecord=-1){
	$html="";
	$v_objAux=new ClassDB();
	$consulta="";

            if($IdRecord != -1){
                	$consulta = "select * from {$this->a_table} where Id = ".$IdRecord."";

                	if ($this->a_table=='usuario')
                		if($this->retieve1($consulta)->Id_rol>2)
                			$consulta=str_replace("*", "Id,nombre,primer_apellido,segundo_apellido,telefonos", $consulta);
                	


            }else
                $consulta = "select * from {$this->a_table}";
		

		$tupla = $this->retieve1($consulta); 






	    $html.='<div class="container my-sm-4" style="max-width: 70%;">
           		<div class="card">
                	<div class="card-header">
                    '.(($IdRecord!=-1)?"Actualizar ".$this->a_table:"Nuevo ".$this->a_table).'
                        </div>
                        <div class="card-body bg-complete">
                            <form method="POST" id="formulario" onsubmit="return false;">';

    for ($v_campo=0; $v_campo < $this->numeCampos; $v_campo++) { 
  		$v_campName=$this->getNombreCampo($v_campo);
  		$v_flag=$this->getFlagsCampo($v_campo);
  		//$html.=$v_flag."<br>";


    	if($v_flag==49160 or $v_flag==53257 or $v_flag==49161){

    		if ($IdRecord!=-1)
    			$html.= $this->m_geneList($v_campName,$v_objAux->m_getTablReference(
    				$this->a_table,$v_campName),$tupla->$v_campName);
    		else
    			$html.= $this->m_geneList($v_campName,$v_objAux->m_getTablReference(
    				$this->a_table,$v_campName));


    	}else

    		if ($v_campo!=0 and $v_campName!='Password') {
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
             }else if ($IdRecord!=-1 and $v_campName!='Password'){

  			 $html.= '<div class="row separete-top">
                    <label class="label col-3">'.$v_campName.'</label>
                      <div class="col-9">

                      	<input class="form-control" name="'.$v_campName.'" type="" value="'.$tupla->$v_campName.'" disabled>
                         <input class="form-control" name="'.$v_campName.'" type="hidden" value="'.$tupla->$v_campName.'" >


                      </div>
                 </div>';
             }



    	}
    



    $html.= '
	<input name="accion" type="hidden" value='.(($IdRecord!=-1)?"update":"insert").'></input>
    <button class="btn btn-success" onClick="admin(\'inseUpdate\')">Enviar</button>
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
		$v_respuesta='';
		$this->retieve1("SELECT * FROM {$this->a_table}");
		$cad="INSERT INTO {$this->a_table} SET ";
		$v_contador=($this->a_table=='producto_proveedor')?0:1;
		
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

		if ($this->a_table!='usuario'){
			$cad=substr($cad, 0,-1);
			$this->queryIDU($cad);
		}
		else{
			$v_clave=$this->m_geneclave();
			$cad.="Password=md5('{$v_clave}')";
			$this->retieve1(" SELECT  * from usuario where Correo='{$_REQUEST['Correo']}' ");

			if ($this->numeRegistros==0){

				if ($this->m_sendMail("<h1>Bienvenido a abarrotes carreño: Tu contraseña es: ".$v_clave,$_REQUEST['Correo'])){
					$this->queryIDU($cad);
					$v_respuesta='<span class="bg-success">El usuario ha sido registrado con exito</span>';
				}else
					$v_respuesta='<span class="bg-warning">Ha ocurrido un error al enviar el correo</span>';




			}else 
				$v_respuesta='<span class="bg-warning">El usuario ya esta registrado</span>'.$v_respuesta;
				}




		return $v_respuesta.$this->muesTabla();
	}

	function delete(){
		$this->queryIDU("DELETE from {$this->a_table} where Id='{$_REQUEST['Id']}'");
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
		
		$cad.=" WHERE Id=".$_POST['Id'];

		$this->queryIDU($cad);
		return $this->muesTabla();
	}




		public function m_sendMail($mensaje,$email)
	{

		include( "../resources/class.phpmailer.php");
 		include( "../resources/class.smtp.php");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host="smtp.gmail.com"; //mail.google
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Port = 465;     // set the SMTP port for the GMAIL server
    $mail->SMTPDebug  = 0;  // enables SMTP debug information (for testing)
                              // 1 = errors and messages
                              // 2 = messages only
    $mail->SMTPAuth = true;   //enable SMTP authentication
    
    $mail->Username =   "22031190@itcelaya.edu.mx"; // SMTP account username
    $mail->Password = "npqp roch dbcm lqqb";  // SMTP account password
      
    $mail->From="";
    $mail->FromName="";
    $mail->Subject = "Registro completo";
    $mail->MsgHTML($mensaje);
    $mail->AddAddress($email);
    //$mail->AddAddress("admin@admin.com");
    


    return $mail->Send();	
	}



	function m_geneclave($numeCars=8){
		$letras="ABCDEFGHJKLMNPKRSTUVWXYZabcdefjhijklmnopqrstuvwxyz123456789123456789!$#!_!$#!_!$#!_";

		$pwd="";


		for ($i=0; $i < $numeCars; $i++)  
    		$pwd.=$letras[rand()%strlen($letras)];
		return $pwd;
	}


}



if (isset($_REQUEST['table'])){
	$objCreacion=new classAdmin($_REQUEST['table'],$_REQUEST['query']);
	
	echo $objCreacion->accion($_REQUEST['accion']);
}



?>