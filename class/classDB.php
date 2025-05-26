<?

class ClassDB
{
	var $conexion;
	var $registros;
	var $error;
	var $numeRegistros;
	var $numeCampos;
	private  $v_server="localhost";
	private  $v_user="don_beto";
	private  $v_pwd="123db";
	private  $v_db="don_beto";


	public function m_haceConexion($serv,$user,$pwd,$bd)
	{	
		//$serv=localhost <-- en el mismo servidor, o alfun servidor
		$this->conexion=mysqli_connect($serv,$user,$pwd,$bd);
	}


	public function m_cerrConexion()
	{
		mysqli_close($this->conexion);
	}


	public function query($consulta)
	{
		$this->m_haceConexion($this->v_server,$this->v_user,$this->v_pwd,$this->v_db);
		$this->registros=mysqli_query($this->conexion,$consulta);
		$this->numeCampos=mysqli_num_fields($this->registros);
		$this->numeRegistros=mysqli_num_rows($this->registros);
		$this->m_cerrConexion();
	}



	public function retieve1($consulta)
	{
		//select
		$this->m_haceConexion($this->v_server,$this->v_user,$this->v_pwd,$this->v_db);
		$this->registros=mysqli_query($this->conexion,$consulta);
		$this->numeRegistros=mysqli_num_rows($this->registros);
		$this->numeCampos=mysqli_num_fields($this->registros);
		$this->m_cerrConexion();
		return	mysqli_fetch_object($this->registros);	

	}
	

	public function queryIDU($consulta)
	{
		$this->m_haceConexion($this->v_server,$this->v_user,$this->v_pwd,$this->v_db);
		$this->registros=mysqli_query($this->conexion,$consulta);
		$this->m_cerrConexion();
	}



	public function getNombreCampo($posicion){
		return mysqli_fetch_field_direct($this->registros,$posicion)->name;
	}



	public function getTipoCampo($posicion){
    $tipo = mysqli_fetch_field_direct($this->registros, $posicion)->type;
    switch ($tipo) {
        case MYSQLI_TYPE_TINY:       // tinyint
        case MYSQLI_TYPE_SHORT:      // smallint
        case MYSQLI_TYPE_LONG:       // int
        case MYSQLI_TYPE_LONGLONG:   // bigint
        case MYSQLI_TYPE_INT24:      // mediumint
        case MYSQLI_TYPE_DECIMAL:    // decimal
        case MYSQLI_TYPE_NEWDECIMAL: // decimal (MySQL 5+)
        case MYSQLI_TYPE_FLOAT:      // float
        case MYSQLI_TYPE_DOUBLE:     // double
            return "numeric";
        default:
            return "string";
    }
}


	public function getTypeCampo($posicion){
    return mysqli_fetch_field_direct($this->registros, $posicion)->type;
	}


	public function getFlagsCampo($posicion){
    return mysqli_fetch_field_direct($this->registros, $posicion)->flags;
	}


	public function m_getTablReference($tabla, $columna)
{
    $this->m_haceConexion($this->v_server, $this->v_user, $this->v_pwd, $this->v_db);

    $consulta = "
        SELECT REFERENCED_TABLE_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_NAME = '$tabla'
          AND COLUMN_NAME = '$columna'
          AND TABLE_SCHEMA = '{$this->v_db}'
          AND REFERENCED_TABLE_NAME IS NOT NULL
    ";

    $resultado = mysqli_query($this->conexion, $consulta);

    $tablaReferenciada = null;

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $tablaReferenciada = $fila['REFERENCED_TABLE_NAME'];
    }

    $this->m_cerrConexion();

    return $tablaReferenciada; // Devuelve solo el nombre de la tabla o null
}




}

$oBD=new ClassDB();	
?>