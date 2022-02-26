<?php
    //Ruta Total de la app
    $ruta = $_SERVER['HTTP_HOST'];
    $ruta_final = 'http://'.$ruta.'/proyecto-emprendimiento-main/';
    // $ruta_final = './';
    define('RUTA', $ruta_final);
    
    //Definiendo Rutas por default de los controladores
    define("controller_default", "homeController");
    define("action_default", "index");
?>