<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter mensajes Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jose Jimenez
 * @license		MIT License
 */

// ------------------------------------------------------------------------
if (!function_exists('getError')) {
	function getError($type='error'){
		$mensaje='';
		switch ($type) {
			case 'error':
				$mensaje='Ocurrió un error';
				break;
			case 'peticion':
				$mensaje="Petición no válida, esto es común al acceder a páginas no provistas o sin contenido. <a href='".base_url()."'>Ir al inicio</a>";
				break;
			case 'sesion':
				$mensaje="Tu sesión ha expirado, porfavor recarga la página. <a href='".base_url()."'>Recargar</a>";
				break;
			case 'acceso':
				$mensaje="No tienes acceso para ver lo que has solicitado, si crees que es un error contacta al encargado del sistema.";
				break;
			case 'contrasena':
				$mensaje="Error en usuario y/o contraseña";
				break;
			case 'ajax':
				$mensaje='errors/html/error_noAjax';
				break;
			case 'insert':
				$mensaje='Los datos no fueron guardados, intente de nuevo más tarde';
				break;
			case 'parametros':
				$mensaje='Faltan parametros, porfavor verifique que todos los campos esten completos';
				break;
			default:
				# code...
				break;
		}
		return $mensaje;
	}
}
if (!function_exists('getSuccess')) {
	function getSuccess($type='operacion'){
		$mensaje='';
		switch ($type) {
			case 'operacion':
				$mensaje='Operación realizada correctamente';
				break;
			case 'insert':
				$mensaje="Los datos se guardaron correctamente";
				break;
			default:
				# code...
				break;
		}
	}
}