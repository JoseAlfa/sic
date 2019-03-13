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
    function isAdmin($iduser,$admin=true){//Verific si es administrador el usuario
        return true;
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
                $retornar=array('id'=>$val->id,'marcas'=>$this->marcasSelect($val->idmarca),'tipoPro'=>$this->tiposProSelect($val->idtipo),'nom'=>$val->nom,'cve'=>$val->cv,'det'=>$val->det,'img'=>$val->im);
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
                $retornar=array('id'=>$val->id,'nom'=>$val->nom,'cor'=>$val->cor,'tel'=>$val->tel,'dir'=>$val->dir,'em'=>$val->em,'show'=>$val->show);
            }
        }
        return $retornar;
    }
    /*************************************************************************/
    /*********Funciones de reportes***********/

    public function getPresupuestos($offset=0){
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
    /*************************************************************************/
    /*************     Fin de Funciones de panel     *****+*******************/
    /*************************************************************************/

}