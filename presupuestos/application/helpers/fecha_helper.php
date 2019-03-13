<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	Jose Jimenez
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter String Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jose Jimenez
 */

// ------------------------------------------------------------------------

if ( ! function_exists('getDateNom'))
{
	/**
	 * getDateNom
	 *
	 * Crea una cadena de enunciado de la fecha, recibiendo el dia,el mes, el año,e nombre del dia y si es largo
	 *
	 * /this/that/theother/
	 *
	 * becomes:
	 *
	 * this/that/theother
	 *
	 * @todo	Remove in version 3.1+.
	 * @deprecated	3.0.0	This is just an alias for PHP's native trim()
	 *
	 * @param	string
	 * @return	string
	 */
	function getDateNom($dia,$mes,$ano,$nomdia,$larg=false){
		$diac='';
		$dial='';
		$mesc='';
		$mesl='';
		$mesf='';
		$diaf='';
		switch ($nomdia) {
			case 'Sunday':
				$diac='Dom';
				$dial='Domingo';
				break;
			case 'Monday':
				$diac='Lun';
				$dial='Lunes';	
				break;
			case 'Tuesday':
				$diac='Mar.';
				$dial='Martes';
				break;
			case 'Wednesday':
				$diac='Mie';
				$dial='Miercoles';
				break;
			case 'Thursday':
				$diac='Jue';
				$dial='Jueves';
				break;
			case 'Friday':
				$diac='Vie';
				$dial='Viernes';
				break;
			case 'Saturday':
				$diac='Sáb';
				$dial='Sábado';
				break;
			default:
				# code...
				break;
		}
		switch ($mes) {
			case '01':
				$mesc='Ene';
				$mesl='Enero';
				break;
			case '02':
				$mesc='Feb';
				$mesl='Febrero';
				break;
			case '03':
				$mesc='Mar';
				$mesl='Marzo';
				break;
			case '04':
				$mesc='Abr';
				$mesl='Abril';
				break;
			case '05':
				$mesc='May';
				$mesl='Mayo';
				break;
			case '06':
				$mesc='Jun';
				$mesl='Junio';
				break;
			case '07':
				$mesc='Jul';
				$mesl='Julio';
				break;
			case '08':
				$mesc='Ago';
				$mesl='Agosto';
				break;
			case '09':
				$mesc='Sep';
				$mesl='';
				break;
			case '10':
				$mesc='Oct';
				$mesl='Octubre';
				break;
			case '11':
				$mesc='Nov';
				$mesl='Noviembre';
				break;
			case '12':
				$mesc='Dic';
				$mesl='Diciembre';
				break;
			default:
				# code...
				break;
		}
		if ($larg==true) {
			$diaf=$dial;
			$mesf=$mesl.' de';
		}else{
			$diaf=$diac;
			$mesf=$mesc;
		}
		$fecha=$diaf.' '.$dia.' '.$mesf.' '.$ano;
		return $fecha;
	}
}
if (!function_exists('mesName')) {
	function mesName($mes='',$largo=false){
		$res='';$mesc='';$mesl='';
		switch ($mes) {
			case '01':
				$mesc='Ene';
				$mesl='Enero';
				break;
			case '02':
				$mesc='Feb';
				$mesl='Febrero';
				break;
			case '03':
				$mesc='Mar';
				$mesl='Marzo';
				break;
			case '04':
				$mesc='Abr';
				$mesl='Abril';
				break;
			case '05':
				$mesc='May';
				$mesl='Mayo';
				break;
			case '06':
				$mesc='Jun';
				$mesl='Junio';
				break;
			case '07':
				$mesc='Jul';
				$mesl='Julio';
				break;
			case '08':
				$mesc='Ago';
				$mesl='Agosto';
				break;
			case '09':
				$mesc='Sep';
				$mesl='';
				break;
			case '10':
				$mesc='Oct';
				$mesl='Octubre';
				break;
			case '11':
				$mesc='Nov';
				$mesl='Noviembre';
				break;
			case '12':
				$mesc='Dic';
				$mesl='Diciembre';
				break;
			default:
				# code...
				break;
		}
		$res=$mesc;
		if ($largo) {
			$res=$mesl;
		}
		return $res;
	}
}
if (!function_exists('diaName')) {
	function diaName($dia='',$largo=false){
		$res='';$diac='';$dial='';
		switch ($dia) {
			case 'Sunday':
				$diac='Dom';
				$dial='Domingo';
				break;
			case 'Monday':
				$diac='Lun';
				$dial='Lunes';	
				break;
			case 'Tuesday':
				$diac='Mar.';
				$dial='Martes';
				break;
			case 'Wednesday':
				$diac='Mie';
				$dial='Miercoles';
				break;
			case 'Thursday':
				$diac='Jue';
				$dial='Jueves';
				break;
			case 'Friday':
				$diac='Vie';
				$dial='Viernes';
				break;
			case 'Saturday':
				$diac='Sáb';
				$dial='Sábado';
				break;
			default:
				# code...
				break;
		}
		$res=$diac;
		if ($largo) {
			$res=$dial;
		}
		return $res;
	}
}
if (!function_exists('detColor')) {
	function detColor($color){
		switch ($color) {
			case 'skin-black':
				$color="gray";
				break;
			case 'skin-blue':
				$color="#3c8dbc";
				break;
			case 'skin-green':
				$color="#00a65a";
				break;
			case 'skin-purple':
				$color="#605ca8";
				break;
			case 'skin-red':
				$color="#dd4b39";
				break;
			case 'skin-yellow':
				$color="#f39c12";
				break;
			case 'skin-black-light':
				$color="gray";
				break;
			case 'skin-blue-light':
				$color="#3c8dbc";
				break;
			case 'skin-green-light':
				$color="#00a65a";
				break;
			case 'skin-purple-light':
				$color="#605ca8";
				break;
			case 'skin-red-light':
				$color="#dd4b39";
				break;
			case 'skin-yellow-light':
				$color="#f39c12";
				break;
			default:
				# code...
				break;
		}
		return $color;
	}
}