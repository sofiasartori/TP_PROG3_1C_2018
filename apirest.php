<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/comandaApi.php';
require 'clases/usuario.php';
require 'clases/usuarioApi.php';
require 'clases/pedidosApi.php';
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

$app->group('/comanda', function () {
 
  $this->get('/', \comandaApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $this->get('/{codigo}/', \comandaApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  $this->post('/', \comandaApi::class . ':CargarUno');

  $this->delete('/', \comandaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarMozo');
     
})->add(\MWparaCORS::class . ':HabilitarCORS8080');


$app->group('/usuario', function () {
 
	$this->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   
	$this->get('/uno/{id_usuario}/', \usuarioApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

	$this->get('/dias/', \usuarioApi::class . ':GetDias');

	$this->get('/operaciones/area/{area}', \usuarioApi::class . ':GetOperacionesArea');
	
	$this->get('/operaciones/areaEmpleado/{area}', \usuarioApi::class . ':getOperacionesAreaEmpleado');

	$this->get('/operaciones/empleado/{usuario}', \usuarioApi::class . ':getOperacionesEmpleado');
  
	$this->post('/', \usuarioApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->delete('/', \usuarioApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->put('/', \usuarioApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
	   
  })->add(\MWparaCORS::class . ':HabilitarCORS8080');

  $app->group('/mesa', function () {
 
	$this->get('/', \mesaApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   
	$this->get('/{id_mesa}/', \mesaApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
	
	$this->get('/mesas/masUsada/', \mesaApi::class . ':masUsada')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
	
	$this->get('/mesas/menosUsada/', \mesaApi::class . ':menosUsada')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  
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
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios set ult_fecha_log=CURRENT_TIMESTAMP where usuario='$nombre'");
	$consulta->execute();
	$token= JsonWToken::LogIn($data);
  	$newResponse = $response->withJson($token, 200); 
	return $newResponse;	  
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/pedidos', function (){
	$this->get('/', \pedidosApi::class . ':traerTodos' )->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');
	
	$this->get('/masVendidos/', \pedidosApi::class . ':MasVendidos' );

	$this->get('/menosVendidos/', \pedidosApi::class . ':MenosVendidos' );
	
	$this->get('/cancelados/', \pedidosApi::class . ':TraerCancelados' );
	
	$this->put('/', \pedidosApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');

	$this->post('/', \pedidosApi::class . ':CargarUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

	$this->delete('/', \pedidosApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');
})->add(\MWparaCORS::class . ':HabilitarCORS8080');
$app->run();

/*Falta desde el 9-c en adelante */