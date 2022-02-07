
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
}