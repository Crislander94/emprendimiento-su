<?php
    include_once 'models/usuarioModel.php';
    class UsuarioController{

        //Cargando vistas
        public function crear(){
            //Cargando la vista de crear
            include_once 'views/usuario/crear.php';
        }

        public function gestion(){
            Utils::isAdmin();
            //Cargando la vista de crear
            include_once 'views/usuario/gestion.php';
        }
        //Ejecutando funcionabilidad
        public function login(){
            $usuario = new Usuario('iniciar_sesion');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if( 
                isset($_POST["usuario"]) &&
                isset($_POST["contrasena"])
            ){
                $usuario->setData1($_POST["usuario"]);
                $usuario->setData2(base64_encode($_POST["contrasena"]));
                $smt = $usuario->serverQuery($conexion);
                $response = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response = $response[0];
                $codigo = $response["codigo"];
                $mensaje = $response["mensaje"];
                if($codigo  === "200"){
                    $_SESSION["id"] = $response["ID"];
                    $_SESSION["usuario"] = $response["NOMBRE_USUARIO"];
                    $_SESSION["nombres"] = $response["NOMBRES"];
                    $_SESSION["email"] = $response["EMAIL"];
                    $_SESSION["rol"] = $response["ROL"];
                    header('Location: '.RUTA);
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'home/login');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'home/login');
            }
        }
        public function registro(){
            $usuario = new Usuario('registrar');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if(
                isset($_POST["rol"]) &&
                isset($_POST["usuario"]) &&
                isset($_POST["contrasena"]) &&
                isset($_POST["nombres"]) &&
                isset($_POST["correo"]) &&
                isset($_POST["telefono"])
            ){
                $usuario->setData1($_POST["usuario"]);
                $usuario->setData2(base64_encode($_POST["contrasena"]));
                $usuario->setData3($_POST["nombres"]);
                $usuario->setData4($_POST["correo"]);
                $usuario->setData5($_POST["telefono"]);
                $usuario->setData6($_POST["rol"]);

                $smt = $usuario->serverQuery($conexion);
                $response = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response = $response[0];
                $codigo = $response["codigo"];
                $mensaje = $response["mensaje"];
                if($codigo  === "200"){
                    Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                    header('Location: '.RUTA.'home/login');
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'home/login');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'home/login');
            }
        }
        public function logout(){
            unset($_SESSION["id"]);
            unset($_SESSION["usuario"]);
            unset($_SESSION["nombres"]);
            unset($_SESSION["email"]);
            unset($_SESSION["rol"]);
            header('Location: '.RUTA.'home/index');
        }
        public function modificar(){
            Utils::isAdmin();
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $usuario = new Usuario('consulta', 0,0, $id);
            $smt = $usuario->serverQuery($conexion);
            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            if($codigo  === "-1"){
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                include_once 'views/usuario/gestion.php';
            }else{
                $idx = $response["ID"];
                $nombres = $response["NOMBRES"];
                $nombre_usuariox = $response["NOMBRE_USUARIO"];
                $emailx = $response["EMAIL"];
                $telefonox = $response["TELEFONO"];
                $password = base64_decode($response["PASSWORD"]);
                include_once 'views/usuario/editar.php';
            }
        }
        public function editar(){
            Utils::isAdmin();
            $usuario = new Usuario('editar');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if(
                isset($_POST["current_usuario"]) &&
                isset($_POST["usuario"]) &&
                isset($_POST["id"]) &&
                isset($_POST["contrasena"]) &&
                isset($_POST["nombres"]) &&
                isset($_POST["correo"]) &&
                isset($_POST["telefono"])
            ){
                $usuario->setFiltros($_POST["id"]);
                $usuario->setData1($_POST["current_usuario"]);
                $usuario->setData2($_POST["usuario"]);
                $usuario->setData3($_POST["nombres"]);
                $usuario->setData4($_POST["correo"]);
                $usuario->setData5($_POST["telefono"]);
                $usuario->setData6(base64_encode($_POST["contrasena"]));

                $smt = $usuario->serverQuery($conexion);
                $response = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response = $response[0];
                $codigo = $response["codigo"];
                $mensaje = $response["mensaje"];
                if($codigo  === "200"){
                    Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                    header('Location: '.RUTA.'usuario/gestion');
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'usuario/gestion');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'usuario/gestion');
            }
        }
        public function eliminar(){
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $usuario = new Usuario('eliminar', 0,0, $id);
            $smt = $usuario->serverQuery($conexion);
            $response   = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response   = $response[0];
            $codigo     = $response["codigo"];
            $mensaje    = $response["mensaje"];
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'usuario/gestion');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'usuario/gestion');
            }
        }
    }
?>