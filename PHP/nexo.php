<?php 

include "clases/productos.php";
include "clases/Usuarios.php";
// $_GET['accion'];
if ( !empty( $_FILES ) ) 
{
    $temporal = $_FILES[ 'file' ][ 'tmp_name' ];
    $ruta = "..". DIRECTORY_SEPARATOR . 'fotos' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
    move_uploaded_file( $temporal, $ruta );
    echo "correcto";
}
if(isset($_GET['accion']))
{
	$accion=$_GET['accion'];
	if($accion=="traer")
	{
		$respuesta= array();
		//$respuesta['listado']=producto::TraerproductosTest();
		$respuesta['listado']=producto::TraerTodasLasproductos();
		//var_dump(producto::TraerTodasLasproductos());
		$arrayJson = json_encode($respuesta);
		echo  $arrayJson;
	}

	if($accion=="traerusuarios")
	{
		$respuesta= array();
		$respuesta['listado']=Usuario::TraerTodosLosUsuarios();
		$arrayJson = json_encode($respuesta);
		echo  $arrayJson;
	}


	

}
else{
//var_dump($_REQUEST);


	/*esto es para cuando se configura el headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	POR EJEMPLO 
	$http.post("PHP/nexo.php",{accion :"borrar",producto:producto},{headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
 .then(function(respuesta) {       
         //aca se ejetuca si retorno sin errores        
         console.log(respuesta.data);

    },function errorCallback(response) {        
        //aca se ejecuta cuando hay errores
        console.log( response);           
    });
	*/

	/*echo "<br>";
	var_dump($_POST);*/





	
	/*
	esto es para cuando se pasan los datos por json
	por ejemplo
	$http.post('PHP/nexo.php', { datos: {accion :"insertar",producto:$scope.producto}})
 	  .then(function(respuesta) {     	
 		     //aca se ejetuca si retorno sin errores      	
      	 console.log(respuesta.data);

    },function errorCallback(response) {     		
     		//aca se ejecuta cuando hay errores
     		console.log( response);     			
 	  });*/
	$DatosPorPost = file_get_contents("php://input");
	$respuesta = json_decode($DatosPorPost);
	//var_dump($respuesta);
	switch($respuesta->datos->accion)
	{
		case "borrar":
		{
			/*if($respuesta->datos->producto->foto!="pordefecto.png")
			{
				unlink("../fotos/".$respuesta->datos->producto->foto);
			}*/
			producto::Borrarproducto($respuesta->datos->producto->id);
			break;
		}
		case "insertar":
		{
			/*if($respuesta->datos->producto->foto!="pordefecto.png")
			{
				$rutaVieja="../fotos/".$respuesta->datos->producto->foto;
				$rutaNueva=$respuesta->datos->producto->dni.".".PATHINFO($rutaVieja, PATHINFO_EXTENSION);
				copy($rutaVieja, "../fotos/".$rutaNueva);
				unlink($rutaVieja);
				$respuesta->datos->producto->foto=$rutaNueva;
			}*/
			producto::Insertarproducto($respuesta->datos->producto);
			break;
		}
		case "buscar":
		{
			echo json_encode(producto::TraerUnaproducto($respuesta->datos->id));
			break;
		}
		case "modificar":
		{
			/*if($respuesta->datos->producto->foto!="pordefecto.png")
			{
				$rutaVieja="../fotos/".$respuesta->datos->producto->foto;
				$rutaNueva=$respuesta->datos->producto->dni.".".PATHINFO($rutaVieja, PATHINFO_EXTENSION);
				copy($rutaVieja, "../fotos/".$rutaNueva);
				unlink($rutaVieja);
				$respuesta->datos->producto->foto=$rutaNueva;
			}*/

			producto::Modificarproducto($respuesta->datos->producto);
			break;
		}
		case "borrarUsuario":
		{
			Usuario::BorrarUsuario($respuesta->datos->usuario->id);
			break;
		}
		case "insertarUsuario":
		{
			Usuario::InsertarUsuario($respuesta->datos->usuario);
			break;
		}
		case "modificarUsuario":
		{
			Usuario::ModificarUsuario($respuesta->datos->usuario);
			break;
		}
	}
	
}

	







 ?>