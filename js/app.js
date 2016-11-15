var app = angular.module('SegundoParcial', ['ui.router','satellizer']);

app.config(function($stateProvider, $urlRouterProvider,$authProvider) {

$authProvider.loginUrl = 'Segundo-Parcial/PHP/auth.php';
$authProvider.tokenName='MiTokenGeneradoEnPHP';
$authProvider.tokenPrefix='AngularABM';
$authProvider.authHeader='data';

$stateProvider

      .state('inicio', {
                url : '/inicio',
                templateUrl : 'inicio.html'
                //controller : 'controlInicio'
            })

      .state('usuario', {
                url : '/usuario',
                abstract:true,//permite que con diferentes rutas se le pueda agregar contenidos de otros state 
                templateUrl : 'abstractoUsuario.html'
            })
      .state('usuario.registro', {
                url: '/registrarse',
                views: {
                    'contenido': {
                        templateUrl: 'registroUsuario.html',
                        controller : 'controlRegistroUser'
                    }
                }
            })
      .state('usuario.login', {
                url: '/login',
                views: {
                    'contenido': {
                        templateUrl: 'loginUsuario.html',
                        controller : 'controlLogin'
                    }
                }
            })
      .state('usuario.grilla', {
                url: '/grillauser',
                views: {
                    'contenido': {
                        templateUrl: 'grillaUsuario.html',
                        controller : 'controlUserGrilla'
                    }
                }
            })
      .state('producto', {
                url : '/producto',
                abstract:true,
                templateUrl : 'abstractaproducto.html'
            })
      .state('producto.grilla', {
                url: '/grillaproducto',
                views: {
                    'contenido': {
                        templateUrl: 'grillaproducto.html',
                        controller : 'controlproductoGrilla'
                    }
                }
            })
      .state('producto.AltaProducto', {
                url: '/AltaProducto',
                views: {
                    'contenido': {
                        templateUrl: 'AltaProducto.html',
                        controller : 'controlAltaProducto'
                    }
                }
            })
      .state('producto.modificacion', {
                url: "/modificarproducto/{id}?:dni:precio:descripcion:partidopolitico:foto",
                views: {
                    'contenido': {
                        templateUrl: 'AltaProducto.html',
                        controller : 'controlproductoModificacion'
                    }
                }
            })

      $urlRouterProvider.otherwise('/inicio');
 });

app.controller('controlLogin', function($scope, $scope, $state, $http, $auth) {

    $scope.usuario={};
   

    $scope.Login= function(){
       $auth.login($scope.usuario)
          .then(function(response) {
            console.info('correcto', response);
            
            if ($auth.isAuthenticated()) {                   
                  alert("loggeado exitosamente");
                  $state.go("inicio"); 
            }     
            else {
                 alert("no se pudo loggear");
            }

            console.info($auth.getPayload());
            console.info('El token es: ',$auth.getToken()); 

          })

          .catch(function(response) {
            console.info('no volvio bien', response); 
            console.info($auth.getPayload());
            console.info('El token es: ',$auth.getToken());  
          })
        }

});

app.controller('controlRegistroUser', function($scope, $http, $state) {

  $scope.usuario={};
	/*$scope.usuario.nombreuser = "juan";
	$scope.usuario.dni = 12345;
	$scope.usuario.password = "contrasena";
	$scope.usuario.copiapassword = "contrasena";*/
  $scope.usuario.tipo = "usuario";


	$scope.Registrar=function(){
    $http.post('PHP/nexo.php', { datos: {accion :"insertarUsuario",usuario:$scope.usuario}})
    .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.go("usuario.login");

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log( response);           
    })
  }

});

app.controller('controlUserGrilla', function($scope, $http, $state) {

  $http.get('PHP/nexo.php', { params: {accion :"traerusuarios"}})
  .then(function(respuesta) {       

         $scope.ListadoUsuario = respuesta.data.listado;
         console.info(respuesta);
         console.log(respuesta.data);

    },function errorCallback(response) {
        
        console.log( response);
    })

  $scope.Borrar=function(usuario){
  $http.post("PHP/nexo.php",{datos:{accion :"borrarUsuario",usuario:usuario}})
  .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.reload();

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log(response);           
    })

  }

});

app.controller('controlproductoGrilla', function($scope, $http, $state) {

  $http.get('PHP/nexo.php', { params: {accion :"traer"}})
  .then(function(respuesta) {       

         $scope.Listadoproductos = respuesta.data.listado;
         console.info(respuesta);
         console.log(respuesta.data);

    },function errorCallback(response) {
         $scope.Listadoproductos= [];
        console.log( response);
    })

  $scope.Borrar=function(producto){
  $http.post("PHP/nexo.php",{datos:{accion :"borrar",producto:producto}})
  .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.reload();

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log(response);           
    })

  }

});

app.controller('controlAltaProducto', function($scope, $http, $state) {

    $scope.producto={};

    //$scope.producto.dni= 12312312;
    //$scope.producto.precio= "masculino" ;
    $scope.producto.descripcion= new Date();
    //$scope.producto.partidopolitico= "un partido";
    $scope.producto.foto="pordefecto.png";

    $scope.Registrar=function(){
    $http.post('PHP/nexo.php', { datos: {accion :"insertar",producto:$scope.producto}})
    .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     alert("Se registro tu AltaProducto !");
     $state.go("inicio");

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log( response);           
    })
  }

});

app.controller('controlproductoModificacion', function($scope, $http, $state, $stateParams) {

    $scope.producto={};

    $scope.producto.id=$stateParams.id;
    $scope.producto.dni= parseInt($stateParams.dni);
    $scope.producto.precio= $stateParams.precio;
    $scope.producto.descripcion= $stateParams.descripcion;
    $scope.producto.partidopolitico= $stateParams.partidopolitico;
    $scope.producto.foto=$stateParams.foto;

    $scope.Registrar=function(){
    $http.post('PHP/nexo.php', { datos: {accion :"modificar",producto:$scope.producto}})
    .then(function(respuesta) {       
       //aca se ejetuca si retorno sin errores        
     console.log(respuesta.data);
     $state.go("producto.grilla");

  },function errorCallback(response) {        
      //aca se ejecuta cuando hay errores
      console.log( response);           
    })
  }

});
