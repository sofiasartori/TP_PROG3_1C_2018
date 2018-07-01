<?php
require_once ('AccesoDatos.php');
class Mesa
{
	public $id_mesa;
  	public $estado;


	public function CambiarEstado(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado=:estado WHERE id_mesa=:id");
		$consulta->bindValue(':id', $this->id_mesa, PDO::PARAM_INT);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();		
		
	}

	public function AbrirMesa() 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into mesas values(:id, 'Con cliente esperando pedido')");
		$consulta->bindValue(':id',$this->id_mesa, PDO::PARAM_INT);
		$consulta->execute();							
	}

	public function CerrarMesa()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado='Cerrada' WHERE id_mesa=:id");
		$consulta->bindValue(':id', $this->id_mesa, PDO::PARAM_INT);
		$consulta->execute();
		$comanda = new Comanda();
		$comanda::CargarHoraFin($this->id_mesa);		
	}

	public function ConsultarMesa($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT estado FROM mesas WHERE id_mesa=$id");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		return $mesaBuscada;

	}

	public function traerTodasLasMesas(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas");
		$consulta->execute();
		//quiero ver que trae la consulta, si es un array armo el codigo para hacer una tabla 
		var_dump($consulta);
	}
 
}