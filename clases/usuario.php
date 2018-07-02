<?php
require_once ('AccesoDatos.php');
class Usuario
{
	public $nombre;
 	public $apellido;
  	public $usuario;
	public $perfil;
	public $area;
	public $estado;
	public $id_usuario;
	public $ult_fecha_log;
	public $fecha_alta;
	public $fecha_baja;


	public function MostrarTodosDatos(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("select nombre, apellido, usuario, perfil, area, estado, ult_fecha_log, fecha_alta, fecha_baja from usuarios");
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Nombre</th><th>Apellido</th><th>Usuario</th><th>Perfil</th><th>Area</th><th>Estado</th><th>Fecha ult log</th><th>Fecha alta</th><th>Fecha baja</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['nombre'].'</td>
					   <td>'.$i['apellido'].'</td>
					   <td>'.$i['usuario'].'</td>
					   <td>'.$i['perfil'].'</td>
					   <td>'.$i['area'].'</td>
					   <td>'.$i['estado'].'</td>
					   <td>'.$i['ult_fecha_log'].'</td>
					   <td>'.$i['fecha_alta'].'</td>
					   <td>'.$i['fecha_baja'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarDias(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("select usuario, ult_fecha_log, fecha_alta, fecha_baja from usuarios");
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Fecha ult log</th><th>Fecha alta</th><th>Fecha baja</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['usuario'].'</td>
					   <td>'.$i['ult_fecha_log'].'</td>
					   <td>'.$i['fecha_alta'].'</td>
					   <td>'.$i['fecha_baja'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarOperaciones(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT u.usuario from usuarios as u join comandas as c on (c.mozo=u.id_usuario)");
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Fecha ult log</th><th>Fecha alta</th><th>Fecha baja</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['usuario'].'</td>
					   <td>'.$i['ult_fecha_log'].'</td>
					   <td>'.$i['fecha_alta'].'</td>
					   <td>'.$i['fecha_baja'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function TraerUnUsuario($usuario) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select id_usuario, nombre, apellido, usuario, perfil, area, estado, ult_fecha_log, fecha_alta, fecha_baja from usuarios where usuario = '$usuario'");
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('Usuario');
		return $usuarioBuscado;				
	}

	public function InsertarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre, apellido, usuario, perfil, area, estado, fecha_alta)values(:nombre,:apellido, :usuario, :perfil, :area, 'activo', CURRENT_TIMESTAMP)");
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();
	}

	public function BorrarUsuario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET estado='borrado', fecha_baja=CURRENT_TIMESTAMP where usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->execute();
	}

	public function CambiarEstadoUsuario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET estado=:estado where usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->execute();
	}	 
	 
}