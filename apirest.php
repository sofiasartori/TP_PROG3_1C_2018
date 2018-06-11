<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './clases/AccesoDatos.php';
require './clases/usuarioApi.php';
require './clases/MWparaCORS.php';
require './clases/MWparaAutentificar.php';

//use \Slim\App;

/*INSTALAR COMPOSER EN LA PC Y APARTE INSTALAR SLIM EN EL PROYECTO DONDE ESTÁ LA CARPETA DEL COMPOSER 
php composer.phar require slim/slim */

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*$app = new \Slim\App();

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

$app = new \Slim\App;

$app->group('/usuario', function () use ($app) {
 
  $app->get('/', \usuarioApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $app->get('/{usuario}', \usuarioApi::class . ':TraerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

  $app->post('/', \usuarioApi::class . ':CargarUno');

  $app->delete('/', \usuarioApi::class . ':BorrarUno');

  $app->put('/', \usuarioApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->run();