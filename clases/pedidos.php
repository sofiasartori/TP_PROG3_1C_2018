<?php
require_once ('AccesoDatos.php');
class Pedidos
{  	

    public $codigoAlfa;
	public $tiempo; 
	public $restaurant;
	public $mesa;
	public $cocinero;
	public $comentario;
	public $mozo;
	public $estado;
	public $id_item;
	public $id_descripcion;

	public function CompletarEncuesta(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT estado FROM comandas WHERE id_comanda=:id_comanda");
		$consulta->bindValue(':id_comanda', $this->codigoAlfa, PDO::PARAM_STR);
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Pedidos');
		if($pedidoBuscado->estado != 'Terminado'){
			return "Todavia no puede completar la encuesta";

		}
		else{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
			$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into encuestas values (:id_comanda, :mesa, :mozo, :restaurant, :cocinero, :comentario)");		
			$consulta->bindValue(':id_comanda', $this->codigoAlfa, PDO::PARAM_STR);
			$consulta->bindValue(':mesa', $this->mesa, PDO::PARAM_INT);
			$consulta->bindValue(':mozo', $this->mo<o, PDO::PARAM_INT);
			$consulta->bindValue(':restaurant', $this->restaurant, PDO::PARAM_INT);
			$consulta->bindValue(':cocinero', $this->cocinero, PDO::PARAM_INT);
			$consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
			$consulta->execute();
			return "Gracias por completar la encuesta!!!";
		}
		
	}

	public function EstablecerTiempo($perfil) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if($perfil=='cocinero') {
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo_cocina=:tiempo, estado_cocina='En preparacion' where id_comanda=:id_pedido");
            $consulta->bindValue(':tiempo',$this->tiempo, PDO::PARAM_INT);
            $consulta->bindValue(':id_pedido',$this->codigoAlfa, PDO::PARAM_STR);            
	        $consulta->execute();			
        }
		else if($perfil=='cervecero') {
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo_cerveza=:tiempo, estado_cerveza='En preparacion' where id_comanda=:id_pedido");
            $consulta->bindValue(':tiempo',$this->tiempo, PDO::PARAM_INT);
		    $consulta->bindValue(':id_pedido',$this->codigoAlfa, PDO::PARAM_STR);
            $consulta->execute();
        }
        else if($perfil=='bartender') {
			
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo_barra=:tiempo, estado_barra='En preparacion' where id_comanda=:id_comanda");
            $consulta->bindValue(':tiempo',$this->tiempo, PDO::PARAM_INT);
		    $consulta->bindValue(':id_comanda',$this->codigoAlfa, PDO::PARAM_STR);
            $consulta->execute();
        }
	}

	public function pedidosPendientes($perfil)
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if($perfil=='cocinero') {
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT it.id_item, it.id_comanda FROM itemsxcomanda as it JOIN items as i on (i.tipo='comida' and it.id_item=i.id_item) JOIN comandas as c on (c.id_comanda=it.id_comanda and c.tiempo_cocina is null and c.estado_cocina is null)");
            $consulta->execute();
            $pedidoBuscado= $consulta->fetchAll();
        }
		else if($perfil=='cervecero') {
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT it.id_item, it.id_comanda FROM itemsxcomanda as it JOIN items as i on (i.tipo='cerveza' and it.id_item=i.id_item) JOIN comandas as c on (c.id_comanda=it.id_comanda and c.tiempo_cerveza is null and c.estado_cerveza is null)");
            $consulta->execute();
            $pedidoBuscado= $consulta->fetchAll();
        }
        else if($perfil=='bartender') {
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT it.id_item, it.id_comanda FROM itemsxcomanda as it JOIN items as i on (i.tipo='bar' and it.id_item=i.id_item) JOIN comandas as c on (c.id_comanda=it.id_comanda and c.tiempo_barra is null and c.estado_barra is null)");
            $consulta->execute();
            $pedidoBuscado= $consulta->fetchAll();            
        }

	}

	public function TerminarPedido($perfil){		
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if($perfil=='cocinero') {
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo_cocina=0, estado_cocina='Listo para servir' where id_comanda=:id_pedido");
            $consulta->bindValue(':id_pedido',$this->codigoAlfa, PDO::PARAM_STR);            
	        $consulta->execute();			
        }
		else if($perfil=='cervecero') {
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo_cerveza=0, estado_cerveza='Listo para servir' where id_comanda=:id_pedido");
		    $consulta->bindValue(':id_pedido',$this->codigoAlfa, PDO::PARAM_STR);
            $consulta->execute();
        }
        else if($perfil=='bartender') {
			
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo_barra=0, estado_barra='Listo para servir' where id_comanda=:id_comanda");
		    $consulta->bindValue(':id_comanda',$this->codigoAlfa, PDO::PARAM_STR);
            $consulta->execute();
        }
	}
	
	public function MasVendidos(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		//revisar que no esta devolviendo bien las cantidades
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT i.id_item, i.descripcion, count(c.cantidad) as 'Cantidades' from items as i JOIN itemsxcomanda as c ON (i.id_item=c.id_item) group by c.cantidad order by COUNT(c.cantidad) DESC limit 1");		
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Pedidos');
		echo "Producto más vendido: Se vendieron ".$pedidoBuscado->Cantidades." unidades de ".$pedidoBuscado->descripcion." en total";
	}

	public function MenosVendidos(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		//revisar que no esta devolviendo bien las cantidades
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT i.id_item, i.descripcion, count(c.cantidad) as 'Cantidades' from items as i JOIN itemsxcomanda as c ON (i.id_item=c.id_item) group by c.cantidad order by COUNT(c.cantidad) DESC limit 1");		
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Pedidos');
		echo "Producto más vendido: Se vendieron ".$pedidoBuscado->Cantidades." unidades de ".$pedidoBuscado->descripcion." en total";
	}

	public function Cancelados(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id_comanda from comandas where estado='cancelado'");		
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Pedidos');
		echo "Pedidos cancelados: ".$pedidoBuscado->id_comanda;
	}
}