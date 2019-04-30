<?php
include_once '../../Modelo/conexion/ConexionBD.php';
include_once '../../Modelo/clases/Servicio.php';
include_once '../../Modelo/dao/DAOServicios.php';
include_once '../../Modelo/clases/Imagen.php';
include_once '../../Modelo/dao/DAOImagenes.php';
include_once './AjaxImagenes.php';


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$daoServicios = new DAOServicios();
$daoImagenes = new DAOImagenes();

if (strcmp($action, "insert") === 0) {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombreImagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombreImagen = 'PRO_'.getRandomString(10).substr($nombreImagen, strlen($nombreImagen)-5,strlen($nombreImagen));
    $status = "ERROR";
    //$imagen = new Imagen();
    //$imagen->setNombre($nombreImagen);

    if (uploadImage($nombreImagen)) {
        if (true) {
            $servicio = new Servicio();
            $servicio->setNombre($nombre);
            $servicio->setDescripcion($descripcion);
            $servicio->setImagen($nombreImagen);

            if ($daoServicios->insertar($servicio)) {
                $status = "OK";
            }
        }
    }

    echo $status;
} else if (strcmp($action, "read") === 0) {
    $servicios = $daoServicios->consultarTodos();
    $response = "ERROR";

    if ($servicios != NULL && count($servicios) > 0) {
        $response = showData($servicios);
    } else {
        $response .= "<tr><td colspan='4' align='center'>No hay registros</td></tr>";
    }

    echo $response;
} else if (strcmp($action, "load") === 0) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    //
    $servicio = $daoServicios->consultarPorID($id);
    $response = array(
        'STATUS' => $servicio->getIdServicio() > 0 ? "OK" : "ERROR",
        'ID' => $servicio->getIdServicio(),
        'NOMBRE' => $servicio->getNombre(),
        'DESCRIPCION' => $servicio->getDescripcion()
    );
    echo json_encode($response);
} else if (strcmp($action, "update") === 0) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombreImagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //
    $status = 0;
    //
    $servicio = $daoServicios->consultarPorID($id);
    $servicio->setNombre($nombre);
    $servicio->setDescripcion($descripcion);

    if (strlen($nombreImagen) > 0) {
        //$imagen = new Imagen();
        $nombreImagen = 'PRO_'.getRandomString(10).substr($nombreImagen, strlen($nombreImagen)-5,strlen($nombreImagen));
        //$imagen->setNombre($nombreImagen);

        if (uploadImage($nombreImagen)) {
            if (true) {
                $status = 1;
                $servicio->setImagen($nombreImagen);
            }
        }
    } else {
        $status = 2;
    }

    if ($status > 0) {
        if ($daoServicios->actualizar($servicio)) {
            $status = 3;
        }
    }

    echo $status == 3 ? 'OK' : 'ERROR';
} else if (strcmp($action, "delete") === 0) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $data= serviceData($daoServicios->consultarPorID($id));
    $img=$data['IMAGEN'];
    if ($daoServicios->eliminar($id)) {
        $img='../../presupuestos/images/productos/'.$img;
        //echo $img;
        @unlink($img);
        echo 'OK';
    }else{
        echo "ERROR";
    }    
} else if (strcmp($action, "show") === 0) {
    $servicios = $daoServicios->consultarTodos();
    $response = "ERROR";

    if ($servicios != NULL && count($servicios) > 0) {
        $response = showItems($servicios);
    } else {
        $response .= "<li>No se encontraron servicios</li>";
    }

    echo $response;
}

function showData($servicios) {
    $count = 1;

    foreach ($servicios as $servicio) {
        //$daoImagen = new DAOImagenes();
       // $imagen = $daoImagen->consultarPorID($servicio->getImagen());
        ?>
        <tr>
            <td class="center"><?php echo $count++; ?></td>
            <td align="left"><?php echo $servicio->getNombre(); ?></td>
            <td align="left"><?php echo $servicio->getDescripcion(); ?></td>
            <td align="left">
                <button class="btn btn-xs btn-info img-tooltip">
                    <span>Ver</span>
                    <img src="../presupuestos/images/productos/<?php echo $servicio->getImagen(); ?>" alt="<?php echo $servicio->getNombre(); ?>"/>
                </button>
                <button class="btn btn-xs btn-info" onclick="load(<?php echo $servicio->getIdServicio(); ?>)">
                    <span>Editar</span>
                </button>
                <button class="btn btn-xs btn-info" onclick="remove(<?php echo $servicio->getIdServicio(); ?>)">
                    <span>Eliminar</span>
                </button>
            </td>
        </tr>
        <?php
    }
}

function showItems($servicios) {
    foreach ($servicios as $proyecto) {
        //$daoImagen = new DAOImagenes();
        //$imagen = $daoImagen->consultarPorID($proyecto->getImagen());
        ?>
        <div class="col-md-4">
            <div class="templatemo-service-item">
                <div>
                    <img src="presupuestos/images/productos/<?php echo $proyecto->getImagen(); ?>" alt="icon" />
                    <span class="templatemo-service-item-header"><?php echo $proyecto->getNombre(); ?></span>
                </div>
                <p><?php echo $proyecto->getDescripcion(); ?></p>
                <br class="clearfix"/>
            </div>
            <div class="clearfix"></div>
        </div> 
        <?php
    }
}

function serviceData($servicio){
    $response = array(
        'STATUS' => $servicio->getIdServicio() > 0 ? "OK" : "ERROR",
        'ID' => $servicio->getIdServicio(),
        'NOMBRE' => $servicio->getNombre(),
        'DESCRIPCION' => $servicio->getDescripcion(),
        'IMAGEN'=> $servicio->getImagen()
    );
}