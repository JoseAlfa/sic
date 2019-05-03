<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
*/
session_start();
if(!is_null($_SESSION["name"])){
    header('location: Vista/admin.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="Vista/img/favicon.png" />
        <title>Inicio de sesión</title>
        <link href="Vista/dist/css/bootstrap.css" rel="stylesheet">
        <link href="Vista/css/signin.css" rel="stylesheet">
        <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script-->        
        <script src="Vista/js/jquery.js" type="text/javascript"></script>
        <script src="Controlador/js/login.js" type="text/javascript"></script>
    </head>    
    <body>
        <div class="">
            <form class="form-signin" name="logeo" id="logeo" method="post" onsubmit="$.sic.login();return false;">
                <h3 class="form-signin-heading" style="text-align: center;"><img src="Vista/images/templatemo_logo.png" alt="Logo" class="img-responsive" style="display: initial;"></h3><br>
                <input type="text" class="form-control" placeholder="Usuario" name="usuario" autofocus autocomplete="off" id="usuario">
                <br>
                <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password" autocomplete="off">
                <input type="submit" class="btn btn-lg btn-success btn-block" value="Iniciar sesión">
                <br>
                <a href="index.php" id="back"><span class="glyphicon glyphicon-home"></span>&nbspInicio</a>
            </form>
        </div> 
        <div id="response">
            <div id="loading" style="display:none;">
                <img src="Vista/images/ajax-loader.gif" alt="Back" height="50" width="50">
            </div>
        </div>
    </body>
</html>
