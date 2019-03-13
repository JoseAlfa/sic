<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
*/
class General_model extends CI_Model {
    public function __construct(){
	parent::__construct();
    }
    public function login($usr,$pas) {//Generador de consulta para la validaión por medi de un usuarioy contraseña
        $this->db->select('p.nombre nom,p.apellidos ap,p.correo cor,p.telefono tel,p.id_persona idp,u.id_usuario idu,u.color col');
        $this->db->from('personas p');
        $this->db->join('usuarios u','u.id_persona=p.id_persona');
        $this->db->where('u.nombre',$usr);
	    $this->db->where('u.contrasena',$pas);
        $res=$this->db->get();
        #echo $this->db->last_query();
	    return $res->result();
    }
    public function userdata($idpersona){///Consulta deos dato personales a base de un id
        $this->db->select('p.nombre nom,p.apellidos ap,p.correo cor,p.telefono tel,p.id_persona idp');
        $this->db->from('personas p');
        $this->db->where('p.id_persona',$idpersona);
        $res=$this->db->get();
        return $res->result();
    }
    public function userdataSes($idusuario){///Consulta deos dato personales a base de un id
        $this->db->select('u.nombre nom,u.color col,u.id_persona idp');
        $this->db->from('usuarios u');
        $this->db->where('u.id_usuario',$idusuario);
        $res=$this->db->get();
        return $res->result();
    }
    public function updateUsuario($datos,$idu){//actualizacion de la tabla de usuario
        $this->db->where('id_usuario',$idu);
        return $this->db->update('usuarios',$datos);
    }
    public function verificarContrasena($contrasena,$idu){//consulta lacontraseña de un id de usuario
        $this->db->select('u.nombre nom,u.color col,u.id_persona idp');
        $this->db->from('usuarios u');
        $this->db->where('u.id_usuario',$idu);
        $this->db->where('u.contrasena',$contrasena);
        $res=$this->db->get();
        #echo $this->db->last_query();
        return $res->result();
    }
     /*************Produtos______________>**/
    public function getProductos($id=false,$limit=1000,$offset=0,$pag=true,$q='')  {
        $return=null;
        $this->db->select("p.id_producto id,p.nombre nom,p.id_marca idmarca,p.id_tipo idtipo,p.clave cv, p.detalles det,p.imagen im,m.nombre marca,tp.nombre tipo");
        $this->db->from('productos p');
        $this->db->join('marcas m','p.id_marca=m.id_marca');
        $this->db->join('tipos_producto tp','p.id_tipo=tp.id_tipo');
        $this->db->group_start();
        $this->db->like('p.nombre', $q);
        $this->db->or_like('p.clave', $q);
        $this->db->group_end();
        if ($id) {
            $this->db->where('p.id_producto',$id);
            $res=$this->db->get();
            $return= $res->result();
        }else{
            if ($pag) {
                $this->db->order_by('p.id_producto asc');
                $this->db->limit($limit, $offset);
                $res=$this->db->get();
                //echo $this->db->last_query();
                $return= $res->result();
            }else{
                $res=$this->db->get();
                $return= $res->num_rows();
            }
        }
        return $return;
    }
    public function newPro($datos){//insersion en la tabla de productos
        return $this->db->insert('productos',$datos);
    }
    public function updatePro($datos,$id){//actualizacion de la tabla de productos
        $this->db->where('id_producto',$id);
        return $this->db->update('productos',$datos);
    }
    public function remPro($ref){//Eiminar en la tabla de productos
        $res=$this->db->where('id_producto',$ref);
        return $this->db->delete('productos');
    }
    /*************Marcas______________>**/
    public function getMarcas($idmarca=false,$limit=100000,$offset=0,$pag=true,$q='')  {
        $return=null;
        $this->db->select("m.id_marca id,m.nombre nom,m.imagen im,m.clave cv,m.detalles det");
        $this->db->from('marcas m');
        $this->db->group_start();
        $this->db->like('m.nombre', $q);
        $this->db->or_like('m.clave', $q);
        $this->db->group_end();
        if ($idmarca) {
            $this->db->where('m.id_marca',$idmarca);
            $res=$this->db->get();
            $return= $res->result();
        }else{
            if ($pag) {
                $this->db->order_by('m.id_marca asc');
                $this->db->limit($limit, $offset);
                $res=$this->db->get();
                //echo $this->db->last_query();
                $return= $res->result();
            }else{
                $res=$this->db->get();
                $return= $res->num_rows();
            }
        }
        return $return;
    }
    public function newMarca($datosMarca){
        return $this->db->insert('marcas',$datosMarca);
    }
    public function updateMarca($datos,$id){//actualizacion de la tabla de usuario
        $this->db->where('id_marca',$id);
        return $this->db->update('marcas',$datos);
    }
    public function remMarca($ref){
        $res=$this->db->where('id_marca',$ref);
        return $this->db->delete('marcas');
    }
    public function marcaCount($ref){
        $this->db->select('count(p.id_producto) num');
        $this->db->from('productos p');
        $this->db->where('p.id_marca',$ref);
        $res=$this->db->get();
        return $res->result();
    }
    /*************TiposProdutos______________>**/
    public function getTipPro($idsel=false,$limit=1000000,$offset=0,$pag=true,$q='')  {
        $return=null;
        $this->db->select("tp.id_tipo id,tp.nombre nom,tp.detalles det");
        $this->db->from('tipos_producto tp');
        $this->db->group_start();
        $this->db->like('tp.nombre', $q);
        $this->db->group_end();
        if ($idsel) {
            $this->db->where('tp.id_tipo',$idsel);
            $res=$this->db->get();
            $return= $res->result();
        }else{
            if ($pag) {
                $this->db->order_by('tp.id_tipo asc');
                $this->db->limit($limit, $offset);
                $res=$this->db->get();
                //echo $this->db->last_query();
                $return= $res->result();
            }else{
                $res=$this->db->get();
                $return= $res->num_rows();
            }
        }
        return $return;
    }
    public function newTipPro($datosTP){
        return $this->db->insert('tipos_producto',$datosTP);
    }
    public function updateTipPro($datosTP,$ref){
        $this->db->where('id_tipo',$ref);
        return $this->db->update('tipos_producto',$datosTP);
    }
    public function remTipPro($ref){
        $res=$this->db->where('id_tipo',$ref);
        return $this->db->delete('tipos_producto');
    }
    public function tipProCount($ref){
        $this->db->select('count(p.id_tipo) num');
        $this->db->from('productos p');
        $this->db->where('p.id_tipo',$ref);
        $res=$this->db->get();
        return $res->result();
    }
    /*************Usuarios______________>**/
    public function getUsuarios($idsel,$limit=0,$offset=0,$pag=true,$q='',$idses=0)  {
        $return=null;
        $this->db->select("p.id_persona idp,u.id_usuario idu,p.nombre nom,p.apellidos ap,p.correo cor,p.telefono tel,u.nombre usr,u.administrador adm");
        $this->db->from('personas p');
        $this->db->join('usuarios u','u.id_persona=p.id_persona');
        $this->db->group_start();
        $this->db->like('p.nombre', $q);
        $this->db->or_like('p.apellidos', $q);
        $this->db->or_like('u.nombre', $q);
        $this->db->group_end();
        $this->db->where('p.id_persona!=',$idses);
        if ($idsel) {
            $this->db->where('p.id_persona',$idsel);
            $res=$this->db->get();
            $return= $res->result();
        }else{
            if ($pag) {
                $this->db->order_by('p.id_persona asc');
                $this->db->limit($limit, $offset);
                $res=$this->db->get();
                #echo $this->db->last_query();
                $return= $res->result();
            }else{
                $res=$this->db->get();
                $return= $res->num_rows();
            }
        }
        return $return;
    }
    public function newUser($datosPersona,$datosUser){
        $retorno=false;//variabe a retornar
        $this->db->trans_begin();
        if ($this->db->insert('personas',$datosPersona)) {
            $idp=$this->db->insert_id();
            $datosUser['id_persona']=$idp;
            if ($this->db->insert('usuarios',$datosUser)) {
                $retorno=true;
                $this->db->trans_commit();              
            }else{
                $this->db->trans_rollback();
            }
        }else{
            $this->db->trans_rollback();
        }
        return $retorno;
    }
    public function updateUser($datosUser,$datosPersona,$ids){
        $retorno=false;//variabe a retornar
        $this->db->trans_begin();
        $this->db->where('id_persona',$ids['persona']);
        if ($this->db->update('personas',$datosPersona)) {
            $this->db->where('id_usuario',$ids['user']);
            if ($this->db->update('usuarios',$datosUser)) {
                $retorno=true;
                $this->db->trans_commit();              
            }else{
                $this->db->trans_rollback();
            }
        }else{
            $this->db->trans_rollback();
        }
        return $retorno;
    }
    ///////////7clientes
    public function getClientes($idsel=false,$limit=1000000,$offset=0,$pag=true,$q='') {
         $return=null;
        $this->db->select("c.id_cliente id,c.nombre nom,c.correo cor,c.telefono tel,c.direccion dir,c.empresa em,c.mostrar show");
        $this->db->from('clientes c');
        $this->db->group_start();
        $this->db->like('c.nombre', $q);
        $this->db->or_like('c.correo', $q);
        $this->db->or_like('c.telefono', $q);
        $this->db->group_end();
        if ($idsel) {
            $this->db->where('c.id_cliente',$idsel);
            $res=$this->db->get();
            $return= $res->result();
        }else{
            if ($pag) {
                $this->db->order_by('c.id_cliente asc');
                $this->db->limit($limit, $offset);
                $res=$this->db->get();
                #echo $this->db->last_query();
                $return= $res->result();
            }else{
                $res=$this->db->get();
                $return= $res->num_rows();
            }
        }
        return $return;
    }
    public function newCliente($data){
        return $this->db->insert('clientes',$data);
    }
    public function updateCliente($id,$datos){
        $this->db->where('id_cliente',$id);
        return $this->db->update('clientes',$datos);
    }
    /////////////////////////////////////////////7777777///////////7777
    //////////presupuesto77777777777////777///////////7
    public function presupuestos($idsel=false,$limit=1000000,$offset=0,$pag=true,$q='') {
         $return=null;
        $this->db->select("pr.id_presupuesto id,pr.id_cliente idc,pr.id_usuario idu,pr.clave cv,pr.detalles det, pr.plantilla pla,pr.liberado lib,pr.fecha_ini ini,pr.fecha_fin fin,p.nombre nom,p.apellidos ap, p.correo cor,p.telefono tel,c.nombre cli,c.correo ccor,c.telefono ctel,c.direccion cdir, c.empresa em");
        $this->db->from('personas p');
        $this->db->join('usuarios u','p.id_persona=u.id_persona');
        $this->db->join('presupuestos pr','u.id_usuario=pr.id_usuario');
        $this->db->join('clientes c','pr.id_cliente=c.id_cliente');
        $this->db->group_start();
        $this->db->like('c.nombre', $q);
        $this->db->or_like('c.correo', $q);
        $this->db->or_like('pr.clave', $q);
        $this->db->or_like('pr.detalles', $q);
        $this->db->or_like('p.nombre', $q);
        $this->db->or_like('p.persona', $q);
        $this->db->group_end();
        if ($idsel) {
            $this->db->where('pr.id_presupuesto',$idsel);
            $res=$this->db->get();
            $return= $res->result();
        }else{
            if ($pag) {
                $this->db->order_by('pr.id_presupuesto asc');
                $this->db->limit($limit, $offset);
                $res=$this->db->get();
                #echo $this->db->last_query();
                $return= $res->result();
            }else{
                $res=$this->db->get();
                $return= $res->num_rows();
            }
        }
        return $return;
    }
}