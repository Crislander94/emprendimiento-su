<?php
	// require_once 'models/pedido.php';
	class homeController{
		public function index(){
			require_once 'views/principal.php';
		}
		public function contacto(){
			require_once 'views/contactanos.php';
		}
		public function quiensomos(){
			require_once 'views/quienesomos.php';
		}

		public function login(){
			require_once 'views/login.php';
		}

		public function settings(){
			Utils::isLoggin();
			if(isset($_COOKIE["color_primario"])){
				$color_primario = $_COOKIE["color_primario"];
				$color_secundario = $_COOKIE["color_secundario"];
				$fuente_primaria = $_COOKIE["fuente_primaria"];
			}else{
				$color_primario = "#5072e4";
				$color_secundario = "#237db1";
				$fuente_primaria = "'Poppins', sans-serif";
			}
			require_once 'views/settings.php';
		}


		public function guardar_configuracion(){
			Utils::isLoggin();
			$color_primario = $_POST["color_primary"];
			$color_secundario = $_POST["color_secondary"];
			$fuente_primaria = $_POST["text_style"];

			setcookie("color_primario",$color_primario,time()+60*60*24*360,'/');
			setcookie("color_secundario",$color_secundario,time()+60*60*24*360,'/');
			setcookie("fuente_primaria",$fuente_primaria.', sans-serif',time()+60*60*24*360,'/');
			
			Utils::settingMesaggeResponse('success', "Se guardo la configuración exitosamente", 'Exito!');
			header('Location: '.RUTA.'home/settings');
		}
	}
?>