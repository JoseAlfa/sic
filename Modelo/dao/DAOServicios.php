<?php

class DAOServicios {

    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::getInstance();
    }

    private function setUpdate($sql) {
        $result = $this->conexion->set_update($sql);
        return $result["STATUS"] == "OK";
    }

    public function insertar(Servicio $servicio) {
        $sql = "INSERT INTO productos(nombre, detalles, imagen,id_tipo) VALUES("
                . "'" . $servicio->getNombre() . "',"
                . "'" . $servicio->getDescripcion() . "','"
                . $servicio->getImagen() . "',1)";
        return $this->setUpdate($sql);
    }

    public function actualizar(Servicio $servicio) {
        $sql = "UPDATE productos SET "
                . "nombre = '" . $servicio->getNombre() . "',"
                . "detalles = '" . $servicio->getDescripcion() . "',"
                . "imagen = '" . $servicio->getImagen()."'"
                . " WHERE id_producto = " . $servicio->getIdServicio();
        return $this->setUpdate($sql);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id_producto = " . $id;
        return $this->setUpdate($sql);
    }

    private function createObject($data) {
        $servicio = new Servicio();
        $servicio->setIdServicio($data["id_producto"]);
        $servicio->setNombre($data["nombre"]);
        $servicio->setDescripcion($data["detalles"]);
        $servicio->setImagen($data["imagen"]);
        return $servicio;
    }

    private function getSingleData($sql) {
        $result = $this->conexion->get_data($sql);

        if ($result["STATUS"] == "OK" && count($result["DATA"]) > 0) {
            $data = $result["DATA"][0];
            return $this->createObject($data);
        }

        return NULL;
    }

    private function getArrayData($sql) {
        $result = $this->conexion->get_data($sql);

        if ($result["STATUS"] == "OK" && count($result["DATA"]) > 0) {
            $servicios = array();

            foreach ($result["DATA"] as $data) {
                array_push($servicios, $this->createObject($data));
            }

            return $servicios;
        }

        return NULL;
    }

    public function consultarPorID($id) {
        $sql = "SELECT * FROM productos WHERE id_producto = " . $id;
        return $this->getSingleData($sql);
    }

    public function consultarTodos() {
        $sql = "SELECT * FROM productos where id_tipo=1 ORDER BY nombre";
        return $this->getArrayData($sql);
    }

}
