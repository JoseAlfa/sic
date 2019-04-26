<?php

/**
 * @author JazamarP edit by Jose Alfredo jimenez Sanchez
 */
class ConexionBD {

    private $_connection;
    private static $_instance; //The single instance
    private $_host = "localhost";
    private $_username = "jose";
    private $_password = "123";
    private $_database = "sic_db";
    private static $_lastId = 0;
    
    ///funcion para retornar valoes de conexion
    public function getdb_params() {
        return array('host'=>$this->_host,'db_user'=> $this->_username,'db_password'=> $this->_password,'db_database'=> $this->_database);
    }
    /*
      Get an instance of the Database
      @return Instance
     */

    public static function getInstance() {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    function __construct() {
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(), E_USER_ERROR);
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() {
        //empty
    }

    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }

    public function get_data($sql) {
        $ret = array('STATUS' => 'ERROR', 'ERROR' => '', 'DATA' => array());

        $mysqli = $this->getConnection();
        $res = $mysqli->query($sql);

        if ($res) {
            $ret['STATUS'] = "OK";
        } else {
            $ret['ERROR'] = mysqli_error();
        }

        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $ret['DATA'][] = $row;
        }
        return $ret;
    }

    public function set_update($sql) {
        $ret = array('STATUS' => 'ERROR', 'ERROR' => '');

        $mysqli = $this->getConnection();
        $res = $mysqli->query($sql);

        if ($res) {
            $ret['STATUS'] = "OK";
            self::$_lastId = $mysqli->insert_id;
        } else {
            $ret['ERROR'] = mysqli_error();
            self::$_lastId = 0;
        }

        return $ret;
    }

    public static function get_last_id() {
        return self::$_lastId;
    }

}
