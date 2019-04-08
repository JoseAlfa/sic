<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
* Info: Cotroladorprincipal, en este se declaran las acciones que conforman el sistema de gestion de presupuestos 
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
    
    public function __construct() {
 	parent::__construct();
 	    $this->load->model('General_model','modelo');
        $this->load->helper('mensajes');
        $this->load->library('Jquery_pagination');
    }
    /**Funcion que determina la vista a mostrar**/
    public function index()	{///Función pricipal que carga las vistas determinando si hay una sesión iniciada o no
        $id= $this->session->userdata('iduser');
        if ($id) {
            $userdata=$this->datosUsuarioSesion($this->session->userdata('iduser'));
            $parametros=array('user' => $userdata, 'person' => $this->datosUsuario($this->session->userdata('idperson')));//Parametros necearios al momento de cargar la vista
            $admin=$userdata['admin'];
            if ($admin==1) {
                $this->load->view('inicio',$parametros);
            }else{
                $this->load->view('normal',$parametros);
            }
             
        }else{
           $this->load->view('login'); 
        }     
    }
    /*****************************************************************************************************/
    /**Funciones pertinentes a la validación de usuario y contraseña, necesarios para un inicio de sesión*/
    /*****************************************************************************************************/

    public function login() {///Función que realiza lausqueda en la ase de datos
        if ($this->input->is_ajax_request()) {//Si es una petición de ajax
            $usr= $this->input->post('us',true);//Usuario 
            $pas= $this->input->post('ps',true);//contraseña
            $mensaje="";//mensaje final
            $opcion=3;//opción para determinar el tipo de mensaje
            if ($this->validLogin($usr, $pas)) {///Metodo que verica que el usuarioo y la contraseña no reciva valores nulos
                $this->load->helper('security');//libreria para ecriptar contraseña
		        $pas = do_hash($pas, 'md5');//La cntraseña es covertida a md5 para ser consultada
                $consulta= $this->modelo->login($usr,$pas);//consuta en el modelo, envia usuario y contrseña como parametros
                if ($consulta!=NULL) {//si la consulta recibe valores diferente de null
                    foreach ($consulta as $valor) {//recorridod de la consulta
                        $mensaje="Bienvenido ".$valor->nom;//Mensaje final
                        $opcion=1;//Opcion que determina el mensaje
                        $sesion=array('iduser'=>$valor->idu,'idperson'=>$valor->idp);//datos que se guarda en la sesión
                        $this->session->set_userdata($sesion);//asigna valres de la sesion
                    }
                }else{
                    $mensaje=getError('contrasena');//mensaje final
                }
            }
            echo json_encode(array('o'=>$opcion,'m'=>$mensaje));//Imprime en formato de objeto Json los valore s que se verifican con javaScript
        }else{//Si no es una petición de ajax
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }        
    }
    //validar usuario y contraseña
    function validLogin($usr,$pas) {
        $continuar=false;//valor boleano que determina si son correctos los parametros recibidos
        $mensaje="";//mensaje final
        if ($usr==null||$usr=="") {//si usuaro esta vacio o nulo
            $mensaje="Falta nombre de usuario";//mensaje final
        }else{//si usuario no está vacío o nulo
            if ($pas==null||$pas=="") {//si contraseña está vacío o nulo
                $mensaje="falta contraseña";//mensaje final
            }else{//si contraseña no está vacío o nulo
                $continuar=true;//valor boleano que determina si son correctos los parametros recibidos
            }
        }
        return array('con'=>$continuar,'men'=>$mensaje);
    }
    //función para el cierre de la sesión
    public function salir() {
        $this->session->sess_destroy();///se destruye la sesión
        echo 1;
    }
    /******************************************************/
    /**Fin de funciones pertinentes para inicio de sesión**/
    /******************************************************/
    
    /*******************************************************************/
    /**Funciones generales para uso general de el resto de los modulos**/
    /*******************************************************************/

    function datosUsuario($idpersona){///funció que retorna los datos de un usario a base de una sola persona
        $retornar=array();//arreglo de los datos a retornar
        $consulta=$this->modelo->userdata($idpersona);//consulta a base de datos que envia el parametro de id
        if ($consulta!=null) {//si consulta es diferente de null
            foreach ($consulta as $valor) {//recorrido del contenido de la consulta
               $retornar= array('nombre'=>$valor->nom,'correo'=>$valor->cor,'apellidos'=>$valor->ap,'telefono'=>$valor->tel);//datos a retornar
            }
        }
        return $retornar;//retorno de datos
    }
    function datosUsuarioSesion($idusuario){//funcion que retorna los datos de un usuario de sesión
        $retornar=array();//arreglo de los datos a retornar
        $consulta=$this->modelo->userdataSes($idusuario);//consulta a base de datos que envia el parametro de id
        if ($consulta!=null) {//si consulta es diferente de null
            foreach ($consulta as $valor) {//recorrido del contenido de la consulta
               $retornar= array('nombre'=>$valor->nom,'color'=>$valor->col,'idpersona'=>$valor->idp,'admin'=>$valor->adm);//datos a retornar
            }
        }
        return $retornar;//retorno de datos
    }
    public function saveColor(){//funcion para guardar color del tema del usuario
        if ($this->input->is_ajax_request()) {//pregunta so es peticion de ajax
            $color=$this->input->post('color',true);//color del tema
            $idu=$this->session->userdata('iduser');//id del usuario
            $m="";//mensaje final
            if ($idu) {//sihay una sesión activa
                if ($color!=null) {//si el color es diferente de nulo
                    if ($this->modelo->updateUsuario(array('color'=>$color),$idu)) {//si el color fue guardado
                        $m="Color guardado";//mensaje final
                    }else{///si el color o fue guardado
                        $m="Color no guardado";//mensaje final
                    }
                }else{///si el color es nulo y/o no hay id de usuario
                    $m="Color no recibido";///mensaje final
                }
            }else{//si no hay una sesion
                $m=getError('sesion');
            }
            echo $m;//imprime mensaje final
        }else{///si la petición no es por ajax
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    public function cambiarContrasena(){
        if ($this->input->is_ajax_request()) {//pregunta so es peticion de ajax
            $ps=$this->input->post('ps',true);//contraseña anterior
            $ps1=$this->input->post('ps1',true);//contraseña nueva
            $ps2=$this->input->post('ps2',true);//contraseña nueva
            $idu=$this->session->userdata('iduser');//id del usuario
            $this->load->helper('security');//libreria para ecriptar contraseña
            $o=2;//opcion a responder
            $m="";//mensaje final
            $t="Error";//titulo para swal en javascript
            $sw="error";//tipo de swal
            if ($idu) {//si hay una id de usuario
                $ps = do_hash($ps, 'md5');//La contraseña es covertida a md5 para ser consultada
                if ($this->verificarContrasena($ps,$idu)) {//Verificarsi la contraseña anterior es correcta
                    if ($ps1!=null&&$ps1!=''&&$ps2!=null&&$ps2!='') {//si contraseña nueva no esta vacia
                        if ($ps1==$ps2) {//si las contraseñas nuevas son iguales
                            $ps1 = do_hash($ps1, 'md5');//La contraseña es covertida a md5 para ser consultada
                            if ($this->modelo->updateUsuario(array('contrasena'=>$ps1),$idu)) {//Si se actualiza la cntraseña
                                $o=1;//opcion a responder
                                $t="Hecho";//titulo de mensaje
                                $m="Se ha guardado la contraseña";//Mensaje a responder
                                $sw="success";//Tipo de swal
                            }else{
                                $m="No se pudo guardar la contraseña, intente de nuevo mas tarde";//mensaje a responder
                            }
                        }else{
                            $m="Las contraseñas no coinciden";//mensaje a responder
                        }
                    }else{
                        $m="Porfavor ingrese todos los datos requeridos";//mensaje a responder
                    }
                }else{//si la contrase no es correcta
                    $m="La contraseña anterior no es correcta";
                }
            }else{///si no hay id de usuario
                $m=getError('sesion');///mensaje final
            }
            echo json_encode(array('m'=>$m,'o'=>$o,'t'=>$t,'sw'=>$sw));//imprime un json de lasopciones
        }else{///si la petición no es por ajax
            $this->load->view(getError('ajax'));//Vista que muestra errors
        }
    }
    function verificarContrasena($contrasena,$idu){///verifica si la contraseña es correcta
        $ret=false;///El valor a retornar
        if ($contrasena!="") {//si la contraseña no esta vacia
            if ($this->modelo->verificarContrasena($contrasena,$idu)!=null) {//consulta al modelo
                $ret=true;//Valor a retornar
            }
        }
        return $ret;//Retorno de valor
    }
    function validar($dato=''){//validar dato, verifcando que no sean valores nuloso no definidos
        if ($dato!='undefined' && $dato!='' && $dato!=null) {//si el valor no esta vacío
            return true;//retorna true
        }else{//si valor esta vacío
            return false;///retorna false
        }
    }
    function isDepend($tabla='',$ref=0){///si la tabla seleccionada tiene dependencias de otras
        if ($tabla==''||$ref==0) {
            return false;
        }
        $consulta=null;
        $retornar=false;
        switch ($tabla) {
            case 'marca':
                $consulta=$this->modelo->marcaCount($ref);
                break;
            case 'tipPro':
                $consulta=$this->modelo->tipProCount($ref);
                break;
            case 'producto':
                $consulta=$this->modelo->proCount($ref);
                break;
            default:
                # code...
                break;
        }
        if ($consulta!=null) {
            foreach ($consulta as $val) {
                $retornar=$val->num;
            }
        }
        return $retornar;
    }
    function isAdmin($iduser,$admin=false){//Verific si es administrador el usuario
        $permiso=false;
        $consulta=$this->modelo->userdataSes($iduser);
        if ($consulta!=null) {
            foreach ($consulta as $valor) {
                if ($admin) {
                    if ($valor->adm==1) {
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
    public function accionUsuario(){
        if ($this->input->is_ajax_request()) {
            $msg="";//Mensakje final
            $o=2;//Opcion final
            $swh="Error";//header de swal
            $sw="error";//tipo de swal
            $valido=false;//variable para guardar valor sobre si esta completa la peticion
            if ($this->session->userdata('iduser')) {//si hay una sesion
                if ($this->isAdmin($this->session->userdata('iduser'))) {//si el usuario es administrador
                    $act=$this->input->post('act',true);//accion a realizar
                    if ($this->validar($act)) {//si la accion no esta vacia
                        $nom=$this->input->post('nom',true);//nombre
                        $ape=$this->input->post('ape',true);//apellido
                        $cor=$this->input->post('cor',true);//correo
                        $tel=$this->input->post('tel',true);//telefono
                        $usr=$this->input->post('usr',true);//usuario
                        $pas=$this->input->post('pas',true);//conraseña
                        $adm=$this->input->post('adm',true);//administrador
                        $iduser=$this->input->post('ref',true);//id del usuario a actualizar, en caso de requerirlo
                        $idpers=$this->input->post('ref1',true);//id de la persona a actualizar, en caso de requerirlo
                        if ($this->validar($nom)) {//si nombre es valido
                            if ($this->validar($ape)) {//si apellido es valido
                                if ($this->validar($cor)) {//si correo es válido
                                    if ($this->validar($tel)) {//si télefono es válido
                                        if ($this->validar($usr)) {//si usuario es válido
                                            if ($this->validar($pas)) {//si contraseña es válida
                                                $this->load->helper('security');
                                                $pas=do_hash($pas,'md5');
                                                if ($adm!=''&&$adm!='undefined') {//si administrador es válido
                                                    $valido=true;//los valores se reivieron correctamente
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($valido) {//si la petición es válida
                            $datosPersona=array('nombre'=>$nom,'apellidos'=>$ape,'correo'=>$cor,'telefono'=>$cor);//datos de persona a insertar
                            $datosUser=array('nombre'=>$usr,'administrador'=>$adm);
                            //datos de usuario ainsertar
                            if ($act=='nuevo') {//si se guardara un nuevo usuario
                                $datosUser['contrasena']=$pas;//se incuye la contraseña
                                $datosUser['id_persona']=0;//se incuye la contraseña
                                if ($this->modelo->newUser($datosPersona,$datosUser)) {//si se inserta el nueo usuario
                                    $m=getSuccess('insert');
                                    $o=1;$swh='Completo';$sw='success';
                                }else{
                                    $m=getError('insert');
                                }
                            }else{
                                if ($act=='update') {//si se guardara un usuario editaado
                                    if ($this->validar($iduser)) {//si el id es valida
                                        if ($this->validar($idpers)) {
                                                if ($pas!='cfcd208495d565ef66e7dff9f98764da') {
                                                    $datosUser['contrasena']=$pas;//se incuye la contraseña
                                                }
                                                $ids=array('persona'=>$idpers,'user'=>$iduser);
                                                if ($this->modelo->updateUser($datosUser,$datosPersona,$ids)) {//si se actualizan los datos
                                                $m=getSuccess('insert');
                                                $o=1;$swh='Completo';$sw='success';
                                            }else{
                                                $m=getError('insert');
                                            } 
                                        }else{
                                            $m=getError('parametros');
                                        } 
                                    }else{
                                        $m=getError('parametros');
                                    }                                    
                                }
                            }
                        }else{//si no se recibieron todos los parametros
                            $m=getError('parametros');
                        }
                    }else{//si no se recibió una opción
                        $m="No se pudo realizar la petición";
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'m'=>$m,'sw'=>$sw,'t'=>$swh));///json de rspuesta a procesar en javaScript
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
    //Para marcas
    public function accionMarca(){
        if ($this->input->is_ajax_request()) {
            $msg="";//Mensakje final
            $o=2;//Opcion final
            $swh="Error";//header de swal
            $sw="error";//tipo de swal
            $valido=false;//variable para guardar valor sobre si esta completa la peticion
            if ($this->session->userdata('iduser')) {//si hay una sesion
                if ($this->isAdmin($this->session->userdata('iduser'))) {//si el usuario es administrador
                    $act=$this->input->post('act',true);//accion a realizar
                    if ($this->validar($act)) {//si la accion no esta vacia
                        $nom=$this->input->post('nom',true);//nombre
                        $cve=$this->input->post('cve',true);//clave
                        $det=$this->input->post('det',true);//detalles
                        $ref=$this->input->post('ref',true);//id del registro a actualizar, en caso de requerirlorequerirlo
                        if ($this->validar($nom)) {//si nombre es valido
                            if ($this->validar($cve)) {//si clave es valido
                                $valido=true;
                                if (!$this->validar($det)) {
                                    $det='Sin detalles';
                                }
                            }
                        }
                        if ($valido) {//si la petición es válida
                            $datosMarca=array('nombre'=>$nom,'clave'=>$cve,'detalles'=>$det);
                            //datos de usuario ainsertar
                            if ($act=='nuevo') {//si se guardara un nuevo usuario
                                if ($this->modelo->newMarca($datosMarca)) {//si se inserta el nueo usuario
                                    $m=getSuccess('insert');
                                    $o=1;$swh='Completo';$sw='success';
                                }else{
                                    $m=getError('insert');
                                }
                            }else{
                                if ($act=='update') {//si se guardara un usuario editaado
                                    if ($this->validar($ref)) {//si el id es valida
                                        if ($this->validar($ref)) {
                                                if ($this->modelo->updateMarca($datosMarca,$ref)) {//si se actualizan los datos
                                                $m=getSuccess('insert');
                                                $o=1;$swh='Completo';$sw='success';
                                            }else{
                                                $m=getError('insert');
                                            } 
                                        }else{
                                            $m=getError('parametros');
                                        } 
                                    }else{
                                        $m=getError('parametros');
                                    }                                    
                                }
                            }
                        }else{//si no se recibieron todos los parametros
                            $m=getError('parametros');
                        }
                    }else{//si no se recibió una opción
                        $m="No se pudo realizar la petición";
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'m'=>$m,'sw'=>$sw,'t'=>$swh));///json de rspuesta a procesar en javaScript
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
    public function remMarca() {///Eliminar marca
        if ($this->input->is_ajax_request()) {
            $msg="";//Mensakje final
            $o=2;//Opcion final
            $swh="Error";//header de swal
            $sw="error";//tipo de swal
            $iduser=$this->session->userdata('iduser');
            if ($iduser) {
                if ($this->isAdmin($iduser)) {
                    $ref=$this->input->post('ref',true);
                    if ($ref) {
                        $dependencias=$this->isDepend('marca',$ref);
                        if (!$dependencias) {
                            if ($this->modelo->remMarca($ref)) {
                                $m="La marca se eliminó correctamente";
                                $o=1;
                                $sw='success';
                                $swh='Completo';
                            }else{
                                $m='La marca no fue eliminada';
                            }
                        }else{
                            $m='La marca no pudo ser eliminada debido a que hay '.$dependencias.' productos que dependen de ella';
                        }
                    }else{
                        $m='Imposible realizar operación';
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo(json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw)));
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
////Para tipos de productos
    public function accionTipPro(){
        if ($this->input->is_ajax_request()) {
            $msg="";//Mensakje final
            $o=2;//Opcion final
            $swh="Error";//header de swal
            $sw="error";//tipo de swal
            $valido=false;//variable para guardar valor sobre si esta completa la peticion
            if ($this->session->userdata('iduser')) {//si hay una sesion
                if ($this->isAdmin($this->session->userdata('iduser'))) {//si el usuario es administrador
                    $act=$this->input->post('act',true);//accion a realizar
                    if ($this->validar($act)) {//si la accion no esta vacia
                        $nom=$this->input->post('nom',true);//nombre
                        $det=$this->input->post('det',true);//detalles
                        $ref=$this->input->post('ref',true);//id del registro a actualizar, en caso de requerirlorequerirlo
                        if ($this->validar($nom)) {//si nombre es valido
                            $valido=true;
                            if (!$this->validar($det)) {
                                $det='Sin detalles';
                            }
                        }
                        if ($valido) {//si la petición es válida
                            $datosTP=array('nombre'=>$nom,'detalles'=>$det);
                            //datos de usuario ainsertar
                            if ($act=='nuevo') {//si se guardara un nuevo usuario
                                if ($this->modelo->newTipPro($datosTP)) {//si se inserta el nueo usuario
                                    $m=getSuccess('insert');
                                    $o=1;$swh='Completo';$sw='success';
                                }else{
                                    $m=getError('insert');
                                }
                            }else{
                                if ($act=='update') {//si se guardara un usuario editaado
                                    if ($this->validar($ref)) {//si el id es valida
                                        if ($this->validar($ref)) {
                                                if ($this->modelo->updateTipPro($datosTP,$ref)) {//si se actualizan los datos
                                                $m=getSuccess('insert');
                                                $o=1;$swh='Completo';$sw='success';
                                            }else{
                                                $m=getError('insert');
                                            } 
                                        }else{
                                            $m=getError('parametros');
                                        } 
                                    }else{
                                        $m=getError('parametros'.' !Ups');
                                    }                                    
                                }
                            }
                        }else{//si no se recibieron todos los parametros
                            $m=getError('parametros');
                        }
                    }else{//si no se recibió una opción
                        $m="No se pudo realizar la petición";
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'m'=>$m,'sw'=>$sw,'t'=>$swh));///json de rspuesta a procesar en javaScript
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
    public function remTP() {///Eliminar tipo de producto
        if ($this->input->is_ajax_request()) {
            $msg="";//Mensakje final
            $o=2;//Opcion final
            $swh="Error";//header de swal
            $sw="error";//tipo de swal
            $iduser=$this->session->userdata('iduser');
            if ($iduser) {
                if ($this->isAdmin($iduser)) {
                    $ref=$this->input->post('ref',true);
                    if ($ref) {
                        $dependencias=$this->isDepend('tipPro',$ref);
                        if (!$dependencias) {
                            if ($this->modelo->remTipPro($ref)) {
                                $m="La marca se eliminó correctamente";
                                $o=1;
                                $sw='success';
                                $swh='Completo';
                            }else{
                                $m='La marca no fue eliminada';
                            }
                        }else{
                            $m='El tipo de producto no pudo ser eliminado debido a que hay '.$dependencias.' productos que dependen de este';
                        }
                    }else{
                        $m='Imposible realizar operación';
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo(json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw)));
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
///Productos
    public function saveNuevoPro() {
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=2;$con=false;$sw="error";$swh="Error";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $imgname="";
                        $nom=$this->input->post('nombre',true);
                        $cve=$this->input->post('clave',true);
                        $det=$this->input->post('detalles',true);
                        $tip=$this->input->post('tipo',true);
                        $mar=$this->input->post('marca',true);
                        $pre=$this->input->post('precio',true);
                        $med=$this->input->post('medida',true);
                        if ($this->validar($nom)) {
                            if ($this->validar($cve)) {
                                if (!($tip==""||$tip=="undefined"||$tip=="0")) {
                                    if (!($mar==""||$mar=="undefined"||$mar=="0")) {
                                        $con=true;
                                        if (!$this->validar($det)) {
                                            $det="Sin detalles";
                                        }
                                    }
                                }
                            }
                        }
                        $toInsert=array('imagen' =>'' , 'nombre' => $nom , 'clave'=>$cve,'detalles' =>$det,'id_tipo' => $tip,'id_marca'=>$mar,'precio'=>$pre,'medida'=>$med  );///datos a insertar
                        $dirIMG="";///imagena insetar
                        if ($con) {
                            if ($_FILES['inputImg']['name']) {
                                $this->load->helper('string');
                                $primer=random_string('alnum', 10);    
                                $imgname.="PRO_".$idu.$primer;
                                $mi_imagen = 'inputImg';//Nombre de la imagen segun el nme del input
                                $config['upload_path'] = "./images/productos/temp/";//Carpeta donde se guarda la imagen
                                $config['file_name'] = $imgname;//Nombre del archivo
                                $config['allowed_types'] = "jpg|jpeg|png";//Tipos de imagen
                                $config['max_size'] = "100000";//peso máximo
                                $config['max_width'] = "5000";//ancho máximo
                                $config['max_height'] = "5000";//Largo máximo

                                $this->load->library('upload', $config);//carga libreria y estblece l configurción

                                if (!$this->upload->do_upload($mi_imagen)) {//sube el archivo al servidor
                                    //*** ocurrio un error
                                    $data['uploadError'] = $this->upload->display_errors();
                                    $m=$this->upload->display_errors();$o=2;
                                }else{
                                     $data = array('upload_data' => $this->upload->data());//datos de la imagen precargada
                                     $img_full_path = $config['upload_path'] . $data['upload_data']['file_name'];//imagen que se redimensionará
                                     $imgname=$data['upload_data']['file_name'];//imagen redimensionada
                                     // REDIMENSIONAMOS
                                     $config['image_library'] = 'gd2';//libreria
                                     $config['source_image'] = $img_full_path;///imagen a dimensionar
                                     $config['maintain_ratio'] = TRUE;//manener radio
                                     $config['width'] = 275;//dimensiones
                                     $config['height'] = 250;//dimensiones
                                     $config['new_image'] =  './images/productos/'.$data['upload_data']['file_name'];//iamgen final
                                     $dirIMG=$config['new_image'];
                                     $this->load->library('image_lib', $config);//se carga la libreria
                                     if (!$this->image_lib->resize()) {//si no se redimensiona
                                          @unlink($img_full_path);//se borra imagen precargada
                                          $m= $this->image_lib->display_errors();$o=2;//En caso de no redimencionrla
                                     }else{//si se redimenciona
                                        @unlink($img_full_path);//se borra imagen precargada
                                        $toInsert['imagen']=  $imgname;//se crea arreglo a insertar     
                                        $m="imagen guardada";      
                                     }
                                     $this->image_lib->clear();
                                }
                            }else{$toInsert['imagen']='producto.png';}
                            if ($this->modelo->newPro($toInsert)) {
                                $o=1;$m="El producto se gurardó correctamente";$sw="success";$swh="Completo";
                                if (count($dirIMG)==0) {
                                    $m.='\n, pero la imagen no pudo ser guardada.';
                                }
                            }else{
                                if (count($dirIMG)>0) {
                                    @unlink($dirIMG);
                                }
                                $m="El producto no se gurardó correctamente";
                            }
                        }else{//si no se recibieron todos los parametros
                            $m=getError('parametros');
                        }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw));
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
    public function updateimgPro(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=2;$sw="error";$swh="Error";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $ref=$this->input->post('referencia1',true);
                    if ($_FILES['inputImg']['name']&& $this->validar($ref)) {
                        $this->load->helper('string');
                        $primer=random_string('alnum', 10);    
                        $imgname="PRO_".$idu.$primer;
                        $imgAnt=$this->fotoantpro($ref);
                        $mi_imagen = 'inputImg';//Nombre de la imagen segun el nme del input
                        $config['upload_path'] = "./images/productos/temp/";//Carpeta donde se guarda la imagen
                        $config['file_name'] = $imgname;//Nombre del archivo
                        $config['allowed_types'] = "jpg|jpeg|png";//Tipos de imagen
                        $config['max_size'] = "100000";//peso máximo
                        $config['max_width'] = "5000";//ancho máximo
                        $config['max_height'] = "5000";//Largo máximo
                        $this->load->library('upload', $config);//carga libreria y estblece l configurción
                        if (!$this->upload->do_upload($mi_imagen)) {//sube el archivo al servidor
                            //*** ocurrio un error
                            $data['uploadError'] = $this->upload->display_errors();
                            $m=$this->upload->display_errors();$o=2;
                        }else{
                            $data = array('upload_data' => $this->upload->data());//datos de la imagen precargada
                            $img_full_path = $config['upload_path'] . $data['upload_data']['file_name'];//imagen que se redimensionará
                            $imgname=$data['upload_data']['file_name'];//imagen redimensionada
                            // REDIMENSIONAMOS
                            $config['image_library'] = 'gd2';//libreria
                            $config['source_image'] = $img_full_path;///imagen a dimensionar
                            $config['maintain_ratio'] = TRUE;//manener radio
                            $config['width'] = 275;//dimensiones
                            $config['height'] = 250;//dimensiones
                            $config['new_image'] =  './images/productos/'.$data['upload_data']['file_name'];//iamgen final
                            $imgDir=$config['new_image'];
                            $dirIMG=$config['new_image'];
                            $this->load->library('image_lib', $config);//se carga la libreria
                            if (!$this->image_lib->resize()) {//si no se redimensiona
                                @unlink($img_full_path);//se borra imagen precargada
                                $m= $this->image_lib->display_errors();$o=2;//En caso de no redimencionrla
                            }else{//si se redimenciona
                                @unlink($img_full_path);//se borra imagen precargada
                                $toInsert= array('imagen'=> $imgname);//se crea arreglo a insertar     
                                $m="imagen guardada";
                                if ($this->modelo->updatePro($toInsert,$ref)) {
                                    $m="La imagen se guardó correctamente.";$o=1;$sw="success";$swh="Completo";
                                }else{
                                    @unlink($imgDir);
                                    $m=getError('insert');
                                }    
                            }
                            $this->image_lib->clear();
                        }
                    }else{//si no se recibieron todos los parametros
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw));
        }else{
            $m=$this->load->view(getError('ajax'));
        }
    }
    function fotoantpro($id)   {//consultar foto anterior de producto
        $ret="";
        $con=$this->modelo->getProductos($id);
        if ($con!=null) {
            foreach ($con as $val) {
                $fot=$val->im;
                if ($fot!='producto.png') {
                    $ret=$fot;
                }
            }
        }
        return $ret;
    }
    public function deletePro(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=2;$con=false;$sw="error";$swh="Error";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $ref=$this->input->post('referencia',true);
                    if ($this->validar($ref)) {
                        $con=true;
                    }
                    if ($con) {
                        if ($this->isDepend('producto',$ref)) {
                            $m="Por razones de seguridad, este producto no puede ser eliminado.";
                        }else{
                            if ($this->modelo->remPro($ref)) {
                                $m="Los datos se eliminaron correctamente";$sw="success";$swh="Completo";$o=1;
                            }else{
                                $m=getError('insert');
                            }
                        }
                    }else{//si no se recibieron todos los parametros
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    public function updatedataPro(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=2;$con=false;$sw="error";$swh="Error";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $ref=$this->input->post('referencia',true);
                    $nom=$this->input->post('nombre',true);
                    $cve=$this->input->post('clave',true);
                    $det=$this->input->post('detalles',true);
                    $tip=$this->input->post('tipo',true);
                    $mar=$this->input->post('marca',true);
                    $pre=$this->input->post('precio',true);
                    $med=$this->input->post('medida',true);
                    if ($this->validar($nom)) {
                        if ($this->validar($cve)) {
                            if (!($tip==""||$tip=="undefined"||$tip=="0")) {
                                if (!($mar==""||$mar=="undefined"||$mar=="0")) {
                                    if ($this->validar($ref)) {
                                        $con=true;
                                        if (!$this->validar($det)) {
                                            $det="Sin detalles";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($con) {
                        $toInsert=array('nombre' => $nom , 'clave'=>$cve,'detalles' =>$det,'id_tipo' => $tip,'id_marca'=>$mar,'precio'=>$pre,'medida'=>$med );///datos a insertar
                        if ($this->modelo->updatePro($toInsert,$ref)) {
                            $m="Los datos se actualizaron correctamente";$sw="success";$swh="Completo";$o=1;
                        }else{
                            $m=getError('insert');
                        }
                    }else{//si no se recibieron todos los parametros
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    /////////////////////Clientes//////////////////////////77
    public function nuevoCliente(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=2;$con=false;$sw="error";$swh="Error";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $nom=$this->input->post('nombre',true);
                    $cor=$this->input->post('correo',true);
                    $tel=$this->input->post('telefono',true);
                    $dir=$this->input->post('direccion',true);
                    $em=$this->input->post('tipo',true);
                    $ver=$this->input->post('mostrar',true);
                    $cp=$this->input->post('cp',true);
                    $atn=$this->input->post('atn',true);
                    if ($this->validar($nom)) {
                        if ($this->validar($cor)) {
                            if ($this->validar($tel)) {
                                if ($this->validar($dir)) {
                                    if ($em!=null && $em!='undefined') {
                                        if ($ver!=null  && $ver!='undefined') {
                                            if ($this->validar($cp)) {
                                                #if ($this->validar($atn)) {
                                                    $con=true;
                                                #}
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($con) {
                        $data=array('nombre'=>$nom,'correo'=>$cor,'telefono'=>$tel,'direccion'=>$dir,'empresa'=>$em,'mostrar'=>$ver,'cp'=>$cp,'atn'=>$atn);
                        if ($this->modelo->newCliente($data) ) {
                            $m="Los datos se guardaron correctamente";$o=1;$sw='success';$swh="Completo";
                        }else{
                            $m=getError('insert');
                        }
                    }else{
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    public function updateCliente(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=2;$con=false;$sw="error";$swh="Error";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $nom=$this->input->post('nombre',true);
                    $cor=$this->input->post('correo',true);
                    $tel=$this->input->post('telefono',true);
                    $dir=$this->input->post('direccion',true);
                    $em=$this->input->post('tipo',true);
                    $ver=$this->input->post('mostrar',true);
                    $ref=$this->input->post('referencia',true);
                    $cp=$this->input->post('cp',true);
                    $atn=$this->input->post('atn',true);
                    if ($this->validar($nom)) {
                        if ($this->validar($cor)) {
                            if ($this->validar($tel)) {
                                if ($this->validar($dir)) {
                                    if ($em!=null&&$em!='undefined') {
                                        if ($ver!=null&&$ver!='undefined') {
                                            if ($this->validar($ref)) {
                                                if ($this->validar($cp)) {
                                                    #if ($this->validar($atn)) {
                                                        $con=true;
                                                    #}
                                                }
                                            }                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($con) {
                        $data=array('nombre'=>$nom,'correo'=>$cor,'telefono'=>$tel,'direccion'=>$dir,'empresa'=>$em,'mostrar'=>$ver,'cp'=>$cp,'atn'=>$atn);
                        if ($this->modelo->updateCliente($ref,$data) ) {
                            $m="Los datos se guardaron correctamente";$o=1;$sw='success';$swh="Completo";
                        }else{
                            $m=getError('insert');
                        }
                    }else{
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('o'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    /////////////////////////////////////////////////////////////////////////777
    ////////////Fnciones para presupestos///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    public function nuevoPresupuesto(){
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=true;$con=false;$sw="error";$swh="Error";$ref=0;
            $clave="SICPRE00";
            if ($idu) {
                if ($this->isAdmin($idu)) {
                    $nom=$this->input->post('detalle',true);
                    $as=$this->input->post('as',true);
                    if ($this->validar($nom)) {
                        $con=true;
                    }
                    if ($con) {
                        $data=array('id_usuario'=>$idu,'detalles'=>$nom,'plantilla'=>$as);
                        $ref=$this->modelo->nuevoPresupuesto($data);
                        if ($ref) {
                            $clave.=$ref;
                            $this->modelo->updatePresupuesto($ref,array('clave'=>$clave));
                            $m="Perfecto, ahora completa los datos del prespuesto.";$o=false;$sw='success';$swh="Completo";
                        }else{
                            $m=getError('insert');
                        }
                    }else{
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('error'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw,'ref'=>$ref));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    public function uddategeneralInPre() {
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=true;$con=false;$sw="red";$swh="Error";$ref=0;
            if ($idu) {
                if ($this->isAdmin($idu,false)) {
                    $nom=$this->input->post('detalle',true);
                    $cliente=$this->input->post('cliente',true);
                    $ref=$this->input->post('ref',true);
                    $pago=$this->input->post('pago',true);
                    $vencimiento=$this->input->post('vencimiento',true);
                    $iva=$this->input->post('iva',true);
                    $data=array();
                    if($ref){
                        if($this->validar($cliente)){
                            $data['id_cliente']=$cliente;
                            $con=true;
                        }
                        if ($this->validar($nom)) {
                            $data['detalles']=$nom;
                            $con=true;
                        }
                        if($this->validar($pago)){
                            $data['forma_pago']=$pago;
                            $con=true;
                        }
                        if ($this->validar($vencimiento)) {
                            $data['vencimiento']=$vencimiento;
                            $con=true;
                        }
                        if ($this->validar($iva)) {
                            $data['iva']=$iva;
                            $con=true;
                        }
                    }                 
                    if ($con) {
                        $ref=$this->modelo->updatePresupuesto($ref,$data);
                        if ($ref) {
                            $m="Datos actualizados correctamente.";$o=false;$sw='green';$swh="Completo";
                        }else{
                            $m=getError('insert');
                        }
                    }else{
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('error'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw,'ref'=>$ref));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    public function saveProductosInPre() {
        if ($this->input->is_ajax_request()) {
            $idu=$this->session->userdata('iduser');
            $m="";$o=true;$con=false;$sw="red";$swh="Error";$ref=0;
            if ($idu) {
                if ($this->isAdmin($idu,false)) {
                    $pro=$this->input->post('pro',true);
                    $pre=$this->input->post('pre',true);
                    $precio=$this->input->post('precio',true);
                    $cantidad=$this->input->post('cantidad',true);
                    if(true){
                        if($this->validar($precio)){
                            if ($this->validar($cantidad)) {
                                if ($this->validar($pro)) {
                                    if ($this->validar($pre)) {
                                        $con=true;
                                    }
                                }
                            }
                        }
                    }                 
                    if ($con) {
                        $data=array('id_producto'=>$pro,'id_presupuesto'=>$pre,'precio'=>$precio,'cantidad'=>$cantidad);
                        $ref=$this->modelo->newProInpre($data);
                        if ($ref) {
                            $m="Datos actualizados correctamente.";$o=false;$sw='green';$swh="Completo";
                        }else{
                            $m=getError('insert');
                        }
                    }else{
                        $m=getError('parametros');
                    }
                }else{//si no tiene permisos
                    $m=getError('acceso');
                }
            }else{//si no hay sessio
                $m=getError('sesion');
            }
            echo json_encode(array('error'=>$o,'t'=>$swh,'m'=>$m,'sw'=>$sw,'ref'=>$ref));
        }else{
            $this->load->view(getError('ajax'));
        }
    }
    /*************************************************************************/
    /*************     Fin de Funciones de panel     *****+*******************/
    /*************************************************************************/

}