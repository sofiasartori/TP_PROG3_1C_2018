<?php
require_once ('AccesoDatos.php');
class Comanda
{
	public $mesa;
 	public $mozo;
  	public $foto;
	public $nombre_cliente;
    public $estado;
    public $tiempo;
    public $hora_inicio;
    public $fecha;
	public $hora_fin;
	public $codigoAlfa;


	public function TomarPedido(){
		$fecha=date("D-M-Y");
		$hora=date("H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into comandas (id_comanda, id_mesa, id_usuario, nombre_cliente, hora_inicio, fecha) values (:id_comanda,:id_mesa, :id_usuario, :nombre_cliente, '$hora', '$fecha')");
		$consulta->bindValue(':id_comanda', $this->codigoAlfa, PDO::PARAM_STR);
		$consulta->bindValue(':id_mesa',$this->mesa, PDO::PARAM_INT);
		$consulta->bindValue(':id_usuario', $this->mozo, PDO::PARAM_INT);
		//$consulta->bindValue(':foto_mesa', $foto, PDO::PARAM_STR);
		$consulta->bindValue(':nombre_cliente', $this->nombre_cliente, PDO::PARAM_STR);		
        $consulta->execute();			
	}

	public function EstablecerTiempo() 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo=:tiempo where id_comanda=:id_pedido");
		$consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_INT);
		$consulta->bindValue(':id_pedido',$this->codigoAlfa, PDO::PARAM_STR);
	    $consulta->execute();			
	}

	public function ConsultarPedido($codigo)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT tiempo FROM comandas WHERE id_comanda='$codigo'");
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Comanda');
		return $pedidoBuscado;

	}

	public function CancelarPedido(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set estado='cancelado' where id_comanda=:id_comanda");
		$consulta->bindValue(':id_comanda',$this->codigoAlfa, PDO::PARAM_STR);
		$consulta->execute();
	}	 
}