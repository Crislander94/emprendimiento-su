<?php
ob_start();
session_start();
require_once 'autoload.php';
require_once 'config/settings.php';

	if(isset($_COOKIE["color_primario"])){
		$color_primario = $_COOKIE["color_primario"];
		$color_secundario = $_COOKIE["color_secundario"];
		$fuente_primaria = $_COOKIE["fuente_primaria"];
	}else{
		$color_primario = "#5072e4";
		$color_secundario = "#237db1";
		$fuente_primaria = "'Poppins', sans-serif";
	}

?>
<style>
	:root{
		--primary-color: <?= $color_primario ?>;
    	--secondary-color: <?= $color_secundario ?>;
    	--third-color: #ECC032;
    	--font-primary: <?= $fuente_primaria ?>;
    	--body-size: 16px;
	}
</style>

<?php
require_once 'views/partials/cabecera.php';
require_once 'views/mensaje.php';
require_once 'db/conexion.php';
require_once 'helpers/utils.php';
function show_error(){
	$error = new errorController();
	$error->alerta();
}

if(isset($_GET['controller'])){
	$nombre_controlador = $_GET['controller'].'Controller';

}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
	$nombre_controlador = controller_default;
}else{
	show_error();
	exit();
}

if(class_exists($nombre_controlador)){	
	$controlador = new $nombre_controlador();
	
	if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
		$action = $_GET['action'];
		$controlador->$action();
	}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
		$action_default = action_default;
		$controlador->$action_default();
	}else{
		show_error();
	}
}else{
	show_error();
}
require_once 'views/partials/footer.php';
ob_end_flush();
?>