<?php
require_once 'Comanda.php';
require_once 'IApiUsable.php';

class comandaApi extends Comanda implements IApiUsable
{
 	
     public function TraerUno($request, $response, $args) {
      $codigo=$args['codigo'];
      $pedido=Comanda::ConsultarPedido($codigo);
      $respuesta = $response->withJson("El tiempo de espera para su pedido es de ".$pedido->tiempo_cocina." minutos", 200);  
      return $respuesta;
    }
    
    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $id_mesa= $ArrayDeParametros['mesa'];
        $id_usuario=$ArrayDeParametros['usuario'];
        //$foto_mesa= ver como se obtiene una foto con $request
        $nombre_cliente=$ArrayDeParametros['cliente'];
        $items=array();
        
        foreach ($ArrayDeParametros['item'] as $key => $valor) {
            array_push($items, $valor);
        }        
        
        $id_comanda='';
        $caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($caracteres) - 1;
        for ($i = 0; $i < 5; $i++) {
            $id_comanda .= $caracteres[mt_rand(0, $max)];
        }

        $miPedido = new Comanda();
        $miPedido->codigoAlfa=$id_comanda;
        $miPedido->mesa=$id_mesa;
        $miPedido->mozo=$id_usuario;
        //$miPedido->foto=$foto_mesa;
        $miPedido->nombre_cliente=$nombre_cliente;
        
        $miPedido->TomarPedido($items);
        
        $response->getBody()->write("Pedido tomado, el codigo es: ".$id_comanda);
        return $response;
    }
    
    public function ModificarUno($request, $response, $args){
        
    }

    public function TraerTodos($request, $response, $args){
        
    }
    
    public function BorrarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $codigo = $ArrayDeParametros['codigo'];
        
        $miPedido=new Comanda();
        $miPedido->codigoAlfa=$codigo;
        $miPedido->CancelarPedido();
        $response->getBody()->write("Se canceló el pedido ".$codigo);
    }
    
}