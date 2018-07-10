<?php
require_once ('AccesoDatos.php');
class Mesa
{
	public $id_mesa;
	public $estado;
	public $id_comanda;
	public $comentario;
	public $fecha_inicio;
	public $fecha_fin;


	public function CambiarEstado(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.mesas SET estado=:estado WHERE id_mesa=:id");
		$consulta->bindValue(':id', $this->id_mesa, PDO::PARAM_INT);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();		
		
	}

	public function AbrirMesa() 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.mesas set estado='Con cliente esperando pedido' where id_mesa=:id");
		$consulta->bindValue(':id',$this->id_mesa, PDO::PARAM_INT);
		$consulta->execute();							
	}

	public function CerrarMesa()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.mesas SET estado='Cerrada' WHERE id_mesa=:id");
		$consulta->bindValue(':id', $this->id_mesa, PDO::PARAM_INT);
		$consulta->execute();
		$comanda = new Comanda();
		$comanda::CargarHoraFin($this->id_mesa);		
	}

	public function ConsultarMesa($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id6145613_final.estado FROM mesas WHERE id_mesa=$id");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		return $mesaBuscada;

	}

	public function traerTodasLasMesas(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM id6145613_final.mesas");
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
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT m.id_mesa, COUNT(c.id_mesa) as 'Suma' FROM id6145613_final.mesas as m JOIN id6145613_final.comandas as c ON (m.id_mesa=c.id_mesa) GROUP BY c.id_mesa ORDER BY COUNT(c.id_mesa) DESC");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa más usada fue la mesa ".$mesaBuscada->id_mesa;
	}
	
	public function MesaMenosUsada(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT m.id_mesa, COUNT(c.id_mesa) as 'Suma' FROM id6145613_final.mesas as m JOIN id6145613_final.comandas as c ON (m.id_mesa=c.id_mesa) GROUP BY c.id_mesa ORDER BY COUNT(c.id_mesa) ASC");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa menos usada fue la mesa ".$mesaBuscada->id_mesa;
	}

	public function MesaMasFacturacion(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT sum(i.precio*it.cantidad) as 'SUMA', c.id_mesa from id6145613_final.items as i JOIN id6145613_final.itemsxcomanda as it ON(i.id_item=it.id_item) JOIN id6145613_final.comandas as c ON (c.id_comanda=it.id_comanda) group by c.id_mesa ORDER by sum(i.precio*it.cantidad) DESC limit 1;");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa que mas facturo fue la mesa ".$mesaBuscada->id_mesa." con un monto de $".$mesaBuscada->Suma;
	}

	public function MesaMenosFacturacion(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT sum(i.precio*it.cantidad) as 'SUMA', c.id_mesa from id6145613_final.items as i JOIN id6145613_final.itemsxcomanda as it ON(i.id_item=it.id_item) JOIN id6145613_final.comandas as c ON (c.id_comanda=it.id_comanda) group by c.id_mesa ORDER by sum(i.precio*it.cantidad) ASC limit 1");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa que menos facturo fue la mesa ".$mesaBuscada->id_mesa." con un monto de $".$mesaBuscada->Suma;
	}

	public function MesaFacturaMasImporte(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT sum(i.precio*it.cantidad) as 'SUMA', it.id_comanda, m.id_mesa from id6145613_final.items as i JOIN id6145613_final.itemsxcomanda as it ON(i.id_item=it.id_item) JOIN id6145613_final.mesas as m JOIN id6145613_final.comandas as c ON(it.id_comanda=c.id_comanda and m.id_mesa=c.id_mesa) group by it.id_comanda ORDER by sum(i.precio*it.cantidad) DESC limit 1;");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa que tuvo la factura con mas importe fue la mesa ".$mesaBuscada->id_mesa." con la comanda ".$id_comanda." con un monto de $".$mesaBuscada->Suma;
	}

	public function MesaFacturaMenosImporte(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT sum(i.precio) as 'SUMA', it.id_comanda, m.id_mesa from id6145613_final.items as i JOIN id6145613_final.itemsxcomanda as it ON(i.id_item=it.id_item) JOIN id6145613_final.mesas as m JOIN id6145613_final.comandas as c ON(it.id_comanda=c.id_comanda and m.id_mesa=c.id_mesa) group by it.id_comanda ORDER by sum(i.precio*it.cantidad) ASC limit 1;");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa que tuvo la factura con menos importe fue la mesa ".$mesaBuscada->id_mesa." con la comanda ".$id_comanda." con un monto de $".$mesaBuscada->Suma;
	}

	public function MesaMejorComentario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT sum(e.mozo+ e.restaurant+ e.cocinero+ e.mesa) as 'SUMA', c.id_mesa, e.comentario from id6145613_final.encuestas as e JOIN id6145613_final.comandas as c ON (e.id_comanda=c.id_comanda)group by c.id_comanda ORDER by SUM(e.mozo+ e.restaurant+ e.cocinero+ e.mesa) DESC limit 1;");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa que tuvo mejor puntaje fue la ".$mesaBuscada->id_mesa." con el comentario ".$mesaBuscada->comentario;
	}
	
	public function MesaPeorComentario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT sum(e.mozo+ e.restaurant+ e.cocinero+ e.mesa) as 'SUMA', c.id_mesa, e.comentario from id6145613_final.encuestas as e JOIN id6145613_final.comandas as c ON (e.id_comanda=c.id_comanda)group by c.id_comanda ORDER by SUM(e.mozo+ e.restaurant+ e.cocinero+ e.mesa) ASC limit 1;");
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa que tuvo peor puntaje fue la ".$mesaBuscada->id_mesa." con el comentario ".$mesaBuscada->comentario;
	}

	public function FacturaFechas(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta=$objetoAccesoDato->RetornarConsulta("SELECT sum(i.precio*it.cantidad) as 'SUMA', m.id_mesa from id6145613_final.items as i JOIN id6145613_final.itemsxcomanda as it ON(i.id_item=it.id_item) JOIN id6145613_final.mesas as m JOIN id6145613_final.comandas as c ON(it.id_comanda=c.id_comanda and m.id_mesa=c.id_mesa) where m.id_mesa=:id and c.fecha BETWEEN STR_TO_DATE(:fecha_inicio, '%d-%m-%Y') AND STR_TO_DATE(:fecha_fin, '%d-%m-%Y') group by m.id_mesa ORDER by m.id_mesa ASC limit 1;");
		$consulta->bindValue(':id',$this->id_mesa, PDO::PARAM_INT);
		$consulta->bindValue(':fecha_inicio', $this->fecha_inicio, PDO::PARAM_STR);
		$consulta->bindValue(':fecha_fin', $this->fecha_fin, PDO::PARAM_STR);
		$consulta->execute();
		$mesaBuscada= $consulta->fetchObject('Mesa');
		echo "La mesa ".$mesaBuscada->id_mesa." facturo $".$mesaBuscada->Suma." entre las fechas seleccionadas";
	}
	
}