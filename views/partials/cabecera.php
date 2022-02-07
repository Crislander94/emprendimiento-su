<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link  rel="icon"   href="<?= RUTA?>/assets/img/logo.png" type="image/png" />
    <link rel="stylesheet" href="<?=RUTA?>/assets/css/menuflotante.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= RUTA?>assets/plugins/bootstrap-5/bootstrap.min.css">
    <link rel="stylesheet" href="<?=RUTA?>assets/css/estilos.css">
    <link rel="stylesheet" href="<?=RUTA?>assets/css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?= RUTA?>assets/bootstrap-5/bootstrap.min.js"></script>
    <title>PC LINK </title>
</head>

<body>
    <header class="cover-header">
        <div class="row cover-init justify-content-between py-3 align-items-center mx-0">
            <div class="logo col-12 col-lg-6">
                <a href="<?=RUTA?>">
                    <img src="<?=RUTA?>assets/img/logo.png" alt="PC-Link">
                </a>
            </div>
            <div class="menu-right col-12 col-lg-6 pr-5">
                <a href="<?=RUTA?>home/login" class="login"><i class="fa fa-sign-in fa-lg"></i>Iniciar Sesión</a>
                <a href="#" class="login"><i class="fa fa-user fa-lg"></i>Bienvenido </a>
                <a href="<?=RUTA?>pedido/mis_pedidos" class="gestion"> <i class="fa fa fa-tasks fa-lg"></i>Ver Pedidos</a>
                <a href='<?=RUTA?>carrito/index' class="carrito"><i class="fa fa-shopping-bag fa-lg"></i>Total $</a>   
                <a href="<?=RUTA?>usuario/logout" class="out"> <i class="fa fa-sign-out fa-lg"></i></a>
                <a href="<?=RUTA?>carrito/index" class="gestion"><i class="fa fa-cart-plus fa-lg"></i>Nº Productos(0)</a>
            </div>
        </div>
        <nav class="menu">
            <div class="row mx-0">
                <ul class="col-md-12 p-0 m-0">
                    <li><a href="<?=RUTA?>">Home</a></li>
                    <li><a href="<?=RUTA?>producto/index">Productos</a></li>
                    <li><a href="<?=RUTA?>home/contacto">Contactanos</a></li>
                    <li><a href="<?=RUTA?>home/quiensomos">Quiénes somos</a></li>
                </ul>
            </div>
        </nav>
        <div class="row m-0 textos">
            <div class="container">
                <div class="col-md-12 py-5 text-center">
                    <h2 class="primera_linea">PC LINK</h2>
                    <h3 class="segunda_linea">Somos una empresa que brinda soluciones en tecnología informática; para contribuir al desarrollo integral de las empresas e instituciones, adaptándonos a las cambiantes condiciones de mercado, a las demandas y necesidades de nuestros clientes. </h3>
                    <div class="contenedor-btns">
                        <a href="<?=RUTA?>producto/index">Catálogo</a>
                        <a href="<?=RUTA?>carrito/index">Haz tu pedido</a>
                    </div>
                </div>
            </div>
        </div>
    </header>