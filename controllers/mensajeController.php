<?php
    include_once 'models/mensajeModel.php';
    class mensajeController{
        public function gestion(){
            utils::isAdmin();
            require_once 'views/gestion_mensaje.php';
        }
       
        public function registrar(){
            $db = new DBClass();
            $conexion = $db->getconnection();
            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $asunto = $_POST["asunto"];
            $mensajexx = $_POST["mensaje"];
            $mensajex = new Mensaje('registrar', 0,0,'','',$nombre,$correo,$asunto,$mensajexx);
            $smt = $mensajex->serverQuery($conexion);
            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            // var_dump($response);
            // exit;
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'home/index');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'home/index');
            }
        }


        public function eliminar(){
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $mensaje = new Mensaje('eliminar', 0,0, $id);
            $smt = $mensaje->serverQuery($conexion);
            $response   = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response   = $response[0];
            $codigo     = $response["codigo"];
            $mensaje    = $response["mensaje"];
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'mensaje/gestion');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'mensaje/gestion');
            }
        }
    }
?>