<?php
include_once '../../Modelo/conexion/ConexionBD.php';
include_once '../../Modelo/clases/Proyecto.php';
include_once '../../Modelo/dao/DAOProyectos.php';
include_once '../../Modelo/clases/Imagen.php';
include_once '../../Modelo/dao/DAOImagenes.php';
include_once './AjaxImagenes.php';

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$daoProyectos = new DAOProyectos();
$daoImagenes = new DAOImagenes();

if (strcmp($action, "insert") === 0) {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombreImagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //
    $status = "ERROR";
    $imagen = new Imagen();
    $imagen->setNombre($nombreImagen);

    if (uploadImage($nombreImagen)) {
        if ($daoImagenes->insertar($imagen)) {
            $proyecto = new Proyecto();
            $proyecto->setNombre($nombre);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setImagen(ConexionBD::get_last_id());

            if ($daoProyectos->insertar($proyecto)) {
                $status = "OK";
            }
        }
    }

    echo $status;
} else if (strcmp($action, "read") === 0) {
    $proyectos = $daoProyectos->consultarTodos();
    $response = "ERROR";

    if ($proyectos != NULL && count($proyectos) > 0) {
        $response = showData($proyectos);
    } else {
        $response .= "<tr><td colspan='4' align='center'>No hay registros</td></tr>";
    }

    echo $response;
} else if (strcmp($action, "load") === 0) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    //
    $proyecto = $daoProyectos->consultarPorID($id);
    $response = array(
        'STATUS' => $proyecto->getIdProyecto() > 0 ? "OK" : "ERROR",
        'ID' => $proyecto->getIdProyecto(),
        'NOMBRE' => $proyecto->getNombre(),
        'DESCRIPCION' => $proyecto->getDescripcion()
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
    $proyecto = $daoProyectos->consultarPorID($id);
    $proyecto->setNombre($nombre);
    $proyecto->setDescripcion($descripcion);

    if (strlen($nombreImagen) > 0) {
        $imagen = new Imagen();
        $imagen->setNombre($nombreImagen);

        if (uploadImage($nombreImagen)) {
            if ($daoImagenes->insertar($imagen)) {
                $status = 1;
                $proyecto->setImagen(ConexionBD::get_last_id());
            }
        }
    } else {
        $status = 2;
    }

    if ($status > 0) {
        if ($daoProyectos->actualizar($proyecto)) {
            $status = 3;
        }
    }

    echo $status == 3 ? 'OK' : 'ERROR';
} else if (strcmp($action, "delete") === 0) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    echo $daoProyectos->eliminar($id) ? "OK" : "ERROR";
} else if (strcmp($action, "show") === 0) {
    $proyectos = $daoProyectos->consultarTodos();
    $response = "ERROR";

    if ($proyectos != NULL && count($proyectos) > 0) {
        $response = showItems($proyectos);
    } else {
        $response .= "<li>No se encontraron proyectos</li>";
    }

    echo $response;
}

function showData($proyectos) {
    $count = 1;

    foreach ($proyectos as $proyecto) {
        $daoImagen = new DAOImagenes();
        $imagen = $daoImagen->consultarPorID($proyecto->getImagen());
        ?>
        <tr>
            <td class="center"><?php echo $count++; ?></td>
            <td align="left"><?php echo $proyecto->getNombre(); ?></td>
            <td align="left"><?php echo $proyecto->getDescripcion(); ?></td>
            <td align="left">
                <button class="btn btn-xs btn-info img-tooltip">
                    <span>Ver</span>
                    <img src="images/proyectos/<?php echo $imagen->getNombre(); ?>" alt="<?php echo $proyecto->getNombre(); ?>"/>
                </button>
                <button class="btn btn-xs btn-info" onclick="load(<?php echo $proyecto->getIdProyecto(); ?>)">
                    <span>Editar</span>
                </button>
                <button class="btn btn-xs btn-info" onclick="remove(<?php echo $proyecto->getIdProyecto(); ?>)">
                    <span>Eliminar</span>
                </button>
            </td>
        </tr>
        <?php
    }
}

function showItems($proyectos) {
    foreach ($proyectos as $proyecto) {
        $daoImagen = new DAOImagenes();
        $imagen = $daoImagen->consultarPorID($proyecto->getImagen());
        ?>
        <li class="col-lg-2 col-md-2 col-sm-2  gallery" >
            <div class="templatemo-project-box">
                <img src="Vista/images/proyectos/<?php echo $imagen->getNombre(); ?>" class="img-responsive" alt="gallery" />
                <div class="project-overlay">
                    <h5><?php echo $proyecto->getNombre(); ?></h5>
                    <hr/>
                    <p><?php echo $proyecto->getDescripcion(); ?></p>
                </div>
            </div>
        </li> 
        <?php
    }
}
