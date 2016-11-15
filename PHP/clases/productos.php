<?php
require_once"accesoDatos.php";
class producto
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $precio;
 	public $descripcion;
 	public $partidopolitico;
  	public $dni;
  	public $foto;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function Getdescripcion()
	{
		return $this->descripcion;
	}
	public function Getprecio()
	{
		return $this->precio;
	}

	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function Setdescripcion($valor)
	{
		$this->descripcion = $valor;
	}
	public function Setprecio($valor)
	{
		$this->precio = $valor;
	}
	
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($id=NULL)
	{
		if($id != NULL){
			$obj = producto::TraerUnaproducto($id);
			
			$this->descripcion = $obj->descripcion;
			$this->precio = $obj->precio;
			$this->id = $id;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->descripcion."-".$this->precio."-".$this->id;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnaproducto($idParametro) 
	{	


		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from producto where id =:id");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerUnaproducto(:id)");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$productoBuscada= $consulta->fetchObject('producto');
		return $productoBuscada;	
					
	}
	
	public static function TraerTodasLasproductos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from producto");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasproductos() ");
		$consulta->execute();			
		$arrproductos= $consulta->fetchAll(PDO::FETCH_CLASS, "producto");	
		return $arrproductos;
	}
	
	public static function Borrarproducto($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from producto	WHERE id=:id");	
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL Borrarproducto(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function Modificarproducto($producto)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update producto 
				set precio=:precio,
				descripcion=:descripcion
				WHERE id=:id");
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			//$consulta =$objetoAccesoDato->RetornarConsulta("CALL Modificarproducto(:id,:precio,:descripcion,:foto)");
			$consulta->bindValue(':id',$producto->id, PDO::PARAM_INT);
			$consulta->bindValue(':precio',$producto->precio, PDO::PARAM_STR);
			$consulta->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
			return $consulta->execute();
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function Insertarproducto($producto)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into producto (precio,descripcion)values(:precio,:descripcion)");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL Insertarproducto (:precio,:descripcion,:dni,:foto)");
		$consulta->bindValue(':precio',$producto->precio, PDO::PARAM_STR);
		$consulta->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
//--------------------------------------------------------------------------------//



	public static function TraerproductosTest()
	{
		$arrayDeproductos=array();

		$producto = new stdClass();
		$producto->id = "4";
		$producto->precio = "rogelio";
		$producto->descripcion = "agua";
		$producto->dni = "333333";
		$producto->foto = "333333.jpg";

		//$objetJson = json_encode($producto);
		//echo $objetJson;
		$producto2 = new stdClass();
		$producto2->id = "5";
		$producto2->precio = "Bañera";
		$producto2->descripcion = "giratoria";
		$producto2->dni = "222222";
		$producto2->foto = "222222.jpg";

		$producto3 = new stdClass();
		$producto3->id = "6";
		$producto3->precio = "Julieta";
		$producto3->descripcion = "Roberto";
		$producto3->dni = "888888";
		$producto3->foto = "888888.jpg";

		$arrayDeproductos[]=$producto;
		$arrayDeproductos[]=$producto2;
		$arrayDeproductos[]=$producto3;
		 
		

		return  $arrayDeproductos;
				
	}	


}
