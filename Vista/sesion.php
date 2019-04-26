<?php 
session_start();
if(is_null($_SESSION["name"])){
    header('location: ../acceso.php');
}
include 'header.php';
include 'footer.php';
 ?>