<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>SIC - Presupuestos</title>
        <!-- Favicon-->
        <link rel="icon" type="image/png" href="./img/logos/favicon.png"/>

        <!-- Google Fonts >
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css"-->
        <link href="./icons/iconfont/material-icons.css" rel="stylesheet" type="text/css">

        <!-- Bootstrap Core Css -->
        <link href="./plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="./plugins/node-waves/waves.min.css" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="./plugins/animate-css/animate.min.css" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="./css/style.min.css" rel="stylesheet">

        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="./css/themes/all-themes.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="./icons/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="./js/toastr/toastr.min.css">
        <link href="./css/presupuesto.css" rel="stylesheet" type="text/css"/>

        <!-- Sweetalert Css -->
        <link href="./plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    </head>
    <body class="theme-<?php echo $user['color'];?>">
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
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        <div class="search-bar">
            <div class="search-icon">
                <i class="material-icons">search</i>
            </div>
            <input type="text" placeholder="START TYPING...">
            <div class="close-search">
                <i class="material-icons">close</i>
            </div>
        </div>
        <!-- #END# Search Bar -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="#">Gestión de Presupuestos</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Call Search ->
                        <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                        <!- #END# Call Search -->
                        
                        <li class="pull-right"><a href="#" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div><img src="./img/logos/logo.png" alt="" class="img-responsive"></div>
                </div>
                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li class="header">MENÚ PRINCIPAL</li>                       
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle toggled">
                                <i class="fas fa-newspaper fa-lg"></i>
                                <span>Presupuestos</span>
                            </a>
                            <ul class="ml-menu">
                                <li data-get="newPresupuesto">
                                    <a href="#">Nuevo presupuesto</a>
                                </li>
                                <li data-get="getPresupuestos">
                                    <a href="#">Recientes</a>
                                </li>
                                <li data-get="getBorradores">
                                    <a href="#">Borradores</a>
                                </li>
                                <li data-get="getPlantillas">
                                    <a href="#">Plantillas</a>
                                </li>
                                <li data-get="getPresupuestoClose">
                                    <a href="#">Presupuestos cerrados</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="fas fa-clipboard-list fa-lg"></i>
                                <span>Productos</span>
                            </a>
                            <ul class="ml-menu">
                                <li data-get="productos">
                                    <a href="#">Lista de productos</a>
                                </li>
                                <li data-get="tipos_productos">
                                    <a href="#">Lista de tipos de productos</a>
                                </li>
                                <li data-get="marcas">
                                    <a href="#">Lista de marcas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="far fa-money-bill-alt fa-lg"></i>
                                <span>Clientes</span>
                            </a>
                            <ul class="ml-menu">
                                <li data-get="clientes"><a href="#">Clientes</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="fas fa-users fa-lg"></i>
                                <span>Usuarios</span>
                            </a>
                            <ul class="ml-menu">
                                <li data-get="usuarios"><a href="#">Usuarios del sistema</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="fas fa-lightbulb fa-lg"></i>
                                <span>Más</span>
                            </a>
                            <ul class="ml-menu">
                                <li data-get="dataPDF">
                                    <a href="#">Datos en PDF</a>
                                </li>
                                <li data-get="faq">
                                    <a href="#">Acerca de...</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="header">MAS OPCIONES</li>
                        <li class="ajuestes_bt">
                            <a href="#">
                                <i class="fas fa-cogs fa-lg col-amber"></i>
                                <span>Ajustes</span>
                            </a>
                        </li>
                        <li class="salir_bt">
                            <a href="#">
                                <i class="fas fa-lg fa-power-off col-red"></i>
                                <span>Cerrar sesión</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->
                <div class="legal">
                    <div class="copyright">
                        &copy; 2019 <a href="javascript:void(0);">Soluciones Integrales & Comunicación</a>.
                    </div>
                    <div class="version">
                        <b>Version: </b> 1.0.0
                    </div>
                </div>
                <!-- #Footer -->
            </aside>
            <!-- #END# Left Sidebar -->
            <!-- Right Sidebar -->
            <aside id="rightsidebar" class="right-sidebar">
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active block"><a href="#settings" data-toggle="tab">AJUSTES</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="settings">
                        <div class="demo-settings">
                            <p>TEMA</p>
                            <ul class="setting-list">
                                <li class="demo-choose-skin">
                                    <a class="red tema" data-theme="red"></a>
                                    <a class="tema pink" data-theme="pink"></a>
                                    <a class="tema purple" data-theme="purple"></a>
                                    <a class="tema deep-purple" data-theme="deep-purple"></a>
                                    <a class="tema indigo" data-theme="indigo"></a>
                                    <a class="tema blue" data-theme="blue"></a>
                                    <a class="tema teal" data-theme="teal"></a>
                                    <a class="green tema" data-theme="green"></a>
                                    <a class="tema brown" data-theme="brown"></a>
                                    <a class="tema blue-grey" data-theme="blue-grey"></a>
                                    <a class="black tema" data-theme="black"></a>
                                </li>
                                <li>
                                    <span>Notificar cámbio</span>
                                    <div class="switch">
                                        <label><input class="notifi_q" type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                            <p>AJUSTES DE LA CUENTA</p>
                            <ul class="setting-list">
                                <li class="c_pass">
                                    <span><i class="fas fa-lock"></i> Cambiar contraseña</span>
                                </li>
                                <li class="salir_bt">
                                    <span><i class="fas fa-power-off"></i> Cerrar Sesión</span>
                                </li>
                                
                            </ul>
                           
                        </div>
                    </div>
                </div>
            </aside>
            <!-- #END# Right Sidebar -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="block-header">
                    <h2 id="titulo_general">BLANK PAGE</h2>
                </div>
                <div class="block-body">
                    <div class="card" id="contenedor_general">
                        <div class="body">
                            Error, los componentes no fueron cargados, verifique que su navegador tenga soporte y este activado el uso de java Script
                        </div>
                    </div>
                </div>
                <button id="cl" hidden="hidden">VEr</button>
                
            </div>
        </section>
        <!--///////////////////////////////Modales//////////////////////////////////////-->
        <!-- Default Size -->
            <div class="modal fade" id="cambiar_C" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form class="chang_P" id="chang_P">
                        <div class="modal-content">
                            <!-- Page Loader -->
                            <div class="page-loader-wrapper pas_lod">
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
                            <div class="modal-header">
                                <div class="row"></div>
                                <h3 class="modal-title" id="defaultModalLabel">Cambiar la contraseña</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm"></div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="password" id="ps" class="form-control" required />
                                                <label class="form-label">Contraseña anterior</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="password" id="ps1" class="form-control" required />
                                                <label class="form-label">Nueva contraseña</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="password" id="ps2" class="form-control" required />
                                                <label class="form-label">Repite nueva contraseña</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn bg-blue waves-effect">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <!-- Default Size -->
            <div class="modal fade" id="nuevo_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg min_mod" role="document">
                    <div class="modal-content">
                        <!-- Page Loader -->
                        <div class="page-loader-wrapper nuevo_load">
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
                        <div id="nuevo_panel"></div>
                    </div>
                </div>
            </div>

        <script src="./plugins/jquery/jquery.min.js"></script>
        <script src="./plugins/bootstrap/js/bootstrap.js"></script>
        <script src="./plugins/bootstrap-select/js/bootstrap-select.js"></script>
        <script src="./plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="./plugins/node-waves/waves.js"></script>
        <script src="./js/admin.js"></script>
        <script src="./js/toastr/toastr.js"></script>
        <script src="./plugins/sweetalert/sweetalert.min.js"></script>
        <script src="./js/script.js"></script>
        <script>
            $(document).ready(function() {
                $.sic.theme="theme-<?php echo $user['color'];?>";
            });
        </script>
    </body>
</html>

