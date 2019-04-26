<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Jose Alfredo Jimenez Sanchez
 * @empresa SIC
 */
include_once '../../Modelo/conexion/ConexionBD.php';

$usuario=filter_input(INPUT_POST, 'us', FILTER_SANITIZE_FULL_SPECIAL_CHARS);//Usuario que se envia por ajax, en este caso se le hace un filtro
$contrasena=filter_input(INPUT_POST, 'ps', FILTER_SANITIZE_FULL_SPECIAL_CHARS);//Contraseñas que se envia por ajax, en este caso se le hace un filtro
$login=new Login();
echo $login->buscar($usuario, $contrasena);
//Clase Login, contiene lo metodos para login
class Login{
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::getInstance();
    }
    /*Aqui se genera la consulta para buscar el usuario y la contraseña*/
    public function buscar($user,$pass){
        $sql="SELECT p.nombre nom,p.apellidos ap,p.correo cor,p.telefono tel,administrador adm FROM usuarios u,personas p WHERE u.id_persona=p.id_persona AND u.nombre like('".$user."') AND u.contrasena like(md5('".$pass."'));";
        $result = $this->conexion->get_data($sql);
        //echo $sql;
        $ret=2;
        if ($result["STATUS"] == "OK" && count($result["DATA"]) > 0) {
            //var_dump($result);
            foreach ($result["DATA"] as $data) {
                if ($data['adm']==1|| $data['adm']=='1') {
                    $ret=1;
                    session_start();
                    $_SESSION['name']=$user;
                }else{
                    $ret=3;
                }
            }           
            
        }
        return $ret;
    }
}

