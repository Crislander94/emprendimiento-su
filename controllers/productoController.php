<?php
    include_once 'models/productoModel.php';
    class productoController{
        public function index(){
            require_once 'views/producto/index.php';
        }
        public function gestion(){
            Utils::isAdmin();
            require_once 'views/producto/gestion.php';
        }
        public function crear(){
            Utils::isAdmin();
            $db = new DBClass();
            $conexion = $db->getconnection();
            $producto = new Producto('getCategorias');
            $smt = $producto->serverQuery($conexion);
            $categorias = $smt->fetchAll(PDO::FETCH_ASSOC);
            //Cargando la vista de crear
            include_once 'views/producto/crear.php';
        }
        public function registro(){
            Utils::isAdmin();
            $producto = new Producto('registrar');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if(
                isset($_POST["cod_categoria"]) &&
                isset($_POST["nom_producto"]) &&
                isset($_POST["precio"]) &&
                isset($_POST["descripcion"])
            ){
                $producto->setData1($_POST["nom_producto"]);
                $producto->setData2($_POST["cod_categoria"]);
                $producto->setData3($_POST["descripcion"]);
                $producto->setData4($_POST["precio"]);
                $producto->setData5($_POST["stock"]);
                $imagen         = $_FILES["image"]["name"];
                if($imagen != ""){$producto->setData6("SI");}
                else{$producto->setData6("NO");}
                $ruta_archivo = 'archivos/productos/';
                if(!file_exists('archivos')) mkdir('archivos', 0777);
                if(!file_exists('archivos/productos')) mkdir('archivos/productos', 0777);
                $smt            = $producto->serverQuery($conexion);
                $response       = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response       = $response[0];
                $codigo         = $response["codigo"];
                $mensaje        = $response["mensaje"];
                if($codigo  > "0"){
                    if ($imagen != ""){
                        $fileTmpLoc 		= $_FILES["image"]["tmp_name"];// Archivo en la carpeta tmp de PHP
                        var_dump(move_uploaded_file($fileTmpLoc, "$ruta_archivo$codigo.jpg"));
                    }
                    Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                    header('Location: '.RUTA.'producto/crear');
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'producto/crear');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'producto/crear');
            }
        }
        public function modificar(){
            Utils::isAdmin();
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            //TRAEMOS AL PRODUCTO
            $producto = new Producto('consulta', 0,0, $id);
            $smt = $producto->serverQuery($conexion);
            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            if($codigo  === "-1"){
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                include_once 'views/categoria/gestion.php';
            }else{
                $idx = $response["ID"];
                $nom_productox = $response["NOM_PRODUCTO"];
                $descripcionx = $response["DESCRIPCION"];
                $cod_categoriax = $response["COD_CATEGORIA"];
                $imagen = $response["IMAGEN_PRODUCTO"];
                $rand = rand();
                $imagen = ($imagen == '' || $imagen == null) ? RUTA.'assets/img/custom_image.jpg' : RUTA.'archivos/productos/'.$imagen.'?v='.$rand;
                $preciox = $response["PRECIO"];
                $stockx = $response["STOCK"];
                include_once 'views/producto/editar.php';
            }
        }
        public function editar(){
            Utils::isAdmin();
            $producto = new Producto('editar');
            $db = new DBClass();
            $conexion = $db->getconnection();
            if(
                isset($_POST["current_nombre"]) &&
                isset($_POST["nom_producto"]) &&
                isset($_POST["id"]) &&
                isset($_POST["cod_categoria"]) &&
                isset($_POST["stock"]) &&
                isset($_POST["stock"]) &&
                isset($_POST["descripcion"])
            ){
                $producto->setFiltros($_POST["id"]);
                $producto->setData1($_POST["current_nombre"]);
                $producto->setData2($_POST["nom_producto"]);
                $producto->setData3($_POST["descripcion"]);
                $producto->setData4($_POST["cod_categoria"]);
                $producto->setData5($_POST["precio"]);
                $producto->setData6($_POST["stock"]);
                $id = $_POST["id"];
                $imagen         = $_FILES["image"]["name"];
                if($imagen != ""){$producto->setData7("SI");}
                else{$producto->setData7("NO");}
                $ruta_archivo = 'archivos/productos/';
                if(!file_exists('archivos')) mkdir('archivos', 0777);
                if(!file_exists('archivos/productos')) mkdir('archivos/productos', 0777);

                $smt = $producto->serverQuery($conexion);
                $response = $smt->fetchAll(PDO::FETCH_ASSOC);
                $response = $response[0];
                $codigo = $response["codigo"];
                $mensaje = $response["mensaje"];
               
                if($codigo  === "200"){
                    if ($imagen != ""){
                        $fileTmpLoc 		= $_FILES["image"]["tmp_name"];// Archivo en la carpeta tmp de PHP
                        var_dump(move_uploaded_file($fileTmpLoc, "$ruta_archivo$id.jpg"));
                    }
                    Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                    header('Location: '.RUTA.'producto/gestion');
                }else{
                    Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                    header('Location: '.RUTA.'producto/gestion');
                }
            }else{
                Utils::settingMesaggeResponse('danger', 'Faltan parametros para realizar la solicitud', 'Error!');
                header('Location: '.RUTA.'producto/gestion');
            }
        }
        public function eliminar(){
            Utils::isAdmin();
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            $producto = new Producto('eliminar', 0,0, $id);
            $smt = $producto->serverQuery($conexion);
            $response   = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response   = $response[0];
            $codigo     = $response["codigo"];
            $mensaje    = $response["mensaje"];
            if($codigo  === "200"){
                Utils::settingMesaggeResponse('success', $response["mensaje"], 'Exito!');
                header('Location: '.RUTA.'producto/gestion');
            }else{
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'producto/gestion');
            }
        }

        public function detalle(){
            $id = $_REQUEST["id"];
            $db = new DBClass();
            $conexion = $db->getconnection();
            //TRAEMOS AL PRODUCTO
            $producto = new Producto('consulta', 0,0, $id);
            $smt = $producto->serverQuery($conexion);
            $response = $smt->fetchAll(PDO::FETCH_ASSOC);
            $response = $response[0];
            $codigo = $response["codigo"];
            $mensaje = $response["mensaje"];
            if($codigo  === "-1"){
                Utils::settingMesaggeResponse('danger', $response["mensaje"], 'Error!');
                header('Location: '.RUTA.'home/index');
            }else{
                $idx = $response["ID"];
                $nom_productox = $response["NOM_PRODUCTO"];
                $descripcionx = $response["DESCRIPCION"];
                $cod_categoriax = $response["COD_CATEGORIA"];
                $imagen = $response["IMAGEN_PRODUCTO"];
                $rand = rand();
                $imagen = ($imagen == '' || $imagen == null) ? RUTA.'assets/img/custom_image.jpg' : RUTA.'archivos/productos/'.$imagen.'?v='.$rand;
                $preciox = $response["PRECIO"];
                $stockx = $response["STOCK"];
                include_once 'views/producto/detalle.php';
            }
        }
    }
?>