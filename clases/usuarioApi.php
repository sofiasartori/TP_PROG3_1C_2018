<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';

class usuarioApi extends Usuario implements IApiUsable
{
 	
  public function TraerUno($request, $response, $args) {
    $usuario=$args['usuario'];
   	$usuario=Usuario::TraerUnUsuario($usuario);
   	$response = $response->withJson($usuario, 200);  
  	return $response;
  }
  
  public function CargarUno($request, $response, $args) {
    $ArrayDeParametros = $request->getParsedBody();
    $nombre= $ArrayDeParametros['nombre'];
    $apellido= $ArrayDeParametros['apellido'];
    $usuario= $ArrayDeParametros['usuario'];
    $perfil= $ArrayDeParametros['perfil'];
        
    $miUsuario = new Usuario();
    $miUsuario->nombre=$nombre;
    $miUsuario->apellido=$apellido;
    $miUsuario->usuario=$usuario;
    $miUsuario->perfil=$perfil;
    $miUsuario->InsertarUsuario();
    $response->getBody()->write("se guardo el usuario");

    return $response;
  }	
}