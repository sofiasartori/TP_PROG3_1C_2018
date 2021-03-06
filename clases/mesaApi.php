<?php
require_once 'mesa.php';
require_once 'IApiUsable.php';

class mesaApi extends Mesa implements IApiUsable
{
 	
     public function TraerUno($request, $response, $args) {
      $id=$args['id_mesa'];
      $mesa=Mesa::ConsultarMesa($id);
      $respuesta = $response->withJson("El estado de la mesa ".$id." es: ".$mesa->estado, 200);  
      return $respuesta;
    }
    
    public function CargarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $id= $ArrayDeParametros['mesa'];
                
        $miMesa = new Mesa();
        $miMesa->id_mesa=$id;
        $miMesa->AbrirMesa();
        $response->getBody()->write("Se abrió la mesa ".$id);
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
        $miMesa->CambiarEstado();
        $response->getBody()->write("Se cambió el estado de la mesa ".$id." a ".$estado);

        return $response;
    }

    public function TraerTodos($request, $response, $args){
        $consulta= Mesa::traerTodasLasMesas();
    }
    
    public function BorrarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['mesa'];
        
        $miMesa=new Mesa();
        $miMesa->id_mesa=$id;
        $miMesa->CerrarMesa();
        $response->getBody()->write("Se cerró la mesa ".$id);
    }

    public function FacturacionFechas($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $id = $ArrayDeParametros['mesa'];
        $fecha_inicio=$ArrayDeParametros['fecha_inicio'];
        $fecha_fin=$ArrayDeParametros['fecha_fin'];

        $miMesa=new Mesa();
        $miMesa->id_mesa=$id;
        $miMesa->fecha_inicio=$fecha_inicio;
        $miMesa->fecha_fin=$fecha_fin;
        $miMesa->FacturaFechas();
    }

    public function masUsada($request, $response, $args){
        Mesa::MesaMasUsada();
    }

    public function menosUsada($request, $response, $args){
        Mesa::MesaMenosUsada();
    }

    public function masFacturacion($request, $response, $args){
        Mesa::MesaMasFacturacion();
    }

    public function menosFacturacion($request, $response, $args){
        Mesa::MesaMenosFacturacion();
    }

    public function masFactura($request, $response, $args){
        Mesa::MesaFacturaMasImporte();
    }

    public function menosFactura($request, $response, $args){
        Mesa::MesaFacturaMenosImporte();
    }

    public function mejorComentario($request, $response, $args){
        Mesa::MesaMejorComentario();
    }

    public function peorComentario($request, $response, $args){
        Mesa::MesaPeorComentario();
    }
}