<?php
    include_once '../db/conexion.php';
    include_once '../config/settings.php';
    include_once '../models/carritoModel.php';
    session_start();
    $db = new DBClass();
    $conexion = $db->getconnection();
    switch ($_POST["key"]) {
        case 'add_carrito':
            $response = null;
            if(isset($_SESSION["id"])){
                if($_SESSION["rol"] === 'C'){
                    $id = $_POST["id"];
                    $cod_usuario = $_SESSION["id"];
                    $carrito = new Carrito('add_carrito', 0,0,'', $cod_usuario, $id);
                    $response = $carrito->serverQuery($conexion);
                    $response = $response->fetchAll(PDO::FETCH_ASSOC)[0];
                    if(empty($response)){
                        $response = array("codigo" => -1);
                    }
                }else{
                    $response = array("codigo" => -3);
                }
            }else{
                $response = array("codigo" => -2);
            }
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        case 'delete':
            $response = null;
            if(isset($_SESSION["id"])){
                if($_SESSION["rol"] === 'C'){
                    $id = $_POST["id"];
                    $carrito = new Carrito('delete', 0,0,$id);
                    $response = $carrito->serverQuery($conexion);
                    $response = $response->fetchAll(PDO::FETCH_ASSOC)[0];
                    if(empty($response)){
                        $response = array("codigo" => -1);
                    }
                }else{
                    $response = array("codigo" => -3);
                }
            }else{
                $response = array("codigo" => -2);
            }
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        case 'vaciar':
            $response = null;
            if(isset($_SESSION["id"])){
                if($_SESSION["rol"] === 'C'){
                    $cod_usuario = $_SESSION["id"];
                    $carrito = new Carrito('vaciar', 0,0,'',$cod_usuario);
                    $response = $carrito->serverQuery($conexion);
                    $response = $response->fetchAll(PDO::FETCH_ASSOC)[0];
                    if(empty($response)){
                        $response = array("codigo" => -1);
                    }else{
                        $response = array("codigo" => $response["codigo"]);
                    }
                }else{
                    $response = array("codigo" => -3);
                }
            }else{
                $response = array("codigo" => -2);
            }
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        case 'actualizar_carrito':
            $response = null;
            if(isset($_SESSION["id"])){
                if($_SESSION["rol"] === 'C'){
                    $productos = $_POST["cod_producto"];
                    $cantidades = $_POST["cantidad"];
                    foreach ($productos as $key => $value) {
                        # code...
                        $cantidad = $cantidades[$key];
                        $cod_usuario = $_SESSION["id"];
                        $dbx = new DBClass();
                        $conexionx = $dbx->getconnection();
                        $carrito = new Carrito('actualizar_carrito', 0,0,'', $cod_usuario, $value,$cantidad);
                        $responsex = $carrito->serverQuery($conexionx);
                    }
                    $response = array("codigo" => $responsex->fetchAll(PDO::FETCH_ASSOC)[0]["codigo"]);
                }else{
                    $response = array("codigo" => -3);
                }
            }else{
                $response = array("codigo" => -2);
            }
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        case 'getTotal':
            if(isset($_SESSION["id"])){
                if($_SESSION["rol"] === 'C'){
                    $cod_usuario = $_SESSION["id"];
                    $carrito = new Carrito('getTotal', 0,0,'', $cod_usuario);
                    $response = $carrito->serverQuery($conexion);
                    $response = $response->fetchAll(PDO::FETCH_ASSOC)[0];
                    if(!empty($response)){
                        $response = array("total" => number_format($response["total"],2), "codigo" => 200);
                    }else{
                        $response = array( "codigo" => -1);
                    }
                }else{
                    $response = array("codigo" => -3);
                }
            }else{
                $response = array("codigo" => -2);
            }
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        case 'getTotalitems':
            if(isset($_SESSION["id"])){
                if($_SESSION["rol"] === 'C'){
                    $cod_usuario = $_SESSION["id"];
                    $carrito = new Carrito('getTotalitems', 0,0,'', $cod_usuario);
                    $response = $carrito->serverQuery($conexion);
                    $response = $response->fetchAll(PDO::FETCH_ASSOC)[0];
                    if(!empty($response)){
                        $response = array("cantidad" => $response["total"], "codigo" => 200);
                    }else{
                        $response = array( "codigo" => -1);
                    }
                }else{
                    $response = array("codigo" => -3);
                }
            }else{
                $response = array("codigo" => -2);
            }
            header("Content-Type: application/json");
            echo json_encode($response);
            exit;
        default:
            header("Content-Type: application/json");
            echo json_encode(array("codigo" => -1,"mensaje" => "no existe la solicitud"));
            exit;
            break;
    }
?>