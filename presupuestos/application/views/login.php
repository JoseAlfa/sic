<!DOCTYPE html>
<!--
inicio de sesión SIC todos los derechos reservados 2019.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIC - Presupuestos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="./img/logos/favicon.png"/>
        <!-- Bootstrap Core Css -->
        <link href="./plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="./plugins/node-waves/waves.css" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="./plugins/animate-css/animate.css" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="./css/style.css" rel="stylesheet">

        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="./css/themes/all-themes.css" rel="stylesheet" />
        <link rel="stylesheet" href="./icons/css/fontawesome-all.min.css">
        <link href="./css/presupuesto.css" rel="stylesheet" type="text/css"/>

    </head>
    <body class="login-page b-back">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Porfavor Espere...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <div class="login-box">
            <div class="logo">
                <img src="./img/logos/logo.png" alt="">
            </div>
            <div class="card">
                <div class="body">
                    <form id="loginForm" method="POST">
                        <div class="msg">Sistema de Gestión de Presupuestos</div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-user"></i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="u" placeholder="Usuario" required id="usr" autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="p" placeholder="Contraseña" required id="pas">
                            </div>
                        </div>
                        <div id="mensaje"></div>
                        <div class="row">
                            <div class="col-xs-8 p-t-5">
                                <!--input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-blue darken-4">
                                <label for="rememberme">Remember Me</label-->
                            </div>
                            <div class="col-xs-4">
                                <button class="btn btn-block bg-blue darken-4 waves-effect login" type="submit">INICIAR</button>
                            </div>
                        </div>
                        <div class="row m-t-15 m-b--20">
                            <!--div class="col-xs-6">
                                <a href="sign-up.html">Register Now!</a>
                            </div-->
                            <!--div class="col-xs-12 align-left">
                                <a href="#" id="forgot" class="right">¿Olvidaste la Contraseña?</a>
                            </div-->
                        </div>
                    </form>
                </div>
            </div>
            <div class="logo">
                <small class="text-inf">Todos los derechos reservados &copy 2019. Soluciones Integrales & Comunicación</small>
            </div>
        </div>
        
    </body>
    <!-- Jquery Core Js -->
    <script src="./plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="./plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="./plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="./plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="./plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="./js/admin.js"></script>

    <!-- Demo Js -->
    <script src="./js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $.sic={
                login:function () {
                    us=$("#usr");
                    ps=$("#pas");
                    msg=$("#mensaje");
                    bt=$('.login');
                    if (us.val()==undefined||us.val().replace (/\s/g, '')==''||ps.val()==undefined||ps.val().replace (/\s/g, '')=='') {
                        $.sic.showMsg(msg,'Usuario y contraseña requeridos',3);
                        us.focus();
                    }else{
                        bt.attr('disabled', true);
                        $.ajax({
                            type:'post',
                            url:'Inicio/login',
                            data:{us:us.val(),ps:ps.val()},
                            success:function (data) {
                                try{
                                    js=$.parseJSON(data);
                                    $.sic.showMsg(msg,js.m,js.o);
                                    if (js.o==1) {
                                        setTimeout(function() {window.location.reload();}, 2000);
                                    }else{
                                        bt.attr('disabled', false);
                                    }
                                }catch(e){
                                    $.sic.showMsg(msg,'Respuesta inesperada',3);
                                    bt.attr('disabled', false);
                                }
                            },
                            error:function (as,df,gg) {
                                bt.attr('disabled', false);
                                $.sic.showMsg(msg,"Error intente más tarde",3);
                            }
                        });
                    }
                },
                showMsg:function (div,msg,type) {
                    ct="";
                    clas="";
                    switch(type){
                        case 1:
                            clas="bg-green";
                            break;
                        case 2:
                            clas="bg-orange";
                            break
                        case 3:
                            clas="bg-red";
                            break;
                        default:
                            clas="bg-teal";
                            break;
                    }
                    div.html('<div class="alert alert-dismissible animated fadeIn '+clas+'"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" >×</span></button>'+msg+'</div>');
                    //setTimeout(function() {div.html('');}, 2000);
                    return true;
                }
            };
            $("#loginForm").submit(function(event) {
                event.preventDefault();
                $.sic.login();
            });
        });
    </script>
</html>
