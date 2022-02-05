<?php
    function loadController($controller){
        $name_controller = ucwords($controller).'Controller';   
        $fileController = 'controller/'.$name_controller.'.php';
        if(!is_file($fileController)){
            $fileController = 'controller/'.CONTROLLER_MAIN.'Controller.php';
            header('Location: producto.php');
        }
        //Cargamos el controlador
        require_once $fileController;
        $controller = new $name_controller();

        return $controller;
    }
    function loadAction($controller, $action, $conexion, $cod_empresa){
        if(isset($action) && method_exists($controller, $action)){
            $controller->$action($conexion,$cod_empresa);
        }else{
            header('Location: producto.php');
        }
    }