<?php

class Proyecto {

    private $idProyecto;
    private $nombre;
    private $descripcion;
    private $imagen;

    public function getIdProyecto() {
        return $this->idProyecto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setIdProyecto($idProyecto) {
        $this->idProyecto = $idProyecto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

}
