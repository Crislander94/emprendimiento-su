<?php
    include_once 'models/carritoModel.php';
    include_once 'models/pedidoModel.php';
    class pedidoController{
        public function mis_pedidos(){
            utils::isCliente();
            require_once 'views/pedidos/index.php';
        }
        public function crear(){
            utils::isCliente();
            require_once 'views/pedidos/crear.php';
        }

        public function registrar(){
            $response_final = null;
            utils::isCliente();
            //Traer información de cantidad total de productos en carrito
            $db = new DBClass();
            $conexion = $db->getconnection();
            $cod_usuario = $_SESSION["id"];
            $carrito = new Carrito('getTotalitems', 0,0,'', $cod_usuario);
            $response = $carrito->serverQuery($conexion);
            $response = $response->fetchAll(PDO::FETCH_ASSOC)[0];
            //Verificar que existen productos en el carrito
            if(!empty($response)){
                if(intval($response["total"]) > 0){
                    //Insertar pedido y obtener su codigo;
                    $provincia = $_POST["provincia"];
                    $ciudad = $_POST["ciudad"];
                    $nombre = $_POST["nombre"];
                    $direccion = $_POST["direccion"];
                    $correo = $_POST["correo"];
                    $telefono = $_POST["telefono"];
                    $pedido = new Pedido('insertar', 0,0,'', $cod_usuario,$provincia,$ciudad,$nombre,$direccion,$correo, $telefono);
                    $insert_pedido = $pedido->serverQuery($conexion);
                    $insert_pedido = $insert_pedido->fetchAll(PDO::FETCH_ASSOC)[0];
                    //Verificar que el pedido se realizo exitosamente
                    if(!empty($insert_pedido)){
                        $result_insert_pedido = $insert_pedido["codigo"];
                        //Verificar que el pedido se realizo exitosamente
                        if(intval($result_insert_pedido) === 200){
                            Utils::settingMesaggeResponse('success', 'Se ha generado su pedido con exito', 'Exito!');
                            header('Location: '.RUTA.'producto/index');
                        }else{
                            Utils::settingMesaggeResponse('danger', 'No se pudo registrar su pedido', 'Error!');
                            header('Location: '.RUTA.'producto/index');
                        }
                    }else{
                        Utils::settingMesaggeResponse('danger', 'No se pudo registrar su pedido', 'Error!');
                        header('Location: '.RUTA.'producto/index');
                    }
                }else{
                    Utils::settingMesaggeResponse('danger', 'No cuenta con productos para generar un pedido', 'Error!');
                    header('Location: '.RUTA.'producto/index');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'No cuenta con productos para generar un pedido', 'Error!');
                header('Location: '.RUTA.'producto/index');
            }
        }

        public function detalle(){
            Utils::isLoggin();
            $db = new DBClass();
            $conexion = $db->getconnection();
            $id         = $_REQUEST["id"];
            $pedido = new Pedido('detalle', 0,0,$id);
            $response = $pedido->serverQuery($conexion);
            $response_pedido = ($response->fetchAll(PDO::FETCH_ASSOC))[0];
            $response->nextRowset();
            $detalle_pedido = ($response->fetchAll(PDO::FETCH_ASSOC));
            include_once 'views/pedidos/detalle.php';
        }

        public function gestion(){
            utils::isAdmin();
            require_once 'views/pedidos/gestion.php';
        }

        public function actualizar_cliente(){
            utils::isCliente();
            $db = new DBClass();
            $conexion = $db->getconnection();
            $id = $_POST["id_pedido"];
            $pedido = new Pedido('actualizar_cliente', 0,0,$id);
            $smt = $pedido->serverQuery($conexion);
            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'pedido/mis_pedidos');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'pedido/mis_pedidos');
            }
        }

        public function actualizar_gestion(){
            utils::isAdmin();
            $id = $_POST["id_pedido"];
            $st_pedido = $_POST["st_pedido"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $pedido = new Pedido('actualizar_gestion', 0,0,$id, '', $st_pedido);
            $smt = $pedido->serverQuery($conexion);

            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'pedido/gestion');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'pedido/gestion');
            }
        }

    }
?>