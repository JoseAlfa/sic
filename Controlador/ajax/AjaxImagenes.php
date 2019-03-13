<?php

function uploadImage($nombreImagen) {
    $carpetaDestino = "../../Vista/images/proyectos/";

    if (validateImage($carpetaDestino)) {
        $origen = $_FILES["archivo"]["tmp_name"];
        $destino = $carpetaDestino . $nombreImagen;
        
        if (move_uploaded_file($origen, $destino)) {
            return true;
        }
    }

    return false;
}

function validateImage($carpetaDestino) {
    # si hay algun archivo que subir
    if ($_FILES["archivo"]["name"]) {
        # si es un formato de imagen
        if ($_FILES["archivo"]["type"] == "image/jpeg" || $_FILES["archivo"]["type"] == "image/png") {
            # si exsite la carpeta o se ha creado
            if (file_exists($carpetaDestino) || @mkdir($carpetaDestino)) {
                return TRUE;
            }
        }
    }

    return FALSE;
}
