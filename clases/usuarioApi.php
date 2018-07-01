<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';

class usuarioApi extends Usuario implements IApiUsable
{
 	
     public function TraerUno($request, $response, $args) {
        $usuario=$args['usuario'];
        $miUsuario=Usuario::TraerUnUsuario($usuario);
     	$respuesta = $response->withJson($miUsuario, 200);  
    	return $respuesta;
    }

    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $usuario= $ArrayDeParametros['usuario'];
        $perfil= $ArrayDeParametros['perfil'];
        $area= $ArrayDeParametros['area'];

        $miUsuario = new Usuario();
        $miUsuario->nombre=$nombre;
        $miUsuario->apellido=$apellido;
        $miUsuario->usuario=$usuario;
        $miUsuario->perfil=$perfil;
        $miUsuario->area=$area;
        $miUsuario->InsertarUsuario();
        $response->getBody()->write("Se insertó el usuario");

        return $response;
    }

    public function BorrarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $usuario= $ArrayDeParametros['usuario'];

        $miUsuario = new Usuario();
        $miUsuario->usuario=$usuario;
        $miUsuario->BorrarUsuario();
        $response->getBody()->write("El usuario ".$usuario." fue dado de baja del sistema");
    }

    public function ModificarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $usuario= $ArrayDeParametros['usuario'];
        $estado=$ArrayDeParametros['estado'];

        $miUsuario = new Usuario();
        $miUsuario->usuario=$usuario;
        $miUsuario->estado=$estado;
        $miUsuario->CambiarEstadoUsuario();
        $response->getBody()->write("El estado del usuario ".$usuario." cambió a ".$estado);
    }

    public function TraerTodos($request, $response, $args){
        
    }
        
}