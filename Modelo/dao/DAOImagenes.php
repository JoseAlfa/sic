<?php

class DAOImagenes {

    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::getInstance();
    }

    private function setUpdate($sql) {
        $result = $this->conexion->set_update($sql);
        return $result["STATUS"] == "OK";
    }

    public function insertar(Imagen $imagen) {
        $sql = "INSERT INTO imagenes(nombre) VALUES('" . $imagen->getNombre() . "')";
        return $this->setUpdate($sql);
    }

    public function actualizar(Imagen $imagen) {
        $sql = "UPDATE imagenes SET nombre = '" . $imagen->getNombre() . "'"
                . " WHERE id_imagen = " . $imagen->getIdImagen();
        return $this->setUpdate($sql);
    }

    private function createObject($data) {
        $imagen = new Imagen();
        $imagen->setIdImagen($data["id_imagen"]);
        $imagen->setNombre($data["nombre"]);
        return $imagen;
    }

    private function getSingleData($sql) {
        $result = $this->conexion->get_data($sql);

        if ($result["STATUS"] == "OK" && count($result["DATA"]) > 0) {
            $data = $result["DATA"][0];
            return $this->createObject($data);
        }

        return NULL;
    }

    public function consultarPorID($id) {
        $sql = "SELECT * FROM imagenes WHERE id_imagen = " . $id;
        return $this->getSingleData($sql);
    }

}
