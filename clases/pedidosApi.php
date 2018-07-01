<?php
require_once 'pedidos.php';
require_once 'Comanda.php';
require_once 'IApiUsable.php';

class pedidosApi extends Pedidos implements IApiUsable
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
        $codigo= $ArrayDeParametros['codigo'];

        $miPedido = new Pedido();
        $miPedido->codigoAlfa=$codigo;
        $miUsuario->TerminarPedido($args);
        $response->getBody()->write("El pedido ".$pedido." ya está listo por parte del ".$args);
    }

    public function ModificarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $tiempo= $ArrayDeParametros['tiempo'];
        $codigo= $ArrayDeParametros['codigo'];
                
        $miPedido = new Pedidos();
        $miPedido->codigoAlfa=$codigo;
        $miPedido->tiempo=$tiempo;
        $miPedido->EstablecerTiempo($args);
        $response->getBody()->write("Se estableció el tiempo estimado del pedido en ".$tiempo." minutos para la comanda ".$codigo);
        return $response;
    }

    public function TraerTodos($request, $response, $args){
        $pedidos=new Pedidos();
        $pedidos->pedidosPendientes();   
    }
        
}