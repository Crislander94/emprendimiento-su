<?php
    include_once 'models/categoriaModel.php';
    class categoriaController{
        public function gestion(){
            Utils::isAdmin();
            require_once 'views/categoria/gestion.php';
        }
        public function crear(){
            //Cargando la vista de crear
            Utils::isAdmin();
            include_once 'views/categoria/crear.php';
        }
        public function registro(){
            Utils::isAdmin();
            $categoria = new Categoria('registrar');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if(
                isset($_POST["nom_categoria"]) &&
                isset($_POST["descripcion"])
            ){
                $categoria->setData1($_POST["nom_categoria"]);
                $categoria->setData2($_POST["descripcion"]);
                $smt = $categoria->serverQuery($conexion);
                $response = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response = $response[0];
                $codigo = $response["codigo"];
                $mensaje = $response["mensaje"];
                if($codigo  === "200"){
                    Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                    header('Location: '.RUTA.'categoria/crear');
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'categoria/crear');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'categoria/crear');
            }
        }
        public function modificar(){
            Utils::isAdmin();
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $categoria = new Categoria('consulta', 0,0, $id);
            $smt = $categoria->serverQuery($conexion);
            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            if($codigo  === "-1"){
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                include_once 'views/categoria/gestion.php';
            }else{
                $idx = $response["ID"];
                $nombre_categoriax = $response["NOM_CATEGORIA"];
                $descripcionx = $response["DESCRIPCION"];
                include_once 'views/categoria/editar.php';
            }
        }
        public function editar(){
            Utils::isAdmin();
            $categoria = new Categoria('editar');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if(
                isset($_POST["current_nombre"]) &&
                isset($_POST["nom_categoria"]) &&
                isset($_POST["id"]) &&
                isset($_POST["descripcion"])
            ){
                $categoria->setFiltros($_POST["id"]);
                $categoria->setData1($_POST["current_nombre"]);
                $categoria->setData2($_POST["nom_categoria"]);
                $categoria->setData3($_POST["descripcion"]);

                $smt = $categoria->serverQuery($conexion);
                $response = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response = $response[0];
                $codigo = $response["codigo"];
                $mensaje = $response["mensaje"];
                if($codigo  === "200"){
                    Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                    header('Location: '.RUTA.'categoria/gestion');
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'categoria/gestion');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'categoria/gestion');
            }
        }
        public function eliminar(){
            Utils::isAdmin();
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $categoria = new Categoria('eliminar', 0,0, $id);
            $smt = $categoria->serverQuery($conexion);
            $response   = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response   = $response[0];
            $codigo     = $response["codigo"];
            $mensaje    = $response["mensaje"];
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'categoria/gestion');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'categoria/gestion');
            }
        }
    }
?>