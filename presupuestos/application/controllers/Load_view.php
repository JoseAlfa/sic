<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
* Info: Cotroladorprincipal, en este se declaran las acciones de vistas estaticas que conforman el sistema de gestion de presupuestos 
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Load_view extends CI_Controller {
    
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
    /*******************************************************************/
    /**Funciones generales para uso general de el resto de los modulos**/
    /*******************************************************************/

    
    public function vista_ajax(){//vista por peticion de ajax
    	if ($this->input->is_ajax_request()) {//Si es una petición de ajax
            if ($this->session->userdata('iduser')) {
                if ($this->isAdmin($this->session->userdata('iduser'))) {
                    $vista=$this->input->post('nuevo',true);
                    $idsel=$this->input->post('ref',true);///id de detalles en caso de solicitarlo
                    if ($vista) {
                        $data=array('nuevo'=>true,'marcas'=>$this->marcasSelect(),'tipoPro'=>$this->tiposProSelect());
                        if ($idsel) {
                            $data=$this->{$vista}($idsel);
                            #echo var_dump($data);                  
                        }
                        $this->load->view('ajax/'.$vista,$data);
                    }else{
                        echo '<br><button type="button" class="btn bg-red" data-dismiss="modal" >CERRAR</button>';
                    }
                }else{
                    echo getError('acceso').'<br><button type="button" class="btn bg-red" data-dismiss="modal" >CERRAR</button>';
                }                
            }else{//Si no hay una sesion activa
                echo getError('sesion').'<br><button type="button" class="btn bg-red" data-dismiss="modal" >CERRAR</button>';//lo que se imprime al final.
            }    		            
        }else{//Si no es una petición de ajax
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }  
    }
    private function hacerFecha($fecha=false,$larga=false){
        $consulta=$this->modelo->getDate($fecha);
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
    /////////////paginación//////////////////
    function pagConfig($q="",$limit=10,$vista='#contenedor_general'){///Funcion que retorna la configuracion basica de la paginacion
        $config['div'] = $vista;//asignamos un id al contendor general            
        $config['anchor_class'] = 'page_link';//asignamos una clase a los links para maquetar            
        $config['show_count'] = true;//en true queremos ver Viendo 1 a 10 de 52            
        $config['per_page'] = $limit;//-->número de registros por página            
        $config['num_links'] = 4;//-->número de links visibles            
        $config['full_tag_open']    = '<ul class="pagination">';
        $config['full_tag_close']   = '</ul>';
        $config['first_tag_open']   = '<li class="waves-effect">';
        $config['first_tag_close']  = '</li>';
        $config['prev_tag_open']    = '<li class="waves-effect">';
        $config['prev_tag_close']   = '</li>';
        $config['last_tag_open']    = '<li class="waves-effect">';
        $config['last_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a>';
        $config['cur_tag_close']    = '</a></li>';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['num_tag_open']     = '<li class="waves-effect">';
        $config['num_tag_close']    = '</li>';
        $config['first_link']       = '&lsaquo; Primera';//->configuramos 
        $config['next_link']        = '&gt;';//-------------->los links
        $config['prev_link']        = '&lt;';//-------------->de anterior
        $config['last_link']        = 'Última &rsaquo;';//--->y siguiente
        $config['id_complmet']      = 'segmento';///Configuracion del id del elento que guarda el segmento
        $config['additional_param'] = "{'pagina' : 'false',q:'".$q."'}";
        return $config;
    }
    function busquedaForm($seccion,$busqueda,$nuevo){//genera el formulario de busqueda
        return '<div class="header">
                    <div class="row clearfix" >
                    <form onsubmit="$.sic.buscar(this,\''.$seccion.'\');return false;">
                        <div class="col-sm-8 searchIn">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="search" name="q" id="q" class="form-control" placeholder="Buscar" value='.$busqueda.'>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn bg-blue waves-effect"> BUSCAR</button>
                            <button type="button" class="btn bg-red waves-effect" onclick="$.sic.load(\''.$seccion.'\',$.sic.tituloSave);">REINICIAR</button>
                        </div>
                    </form>
                    <div class="col-sm-12"><button onclick="$.sic.nuevo(\''.$nuevo.'\');" class="btn theme nuevobt"><i class="fas fa-plus"></i> AGREGAR</button></div>
                    </div>
                </div><div class="body table-responsive">';
    }
    function hacerEncabezado($encabezado){//hace encabezado de una tbal a base de u array
        $return='<table class="table"><thead><tr>';//valor a retornar
        if (is_array($encabezado)) {//si el parametro es un arreglo
            for ($i=0; $i < count($encabezado); $i++) { ///cicloq ue recorre arreglo
                $return.='<th>'.$encabezado[$i].'</th>';//Valor a retornar
            }
        }
        return $return.'</tr></thead><tbody>';//valor retornado
    }
    function editScript(){//crea la llamada de la funcion que carga los detalles
        return '<script>$(\'.detail\').click(function(){$.sic.nuevo($(this).attr(\'ur\'),$(this).attr(\'ref\'));});</script>';
    }
    function isAdmin($iduser,$admin=false){//Verific si es administrador el usuario
        $permiso=false;
        $consulta=$this->modelo->userdataSes($iduser);
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
    /*************************************************************************/
    /**Fin deFunciones generales para uso general de el resto de los modulos**/
    /*************************************************************************/


    /*************************************************************************/
    /**************         Funciones de panel      **************************/
    /*************************************************************************/
    //para productos
    public function productos($offset='0'){///devueve lita de prodctos
        if ($this->input->is_ajax_request()) {//Si es una peticion por ajax
            $print="";//loque se imprime al final
            $idu=$this->session->userdata('iduser');//id de usuario en sesion
            if ($idu) {//Si hay una sesion activa
                if ($this->isAdmin($idu)) {//Si elusuario es administrador
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/productos';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getProductos(false,$limit,$offset,false,$q);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getProductos(false,$limit,$offset,true,$q);//consulta de valores pertinentes a esta página
                    $print=$this->busquedaForm('productos',$q,'producto');///formulario de busqueda
                    $encabezado=array('Foto','Nombre','Clave','Marca','Tipo','Detalles');//Encabezado de la tablaa
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->id;///Id 
                            $nombre=$val->nom;//nombre
                            $clave=$val->cv;//clave
                            $imagen=$val->im;//imagen o logo
                            $detalles=$val->det;///Detalles
                            $tipo=$val->tipo;//Tipos
                            $marca=$val->marca;//marca
                            $print.='<tr class="detail" ur="producto" ref="'.$id.'">
                            <td><a href="javascript:void(0);"><img src="./images/productos/'.$val->im.'" class="img-circle imgfortable"></a></td><td>'.$nombre.'</td><td>'.$clave.'</td><td>'.$marca.'</td><td>'.$tipo.'</td><td>'.$detalles.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{//Si el usuario no es administrador
                    $print=getError('acceso');//lo que se imprime al final.
                }
            }else{//Si no hay una sesion activa
                $print=getError('sesion');//lo que se imprime al final.
            }
            echo $print;//se imprime el resultado final
        }else{//Si no es una peticion por ajax
            $this->load->view(getError('ajax'));//se carga la vista de error en peticion de ajax
        }
    }
    function producto($id) {//datos de un usuario
        $retornar=array();
        $consulta=$this->modelo->getProductos($id);
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $retornar=array('id'=>$val->id,'pre'=>$val->prec,'marcas'=>$this->marcasSelect($val->idmarca),'tipoPro'=>$this->tiposProSelect($val->idtipo),'nom'=>$val->nom,'cve'=>$val->cv,'det'=>$val->det,'img'=>$val->im,'med'=>$val->med);
            }
        }
        return $retornar;
    }
    //para tipo productos
    public function tipos_productos($offset='0'){
        if ($this->input->is_ajax_request()) {//Si es una peticion por ajax
            $print="";//loque se imprime al final
            $idu=$this->session->userdata('iduser');//id de usuario en sesion
            if ($idu) {//Si hay una sesion activa
                if ($this->isAdmin($idu)) {//Si elusuario es administrador
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/tipos_productos';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getTipPro(false,$limit,$offset,false,$q);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getTipPro(false,$limit,$offset,true,$q);//consulta de valores pertinentes a esta página
                    $encabezado=array('Nombre','Detalles');//Encabezado de la tablaa
                    $print=$this->busquedaForm('tipos_productos',$q,'tipPro');///formulario de busqueda
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->id;///Id 
                            $nombre=$val->nom;//nombre
                            $detalles=$val->det;//clave
                            $print.='<tr class="detail" ur="tipPro" ref="'.$id.'"><td>'.$nombre.'</td><td>'.$detalles.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{//Si el usuario no es administrador
                    $print=getError('acceso');//lo que se imprime al final.
                }
            }else{//Si no hay una sesion activa
                $print=getError('sesion');//lo que se imprime al final.
            }
            echo $print;//se imprime el resultado final
        }else{//Si no es una peticion por ajax
            $this->load->view(getError('ajax'));//se carga la vista de error en peticion de ajax
        }
    }
    function tipPro($id){
        $retornar=array();
        $consulta=$this->modelo->getTipPro($id);//Cinulta de datos
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $retornar=array('id'=>$val->id,'nom'=>$val->nom,'det'=>$val->det);
            }
        }
        return $retornar;
    }
    function tiposProSelect($ids=0){
        $return='<option value="undefined">Seleccione un valor</option>';
        $consulta=$this->modelo->getTipPro();
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $id=$val->id;///Id 
                $nombre=$val->nom;//nombre
                if ($ids==$id) {
                    $return.='<option value="'.$id.'"selected>'.$nombre.'</option>';
                }else{
                    $return.='<option value="'.$id.'">'.$nombre.'</option>';
                }                
            }
        }else{
            $return='<option value="undefined">No hay marcas registradas</option>';
        }
        return $return;
    }
//para marcas
    public function marcas($offset='0'){
        if ($this->input->is_ajax_request()) {//Si es una peticion por ajax
            $print="";//loque se imprime al final
            $idu=$this->session->userdata('iduser');//id de usuario en sesion
            if ($idu) {//Si hay una sesion activa
                if ($this->isAdmin($idu)) {//Si elusuario es administrador
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/marcas';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getMarcas(false,$limit,$offset,false,$q);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getMarcas(false,$limit,$offset,true,$q);//consulta de valores pertinentes a esta página
                    $encabezado=array('Nombre','Clave','Detalles');//Encabezado de la tabla
                    $print=$this->busquedaForm('marcas',$q,'marca');///formulario de busqueda
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->id;///Id 
                            $nombre=$val->nom;//nombre
                            $clave=$val->cv;//clave
                            $imagen=$val->im;//imagen o logo
                            $det=$val->det;
                            $print.='<tr class="detail" ur="marca" ref="'.$id.'"><td>'.$nombre.'</td><td>'.$clave.'</td><td>'.$det.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{//Si el usuario no es administrador
                    $print=getError('acceso');//lo que se imprime al final.
                }
            }else{//Si no hay una sesion activa
                $print=getError('sesion');//lo que se imprime al final.
            }
            echo $print;//se imprime el resultado final
        }else{//Si no es una peticion por ajax
            $this->load->view(getError('ajax'));//se carga la vista de error en peticion de ajax
        }
    }
    function marca($id) {//datos de un usuario
        $retornar=array();
        $consulta=$this->modelo->getMarcas($id);//cosulta 
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $retornar=array('id'=>$val->id,'nom'=>$val->nom,'cve'=>$val->cv,'det'=>$val->det);
            }
        }
        return $retornar;
    }
    function marcasSelect($ids=''){//devulve estructura de select de marcas
        $return='<option value="undefined">Seleccione un valor</option>';
        $consulta=$this->modelo->getMarcas();
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $id=$val->id;///Id 
                $nombre=$val->nom;//nombre
                $clave=$val->cv;//clave
                if ($ids==$id) {
                    $return.='<option value="'.$id.'" selected>'.$nombre.' ('.$clave.')</option>';
                }else{
                    $return.='<option value="'.$id.'">'.$nombre.' ('.$clave.')</option>';
                } 
            }
        }else{
            $return='<option value="undefined">No hay marcas registradas</option>';
        }
        return $return;
    }
///Para usuarios
    public function usuarios($offset='0'){//Devuelv ista de usuarios
        if ($this->input->is_ajax_request()) {//Si es una peticion por ajax
            $print="";//loque se imprime al final
            $idu=$this->session->userdata('iduser');//id de usuario en sesion
            $idp=$this->session->userdata('idperson');//id de persona en sesion
            if ($idu) {//Si hay una sesion activa
                if ($this->isAdmin($idu)) {//Si elusuario es administrador
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/usuarios';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getUsuarios(false,$limit,$offset,false,$q,$idp);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getUsuarios(false,$limit,$offset,true,$q,$idp);//consulta de valores pertinentes a esta página
                    $print=$this->busquedaForm('usuarios',$q,'user');///formulario de busqueda
                    $encabezado=array('Nombre','Correo','Telefono','Usuario','Tipo');//Encabezado de la tablaa
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->idp;///Id de persona
                            $idu=$val->idu;//id de usuario
                            $nombre=$val->nom;//nombre
                            $apellidos=$val->ap;//apellidos
                            $correo=$val->cor;//correo
                            $telefono=$val->tel;//correo
                            $admin=$val->adm;///Tipo de usuario
                            $usr=$val->usr;//ombre de usuario
                            $tipo="Administrador";//tipo de usuario en nombre
                            if (!$admin) {//Si no es administrador
                                $tipo="Usuario normal";//tipo de usuario en nombre
                            }
                            $print.='<tr class="detail" ur="user" ref="'.$id.'"><td>'.$nombre.' '.$apellidos.'</td><td>'.$correo.'</td><td>'.$telefono.'</td><td>'.$usr.'</td><td>'.$tipo.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{//Si el usuario no es administrador
                    $print=getError('acceso');//lo que se imprime al final.
                }
            }else{//Si no hay una sesion activa
                $print=getError('sesion');//lo que se imprime al final.
            }
            echo $print;//se imprime el resultado final
        }else{//Si no es una peticion por ajax
            $this->load->view(getError('ajax'));//se carga la vista de error en peticion de ajax
        }
    }
    public function user($id) {//datos de un usuario
        $retornar=array();
        $consulta=$this->modelo->getUsuarios($id);
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $retornar=array('idu'=>$val->idu,'idp'=>$val->idp,'nom'=>$val->nom,'ape'=>$val->ap,'cor'=>$val->cor,'tel'=>$val->tel,'usr'=>$val->usr,'adm'=>$val->adm,'pas'=>'bien');
            }
        }
        return $retornar;
    }
    ///clientes
    public function clientes($offset=0){
        if ($this->input->is_ajax_request()) {//Si es una peticion por ajax
            $print="";//loque se imprime al final
            $idu=$this->session->userdata('iduser');//id de usuario en sesion
            $idp=$this->session->userdata('idperson');//id de persona en sesion
            if ($idu) {//Si hay una sesion activa
                if ($this->isAdmin($idu)) {//Si elusuario es administrador
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/clientes';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getClientes(false,$limit,$offset,false,$q,$idp);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getClientes(false,$limit,$offset,true,$q,$idp);//consulta de valores pertinentes a esta página
                    $print=$this->busquedaForm('clientes',$q,'cliente');///formulario de busqueda
                    $encabezado=array('Tipo','Nombre','Correo','Telefono');//Encabezado de la tablaa
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->id;///Id de persona
                            $nombre=$val->nom;//nombre
                            $correo=$val->cor;//correo
                            $telefono=$val->tel;//correo
                            $em=$val->em;///Tipo de usuario
                            $icon="fa-building";//tipo de usuario en nombre
                            if (!$em) {//Si no es administrador
                                $icon="fa-user";//tipo de usuario en nombre
                            }
                            $print.='<tr class="detail" ur="cliente" ref="'.$id.'"><td class="icon-t"><i class="fas '.$icon.'"></i></td><td>'.$nombre.'</td><td>'.$correo.'</td><td>'.$telefono.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{//Si el usuario no es administrador
                    $print=getError('acceso');//lo que se imprime al final.
                }
            }else{//Si no hay una sesion activa
                $print=getError('sesion');//lo que se imprime al final.
            }
            echo $print;//se imprime el resultado final
        }else{//Si no es una peticion por ajax
            $this->load->view(getError('ajax'));//se carga la vista de error en peticion de ajax
        }
    }
    public function cliente($id) {//datos de un usuario
        $retornar=array();
        $consulta=$this->modelo->getClientes($id);
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $retornar=array('id'=>$val->id,'nom'=>$val->nom,'cor'=>$val->cor,'tel'=>$val->tel,'dir'=>$val->dir,'em'=>$val->em,'show'=>$val->show,'cp'=>$val->cp,'atn'=>$val->atn);
            }
        }
        return $retornar;
    }
    /*************************************************************************/
    /*********Funciones de reportes***********/

    private function clientesSel($id=false) {
        $query=$this->modelo->getClientes();
        $sel='<option value="undefined">Seleccione una opción</option>';
        if ($query!=null) {
            foreach ($query as $val) {
                if ($val->id==$id) {
                    $sel.='<option selected value="'.$val->id.'">'.$val->nom.'</option>';
                }else{
                    $sel.='<option value="'.$val->id.'">'.$val->nom.'</option>';
                }
            }
        }
        return $sel;
    }
    private function productosSel($id=false) {
        $query=$this->modelo->getProductos();
        $sel='<option value="undefined">Seleccione una opción</option>';
        if ($query!=null) {
            foreach ($query as $val) {
                if ($val->id==$id) {
                    $sel.='<option selected value="'.$val->id.'">'.$val->nom.'</option>';
                }else{
                    $sel.='<option id="productoSel'.$val->id.'" value="'.$val->id.'">'.$val->nom.'</option>';
                }
            }
        }
        return $sel;
    }
    private function productsJSON() {
        $query=$this->modelo->getProductos();
        $arr="";
        if ($query!=null) {
            $arr=json_encode($query);
        }
        return $arr;
    }
    public function newPresupuesto(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            $print="";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $data['clientes']=$this->clientesSel();
                    $data['productos']=$this->productosSel();
                    $data['json']=$this->productsJSON();
                    $data['nuevo']=true;
                    $this->load->view('ajax/presupuestos',$data);
                }else{
                    $print=getError('acceso');
                }
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }

    private function presupuestosTable($consulta,$busqueda,$padre,$detalles) {
        $print=$this->busquedaForm($padre,$busqueda,$detalles);///formulario de busqueda
        $encabezado=array('Nombre','Correo','Telefono','Usuario','Tipo');//Encabezado de la tablaa
        $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
        if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
            foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                $id=$val->idp;///Id de persona
                $idu=$val->idu;//id de usuario
                $nombre=$val->nom;//nombre
                $apellidos=$val->ap;//apellidos
                $correo=$val->cor;//correo
                $telefono=$val->tel;//correo
                $admin=$val->adm;///Tipo de usuario
                $usr=$val->usr;//ombre de usuario
                $tipo="Administrador";//tipo de usuario en nombre
                if (!$admin) {//Si no es administrador
                    $tipo="Usuario normal";//tipo de usuario en nombre
                }
                $print.='<tr class="detail" ur="user" ref="'.$id.'"><td>'.$nombre.' '.$apellidos.'</td><td>'.$correo.'</td><td>'.$telefono.'</td><td>'.$usr.'</td><td>'.$tipo.'</td></tr>';
            }
        }else{
            $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
        }
        return $print.='</tbody></table></div>';
    }

    public function presupuesto(){
         if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            $print="";
            if ($idu) {
                $consulta=null;
                if ($this->isAdmin($idu)) {
                    $ref=$this->input->post('ref',true);
                    $consulta=$this->modelo->recientesPre(false,1,$ref);
                    if ($consulta!=null) {
                        $data=array();
                        foreach ($consulta as $val) {
                            $ref='code,'.$idu.','.$val->id;
                            $ref=base64_encode($ref);
                            $data['ref']=$ref;
                            $data['detalle']=$val->det;
                            $data['pago']=$val->pago;
                            $data['iva']=$val->iva;
                            $data['idpre']=$val->id;
                            #$data['']=$val->;
                            $data['vencimiento']=$val->ven;
                            $data['clientes']=$this->clientesSel($val->idc);
                            $data['productos']=$this->productosSel();
                            $data['json']=$this->productsJSON();
                            $this->load->view('ajax/presupuestos',$data);
                        }
                    }
                }else{
                    $print=getError('acceso');
                }
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    public function getPresupuestos($offset=0){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            if ($idu) {
                $print='<div class="row"><div class="col-sm-1"></div><div class="col-sm-10"><br><br><div class="list-group">';
                $consulta=null;
                if ($this->isAdmin($idu,true)) {
                    $consulta=$this->modelo->recientesPre();
                }else{
                    $consulta=$this->modelo->recientesPre($idu);
                }
                if ($consulta!=null) {
                    foreach ($consulta as $val) {
                        if($val->lib){
                            $ref='code,'.$idu.','.$val->id;
                            $ref=base64_encode($ref);
                            $print.='<a class="list-group-item recent" href="./Report/generar?ref='.$ref.'" target="blank">'.$val->cv.' - '.$val->det.'<span class="badge bg-red">Cerrado</span><span class="badge bg-blue">Por '.$val->nom.' '.$val->ap.'</span></a>';
                        }else{
                           $print.='<a class="list-group-item recent" onclick="$.sic.load(\'presupuesto\',\''.$val->cv.'\',{ref:'.$val->id.'})">'.$val->cv.' - '.$val->det.'<span class="badge bg-green">Editable</span><span class="badge bg-blue">Por '.$val->nom.' '.$val->ap.'</span></a>'; 
                        }
                    }
                }else{
                    $print.='<button type="button" class="list-group-item">No hay resultados</button>';
                }
                $print.='</div></div></div>';
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    public function getPlantillas($offset=0){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            if ($idu) {
                if ($this->isAdmin($idu,true)) {
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/usuarios';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getUsuarios(false,$limit,$offset,false,$q,$idp);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getUsuarios(false,$limit,$offset,true,$q,$idp);//consulta de valores pertinentes a esta página
                    $print=$this->busquedaForm('usuarios',$q,'user');///formulario de busqueda
                    $encabezado=array('Nombre','Correo','Telefono','Usuario','Tipo');//Encabezado de la tablaa
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->idp;///Id de persona
                            $idu=$val->idu;//id de usuario
                            $nombre=$val->nom;//nombre
                            $apellidos=$val->ap;//apellidos
                            $correo=$val->cor;//correo
                            $telefono=$val->tel;//correo
                            $admin=$val->adm;///Tipo de usuario
                            $usr=$val->usr;//ombre de usuario
                            $tipo="Administrador";//tipo de usuario en nombre
                            if (!$admin) {//Si no es administrador
                                $tipo="Usuario normal";//tipo de usuario en nombre
                            }
                            $print.='<tr class="detail" ur="user" ref="'.$id.'"><td>'.$nombre.' '.$apellidos.'</td><td>'.$correo.'</td><td>'.$telefono.'</td><td>'.$usr.'</td><td>'.$tipo.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{
                    $print=getError('acceso');
                }
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    public function getPresupuestoClose($offset=0){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            if ($idu) {
                if ($this->isAdmin($idu,false)) {
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/usuarios';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->presupuestos(false,1,$limit,$offset,false,$q,$idp);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->presupuestos(false,1,$limit,$offset,true,$q,$idp);//consulta de valores pertinentes a esta página
                    $print=$this->busquedaForm('usuarios',$q,'user');///formulario de busqueda
                    $canSeeAut=$this->isAdmin($idu,true);
                    $encabezado=array('Clave','Detalles','Cliente','Cerrado');//Encabezado de la tablaa
                    if($canSeeAut){
                        $encabezado=array('Clave','Detalles','Cliente','Cerrado','Creado por');//Encabezado de la tablaa
                    }
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->id;///Id pre
                            $clave=$val->cv;//clave de pre
                            $det=$val->det;///detalles de presupuesto
                            $cliente=$val->cliente;
                            $cerrado=$val->fin;//fin
                            $creador=$val->nom.' '.$val->ap;
                            $ini=$this->hacerFecha($val->ini);
                            $fin=$this->hacerFecha($val->fin);
                            $ref='code,'.$idu.','.$id;
                            $ref=base64_encode($ref);
                            $datos=json_encode($val);
                            $print.='<tr class="detailjava" data-ref="'.$ref.'" data-detalle=\''.$datos.'\' data-see="'.$canSeeAut.'" data-inicio="'.$ini.'" data-fin="'.$fin.'"><td>'.$clave.'</td><td>'.$det.'</td><td>'.$cliente.'</td><td>'.$fin.'</td>';
                            if($canSeeAut){
                                $print.='<td>'.$creador.'</td>';
                            }
                            $print.='</tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div> <script>$(".detailjava").click(function(e){$.sic.loadJS($(this));});</script>';
                }else{
                    $print=getError('acceso');
                }
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    public function getBorradores($offset=0){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            if ($idu) {
                if ($this->isAdmin($idu,true)) {
                    $q=$this->input->post('q',true);///busqueda
                    $config=$this->pagConfig($q,5);//se carga configuración predeterminada
                    $config['base_url'] = './Load_view/usuarios';//url donde estan los datos a paginar
                    $limit=$config['per_page'];///limete de la consulta
                    $config['total_rows'] = $this->modelo->getUsuarios(false,$limit,$offset,false,$q,$idp);//total de registros
                    $this->jquery_pagination->initialize($config);//se inicializa la librebreria de paginación
                    $consulta =$this->modelo->getUsuarios(false,$limit,$offset,true,$q,$idp);//consulta de valores pertinentes a esta página
                    $print=$this->busquedaForm('usuarios',$q,'user');///formulario de busqueda
                    $encabezado=array('Nombre','Correo','Telefono','Usuario','Tipo');//Encabezado de la tablaa
                    $print.=$this->hacerEncabezado($encabezado);///Se le anexa el encabeado a la tabla
                    if ($consulta!=null&&$consulta) {//Si hay resulados en la consulta
                        foreach ($consulta as $val) {//Se recorre el resltado de la consulta
                            $id=$val->idp;///Id de persona
                            $idu=$val->idu;//id de usuario
                            $nombre=$val->nom;//nombre
                            $apellidos=$val->ap;//apellidos
                            $correo=$val->cor;//correo
                            $telefono=$val->tel;//correo
                            $admin=$val->adm;///Tipo de usuario
                            $usr=$val->usr;//ombre de usuario
                            $tipo="Administrador";//tipo de usuario en nombre
                            if (!$admin) {//Si no es administrador
                                $tipo="Usuario normal";//tipo de usuario en nombre
                            }
                            $ref='code,'.$idu.','.$id;
                            $ref=base64_encode($ref);
                            $print.='<tr class="detail" ur="user" data-ref="'.$ref.'"><td>'.$nombre.' '.$apellidos.'</td><td>'.$correo.'</td><td>'.$telefono.'</td><td>'.$usr.'</td><td>'.$tipo.'</td></tr>';
                        }
                    }else{
                        $print.='<tr><td colspan="'.count($encabezado).'">No hay resultados</td></tr>';//No hay resultado
                    }
                    $print.='</tbody></table></div><div class="paginas">'.$this->jquery_pagination->create_links().'</div>'.$this->editScript();
                }else{
                    $print=getError('acceso');
                }
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    ///////////////////detalles de empresa ////////////////////////////////////
    private function empresa() {
        $datos=false;
        $this->load->model('Report_Model','modelo1');
        $consulta=$this->modelo1->epresa();
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
    public function dataPDF(){
        if ($this->input->is_ajax_request()) {
            $print="";
            $idu=$this->session->userdata('iduser');
            $idp=$this->session->userdata('idperson');
            if ($idu) {
                if ($this->isAdmin($idu,true)) {
                    $data=$this->empresa();
                    $this->load->view('ajax/empresa',$data);
                }else{
                    $print=getError('acceso');
                }
            }else{
                $print=getError('sesion');
            }
            echo $print;
        }else{
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    public function faq(){
        $this->load->view('ajax/faq');
    }
    /*************************************************************************/
    /*************     Fin de Funciones de panel     *****+*******************/
    /*************************************************************************/

}