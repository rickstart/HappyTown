<?php
class Conexion  
{
	var $con;
	function Conexion()
	{
		// se definen los datos del servidor de base de datos 
		$conection['server']="localhost:8889";  //host
		$conection['user']="root";         //  usuario
		$conection['pass']="root";             //password
		$conection['base']="aceitera";           //base de datos
		
		// crea la conexion pasandole el servidor , usuario y clave
		$conect= mysql_connect($conection['server'],$conection['user'],$conection['pass']);

		if ($conect) // si la conexion fue exitosa , selecciona la base
		{
			mysql_select_db($conection['base']);			
			$this->con=$conect;
		}
		else
		{
			echo "Error de Conexion";
		}
	}
	function getConexion() // devuelve la conexion
	{
		return $this->con;
	}
	function Close()  // cierra la conexion
	{
		mysql_close($this->con);
	}	

}
class sQuery   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
{

	var $coneccion;
	var $consulta;
	var $resultados;
	function sQuery()  // constructor, solo crea una conexion usando la clase "Conexion"
	{
		$this->coneccion= new Conexion();
	}
	function executeQuery($cons)  // metodo que ejecuta una consulta y la guarda en el atributo $pconsulta
	{
		$this->consulta= mysql_query($cons,$this->coneccion->getConexion());
		return $this->consulta;
	}	
	function getResults()   // retorna la consulta en forma de result.
	{return $this->consulta;}
	
	function Close()		// cierra la conexion
	{$this->coneccion->Close();}	
	
	function Clean() // libera la consulta
	{mysql_free_result($this->consulta);}
	
	function getResultados() // debuelve la cantidad de registros encontrados
	{return mysql_affected_rows($this->coneccion->getConexion()) ;}
	
	function getAffect() // devuelve las cantidad de filas afectadas
	{return mysql_affected_rows($this->coneccion->getConexion()) ;}

    function fetchAll()
    {
        $rows=array();
		if ($this->consulta)
		{
			while($row=  mysql_fetch_array($this->consulta))
			{
				$rows[]=$row;
			}
		}
        return $rows;
    }
}




class Oferta
{
	var $id;
	var $puesto;     
	var $escolaridad;
	var $edad;
	var $estado;
	var $experiencia;
	var $sexo;
	var $calle;
	var $colonia;
	var $cp;
	var $email;

    public static function getOfertas() 
		{
			$obj_oferta=new sQuery();
			$obj_oferta->executeQuery("select * from tbl_bolsa"); 

			return $obj_oferta->fetchAll(); 
		}

	function Oferta($nro=0) 
	{
		if ($nro!=0)
		{
			$obj_oferta=new sQuery();
			$result=$obj_oferta->executeQuery("select * from tbl_bolsa where id = $nro"); 
			$row=mysql_fetch_array($result);
			$this->id=$row['id'];
			$this->puesto=$row['puesto'];
			$this->escolaridad=$row['escolaridad'];
			$this->edad=$row['edad'];
			$this->estado=$row['estado'];
			$this->experiencia=$row['experiencia'];
			$this->sexo=$row['sexo'];
			$this->calle=$row['calle'];
			$this->colonia=$row['colonia'];
			$this->cp=$row['cp'];
			$this->email=$row['email'];
			
		}
	}
		
		// metodos que devuelven valores
	function getId()
	 { return $this->id;}
	function getPuesto()
	 { return $this->puesto;}
	function getEscolaridad()
	 { return $this->escolaridad;}
	function getEdad()
	 { return $this->edad;}
	function getEstado()
	 { return $this->estado;}
	function getExperiencia()
	 { return $this->experiencia;}
	function getSexo()
	 { return $this->sexo;}
	function getCalle()
	 { return $this->calle;}
	function getColonia()
	 { return $this->colonia;}
	function getCp()
	 { return $this->cp;}
	function getEmail()
	 { return $this->email;}

	 
		// metodos que setean los valores


	function setPuesto($val)
	 { return $this->puesto=$val;}
	function setEscolaridad($val)
	 { return $this->escolaridad=$val;}
	function setEdad($val)
	 { return $this->edad=$val;}
	function setEstado($val)
	 { return $this->estado=$val;}
	function setExperiencia($val)
	 { return $this->experiencia=$val;}
	function setSexo($val)
	 { return $this->sexo=$val;}
	function setCalle($val)
	 { return $this->calle=$val;}
	function setColonia($val)
	 { return $this->colonia=$val;}
	function setCp($val)
	 { return $this->cp=$val;}
	function setEmail($val)
	 { return $this->email=$val;}


    function save()
    {
        if($this->id)
        {$this->updateOferta();}
        else
        {$this->insertOferta();}
    }
	private function updateOferta()	// actualiza el cliente cargado en los atributos
	{
			$obj_oferta=new sQuery();
			$query="update tbl_bolsa set puesto='$this->puesto', escolaridad='$this->escolaridad',edad='$this->edad',estado='$this->estado',experiencia='$this->experiencia',sexo='$this->sexo',calle='$this->calle',colonia='$this->colonia',cp='$this->cp',email='$this->email' where id = $this->id";
			$obj_oferta->executeQuery($query); 
		
			return $obj_oferta->getAffect(); // retorna todos los registros afectados
	
	}
	private function insertOferta()	// inserta el cliente cargado en los atributos
	{
			$obj_oferta=new sQuery();
			$query="insert into tbl_bolsa( puesto, escolaridad, edad, estado,experiencia, sexo, calle, colonia, cp, email)values('$this->puesto', '$this->escolaridad','$this->edad','$this->estado','$this->experiencia','$this->sexo','$this->calle','$this->colonia','$this->cp','$this->email')";
			
			$obj_oferta->executeQuery($query); // ejecuta la consulta para traer al cliente 
			return $obj_oferta->getAffect(); // retorna todos los registros afectados
	
	}	
	function delete()	// elimina el cliente
	{
			$obj_oferta=new sQuery();
			$query="delete from tbl_bolsa where id=$this->id";
			$obj_oferta->executeQuery($query); // ejecuta la consulta para  borrar el cliente
			return $obj_oferta->getAffect(); // retorna todos los registros afectados
	
	}	

	function exportXml()
	{

		$view->ofertas=Oferta::getOfertas();
		
		$xml = new DomDocument('1.0', 'UTF-8');
		$root = $xml->createElement('vacantes');
		$root = $xml->appendChild($root);

		foreach ($view->ofertas as $oferta):

			$vacante = $xml->createElement('vacante');
			$vacante = $root->appendChild($vacante);

			$ide= "vacante_".$oferta['id'];
			$id = $xml->createElement('id',$ide);
			$id= $vacante->appendChild($id);

			$puesto = $xml->createElement('puesto',$oferta['puesto']);
			$puesto = $vacante->appendChild($puesto);

			$escolaridad = $xml->createElement('escolaridad',$oferta['escolaridad']);
			$escolaridad = $vacante->appendChild($escolaridad);

			$requisitos = $xml->createElement('requisitos');
			$requisitos = $vacante->appendChild($requisitos);

			$edad = $xml->createElement('edad',$oferta['edad']);
			$edad= $requisitos->appendChild($edad);

			$estado = $xml->createElement('estado',$oferta['estado']);
			$estado = $requisitos->appendChild($estado);

			$experiencia = $xml->createElement('experiencia',$oferta['experiencia']);
			$experiencia= $requisitos->appendChild($experiencia);

			$sexo = $xml->createElement('sexo',$oferta['sexo']);
			$sexo= $requisitos->appendChild($sexo);

			$direccion = $xml->createElement('direccion');
			$direccion = $vacante->appendChild($direccion);

			$calle = $xml->createElement('calle',$oferta['calle']);
			$calle= $direccion->appendChild($calle);

			$colonia = $xml->createElement('colonia',$oferta['colonia']);
			$colonia= $direccion->appendChild($colonia);

			$cp = $xml->createElement('cp',$oferta['cp']);
			$cp= $direccion->appendChild($cp);

			$email = $xml->createElement('email',$oferta['email']);
			$email= $vacante->appendChild($email);



		endforeach;

		$xml->formatOutput = true;

		//Guardar el xml como un archivo de String, es decir, poner los string en la variable $strings_xml:

		$strings_xml = $xml->saveXML();

		//Finalmente, guardarlo en un directorio:

		$xml->save('xml/bolsa.xml'); //esto se almacena en ruta siguiente
	

	}
	
}
function cleanString($string)
{
    $string=trim($string);
    $string=mysql_escape_string($string);
	$string=htmlspecialchars($string);
	
    return $string;
}


?>