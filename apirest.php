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
/**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */

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
 
	$this->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
   
	$this->get('/uno/{id_usuario}/', \usuarioApi::class . ':traerUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/dias/', \usuarioApi::class . ':GetDias')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/operaciones/area/{area}', \usuarioApi::class . ':GetOperacionesArea')->add(\MWparaAutentificar::class . ':VerificarUsuario');
	
	$this->get('/operaciones/areaEmpleado/{area}', \usuarioApi::class . ':getOperacionesAreaEmpleado')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/operaciones/empleado/{usuario}', \usuarioApi::class . ':getOperacionesEmpleado')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->post('/', \usuarioApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->delete('/', \usuarioApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->put('/', \usuarioApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
	   
  })->add(\MWparaCORS::class . ':HabilitarCORS8080');

  $app->group('/mesa', function () {
 
	$this->get('/', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
   
	$this->get('/{id_mesa}/', \mesaApi::class . ':traerUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
	
	$this->get('/mesas/masUsada/', \mesaApi::class . ':masUsada')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/mesas/masFacturacion/', \mesaApi::class . ':masFacturacion')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/mesas/menosFacturacion/', \mesaApi::class . ':masFacturacion')->add(\MWparaAutentificar::class . ':VerificarUsuario');
	
	$this->get('/mesas/mejorComentario/', \mesaApi::class . ':mejorComentario')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/mesas/peorComentario/', \mesaApi::class . ':peorComentario')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/mesas/menosUsada/', \mesaApi::class . ':menosUsada')->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->post('/facturacion/', \mesaApi::class . ':FacturacionFechas')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->post('/', \mesaApi::class . ':CargarUno');
  
	$this->delete('/', \mesaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
  
	$this->put('/', \mesaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarMozo');
	   
  })->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->post('/login/', function(Request $request, Response $response){
	$datos = $request->getParsedBody();
	$nombre=$datos['usuario'];
	$clave=$datos['clave'];
	$usuario=new Usuario();
	$usuarioBuscado=$usuario->TraerUnUsuario($nombre, $clave);
	$perfilJWT = $usuarioBuscado->perfil;
	$areaJWT = $usuarioBuscado->area;
	$data=array('Usuario'=>$nombre, 'Perfil'=>$perfilJWT, 'Area'=>$areaJWT);
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.usuarios set ult_fecha_log=CURRENT_TIMESTAMP where usuario='$nombre'");
	$consulta->execute();
	if(!isset($data['Perfil'])){
		$newResponse = $response->withJSON("Usted no pertenece al sistema", 400);
	}
	else{
		$token= JsonWToken::LogIn($data);
  		$newResponse = $response->withJson($token, 200); 
	}
	return $newResponse;	  
	
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/pedidos', function (){
	$this->get('/', \pedidosApi::class . ':traerTodos' )->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');
	
	$this->get('/masVendidos/', \pedidosApi::class . ':MasVendidos' )->add(\MWparaAutentificar::class . ':VerificarUsuario');

	$this->get('/menosVendidos/', \pedidosApi::class . ':MenosVendidos' )->add(\MWparaAutentificar::class . ':VerificarUsuario');
	
	$this->get('/cancelados/', \pedidosApi::class . ':TraerCancelados' )->add(\MWparaAutentificar::class . ':VerificarUsuario');
	
	$this->put('/', \pedidosApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');

	$this->post('/', \pedidosApi::class . ':CargarUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

	$this->delete('/', \pedidosApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':DevolverTipoTrabajador');
})->add(\MWparaCORS::class . ':HabilitarCORS8080');
$app->run();

/*Falta desde el 9-c en adelante */