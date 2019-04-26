/*Create by José Alfredo Jiménez Sánchez*/
$(document).ready(function () {
    $.sic={///Variable gloal del proyecto
            login:function(){
            usuario = $("#usuario").val();
            password = $("#password").val();

            if(usuario === "" || password === ""){
                //location.href = "Vista/admin.html";
                alert("El usuario y la contraseña son obligatorios");
                $("#usuario").focus();
            }else{
                $.ajax({
                    url: "./Controlador/ajax/login.php",
                    type: "post",
                    data: {us:usuario,ps:password},
                    success: function (response) {
                        $.sic.respoder(response,usuario);
                    },
                    error: function (xhr, req, err) {
                        $.sic.respoder("Error en la petición "+err,"");
                    }
                });
            }
        },
        respoder:function(option,name){
            option=option.toString();
            switch(option){
                case "1":
                    alert("Bienvenido "+name);
                    window.location.href = "Vista/";
                    break;
                case "2":
                    alert("Usuario y/o contraseña incorrectos");
                    break;
                case "3":
                    alert("Acceso denegado");
                    break;
                default:
                    alert(option);
                    break;
            }
        }
    };
});
