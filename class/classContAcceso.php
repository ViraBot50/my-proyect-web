<?
//session_start();//usada para todo recurso que va a inciar sesiones 
include "class/classDB.php";



class classContAcceso extends ClassDB{


	function accion($cual){
		$html="";

			switch ($cual) {
				case 'login':$html=$this->login(); break;

				case 'newRecord':$html=$this->newRecord(); break;


				case 'retrievePwd':$html=$this->retrievePwd(); break;
				
				default: break;



			}


		return $html;
	}
	

	public function retrievePwd()
	{
			
		if (isset($_POST['Email']) && $_POST['Email']>"" 
			 ){
			$nuevaContra=$this->clave(7);
			$v_consulta="SELECT * from usuario where Correo='{$_POST['Email']}';";
			$v_msg="<h1>Tu nueva contraseña es: ".$nuevaContra."</h1>";
			$v_update="UPDATE usuario set password=md5('{$nuevaContra}') WHERE Correo='{$_POST['Email']}'";

			$this->query($v_consulta);

			
			
			if ($this->numeRegistros==1){

				if ($this->sendMail($v_msg,$_POST['Email'])) {
	       		  $this->queryIDU($v_update);
       		  return "<h1 class='bg bg-success'>Se te ha enviado a tu correo la contraseña</h1>";
     		}
    		else 
        			return  "El correo no se envio";

			}
	
		}
	}
	


 	


	public function newRecord(){
		if (isset($_POST['user'])){

    $this->query("SELECT * from usuario where email='{$_POST['Correo']}'");


    if ($this->numeRegistros==0){

    $nuevaClave=$this->clave(6);
    $cad="INSERT into usuario set Nombre='".$_POST['user']."', Apellidos='".$_POST['apellidos']."', Genero='".$_POST['genero']."',email='".$_POST['Correo']."', clave=md5('".$nuevaClave."'), FechaIngresoEmpresa='".date('Y-m-d')."'";


    if ($this->sendMail("<h1>BIENVENIDO ".$_POST['user']." ".$_POST['apellidos']."</h1><h2> tu clave de acceso es : ".$nuevaClave."</h2>",$_POST['Correo'])) {
         $this->queryIDU($cad);
         return "<h1>Se te ha enviado a tu correo la contraseña</h1>";
     }
    else 
        return  "Error de envio de correo";

}else
   		 return "<h1>El correo esta registrado</h1>";

}


	}





	public function sendMail($mensaje,$email)
	{

		include( "resources/class.phpmailer.php");
 		include( "resources/class.smtp.php");

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


	function clave($numeCars=8){
		$letras="ABCDEFGHJKLMNPKRSTUVWXYZabcdefjhijklmnopqrstuvwxyz123456789123456789!$#!_!$#!_!$#!_";

		$pwd="";


		for ($i=0; $i < $numeCars; $i++)  
    		$pwd.=$letras[rand()%strlen($letras)];
		return $pwd;
}


	public function login()
	{

		if (isset($_POST['Email']) && $_POST['Email']>"" && 
			isset($_POST['Clave']) &&  $_POST['Clave']>"" ){

		$_POST['Email']=$this->m_borrCaracteres($_POST['Email']);
		$_POST['Clave']=$this->m_borrCaracteres($_POST['Clave']);	

		
		$v_consulta="SELECT * FROM usuario where 
		Correo='{$_POST['Email']}' and password=md5('{$_POST['Clave']}');";
		$registro = $this->retieve1($v_consulta);

		if ($this->numeRegistros==1){ 
				$_SESSION['Correo']=$_POST['Email'];
				$_SESSION['Id']=$registro->Id;
				$_SESSION['Nombre']=$registro->Nombre;
				$_SESSION['Apellidos']=$registro->Primer_apellido.' '.$registro->Segundo_apellido;
				$_SESSION['Rol']=$registro->Id_rol;

			if ($registro->Id_rol==1)
				header("location: admin/home.php");
			else 
				header("location: user/home.php");
				

			}else
				echo '<h1 class="bg bg-danger">Usuario no valido</h1>';
			
		}
	}



	private function m_borrCaracteres($p_campo){
		$letras="ABCDEFGHIJKLMNOPKRSTUVWXYZ0123456789123456789!$#_@.";


		for ($v_caracter=0; $v_caracter < strlen($p_campo); $v_caracter++) { 
		
			if (strpos( $letras,strtoupper($p_campo[$v_caracter]) )===false )
				$p_campo[$v_caracter]="0";

		}

		return $p_campo;
	}


}
			
	



$oContAcceso=new classContAcceso();


?>