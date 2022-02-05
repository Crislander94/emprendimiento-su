<?php
    //Ruta Total de la app
    $ruta = $_SERVER['HTTP_HOST'];
    $ruta_final = 'http://'.$ruta.'/multi-entrega-php-mysql-master/';
    define('RUTA', $ruta_final);

    //Definiendo Rutas por default de los controladores
    define("CONTROLLER_MAIN", 'Producto');
    define("ACTION_MAIN", 'index');
    //Definiendo Rutas por default de los controladores
    define("CONTROLLER_MAIN_ADMIN", 'Admin');
    define("CONTROLLER_MAIN_REPARTIDOR", 'Repartidor');
?>