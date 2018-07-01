<?php
require_once ('AccesoDatos.php');
class Pedidos
{  	

    public $codigoAlfa;
    public $tiempo; 

	public function TomarPedido($items){
		
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
	
	public function CargarHoraFin($id){
		$hora=date("H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$fecha_fin=$objetoAccesoDato->RetornarConsulta("UPDATE comandas SET hora_fin='$hora' WHERE id_mesa=$id");
		$fecha_fin->execute();
	}
}