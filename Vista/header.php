<?php 
function getHeader($titulo){
	$inicio='active';$servicios='';$proyectos='';$clientes='';
	$script='';
	switch ($titulo) {
		case 'Servicios':
			$inicio='';$servicios='active';
			$script='<script src="../Controlador/js/servicios.js" type="text/javascript"></script>';
			break;
		case 'Proyectos':
			$inicio='';$proyectos='active';
			$script='<script src="../Controlador/js/proyectos.js" type="text/javascript"></script>';
			break;
		case 'Clientes':
			$inicio='';$clientes='active';
			$script='';
			break;
		default:
			# code...
			break;
	}
	?>
	<head>
        <title>Panel de control | <?php echo $titulo; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Google Web Font Embed -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <!-- Bootstrap core CSS and other plugins -->
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <link href="js/colorbox/colorbox.css"  rel='stylesheet' type='text/css'>
        <link href="css/templatemo_style.css"  rel='stylesheet' type='text/css'>
        <link href="css/sic.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <link href="dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap.min.js"  type="text/javascript"></script>
        <script src="../Controlador/js/ajax.js" type="text/javascript"></script>
        <?php echo $script; ?>
        <style>
            .navbar-brand img{
                max-height: 100px;
            }
        </style>
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
                                <li class="<?php echo($inicio); ?>"><a href="index.php">Inicio</a></li>
                                <li class="<?php echo($servicios); ?>"><a href="servicios.php">Servicios</a></li>                                
                                <li class="<?php echo($proyectos); ?>"><a href="proyectos.php">Proyectos</a></li>                                                              
                                <li><a onclick="if(confirm('¿En relidad desea salir?')) return true;return false;" href="salir.php">Cerrar sesión</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div><!--/.container-fluid -->
                </div><!--/.navbar -->
            </div> <!-- /container -->
        </div>
	<?php
}

 ?>