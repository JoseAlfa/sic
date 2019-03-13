
$(document).ready(function () {
    showServicios();
    showProyectos();
});

function showProyectos(){
    var parameters = {
        action: "show"
    };
    ajaxShow("Controlador/ajax/AjaxProyectos.php", parameters, "proyectos");
}

function showServicios(){
    var parameters = {
        action: "show"
    };
    ajaxShow("Controlador/ajax/AjaxServicios.php", parameters, "servicios");
}

