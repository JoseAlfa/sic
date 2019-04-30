<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
*/
class Report_Model extends CI_Model {
    public function __construct(){
	parent::__construct();
    }
	public function get_perDet($id_pre,$admin=false,$idu=0){
		$return=null;
        $this->db->select("pr.id_presupuesto id,pr.id_cliente idc,pr.id_usuario idu,pr.clave cv,pr.detalles det, pr.plantilla pla,pr.liberado lib,pr.fecha_ini ini,pr.fecha_fin fin,p.nombre nom,p.apellidos ap,pr.otros_datos otros, p.correo cor,p.telefono tel,pr.liberado lib,pr.forma_pago pago,pr.vencimiento ven,pr.iva iva,c.nombre cliente,c.telefono telC,c.correo corC,c.direccion dirC,c.cp cp,c.atn atn,c.empresa emp");
        $this->db->from('personas p');
        $this->db->join('usuarios u','p.id_persona=u.id_persona');
        $this->db->join('presupuestos pr','u.id_usuario=pr.id_usuario');
        $this->db->join('clientes c','pr.id_cliente=c.id_cliente');
        $this->db->where('pr.id_presupuesto',$id_pre);
        if(!$admin){
        	$this->db->where('u.id_usuario',$idu);
        }
        $res=$this->db->get();
        #echo $this->db->last_query();exit();
        $return= $res->result();
        return $return;
	}
	public function productos($id_pre){
		$return=null;
        $this->db->select("pr.nombre pro,pr.detalles det,pr.medida med,pp.precio pre,pp.cantidad can,m.nombre mar,pp.detalles detP");
        $this->db->from('presupuestos p');
        $this->db->join('presupuesto_productos pp','p.id_presupuesto=pp.id_presupuesto');
        $this->db->join('productos pr','pp.id_producto=pr.id_producto');
        $this->db->join('marcas m','m.id_marca=pr.id_marca');
        $this->db->where('p.id_presupuesto',$id_pre);
        $res=$this->db->get();
        $return= $res->result();
        return $return;
	}
	public function epresa(){
		$this->db->select('*');
		$this->db->from('empresa');
		$this->db->limit(1);
		$res=$this->db->get();
		#echo $this->db->last_query();
        $return= $res->result();
        return $return;
	}
    public function ceo($id) {
        $this->db->where('id_persona',$id);
        $res=$this->db->get('personas');
        return $res->result();
    }
    public function productosShow($tipo=1)   {
        $this->db->where('id_tipo',$tipo);
        $res=$this->db->get('productos');
        //echo $this->db->last_query();
        return $res->result();
    }
    public function clientes($mostrar=1) {
        $this->db->where('mostrar',$mostrar);
        $res=$this->db->get('clientes');
        return $res->result();
    }
}