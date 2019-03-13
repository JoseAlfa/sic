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
if (!function_exists('createDiv')) {
	function createDiv($content,$class='',$aditionalData=''){
		$div='';
		$div='<div class="'.$class.'" '.$aditionalData.'>'.$content.'</div>';
		return $div;
	}
}
if (!function_exists('createInput')) {
	function createInput($type,$class='',$value='',$aditionalData=''){
		$input='<input type="'.$type.'" class="'.$class.'" value="'.$value.'" '.$aditionalData.'>';
		return $input;
	}
}
if (!function_exists('createSelect')) {
	function createSelect($content,$class='',$aditionalData='')	{
		$select='<select class="'.$class.'" '.$aditionalData.'>'.$content.'</select>';
		return $select;
	}
}
if (!function_exists('createOption')) {
	function createOption($content,$class='',$aditionalData='')	{
		$select='<select class="'.$class.'" '.$aditionalData.'>'.$content.'</select>';
		return $select;
	}
}
if (!function_exists('createForm')) {
	function createForm($content,$class='',$aditionalData=''){
		$form='<form class="'.$class.'" '.$aditionalData.'>'.$content.'</form>';
		return $form;
	}
}
if (!function_exists('createScript')) {
	function createScript($content,$aditionalData=''){
		$script='<script '.$aditionalData.'>'.$content.'</script>';
		return $script;
	}
}
if (!function_exists('createLabel')) {
	function createLabel($content,$class='',$aditionalData=''){
		$label='<label class="'.$class.'" '.$aditionalData.'>'.$content.'</label>';
		return $label;
	}
}
if (!function_exists('createLink')) {
	function createLink($content,$class='',$aditionalData=''){
		$link='<a class="'.$class.'" '.$aditionalData.'>'.$content.'</a>';
		return $link;
	}
}
if (!function_exists('createButton')) {
	function createButton($type,$content,$class='',$aditionalData='')	{
		$button='<button type="'.$type.'" class="'.$class.'" '.$aditionalData.'>'.$content.'</button>';
		return $button;
	}
}
if (!function_exists('createH')) {
	function createH($content,$tam=4,$class='',$aditionalData=''){
		$h='<h'.$tam.' class="'.$class.'" '.$aditionalData.'>'.$content.'</h'.$tam.'>';
		return $h;
	}
}
if (!function_exists('createTextArea')) {
	function createTextArea($val="",$class="",$col=2,$row=2,$aditionalData=''){
		$h='<textarea col="'.$col.'" row="'.$row.'" class="'.$class.'" '.$aditionalData.'>'.$val.'</textarea>';
		return $h;
	}
}
if (!function_exists('createSpan')) {
	function createSpan($val="",$class="",$aditionalData=''){
		$h='<span class="'.$class.'" '.$aditionalData.'>'.$val.'</span>';
		return $h;
	}
}