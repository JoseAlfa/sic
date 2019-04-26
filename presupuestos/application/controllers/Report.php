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
        $this->load->model('Report_Model','modelo');
        $this->load->helper('mensajes');
        $this->load->library('Jquery_pagination');
    }
    /**Funcion que determina la vista a mostrar**/
    public function index()	{///Función pricipal que carga las vistas determinando si hay una sesión iniciada o no
        $this->load->view(getError('ajax'));       
    }
    /**Funciones generales**/
    //////////////////Funcines generales
    private function hacerFecha($fecha=false,$larga=false){
        $this->load->model('General_model','modelo1');
        $consulta=$this->modelo1->getDate($fecha);
        $fecha='';
        $this->load->helper('fecha');
        if ($consulta!=null) {
            foreach ($consulta as $data) {
                $dia=$data->d;
                $dianombre=$data->dn;
                $mes=$data->m;
                $mesnombre=$data->mn;
                $ano=$data->y;
                $hora=$data->hr;
                $fecha=getDateNom($dia,$mes,$ano,$dianombre,$larga);
            }
        }
        return $fecha;
    }
    function isAdmin($iduser,$admin=false){//Verific si es administrador el usuario
        $permiso=false;
        $this->load->model('General_model','modelo2');
        $consulta=$this->modelo2->userdataSes($iduser);
        if ($consulta!=null) {
            foreach ($consulta as $valor) {
                if ($admin) {
                    if ($valor->adm==1 || $valor->adm=='1') {
                        $permiso=true;
                    }
                }else{
                    $permiso=true;
                }
            }
        }
        return $permiso;
    }
    private function empresa() {
        $datos=false;
        $consulta=$this->modelo->epresa();
        $uno=true;
        foreach ($consulta as $val) {
            if ($uno) {
                $datos=array('nombre'=>$val->nombre,'direccion'=>$val->direccion,'telefono'=>$val->telefono,'movil'=>$val->movil,'correo'=>$val->correo,'firma'=>$val->firma);
            }else{
                $uno=false;break;
            }
        }
        return $datos;
    }
    public function generar() {
        $idu=$this->session->userdata('iduser');
        $id_peticicion=0;
        $data=$this->input->get('ref', true);
        $continuar=false;
        $datos_pre=array();
        $pro_pre=array();
        $id_pre=0;
        $total=0;
        $firmaPre='';
        if($data){
            $data=base64_decode($data);
            $data=explode(',', $data);
            if(isset($data[1])){
                if($data[1]==$idu){
                    if (isset($data[2])) {
                        $id_pre=$data[2];
                        $continuar=true;
                    }
                }
            }
        }
        if($continuar){
            if($id_pre){
                $admin=$this->isAdmin($idu,true);
                $datos_pre_con=$this->modelo->get_perDet($id_pre,$admin);
                $pro_pre=$this->modelo->productos($id_pre);
                if ($datos_pre_con==null) {
                    echo "Error, imposible generar PDF, esto debido a que no se ha seleccionado ningún cliente.";
                    exit();
                }
                foreach ($datos_pre_con as $val) {
                    //,c.telefono telC,c.correo corC,c.direccion dirC,c.cp cp,c.atn atn,c.empresa emp
                    $det="";
                    $firmaPre=$val->cliente;
                    if($val->emp==1){$det="Empresa ";$firmaPre=$val->atn;}
                    $datos_pre=array('clave'=>$val->cv,'fecha'=>$this->hacerFecha($val->fin),'cliente'=>$det.$val->cliente,'otros'=>$val->otros,'pago'=>$val->pago,'iva'=>$val->iva,'vencimiento'=>$val->ven,'numeroCliente'=>$val->telC,'correoCliente'=>$val->corC,'direccionCliente'=>$val->dirC.' C.P. '.$val->cp,'atn'=>$val->atn,'liberado'=>$val->lib);
                }
            }else{
                echo "No fue posible generar el archivo PDF.";exit();
            }
        }else{
            echo "Error, no fue posible generar. Esto puede ser debido a que su sesión expiró o no tiene permiso para esta opción. Si usted cree que es un error porfavor contacte al administrador del sistema.";
            exit();
        }
        $empresa=$this->empresa();
        if (!is_array($empresa)) {
            echo "No se encontranron datos de la empresa, porfavor agrégalos";
            exit();
        }
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Gesion de presupuesto');
        $pdf->SetTitle($datos_pre['clave']);
        $pdf->SetSubject('Presupuesto');
        $pdf->SetKeywords('Presupuesto');

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------


        // add a page
        $pdf->AddPage();
        if(!$datos_pre['liberado']){
            // draw jpeg image
            //$pdf->Image('./img/logos/noOfi.png', 90, 100, 60, 60, '', 'http://www.tcpdf.org', '', true, 72);

            // get the current page break margin
            $bMargin = $pdf->getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = $pdf->getAutoPageBreak();
            // disable auto-page-break
            $pdf->SetAutoPageBreak(false, 0);
            // set bacground image
            $img_file = './img/logos/noOfi.png';
            $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            // restore auto-page-break status
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $pdf->setPageMark();
        }

        $pdf->SetFont('helvetica', '', 10);

        // -----------------------------------------------------------------------------
        $back='#e4f0f5';
        $lineColor='#3d7e9a';
        $style='
        <style>
            th{
                font-weight: bolder;
                padding-left:10px;
            }
            td{
                padding-left:10px;
            }
        </style>';
        $tbl = $style.'
        <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td style="width:30px;" rowspan="2"></td>
                <td rowspan="2" style="width:250px;"><img height="100px" src="./img/logos/logo.png" alt="test alt attribute" border="0"></td>
                <td style="width:50px;" rowspan="2"></td>
                <td style="text-align:center;width:280px;"><br></td>
            </tr>
            <tr>
                <td style="text-align:center;width:280px;"><b>'.$empresa['direccion'].'
                                Teléfono: '.$empresa['telefono'].', Móvil: '.$empresa['movil'].'
                                e-mail: '.$empresa['correo'].'</b></td>
            </tr>

        </table><br>
        ';

        $pdf->writeHTML($tbl, true, false, false, false, '');
        // -----------------------------------------------------------------------------

        $tbl = $style.'
        <table cellspacing="0" cellpadding="3" border="0">
            <tr><th colspan="2" style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center;width:470px">CLIENTE</th>
            <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center;width:168x">PRESUPUESTO</th></tr>
            <tr>
                <th style="border-left:1px solid '.$lineColor.'; width:100px;">Nombre:</th>
                <td style="width:370px;">'.$datos_pre['cliente'].'</td>
                <td rowspan="2" style="text-align:center;border:1px solid '.$lineColor.';">'.$datos_pre['clave'].'</td>
            </tr>
            <tr>
                <th style="background:'.$back.';border-left:1px solid '.$lineColor.';">Dirección:</th>
                <td  style="border-right:1px solid '.$lineColor.';">'.$datos_pre['direccionCliente'].'</td>
            </tr>
            <tr>
                <th style="border-left:1px solid '.$lineColor.';">Télefono:</th>
                <td style="">'.$datos_pre['numeroCliente'].'</td>
                <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center;">FECHA</th>
            </tr>
            <tr>
                <th style="border-left:1px solid '.$lineColor.';border-bottom:1x solid '.$lineColor.';">AT\'N:</th>
                <td style="border-bottom:1px solid '.$lineColor.';border-right:1px solid '.$lineColor.';">'.$datos_pre['atn'].'</td>
                <td style="border-bottom:1px solid '.$lineColor.';border-right:1px solid '.$lineColor.';text-align:center;">'.$datos_pre['fecha'].'</td>
            </tr>

        </table><br><br>';

        $pdf->writeHTML($tbl, true, false, false, false, '');
        // -----------------------------------------------------------------------------

        $tbl = $style.'
        <table cellspacing="0" cellpadding="3" border="0">
            <thead>
                <tr>
                    <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:107px;">UNIDAD</th>
                    <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:230px;">DESCRIPCIÓN</th>
                    <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:107px;">CANT.</th>
                    <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:97px;">PRECIO</th>
                    <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:97px;">IMPORTE</th>
                </tr>
            </thead>';
        foreach ($pro_pre as $val) {
            //pr.nombre pro,pr.detalles det,pr.medida med,pp.precio pre,pp.cantidad can,m.nombre mar
            $can=$val->pre;
            $temp=intval($can);
            if($can==$temp){$can.='.00';}
            $sub=$val->can*$val->pre;
            $total+=$sub;
            $temp=intval($sub);
            if($sub==$temp){$sub.='.00';}
            $tbl .='
            <tr>
                <td style="border:1px solid '.$lineColor.';text-align:center;width:107px;">'.$val->pro.'</td>
                <td style="border:1px solid '.$lineColor.';width:230px;">'.$val->det.'('.$val->det.')</td>
                <td style="border:1px solid '.$lineColor.';text-align:center;width:107px;">'.$val->can.'</td>
                <td style="border:1px solid '.$lineColor.';text-align:right; width:97px;">$ '.$can.'</td>
                <td style="border:1px solid '.$lineColor.';text-align:right; width:97px;">$ '.$sub.'</td>
            </tr>';
        } 
        $tbl .='</table><br><br>';
        $pdf->writeHTML($tbl, true, false, false, false, '');
        // -----------------------------------------------------------------------------


        $masiva=($total/100)*$datos_pre['iva'];
        $coniva=$masiva+$total;
        $temp=intval($coniva);
        if($coniva==$temp){$coniva.='.00';} 
        $temp=intval($masiva);
        if($masiva==$temp){$masiva.='.00';} 
        $temp=intval($total);
        if($total==$temp){$total.='.00';}  
        $left_column=$style.'
        <table cellspacing="0" cellpadding="0" border="0">
        <tr><td style="width:460px;padding-left:0px;">
        <table cellspacing="0" cellpadding="3" border="0">
            <tr>
                <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:230px;">OTROS DATOS</th>
                <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:100px;">SUBTOTAL</th>
                <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:100px;">I.V.A. '.$datos_pre['iva'].'%</th>
            </tr>
            <tr>
                <td style="border:1px solid '.$lineColor.';text-align:left;">
                <b>Forma de pago: </b>'.$datos_pre['pago'].' <br>
                <b>Vencimiento: </b>'.$datos_pre['vencimiento'].'<br>
                <b>Otros datos: </b>'.$datos_pre['otros'].'
                </td>
                <td style="border:1px solid '.$lineColor.';">$ '.$total.'</td>
                <td style="border:1px solid '.$lineColor.';text-align:center;">$ '.$masiva.'</td>
            </tr>

        </table></td><td>
        ';

        $right_column=$left_column.'
        <table>
            <tr><th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:160px;font-size:15pt;">TOTAL</th></tr>
            <tr><td style="border:1px solid '.$lineColor.';text-align:center;font-size:15pt;">$ '.$coniva.'<br>MXN</td></tr>
        </table></td></tr></table><br>';
        // write the first column;
        $pdf->writeHTML($right_column, true, false, false, false, '');

        
        // -----------------------------------------------------------------------------

        $tbl = $style.'
        <table cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td style="width:40px;"></td>
                <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:232px;">RESPONSABLE DE PRESUPUESTO</th>
                <td style="width:93px;"></td>
                <th style="background-color:'.$back.';border:1px solid '.$lineColor.';text-align:center; width:232px;">CLIENTE</th>
            </tr>
            <tr>
                <td style="width:40px;"></td>
                <td style="border:1px solid '.$lineColor.';text-align:center;">
                    <br>
                    <br>
                    ______________________________ <br>
                    '.$empresa['firma'].'
                </td>
                <td style=""></td>
                <td style="border:1px solid '.$lineColor.';text-align:center;">
                    <br>
                    <br>
                    ______________________________ <br>
                    '.$firmaPre.'
                </td>
            </tr>
            

        </table>';

        $pdf->writeHTML($tbl, true, false, false, false, '');


        //Close and output PDF document
        $pdf->Output($datos_pre['clave'].'.pdf', 'I');
    }
    ////////Generar curriculum empresarial
    public function curriculum() {
        $empresa=$this->empresa();
        if (!is_array($empresa)) {
            echo "No se encontranron datos de la empresa, porfavor agrégalos";
            exit();
        }
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Gesion de presupuesto');
        $pdf->SetTitle('Curriculum empresarial');
        $pdf->SetSubject('Presupuesto');
        $pdf->SetKeywords('Presupuesto');

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------


        // add a page
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        // -----------------------------------------------------------------------------
        $back='#e4f0f5';
        $lineColor='#3d7e9a';
        $style='
        <style>
            th{
                font-weight: bolder;
                padding-left:10px;
            }
            td{
                padding-left:10px;
            }
        </style>';
        $tbl = $style.'
        <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td style="width:30px;" rowspan="2"></td>
                <td rowspan="2" style="width:250px;"><img height="100px" src="./img/logos/logo.png" alt="test alt attribute" border="0"></td>
                <td style="width:50px;" rowspan="2"></td>
                <td style="text-align:center;width:280px;"><br></td>
            </tr>
            <tr>
                <td style="text-align:center;width:280px;"><b>'.$empresa['direccion'].'
                                Teléfono: '.$empresa['telefono'].', Móvil: '.$empresa['movil'].'
                                e-mail: '.$empresa['correo'].'</b></td>
            </tr>

        </table><br>
        ';

        $pdf->writeHTML($tbl, true, false, false, false, '');



        //Close and output PDF document
        $pdf->Output('curriculum_sic.pdf', 'I');
    }
}