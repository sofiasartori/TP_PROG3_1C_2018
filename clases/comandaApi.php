<?php
require_once 'Comanda.php';
require_once 'IApiUsable.php';

class comandaApi extends Comanda implements IApiUsable
{
 	
     public function TraerUno($request, $response, $args) {
      $codigo=$args['codigo'];
      $codigo=Comanda::ConsultarPedido($codigo);
      $response = $response->withJson($codigo, 200);  
      return $response;
    }
    
    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $id_mesa= $ArrayDeParametros['mesa'];
        $id_usuario=$ArrayDeParametros['usuario'];
        //$foto_mesa= ver como se obtiene una foto con $request
        $nombre_cliente=$ArrayDeParametros['cliente'];
        $miPedido = new Comanda();
        $miPedido->mesa=$id_mesa;
        $miPedido->mozo=$id_usuario;
        $miPedido->foto=$foto_mesa;
        $miPedido->nombre_cliente=$nombre_cliente;
        $miPedido->TomarPedido();
        $codigo='';
        $caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($caracteres) - 1;
        for ($i = 0; $i < 5; $i++) {
            $codigo .= $caracteres[mt_rand(0, $max)];
        }
        $response->getBody()->write("Pedido tomado, el codigo es: ".$codigo);
        return $response;
    }
    
    public function ModificarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $tiempo= $ArrayDeParametros['tiempo'];
        $codigo= $ArrayDeParametros['codigo'];
                
        $miPedido = new Comanda();
        $miPedido->tiempo=$tiempo;
        $miPedido->codigoAlfa=$codigo;
        $miPedido->EstablecerTiempo();
        $response->getBody()->write("Se estableció el tiempo estimado del pedido en ".$tiempo);

        return $response;
    }

    public function TraerTodos($request, $response, $args){
        $consulta= Mesa::traerTodasLasMesas();
        $response = $response->withJson($id, 200);
    }
    
    public function BorrarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $codigo = $ArrayDeParametros['codigo'];
        //$id_mozo= $ArrayDeParametros['usuario'];
        //tengo que verificar q el usuario es un mozo, JWT->getPayload
        $miPedido=new Comanda();
        $miPedido->codigoAlfa=$codigo;
        //$miPedido->mozo=$id_mozo;
        $miPedido->CancelarPedido();
        $response->getBody()->write("Se canceló el pedido ".$codigo);
    }
    
}