<?php
require_once 'pedidos.php';
require_once 'Comanda.php';
require_once 'IApiUsable.php';

class pedidosApi extends Pedidos implements IApiUsable
{
 	
     public function TraerUno($request, $response, $args) {
        
    }

    public function MasVendidos() {
        $miPedido=Pedidos::MasVendidos();
    }

    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $codigo = $ArrayDeParametros['codigo'];
        $mesa= $ArrayDeParametros['mesa'];
        $restaurant= $ArrayDeParametros['restaurant'];
        $mozo= $ArrayDeParametros['mozo'];
        $cocinero= $ArrayDeParametros['cocinero'];
        $comentario= $ArrayDeParametros['comentario'];

        $miPedido = new Pedidos();
        $miPedido->mesa=$mesa;
        $miPedido->restaurant=$restaurant;
        $miPedido->mozo=$mozo;
        $miPedido->cocinero=$cocinero;
        $miPedido->comentario=$comentario;
        $miPedido->codigoAlfa=$codigo;
        $respuesta=$miPedido->CompletarEncuesta();
        $response->getBody()->write($respuesta);

        return $response;
    }

    public function BorrarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $codigo= $ArrayDeParametros['codigo'];

        $miPedido = new Pedidos();
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

    public function TraerCancelados(){
        $pedidos=Pedidos::Cancelados();
    }
        
}