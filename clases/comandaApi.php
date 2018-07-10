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
        $fotos = $request->getUploadedFiles();
        $id_mesa= $ArrayDeParametros['mesa'];
        $id_usuario=$args;
        $foto_mesa= $fotos['foto'];
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

        $destino='/storage/ssd3/613/6145613/public_html/Fotos/comandas/';
        $idFoto = $id_comanda;
        $nombreFoto=$foto_mesa->getClientFileName();        
        $tipoArchivo=pathinfo($nombreFoto, PATHINFO_EXTENSION);
        if($tipoArchivo != "jpg" && $tipoArchivo !="jpeg" && $tipoArchivo != "png") {
			echo "S&oacute;lo son permitidas imagenes con extensi&oacute;n JPG, JPEG o PNG.";
        }
        else{
            if(!file_exists($destino)){
                mkdir($destino);
                move_uploaded_file($foto_mesa->file, $destino.$idFoto.'.'.$tipoArchivo);
            }
            else{
                move_uploaded_file($foto_mesa->file, $destino.$idFoto.'.'.$tipoArchivo);
            }
        }

        $miPedido = new Comanda();
        $miPedido->codigoAlfa=$id_comanda;
        $miPedido->mesa=$id_mesa;
        $miPedido->mozo=$id_usuario;
        $miPedido->foto=$destino.$idFoto.'.'.$tipoArchivo;
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