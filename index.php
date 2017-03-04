<?php
/**
 * ARCHIVO INDEX
 * MVC - IMAGENWEBHQ.COM
 * @author "Raul Ramirez" <raul.chuky@gmail.com>
 * @copyright 2016 imagenwebhq.com
 * @version 1 2016-03-01
 */
#definimos el timezone de paraguay
date_default_timezone_set('America/Asuncion');
#mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();

require 'config.php';
require 'util/Auth.php';

//autoloader para los metodos
function __autoload($class) {
    require LIBS . $class . ".php";
}

Session::init();

//cargarmos el helper
require 'util/Helper.php';
//cargamos el carrito y lo inicializamos
require 'util/Carrito.php';


//cargamos el bootstrap
$bootstrap = new Bootstrap();

$bootstrap->init();
ob_end_flush();
