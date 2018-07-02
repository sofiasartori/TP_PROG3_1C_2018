<?php

require_once("JWT.php");
require_once("pedidos.php");
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
				try{
					$token=$request->getHeader('HTTP_RESTAURANTLOLO')[0];
					JsonWToken::Checkear($token);
					$objResp->esValido=true;
				}
				catch (Exception $e){
					//$objResp->excepcion=$e->getMessage();
					$objResp->esValido=false;
				}

				if($objResp->esValido){
					$payload=JsonWToken::ObtenerDatos($token);
					if($payload->Perfil=="socio"){
						//echo $token;
						$response=$next($request, $response);
						
					}
					else
						$objResp->respuesta="Solo administradores";
				}
				else{
					$objResp->respuesta="Solo usuarios registrados";
				}
			}
			if($objResp->respuesta !=""){
				$nueva=$response->withJson($objResp, 401);
				return $nueva;
			}
		  //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		  return $response;   
	}

	public function VerificarMozo($request, $response, $next) {
		$objResp= new stdclass();
		$objResp->respuesta="";	
		
		  if($request->isPut())
		  {
		         
			try{
				$token=$request->getHeader('HTTP_RESTAURANTLOLO')[0];
				JsonWToken::Checkear($token);
				$objResp->esValido=true;
			}
			catch (Exception $e){
				$objResp->excepcion=$e->getMessage();
				$objResp->esValido=false;
			}

			if($objResp->esValido){
				$payload=JsonWToken::ObtenerDatos($token);
				if($payload->Perfil=="mozo"){
					//echo $token;
					$response=$next($request, $response);
					
				}
				else
					$objResp->respuesta="Solo mozos pueden realizar esta acción";
			}
			else{
				$objResp="Solo usuarios registrados";
				$objResp->elToken=$token;
			}
		}
		else
			echo "no funciona el isPut";
		if($objResp->respuesta !=""){
			$nueva=$response->withJson($objResp, 401);
			return $nueva;
		}
		//$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		return $response;   
	}

	public function DevolverTipoTrabajador($request, $response, $next){
		$objResp= new stdclass();
		$objResp->respuesta="";	
		
		  if($request->isGet())
		  {
		         
			try{
				$token=$request->getHeader('HTTP_RESTAURANTLOLO')[0];
				JsonWToken::Checkear($token);
				$objResp->esValido=true;
			}
			catch (Exception $e){
				$objResp->excepcion=$e->getMessage();
				$objResp->esValido=false;
			}

			if($objResp->esValido){
				$payload=JsonWToken::ObtenerDatos($token);
				$pedido = new Pedidos();
				$pedido->pedidosPendientes($payload->Perfil);
				
			}
			else{
				$objResp="Solo usuarios registrados";
				$objResp->elToken=$token;
			}
		}
		else if($request->isPut()){
			try{
				$token=$request->getHeader('HTTP_RESTAURANTLOLO')[0];
				JsonWToken::Checkear($token);
				$objResp->esValido=true;
			}
			catch (Exception $e){
				$objResp->excepcion=$e->getMessage();
				$objResp->esValido=false;
			}

			if($objResp->esValido){
				$payload=JsonWToken::ObtenerDatos($token);
				PedidosApi::ModificarUno($request, $response, $payload);
				
			}
			else{
				$objResp="Solo usuarios registrados";
				$objResp->elToken=$token;
			}
		}
		else if($request->isDelete()){
			try{
				$token=$request->getHeader('HTTP_RESTAURANTLOLO')[0];
				JsonWToken::Checkear($token);
				$objResp->esValido=true;
			}
			catch (Exception $e){
				$objResp->excepcion=$e->getMessage();
				$objResp->esValido=false;
			}

			if($objResp->esValido){
				$payload=JsonWToken::ObtenerDatos($token);
				PedidosApi::BorrarUno($request, $response, $payload->Perfil);
				
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