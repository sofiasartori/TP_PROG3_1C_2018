<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/comandaApi.php';
require 'clases/usuario.php';
require 'clases/usuarioApi.php';
require 'clases/MWparaCORS.php';
require 'clases/MWparaAutentificar.php';
require_once 'clases/JWT.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*$app = new \Slim\Slim();

$app->get('/traerTodos', function() use($app) {
	$usuario = new Usuario();
	$resultados["Mensaje"] = "GET";
	$resultados["Lineas"]=$usuario::MostrarTodosDatos();
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($resultados));
	
});

// POST: Para crear recursos
$app->post("/usuario", function() use($app)
{
	// Recuperamos los valores con $app->request->'metodo'("key")
	// 'metodo' -> post, put o delete
	$nombre = $app->request->post("nombre");
	$apellido = $app->request->post("apellido");
	$usuario = $app->request->post("usuario");
    $perfil = $app->request->post("perfil");

	$res = array("Mensaje" => "POST", "v1" => $nombre, "v2" => $apellido, "v3" => $usuario, "v4" => $perfil);	
	
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($res));

	$usuario = new Usuario();
	$usuario::InsertarUsuario($nombre, $apellido, $usuario, $perfil);

});


// Accedemos por get a /cd/ pasando un id 
// Ruta /cd/id
// Los parámetros en la url se definen con :parametro
// El valor del parámetro :id se pasará a la función de callback como argumento
$app->get('/usuario/:usuario/:perfil', function($usuario) use($app) {
    $usuario = new Usuario();
	$resultados["Mensaje"] = "GET";
	$resultados["Lineas"]=$usuario::VerificarUsuario();
// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
	$app->response->headers->set("Content-type", "application/json");
	$app->response->status(200);
	$app->response->body(json_encode($resultados));
});

$app->run();*/

$app = new \Slim\App(["settings" => $config]);
/*use \Slim\App;

$app = new App();*/

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/comanda', function () {
 
  $this->get('/', \comandaApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $this->get('/{codigo}/', \comandaApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  $this->post('/', \comandaApi::class . ':CargarUno');

  $this->delete('/', \comandaApi::class . ':BorrarUno');

  $this->put('/', \comandaApi::class . ':ModificarUno');
     
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/usuario', function () {
 
	$this->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   
	$this->get('/{id_usuario}/', \usuarioApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  
	$this->post('/', \usuarioApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->delete('/', \usuarioApi::class . ':BorrarUno');
  
	$this->put('/', \usuarioApi::class . ':ModificarUno');
	   
  })->add(\MWparaCORS::class . ':HabilitarCORS8080');


$app->post('/login/', function(Request $request, Response $response){
	$datos = $request->getParsedBody();
	$nombre=$datos['usuario'];
	
	$usuario=new Usuario();
	$usuarioBuscado=$usuario->TraerUnUsuario($nombre);
	$perfilJWT = $usuarioBuscado->perfil;
	$areaJWT = $usuarioBuscado->area;
	$data=array('Usuario'=>$nombre, 'Perfil'=>$perfilJWT, 'Area'=>$areaJWT);
	$token= JsonWToken::LogIn($data); 
  	$newResponse = $response->withJson($token, 200); 
	return $newResponse;	  
})->add(\MWparaCORS::class . ':HabilitarCORS8080');
$app->run();

