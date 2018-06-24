<?php
require_once ('AccesoDatos.php');
class Usuario
{
	public $nombre;
 	public $apellido;
  	public $usuario;
	public $perfil;
	public $area;


	public function MostrarTodosDatos(){
		//$this->objetoPDO = new PDO('mysql:host=localhost;sdbname=id6145613_sofiasar_final;charset=utf8', 'id6145613_sofiasar_sofia', 'iPad2017', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO = new PDO('mysql:host=localhost;dbname=sofiasar_final;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO->exec("SET CHARACTER SET utf8"); 
		$consulta =$objetoPDO->prepare("select nombre, apellido, usuario, perfil, area from usuarios");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
	}

	public function TraerUnUsuario($usuario) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select id_usuario, nombre, apellido, usuario, perfil, area from usuarios where usuario = '$usuario'");
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('Usuario');
		return $usuarioBuscado;				
	}

	public function InsertarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre, apellido, usuario, perfil, area)values(:nombre,:apellido, :usuario, :perfil, :area)");
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
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