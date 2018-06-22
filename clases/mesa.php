<?php
require_once ('AccesoDatos.php');
class Mesa
{
	public $id_mesa;
  	public $estado;


	public function CambiarEstado($id, $estado){
		//$this->objetoPDO = new PDO('mysql:host=localhost;sdbname=id6145613_sofiasar_final;charset=utf8', 'id6145613_sofiasar_sofia', 'iPad2017', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO = new PDO('mysql:host=localhost;dbname=sofiasar_final;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO->exec("SET CHARACTER SET utf8"); 
		$consulta =$objetoPDO->prepare("UPDATE mesas SET estado='$estado' WHERE id_mesa=$id");
        $consulta->execute();			
		echo "Estado de la mesa ".$id." cambiado a ".$estado;
	}

	public static function AbrirMesa($id) 
	{
		$objetoPDO = new PDO('mysql:host=localhost;dbname=sofiasar_final;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$consulta =$objetoPDO->prepare("INSERT into mesas values(:id, 'Con cliente esperando pedido')");
		$consulta->bindValue(':id',$id, PDO::PARAM_INT);
		$consulta->execute();
		echo "La mesa ".$id." fue abierta";							
	}

	public function CerrarMesa($perfil, $id, $id_pedido)
	{
		if($perfil=='socio')
		//tengo que verificar con el jwt->getPayload
		{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesas SET estado='Cerrada' WHERE id=$id");
            $consulta->execute();
            $fecha_fin=$objetoAccesoDato->RetornarConsulta("UPDATE comandas SET fecha_fin=NOW() WHERE id_mesa=$id and id_comanda=$id_pedido");
            echo "La mesa ".$id." fue cerrada";
        }
        else
            echo "Solo un socio puede cerrar la mesa";
	}

	public function ConsultarMesa($id)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT estado FROM mesas WHERE id=$id");
		$consulta->execute();
		echo "El estado de la mesa es: ".$consulta;      
	}

	public function traerTodasLasMesas(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM mesas");
		$consulta->execute();
		//quiero ver que trae la consulta, si es un array armo el codigo para hacer una tabla 
		var_dump($consulta);
	}
 
}