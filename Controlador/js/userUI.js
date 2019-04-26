
$(document).ready(function () {
    showServicios();
    showProyectos();
    showCleintes();
    showContacto();
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
function showCleintes() {
    var parameters={
        action:"show"
    };
    ajaxShow("presupuestos/Load_view/clientesJSON", parameters, "clientes");
}
function showContacto() {
    contacto();
}
