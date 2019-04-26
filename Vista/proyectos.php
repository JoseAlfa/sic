<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
* Autor: Jose Alfredo Jimenez Sanchez 
* Contacto: josejimenezsanchez180697@gmail.com
*/
include 'sesion.php';
?>
<!DOCTYPE html>
<html lang="en">
    <?php getHeader('Proyectos'); ?>
        <!-- <div class="templatemo-welcome" id="templatemo-welcome">
            <div class="container">
                <div class="templatemo-slogan text-center">
                    <span class="txt_darkgrey">Bienvenido al </span><span class="txt_orange">Panel de Control</span>
                    <p class="txt_slogan"><i>Soluciones Integrales & Telecomunicaciones</i></p>
                </div>
            </div>
        </div>   -->
        <!------------------------------->
        <!---------- PROYECTOS ---------->
        <!------------------------------->
        <div id="proyectos" class="form-container">
            <div class="form-container-title">
                <h3>Proyectos</h3>
            </div>
            <form id="form">
                <table>                    
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" placeholder="Nombre del proyecto" id="nombreProyecto">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" placeholder="Descripción del proyecto" id="descripcionProyecto">
                            </td>
                        </tr>
                        <tr>                            
                            <td>Imagen del proyecto</td>
                            <td><input type="file" class="form-control" id="imagenProyecto"></td>
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
                    <tr><th colspan="4" align="center">Catálogo de proyectos</th></tr>
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
    <?php getFooter(); ?>
</html>
