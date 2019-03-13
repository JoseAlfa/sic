<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
*/
session_start();
if(is_null($_SESSION["name"])){
    header('location: ../acceso.html');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Panel de control | Servicios</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Google Web Font Embed -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <!-- Bootstrap core CSS -->
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <link href="js/colorbox/colorbox.css"  rel='stylesheet' type='text/css'>
        <link href="css/templatemo_style.css"  rel='stylesheet' type='text/css'>
        <link href="css/sic.css" rel="stylesheet" type="text/css"/>        
        <link href="dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- Scripts JS/JQuery -->
        <script src="js/bootstrap.min.js"  type="text/javascript"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="../Controlador/js/ajax.js" type="text/javascript"></script>
        <script src="../Controlador/js/servicios.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="templatemo-top-bar" id="templatemo-top">
            <div class="container">
                <div class="subheader"></div>
            </div>
        </div>
        <div class="templatemo-top-menu">
            <div class="container">
                <!-- Static navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="#templatemo_395_urbanic" class="navbar-brand"><img src="images/templatemo_logo.png" alt="Urbanic - free HTML5 website template" title="Urbanic HTML5 Template" /></a>
                        </div>
                        <div class="navbar-collapse collapse" id="templatemo-nav-bar">
                            <ul class="nav navbar-nav navbar-right" style="margin-top: 37px;">
                                <li><a href="admin.php">Inicio</a></li>
                                <li class="active"><a href="servicios.php">Servicios</a></li>                                
                                <li><a href="proyectos.php">Proyectos</a></li>                           
                                <li><a onclick="if(confirm('¿En relidad desea salir?')) return true;return false;" href="salir.php">Cerrar sesión</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div><!--/.container-fluid -->
                </div><!--/.navbar -->
            </div> <!-- /container -->
        </div>
        <div class="templatemo-welcome" id="templatemo-welcome">
            <div class="container">
                <div class="templatemo-slogan text-center">
                    <span class="txt_darkgrey">Bienvenido al </span><span class="txt_orange">Panel de Control</span>
                    <p class="txt_slogan"><i>Soluciones Integrales & Telecomunicaciones</i></p>
                </div>
            </div>
        </div>  
        <!------------------------------->
        <!---------- SERVICIOS ---------->
        <!------------------------------->
        <div id="proyectos" class="form-container">
            <div class="form-container-title">
                <h3>Servicios</h3>
            </div>
            <form id="form">
                <table>                    
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" placeholder="Nombre del servicio" id="nombreServicio">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" placeholder="Descripción del servicio" id="descripcionServicio">
                            </td>
                        </tr>
                        <tr>                            
                            <td>Imagen del servicio</td>
                            <td><input type="file" class="form-control" id="imagenServicio"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="btn btn-lg btn-success btn-block" type="button" value="Registrar" id="action-btn" onclick="insert()">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <br>
            <table>
                <thead>
                    <tr><th colspan="4" align="center">Catálogo de servicios</th></tr>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    <tr><td colspan="4">Sin resultados</td></tr>
                </tbody>
            </table>
        </div>        
        <div class="templatemo-footer" >
            <div class="container">
                <div class="row">
                    <div class="text-center">
                        <br>
                        <div class="footer_bottom_content">Copyright © 2018 <a href="#">Soluciones Integrales & Comunicaciones</a></div>
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>


