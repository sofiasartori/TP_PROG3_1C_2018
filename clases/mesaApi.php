<?php
require_once 'mesa.php';
require_once 'IApiUsable.php';

class mesaApi extends Mesa implements IApiUsable
{
 	
     public function TraerUno($request, $response, $args) {
      $id=$args['mesa'];
      $id=Mesa::ConsultarMesa($id);
      $response = $response->withJson($id, 200);  
      return $response;
    }
    
    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $id= $ArrayDeParametros['mesa'];
                
        $miMesa = new Mesa();
        $miMesa->id_mesa=$id;
        $miUsuario->AbrirMesa();
        $response->getBody()->write("Se abrió la mesa");

        return $response;
    }
    
    public function ModificarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $id= $ArrayDeParametros['mesa'];
        $estado= $ArrayDeParametros['estado'];
                
        $miMesa = new Mesa();
        $miMesa->id_mesa=$id;
        $miMesa->estado=$estado;
        $miUsuario->CambiarEstado();
        $response->getBody()->write("Se abrió la mesa");

        return $response;
    }

    public function TraerTodos($request, $response, $args){
        $consulta= Mesa::traerTodasLasMesas();
        $response = $response->withJson($id, 200);
    }
	
}