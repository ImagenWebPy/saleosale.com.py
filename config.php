<?php
/**
 * ARCHIVO DE CONFIGURACIONES
 * MVC - IMAGENWEBHQ.COM
 * @author "Raul Ramirez" <raul.chuky@gmail.com>
 * @copyright 2016 imagenwebhq.com
 * @version 1 2016-03-01
 */
//define('URL', 'http://saleosale.com.py/');
define('URL', 'http://localhost/saleosale.com.py/');
define('LIBS', 'libs/');

/**
 * PRODUCCION
 */
//define('DB_TYPE', 'mysql');
//define('DB_HOST', 'saleosale.com.py');
//define('DB_NAME', 'saleosal_e');
//define('DB_USER', 'saleosal_web');
//define('DB_PASS', ')OiD20Fbe)X6');

/**
 * DESARROLLO
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'saleosale');
define('DB_USER', 'root');
define('DB_PASS', '');

// Salt utilizado para el hash de la BD
define('HASH_PASSWORD_KEY', '!@123456789ABCDEFGHIJKLMNOPRSTWYZ[¿]{?}<->');

// Constantes varias
define('SITE_TITLE', 'Sale o Sale | ');
define('URL_PRODUCTO', URL.'producto/item/');
define('CANT_REGISTROS_PAGINA', 18);
define('FB_PUBLIC_KEY', '220173965025048');
define('FB_PRIVATE_KEY', 'a86dcfa667ba4575c88d0bde69e72780');

//contantes del sitio
define('IMAGES', URL.'public/images/');
define('IMAGES_PUBLICIDAD', URL.'public/images/banner-publicidad/');
define('IMAGE_PRODUCT', URL.'public/products-images/');
define('IMAGE_CANJE', 'views/carrito/img/');
define('IMAGE_SUBASTA', URL.'public/subasta/');
define('UPLOAD_IMAGE', 'public/products-images/');
define('UPLOAD', 'public/images/');
define('UPLOAD_CATEGORIAS', 'public/images/categorias/');
define('UPLOAD_SUBASTA', 'public/subasta/');
define('URL_MAIL', URL.'public/mails/' );
define('FB_SDK', 'util/fb-connet/');
define('MAILFROM', 'info@saleosale.com.py');
define('NAMEMAIL', 'Sale o Sale');

//administrador
define('CANT_REG_PAGINA_ADMIN', 20);

//creditos
define('TASA_INTERES',4);