function ajaxCreate(php, parameters) {
    $.ajax({
        url: php,
        type: "post",
        data: parameters,
        processData: false,
        contentType: false,
        success: function (response) {
            doAfterCreate(response === "OK" ? 1 : 0);
        },
        error: function (xhr, req, err) {
            doAfterCreate(-1);
        }
    });
}

function ajaxRead(php, parameters) {
    $.ajax({
        url: php,
        type: "post",
        data: parameters,
        success: function (response) {
            doAfterRead(response !== "ERROR" ? response : 0);
        },
        error: function (xhr, req, err) {
            doAfterRead(-1);
        }
    });
}

function ajaxGet(php, parameters) {
    $.ajax({
        url: php,
        type: "post",
        data: parameters,
        success: function (response) {
            var jsonResponse = $.parseJSON(response);
            doAfterGet(jsonResponse.STATUS === "OK" ? jsonResponse : 0);
        },
        error: function (xhr, req, err) {
            doAfterGet(-1);
        }
    });
}

function ajaxUpdate(php, parameters) {
    $.ajax({
        url: php,
        type: "post",
        data: parameters,
        processData: false,
        contentType: false,
        success: function (response) {
            doAfterUpdate(response === "OK" ? 1 : 0);
        },
        error: function (xhr, req, err) {
            doAfterUpdate(-1);
        }
    });
}

function ajaxDelete(php, parameters) {
    $.ajax({
        url: php,
        type: "post",
        data: parameters,
        success: function (response) {
            doAfterDelete(response === "OK" ? 1 : 0);
        },
        error: function (xhr, req, err) {
            doAfterDelete(-1);
        }
    });
}

function ajaxShow(php, parameters, component){
    $.ajax({
        url: php,
        type: "post",
        data: parameters,
        success: function (response) {
            $("#" + component).html(response);
        },
        error: function (xhr, req, err) {
            $("#" + component).html("No hay datos para mostrar");
        }
    });
}

function doAfterCreate(response) {
    switch (response) {
        case - 1:
            alert("Ha ocurrido un error en el servidor");
            break;
        case 0:
            alert("Error al registrar");
            break;
        case 1:
            alert("Registro exitoso");
            search();
            break;
    }
}

function doAfterRead(response) {
    switch (response) {
        case - 1:
            alert("Ha ocurrido un error en el servidor");
            break;
        case 0:
            alert("Error al buscar registros");
            break;
        default :
            $("#dataTable").html(response);
            break;
    }
}

function doAfterGet(response) {
    switch (response) {
        case - 1:
            alert("Ha ocurrido un error en el servidor");
            break;
        case 0:
            alert("Error al buscar registro");
            break;
        default :
            showData(response);
            break;
    }
}

function doAfterUpdate(response) {
    switch (response) {
        case - 1:
            alert("Ha ocurrido un error en el servidor");
            break;
        case 0:
            alert("Error al actualizar");
            break;
        case 1:
            alert("Actualización exitosa");
            search();
            break;
    }
}

function doAfterDelete(response) {
    switch (response) {
        case - 1:
            alert("Ha ocurrido un error en el servidor");
            break;
        case 0:
            alert("Error al eliminar");
            break;
        case 1:
            alert("El registro se eliminó correctamente");
            search();
            break;
    }
}