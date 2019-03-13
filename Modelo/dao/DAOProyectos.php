<?php

class DAOProyectos {

    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::getInstance();
    }

    private function setUpdate($sql) {
        $result = $this->conexion->set_update($sql);
        return $result["STATUS"] == "OK";
    }

    public function insertar(Proyecto $proyecto) {
        $sql = "INSERT INTO proyectos(nombre, descripcion, id_imagen) VALUES("
                . "'" . $proyecto->getNombre() . "',"
                . "'" . $proyecto->getDescripcion() . "',"
                . $proyecto->getImagen() . ")";
        return $this->setUpdate($sql);
    }

    public function actualizar(Proyecto $proyecto) {
        $sql = "UPDATE proyectos SET "
                . "nombre = '" . $proyecto->getNombre() . "',"
                . "descripcion = '" . $proyecto->getDescripcion() . "',"
                . "id_imagen = " . $proyecto->getImagen()
                . " WHERE id_proyecto = " . $proyecto->getIdProyecto();
        return $this->setUpdate($sql);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM proyectos WHERE id_proyecto = " . $id;
        return $this->setUpdate($sql);
    }

    private function createObject($data) {
        $proyecto = new Proyecto();
        $proyecto->setIdProyecto($data["id_proyecto"]);
        $proyecto->setNombre($data["nombre"]);
        $proyecto->setDescripcion($data["descripcion"]);
        $proyecto->setImagen($data["id_imagen"]);
        return $proyecto;
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
            $proyectos = array();

            foreach ($result["DATA"] as $data) {
                array_push($proyectos, $this->createObject($data));
            }

            return $proyectos;
        }

        return NULL;
    }

    public function consultarPorID($id) {
        $sql = "SELECT * FROM proyectos WHERE id_proyecto = " . $id;
        return $this->getSingleData($sql);
    }

    public function consultarTodos() {
        $sql = "SELECT * FROM proyectos ORDER BY nombre";
        return $this->getArrayData($sql);
    }

}
