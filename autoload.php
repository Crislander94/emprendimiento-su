<?php

    function controllers_autoload($nombredeclase){
        include 'controllers/' . $nombredeclase . '.php';
    }

    spl_autoload_register('controllers_autoload');