<?php

    class Utils{
        public static function settingMesaggeResponse($color, $mensaje, $tipo){
            $_SESSION["color_alerta"] = $color;
            $_SESSION["mensaje"] = $mensaje;
            $_SESSION["resultado_response"] = $tipo;
        }

        public static function isAdmin(){
            if(!isset($_SESSION["id"])){
                header("Location: ". RUTA. "home/login");
            }else{
                if($_SESSION["rol"] !== 'A'){
                    header("Location: ". RUTA. "home/index");
                }
            }
        }

        public static function isCliente(){
            if(!isset($_SESSION["id"])){
                header("Location: ". RUTA. "home/login");
            }else{
                if($_SESSION["rol"] !== 'C'){
                    header("Location: ". RUTA. "home/index");
                }
            }
        }


        public static function isLoggin(){
            if(!isset($_SESSION["id"])){
                header("Location: ".RUTA."home/index");
            }
        }
    }