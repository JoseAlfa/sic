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
<?php getHeader('Proyectos'); ?>
        <div class="templatemo-welcome" id="templatemo-welcome">
            <div class="container">
                <div class="templatemo-slogan text-center">
                    <span class="txt_darkgrey">Bienvenido al </span><span class="txt_orange">Panel de Control</span>
                    <p class="txt_slogan"><i>Soluciones Integrales & Telecomunicaciones</i></p>
                </div>
            </div>
        </div>  
        <!------------------------------->
        <!---------- CLIENTES ---------->
        <!------------------------------->
        <div id="clientes" class="form-container">
            <div class="form-container-title">

                <h3>Clientes</h3>
            </div>
            <table class="small-table">
                <thead>
                    <tr><th colspan="4" align="center">Catálogo de clientes</th></tr>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td align="left">Rigoberto Nava</td>
                        <td align="left">rinadi@hotmail.com</td>
                        <td align="left">
                            <a href="#"><span>Eliminar</span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php getFooter(); ?>
</html>
