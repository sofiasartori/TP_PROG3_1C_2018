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
	public $operaciones;
	public $clave;


	public function MostrarTodosDatos(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("select nombre, apellido, usuario, perfil, area, estado, ult_fecha_log, fecha_alta, fecha_baja, operaciones from id6145613_final.usuarios");
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
					   <td>'.$i['fecha_baja'].'</td>
					   <td>'.$i['operaciones'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarDias(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("select usuario, ult_fecha_log, fecha_alta, fecha_baja from id6145613_final.usuarios");
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

	public function MostrarOperacionesArea(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT area, operaciones from id6145613_final.usuarios WHERE area=:area");
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Area</th><th>Operaciones</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['area'].'</td>
					   <td>'.$i['operaciones'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarOperacionesAreaEmpleado(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT usuario, area, operaciones from id6145613_final.usuarios WHERE area=:area");
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();		
		$tabla ='<table style="border:1px solid black;"><tr><th>Usuario</th><th>Area</th><th>Operaciones</th></tr>';
		while($i=$consulta->fetch()){
			$tabla = $tabla.'<tr><td>'.$i['usuario'].'</td>
					   <td>'.$i['area'].'</td>
					   <td>'.$i['operaciones'].'</td></tr>';
		}
		$tabla =$tabla.'</table>';
		echo $tabla;
	}

	public function MostrarOperacionesEmpleado(){
		$objetoPDO = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoPDO->RetornarConsulta("SELECT usuario, operaciones from id6145613_final.usuarios WHERE usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->execute();		
		$cantidad= $consulta->fetchObject('Usuario');
		echo "El usuario ".$cantidad->usuario." realizó ".$cantidad->operaciones." operaciones";
	}

	public function TraerUnUsuario($usuario, $clave) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id_usuario, nombre, apellido, usuario, perfil, area, estado, ult_fecha_log, fecha_alta, fecha_baja from id6145613_final.usuarios where usuario = '$usuario' AND clave='$clave'");
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('Usuario');
		return $usuarioBuscado;				
	}

	public function InsertarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into id6145613_final.usuarios (nombre, apellido, usuario, clave, perfil, area, estado, fecha_alta)values(:nombre,:apellido, :usuario, :clave, :perfil, :area, 'activo', CURRENT_TIMESTAMP)");
		$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
		$consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
		$consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
		$consulta->execute();
	}

	public function BorrarUsuario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.usuarios SET estado='borrado', fecha_baja=CURRENT_TIMESTAMP where usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->execute();
	}

	public function CambiarEstadoUsuario(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.usuarios SET estado=:estado where usuario=:usuario");
		$consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
		$consulta->execute();
	}	 
	 
}