<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
* Info: Cotroladorprincipal, en este se declaran las acciones de vistas en reportes
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    
    public function __construct() {
 	parent::__construct();
        $this->load->model('General_model','modelo');
        $this->load->helper('mensajes');
        $this->load->library('Jquery_pagination');
    }
    /**Funcion que determina la vista a mostrar**/
    public function index()	{///Función pricipal que carga las vistas determinando si hay una sesión iniciada o no
        $this->load->view(getError('ajax'));       
    }
    /**Funciones generales**/
    function isAdmin($id){
    	return true;
    }
    
   
    public function generar() {
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SIC');
        $pdf->SetTitle('Presupuesto');
        $pdf->SetSubject('Soluciones Integrales y comunicación');
        $pdf->SetKeywords('none');
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
		// Establecer el tipo de letra
 
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('times', '', 14, '', true);
 
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->AddPage();
 
		//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		// Establecemos el contenido para imprimir
        //$provincia = $this->input->post('provincia');
        //$provincias = $this->pdfs_model->getProvinciasSeleccionadas($provincia);
        /*foreach($provincias as $fila){
            $prov = $fila['p.provincia'];
        }*/
        //preparamos y maquetamos el contenido a crear
        $html = '';
        $html .= "<style type=text/css>";
        $html .= "";
        $html .= "";
        $html .= "</style>";
        //$html .= "<h2>Localidades de ".$prov."</h2><h4>Actualmente: ".count($provincias)." localidades</h4>";
        $html .= '<img src="./img/logos/logo.png" width="210">';
        $html .= '<div width="200px"><b>Andador Antoni Soler #114</b><br><b>Col Infonavid Atasta C.P. 86100</b><br><b>Villahermosa, Centro, Tabasco</b></div>';
        
        //provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
        /*foreach ($provincias as $fila) 
        {
            $id = $fila['l.id'];
            $localidad = $fila['l.localidad'];
 
            $html .= "<tr><td class='id'>" . $id . "</td><td class='localidad'>" . $localidad . "</td></tr>";
        }*/
        //$html .= "</table>";
 
// Imprimimos el texto con writeHTMLCell()
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Localidades de vv.pdf");
        $pdf->Output($nombre_archivo, 'I');
    }
}