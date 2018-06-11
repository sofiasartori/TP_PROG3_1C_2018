<?php
require_once ('AccesoDatos.php');
class Usuario
{
	public $nombre;
 	public $apellido;
  	public $usuario;
  	public $perfil;


	public function MostrarTodosDatos(){
		$objetoPDO = new PDO('mysql:host=localhost:8080;dbname=sofiasar_final;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$objetoPDO->exec("SET CHARACTER SET utf8"); 
		$consulta =$objetoPDO->prepare("select nombre, apellido, usuario, perfil from usuarios");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
	}

	 public function InsertarUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				echo ('insertando');
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre, apellido, usuario, perfil)values('$this->nombre', '$this->apellido','$this->usuario','$this->perfil')");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				

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
	 
	 

	public static function TraerUnUsuario($usuario) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, apellido, usuario, perfil from usuarios where usuario = '$usuario'");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('Usuario');
			return $usuarioBuscado;				

			
	}


}