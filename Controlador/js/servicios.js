var AJAX_PHP = "../Controlador/ajax/AjaxServicios.php";

$(document).ready(function () {
    search();
});

function insert() {
    if (validateForm(true)) {
        var formData = getDataFromForm();
        formData.append('action', 'insert');
        ajaxCreate(AJAX_PHP, formData);
    }
}

function validateForm(validateImage) {
    var error = $('#nombre').val() === "" ? "E" : "";
    error += $('#nombreServicio').val() === "" ? "E" : "";
    error += $('#descripcionServicio').val() === "" ? "E" : "";

    if (validateImage) {
        error += $('#imagenServicio').val() === "" ? "E" : "";
    }

    if (error.length === 0) {
        return true;
    } else {
        alert("Se deben llenar todos los campos");
        return false;
    }
}

function getDataFromForm() {
    var formData = new FormData();
    formData.append('nombre', $('#nombreServicio').val());
    formData.append('descripcion', $('#descripcionServicio').val());
    //Image data
    var file = document.getElementById('imagenServicio').files[0];
    formData.append('archivo', file);
    formData.append('imagen', $('#imagenServicio').val().split(/(\\|\/)/g).pop());
    return formData;
}

function search() {
    var parameters = {
        action: "read"
    };
    ajaxRead(AJAX_PHP, parameters);
    $('#form').trigger("reset");
}

function load(id) {
    var parameters = {
        action: "load",
        id: id
    };
    ajaxGet(AJAX_PHP, parameters);
}

function showData(object) {
    $('#nombreServicio').val(object.NOMBRE);
    $('#descripcionServicio').val(object.DESCRIPCION);
    $('#action-btn').attr('value', 'Actualizar');
    $('#action-btn').attr('onclick', 'update(' + object.ID + ')');
}

function update(id) {
    if (validateForm(false)) {
        var formData = getDataFromForm();
        formData.append('action', 'update');
        formData.append('id', id);
        ajaxUpdate(AJAX_PHP, formData);
        $('#action-btn').attr('value', 'Registrar');
        $('#action-btn').attr('onclick', 'insert()');
    }
}

function remove(id) {
    var parameters = {
        action: "delete",
        id: id
    };
    ajaxDelete(AJAX_PHP, parameters);
}