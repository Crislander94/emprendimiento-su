<?php
    $usuario_pclink = '';
    $cargo_pclink = '';
    $nombre_pclink = '';
    $email_pclink = '';
    $codigo_pclink = '';
    if(
        isset($_SESSION["id"])&&
        isset($_SESSION["usuario"])&&
        isset($_SESSION["nombres"])&&
        isset($_SESSION["email"])&&
        isset($_SESSION["rol"]))
    {
        $usuario_pclink = $_SESSION["usuario"];
        $cargo_pclink   = $_SESSION["rol"];
        $nombre_pclink  = $_SESSION["nombres"];
        $email_pclink   = $_SESSION["email"];
        $codigo_pclink  = $_SESSION["rol"];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="icon"       href="<?php echo RUTA?>assets/img/logo.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:ital,wght@0,100;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Coming+Soon&family=Poppins:ital,wght@0,100;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Coming+Soon&family=Dancing+Script:wght@400;500;600;700&family=Poppins:ital,wght@0,100;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet"  href="<?php echo RUTA?>assets/plugins/bootstrap-5/bootstrap.min.css">
    <link rel="stylesheet"  href="<?php echo RUTA?>assets/css/index.css">
    <link rel="stylesheet"  href="<?php echo RUTA?>assets/css/estilos.css">
    <link rel="stylesheet" href="<?php echo RUTA ?>assets/icons/all.min.css">
    <link rel="stylesheet" href="<?php echo RUTA ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
    
    <link rel="stylesheet" href="<?php echo RUTA ?>assets/plugins/owl-carousel/owl.carousel.min.css">
    <script src="<?php echo RUTA ?>/assets/scripts/misc.js"></script>
    <script src="<?php echo RUTA ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo RUTA ?>assets/plugins/owl-carousel/js/owl.carousel.js"></script>
    <script src="<?php echo RUTA ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <link rel="stylesheet" href="assets/owl-carousel/owl.carousel.min.css">
    <title>PC LINK </title>
</head>
<body>
    <header class="cover-header">
        <div class="row cover-init justify-content-between pt-3 align-items-center mx-0">
            <div class="logo col-12 col-lg-4">
                <a href="<?= RUTA ?>home/index">
                    <img src="<?php echo RUTA ?>assets/img/logo.png" alt="PC-Link">
                </a>
            </div>
            <div class="menu-right col-12 col-lg-8 pr-5">
                <a href="<?php echo RUTA ?>home/quiensomos" class="login"><i class="fas fa-city mx-1"></i>Quienes Somos</a>
                <a href="<?php echo RUTA ?>home/contacto" class="login"><i class="fas fa-address-book mx-1"></i> Contactanos</a>
                <?php
                    if($cargo_pclink === ''){
                ?>
                    <a href="<?php echo RUTA ?>home/login" class="login"><i class="fas fa-sign-in-alt mx-2"></i>Iniciar Sesión</a>
                <?php
                    }else{
                ?>
                    <a href="<?php echo RUTA ?>home/settings" class="login"><i class="fas fa-user-cog mx-2"></i> Configuracion</a>
                    <?php
                        if($cargo_pclink === 'C'){
                    ?>
                        <!-- TODOS LOS USUARIOS CLIENTES -->
                        <a class="dropdown">
                            <a class="dropdown-custom-menu btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user mx-1"></i>Bienvenido, <?= $usuario_pclink ?>
                            </a>
                            <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" style="padding:15px 35px;display:inline-block;" href="<?php echo RUTA ?>pedido/mis_pedidos"><i class="fas fa-tasks mx-2"></i>Ver Pedidos</a></li>
                                <li><a class="dropdown-item" style="padding:15px 35px;display:inline-block;" href="<?php echo RUTA ?>carrito/index"><i class="fas fa-shopping-cart mx-2"></i>Total $<span id="precio_carrito_cabecera">0.00</span></a></li>
                                <li><a class="dropdown-item" style="padding:15px 35px;display:inline-block;" href="<?php echo RUTA ?>carrito/index"><i class="fas fa-desktop mx-2"></i>Nº Productos(<span id="cantidad_productos_cabecera">0</span>)</a></li>
                                <li><a class="dropdown-item" style="padding:15px 35px;display:inline-block;" href="<?php echo RUTA ?>usuario/logout"><i class="fas fa-sign-out-alt mx-2"></i>Cerrar Sesion</a></li>
                            </ul>
                        </a>
                    <?php
                        }else{
                    ?>
                            <!-- TODOS LOS USUARIOS ADMIN -->
                            <a class="dropdown">
                                <a class="dropdown-custom-menu btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cogs mx-1"></i>Bienvenido, <?= $usuario_pclink ?>
                                </a>
                                <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" style="padding:15px 18px;display:inline-block;" href="<?php echo RUTA ?>usuario/gestion"><i class="fas fa-user-cog mx-2"></i>Gestion de usuarios</a></li>
                                    <li><a class="dropdown-item" style="padding:15px 18px;display:inline-block;" href="<?php echo RUTA ?>categoria/gestion"><i class="fas fa-dharmachakra mx-2"></i>Gestion de categorias</a></li>
                                    <li><a class="dropdown-item" style="padding:15px 18px;display:inline-block;" href="<?php echo RUTA ?>producto/gestion"><i class="fas fa-desktop mx-2"></i>Gestion de productos</a></li>
                                    <li><a class="dropdown-item" style="padding:15px 18px;display:inline-block;" href="<?php echo RUTA ?>pedido/gestion"><i class="fas fa-box mx-2"></i>Gestion de pedidos</a></li>
                                    <li><a class="dropdown-item" style="padding:15px 18px;display:inline-block;" href="<?php echo RUTA ?>mensaje/gestion"><i class="fas fa-bullhorn mx-2"></i>Gestion de mensajes</a></li>
                                    <li><a class="dropdown-item" style="padding:15px 18px;display:inline-block;" href="<?php echo RUTA ?>usuario/logout"><i class="fas fa-sign-out-alt mx-2"></i> Cerrar Sesion</a></li>
                                </ul>
                            </a>
                <?php
                        }
                    }
                ?>
            </div>
            <?php
                if($cargo_pclink === 'C' || $cargo_pclink === ''){
            ?>
                <div class="row m-0 textos">
                    <div class="container">
                        <div class="col-md-12 py-5 text-center">
                            <h2 class="primera_linea">PC LINK</h2>
                            <h3 class="segunda_linea">Somos una empresa que brinda soluciones en tecnología informática; para contribuir al desarrollo integral de las empresas e instituciones, adaptándonos a las cambiantes condiciones de mercado, a las demandas y necesidades de nuestros clientes. </h3>
                            <div class="contenedor-btns">
                                <a href="<?php echo RUTA?>producto/index">Catálogo</a>
                                <a href="<?php echo RUTA?>carrito/index">Haz tu pedido</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
    </header>