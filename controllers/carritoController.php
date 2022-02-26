<?php
    include_once 'models/carritoModel.php';
    class carritoController{
        public function index(){
            Utils::isCliente();
            $carrito = new Carrito('getItems',0,0,'', $_SESSION["id"]);
            $db = new DBClass();
            $conexion = $db->getconnection();
            $response = $carrito->serverQuery($conexion);
            $response = $response->fetchAll(PDO::FETCH_ASSOC);


            $carritox = new Carrito('getTotal',0,0,'', $_SESSION["id"]);
            $dbx = new DBClass();
            $conexionx = $dbx->getconnection();
            $response_total = $carritox->serverQuery($conexion);
            $response_total = $response_total->fetchAll(PDO::FETCH_ASSOC);
            require_once 'views/carrito/index.php';
        }
    }
?>