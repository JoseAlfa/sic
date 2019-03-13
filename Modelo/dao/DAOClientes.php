<?php

class DAOClientes {

    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::getInstance();
    }

    private function setUpdate($sql) {
        $result = $this->conexion->set_update($sql);
        return $result["STATUS"] == "OK";
    }

    public function insertar(Cliente $cliente) {
        $sql = "INSERT INTO clientes(nombre, correo) VALUES("
                . "'" . $cliente->getNombre() . "',"
                . "'" . $cliente->getCorreo() . "')";
        return $this->setUpdate($sql);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM clientes WHERE id_cliente = " . $id;
        return $this->setUpdate($sql);
    }

    private function createObject($data) {
        $cliente = new Cliente();
        $cliente->setIdCliente($data["id_cliente"]);
        $cliente->setNombre($data["nombre"]);
        $cliente->setCorreo($data["correo"]);
        return $cliente;
    }

    private function getArrayData($sql) {
        $result = $this->conexion->get_data($sql);

        if ($result["STATUS"] == "OK" && count($result["DATA"]) > 0) {
            $clientes = array();

            foreach ($result["DATA"] as $data) {
                array_push($clientes, $this->createObject($data));
            }

            return $clientes;
        }

        return NULL;
    }

    public function consultarTodos() {
        $sql = "SELECT * FROM clientes ORDER BY nombre";
        return $this->getArrayData($sql);
    }

}
