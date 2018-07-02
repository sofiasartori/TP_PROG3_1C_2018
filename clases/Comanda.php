<?php
require_once ('AccesoDatos.php');
class Comanda
{
	public $mesa;
 	public $mozo;
  	public $foto;
	public $nombre_cliente;
	public $tiempo_cocina;
	public $tiempo_barra;
	public $tiempo_cerveza;
	public $codigoAlfa;

	public function TomarPedido($items){
		$fecha=date("Y-m-d");
		$hora=date("H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into id6145613_final.comandas (id_comanda, id_mesa, id_usuario, foto_mesa, nombre_cliente, hora_inicio, fecha) values (:id_comanda,:id_mesa, :id_usuario, :foto_mesa, :nombre_cliente, '$hora', '$fecha')");
		$consulta->bindValue(':id_comanda', $this->codigoAlfa, PDO::PARAM_STR);
		$consulta->bindValue(':id_mesa',$this->mesa, PDO::PARAM_INT);
		$consulta->bindValue(':id_usuario', $this->mozo, PDO::PARAM_INT);
		$consulta->bindValue(':foto_mesa', $this->foto, PDO::PARAM_STR);
		$consulta->bindValue(':nombre_cliente', $this->nombre_cliente, PDO::PARAM_STR);		
		$consulta->execute();			
		
		for ($i=0; $i <sizeof($items) ; $i++) { 
			$itemsComanda = $objetoAccesoDato->RetornarConsulta("INSERT into id6145613_final.itemsxcomanda (id_item, id_comanda, cantidad) values (:id_item, :id_comanda, :cantidad);");
			$itemsComanda->bindValue(':id_item', $items[$i]['item'], PDO::PARAM_INT);
			$itemsComanda->bindValue(':id_comanda', $this->codigoAlfa, PDO::PARAM_STR);
			$itemsComanda->bindValue(':cantidad', $items[$i]['cantidad'], PDO::PARAM_INT);
			$itemsComanda->execute();
		}
		
	}

	public function ConsultarPedido($codigo)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT foto_mesa, tiempo_cocina, estado_cocina, tiempo_barra, estado_barra, tiempo_cerveza, estado_cerveza FROM id6145613_final.comandas WHERE id_comanda='$codigo'");
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Comanda');
		return $pedidoBuscado;

	}

	public function CancelarPedido(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.comandas set estado='cancelado' where id_comanda=:id_comanda");
		$consulta->bindValue(':id_comanda',$this->codigoAlfa, PDO::PARAM_STR);
		$consulta->execute();
	}
	
	public function CargarHoraFin($id){
		$hora=date("H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$fecha_fin=$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.comandas SET hora_fin='$hora', estado='Terminado' WHERE id_mesa=$id");
		$fecha_fin->execute();
	}
}