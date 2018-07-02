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
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesas set estado='Con cliente esperando pedido' where id_mesa=:id");
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
		$tabla ='<table style="border:1px solid black;"><tr><th>Mesa</th><th>Estado</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['id_mesa'].'</td>
					   <td>'.$i['estado'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MesaMasUsada(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT m.id_mesa, COUNT(c.id_mesa) as 'Suma' FROM mesas as m JOIN comandas as c ON (m.id_mesa=c.id_mesa) GROUP BY c.id_mesa ORDER BY COUNT(c.id_mesa) DESC");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa más usada fue la mesa ".$mesaBuscada->id_mesa;
	}
	
	public function MesaMenosUsada(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT m.id_mesa, COUNT(c.id_mesa) as 'Suma' FROM mesas as m JOIN comandas as c ON (m.id_mesa=c.id_mesa) GROUP BY c.id_mesa ORDER BY COUNT(c.id_mesa) ASC");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa menos usada fue la mesa ".$mesaBuscada->id_mesa;
	}
}