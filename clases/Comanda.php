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
	//agrego el codigo alfanumerico
	public $codigoAlfa;


	public function TomarPedido($id_mesa, $id_mozo, $foto, $nombre_cliente){
		$objetoPDO = new PDO('mysql:host=localhost;dbname=sofiasar_final;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO->exec("SET CHARACTER SET utf8"); 
		$consulta =$objetoPDO->prepare("INSERT into comandas (id_mesa, id_usuario, foto_mesa, nombre_cliente, hora_inicio, fecha) values (:id_mesa, :id_mozo, ':foto', ':nombre_cliente', NOW(), DATE())");
		$consulta->bindValue(':id_mesa',$mesa, PDO::PARAM_INT);
		$consulta->bindValue(':id_usuario', $mozo, PDO::PARAM_INT);
		$consulta->bindValue(':foto_mesa', $foto, PDO::PARAM_STR);
		$consulta->bindValue(':nombre_cliente', $nombre_cliente, PDO::PARAM_STR);
        $consulta->execute();			
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public static function EstablecerTiempo($tiempo, $id_pedido) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set tiempo=$tiempo where id_comanda=$id_pedido");
		$consulta->execute();
			
	}

	public function ConsultarPedido($codigo)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT tiempo FROM comandas WHERE codigo='$codigo'");
		$consulta->execute();
		echo "El tiempo estimado de la comanda es: ".$consulta;	

	}

	public function CancelarPedido($codigo){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE comandas set estado='cancelado' where id_comanda=$codigo");
		$consulta->execute();
	}

	 /*public function InsertarDatos($valor_char, $valor_date, $valor_int){
		$objetoPDO = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO->exec("SET CHARACTER SET utf8"); 
		$consulta =$objetoPDO->prepare("INSERT into tabla (valor_char, valor_date, valor_int)values(:valor_char,:valor_date,:valor_int)");
		$consulta->bindValue(':valor_char',$valor_char, PDO::PARAM_STR);
		$consulta->bindValue(':valor_date', $valor_date, PDO::PARAM_STR);
		$consulta->bindValue(':valor_int', $valor_int, PDO::PARAM_INT);
		$consulta->execute();		
	 }*/
	 
	 
}