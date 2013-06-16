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
		$conection['base']="happyTown";           //base de datos
		
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




class post
{
	var $id;
	var $description;
	var $title;     
	var $category_id;
	var $image;
	var $lat;
	var $lng;


    public static function getPins() 
	{
		$obj_post=new sQuery();
		$obj_post->executeQuery("select * from post_tbl"); 

		return $obj_post->fetchAll(); 
	}
	public static function getCat() 
	{
		$obj_post=new sQuery();
		$obj_post->executeQuery("select * from category_tbl"); 

		return $obj_post->fetchAll(); 
	}

	function Post($nro=0) 
	{
		if ($nro!=0)
		{
			$obj_post=new sQuery();
			$result=$obj_post->executeQuery("select * from post_tbl where post_id = $nro"); 
			$row=mysql_fetch_array($result);
			$this->id=$row['post_id'];
			$this->title=$row['description'];
			$this->title=$row['title'];
			$this->category_id=$row['category_id'];
			$this->image_id=$row['image'];
			$this->lat=$row['lat'];
			$this->lng=$row['lng'];
			
			
		}
	}
		
		// metodos que devuelven valores
	function getId()
	 { return $this->id;}
	function getDescription()
	 { return $this->description;}
	function getTitle()
	 { return $this->title;}
	function getCategory()
	 { return $this->category_id;}
	function getImage()
	 { return $this->image;}
	function getLat()
	 { return $this->lat;}
	function getLng()
	 { return $this->lng;}

	 
		// metodos que setean los valores


	function setId($val)
	 { return $this->id=$val;}
	function setDescription($val)
	 { return $this->description=$val;}
	function setTitle($val)
	 { return $this->title=$val;}
	function setCategory($val)
	 { return $this->category_id=$val;}
	function setImage($val)
	 { return $this->image=$val;}
	function setLat($val)
	 { return $this->lat=$val;}
	 function setLng($val)
	 { return $this->lng=$val;}

 
	
	private function insertPost()	
	{
			$obj_post=new sQuery();
			$query="insert into post_tbl( description, title, category_id, image, lat, lng)values('$this->description',$this->title', '$this->category_id','$this->image','$this->lat','$this->lng')";
			
			$obj_post->executeQuery($query); 
			return $obj_post->getAffect(); 
	
	}	



}



?>