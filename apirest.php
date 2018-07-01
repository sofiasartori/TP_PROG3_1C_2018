<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/comandaApi.php';
require 'clases/usuario.php';
require 'clases/usuarioApi.php';
require 'clases/trabajadorApi.php';
require 'clases/mesaApi.php';
require 'clases/MWparaCORS.php';
require 'clases/MWparaAutentificar.php';
require_once 'clases/JWT.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

//$app = new \Slim\Slim();

$app = new \Slim\App(["settings" => $config]);
/*use \Slim\App;

$app = new App();*/

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/comanda', function () {
 
  $this->get('/', \comandaApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $this->get('/{codigo}/', \comandaApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  $this->post('/', \comandaApi::class . ':CargarUno');

  $this->delete('/', \comandaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarMozo');
     
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

//ver manera de que los trabadores vean q tipo de item es (cocina, bar, cerveza) y suban el tiempo estimado y lo marquen como recibido o algo asi

$app->group('/usuario', function () {
 
	$this->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   
	$this->get('/{id_usuario}/', \usuarioApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  
	$this->post('/', \usuarioApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->delete('/', \usuarioApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');;
  
	$this->put('/', \usuarioApi::class . ':ModificarUno');
	   
  })->add(\MWparaCORS::class . ':HabilitarCORS8080');

  $app->group('/mesa', function () {
 
	$this->get('/', \mesaApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   
	$this->get('/{id_mesa}/', \mesaApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  
	$this->post('/', \mesaApi::class . ':CargarUno');
  
	$this->delete('/', \mesaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->put('/', \mesaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarMozo');
	   
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

$app->group('/pedidos', function (){
	$this->get('/', \trabajadorApi::class . ':traerTodos' )->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');
	
	$this->put('/', \trabajadorApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');

	$this->delete('/', \trabajadorApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');
})->add(\MWparaCORS::class . ':HabilitarCORS8080');
$app->run();

