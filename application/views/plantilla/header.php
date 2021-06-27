<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>
		<?php 
		$nombre_empresa = "Sistema de Inventarios";
		if (!isset($titulo))
		{
			echo $nombre_empresa;
		}
		else
		{
			echo "$titulo - $nombre_empresa";
		}
		?>
	</title>
	<!--Iconos-->
	<link rel="shorcut icon" href="<?= base_url() ?>assets/images/favicons/favicon.png">
    <link rel="icon" href="<?= base_url() ?>assets/images/favicons/icono_144x144.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?= base_url() ?>assets/images/favicons/icono_57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets/images/favicons/icono_72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets/images/favicons/icono_114x114.png">
	<!--Fin Iconos-->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	 <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.responsive.css" media="all">
	<script src="<?= base_url() ?>assets/js/jquery-1.11.3.min.js"></script>
	<script src="<?= base_url() ?>assets/js/script.js"></script>
    <script src="<?= base_url() ?>assets/js/script.responsive.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
<div id="main">
    <header class="header">
        <div class="shapes">
            <div class="object870478619">
                <img src="<?= base_url() ?>assets/images/logotipo.png" alt="">
            </div>
        </div>
        <h1 class="headline">
            <a href="<?= base_url() ?>">Sistema para el control de inventarios</a>
        </h1>             
    </header>
    <?php if(isset($menu)): ?>
    <nav class="nav">
        <div class="nav-inner">
            <ul class="hmenu">
                <li><a href="<?= base_url() ?>admin">Principal</a></li>
                <li><a href="<?= base_url() ?>clientes" <?php if($menu == "clientes") :?> class="active" <?php endif ?>>Clientes</a></li>
                <li><a href="<?= base_url() ?>productos" <?php if($menu == "productos") :?> class="active" <?php endif ?>>Productos</a></li>
                <li><a href="<?= base_url() ?>categorias" <?php if($menu == "categorias") :?> class="active" <?php endif ?>>Categorías</a></li>
                <li>
                    <a href="<?= base_url() ?>orden_salida" <?php if($menu == "orden_salida") :?> class="active" <?php endif ?>>orden de salida</a>
                    <ul>
                        <li><a href="<?= base_url() ?>orden_salida">Lista de Ordenes</a></li>
                        <li><a href="<?= base_url() ?>orden_salida/nueva">Nueva Orden</a></li>
                    </ul>
                </li>
                <li><a href="<?= base_url() ?>usuarios" <?php if($menu == "usuarios") :?> class="active" <?php endif ?>>usuarios</a></li>
            </ul> 
        </div>
    </nav>
	<?php endif ?>
    <div class="sheet clearfix">
        <div class="layout-wrapper">
            <div class="content-layout">
                <div class="content-layout-row">
                    <div class="layout-cell content">
                        <article class="post article">
                            <div class="postmetadataheader">
                                <h2 class="postheader">
                                	<span class="postheadericon">
                                	<?php
                                	if (!isset($titulo))
									{
										echo $nombre_empresa;
									}
									else
									{
										echo $titulo;
									}
                                	?>
                                	</span>
                                </h2>
                            </div>                           
                            <div class="postcontent postcontent-0 clearfix">