<?php

class Imagen {

    private $idImagen;
    private $nombre;

    public function getIdImagen() {
        return $this->idImagen;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setIdImagen($idImagen) {
        $this->idImagen = $idImagen;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

}
