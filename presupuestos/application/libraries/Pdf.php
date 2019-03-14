<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf extends TCPDF{

	var $logo='./img/logos/logo.png';
	var $font='helvetica';
	var $fontsize='10';
	var $datosEmpresa='Andador antonio Soler #114 Col Infonavit Atasta';


	

    /**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	public function initialize($params = array()){
		if (is_array($params)) {
			if (count($params) > 0)	{
				foreach($params as $key => $val){
					if (isset($this->$key))	{
						$this->$key = $val;
					}
				}		
			}
		}
		
	}
    public function Headerr() {
        // Logo
        $image_file = $this->logo;
        $this->Image($image_file, 17, 17,75, 40, 'PNG', '', 'T', false, 150, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont($this->font, 'B', $this->fontsize);
        // Title
        $this->Cell(0, 15, $this->datosEmpresa, 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
}