<?php

require_once("JWT.php");
class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
	public function VerificarUsuario($request, $response, $next) {
		$objResp= new stdclass();
		$objResp->respuesta="";	
		
		  if($request->isGet())
		  {
		     $response->getBody()->write('<p>NO necesita credenciales para los get </p>');
		     $response = $next($request, $response);
		  }
		  else
		  {
		    //*$response->getBody()->write('<p>verifico credenciales</p>');
		    $ArrayDeParametros = $request->getParsedBody();
		    $nombre=$ArrayDeParametros['nombre'];
		    $tipo=$ArrayDeParametros['perfil'];
		    /*if($tipo=="socia")
		    {
		      $response->getBody()->write("<h3>Bienvenido $nombre </h3>");
		      $response = $next($request, $response);
		    }
		    else
		    {
		      $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
				}*/
				$datos=array("usuario"=> $nombre, "perfil"=>$tipo);
				$token= JsonWToken::LogIn($datos);
				$objResp->esValido=true;
				try{
					JsonWToken::Checkear($token);
					$objResp->esValido=true;
				}
				catch (Exception $e){
					$objResp->excepcion=$e->getMessage();
					$objResp->esValido=false;
				}

				if($objResp->esValido){
					$payload=JsonWToken::ObtenerDatos($token);
					if($payload->perfil=="socio"){
						echo $token;
						$response=$next($request, $response);
						
					}
					else
						$objResp->respuesta="Solo administradores";
				}
				else{
					$objResp="Solo usuarios registrados";
					$objResp->elToken=$token;
				}
			}
			if($objResp->respuesta !=""){
				$nueva=$response->withJson($objResp, 401);
				return $nueva;
			}
		  //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		  return $response;   
	}
}