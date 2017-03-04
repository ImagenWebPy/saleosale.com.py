<?php

$helper = new Helper();
$pagina = $helper->getUrlAnterior();
$url = URL . 'cart/carrito_resumen/';
$urlComprar = URL . 'cart/carrito_comprar/';
#instanciamos la BD
$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
#datos app
$required_scope = 'public_profile, email';
// added in v4.0.0
require_once 'autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// start session
// init app with app id and secret
FacebookSession::setDefaultApplication(FB_PUBLIC_KEY, FB_PRIVATE_KEY);

// login helper with redirect_uri

$helperFB = new FacebookRedirectLoginHelper('http://saleosale.com.py/login');

try {
    $session = $helperFB->getSessionFromRedirect();
} catch (FacebookRequestException $ex) {
    // When Facebook returns an error
} catch (Exception $ex) {
    // When validation fails or other local issues
}

// see if we have a session
if (isset($session)) {
    // graph api request for user data
    $request = new FacebookRequest($session, 'GET', '/me?locale=en_US&fields=id,name,email');

    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject();
    echo '<pre>';
    $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
    $fbuname = $graphObject->getProperty('username');  // To Get Facebook Username
    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
    #buscamos el email en la bd
    $email = $this->db->select("select id, email, nombre, apellido, facebook_id from cliente where email = '$femail'");
    #verificamos si las variables de FB estan seteadas
    if (!empty($email[0]['email'])) {
        #verficiamos si no es la 1ra vez que se loguea con FB
        if (empty($email[0]['facebook_id'])) {
            #insertamos los datos de FB
            $data = array(
                'facebook_id' => $fbid,
                'facebook_email' => $femail
            );
            $this->db->update('cliente', $data, "`email` = '" . $email[0]['email'] . "'");
        }
        Session::set('cliente', array(
            'id' => $email[0]['id'],
            'nombre' => $email[0]['nombre'],
            'apellido' => $email[0]['apellido'],
            'email' => $email[0]['email'],
        ));
    } else {
        #insertamos los datos del cliente en la BD
        $this->db->insert('cliente', array(
            'nombre' => $fbfullname,
            'email' => $femail,
            'facebook_id' => $fbid,
            'facebook_email' => $femail,
            'fecha_registro' => date('Y-m-d H:i:s')
        ));
        $idCliente = $this->db->lastInsertId('id');
        Session::set('cliente', array(
            'id' => $idCliente,
            'nombre' => $fbfullname,
            'apellido' => '',
            'email' => $femail,
        ));
        #enviamos la confirmacion del email
        $nombreCliente = $fbfullname;
        $asunto = 'Hola ' . $nombreCliente . ', gracias por registrarte';
        $destinatario = $femail;
        $helper->sendMail($destinatario, $asunto, 'cliente[bienvenida]', '', $destinatarioNombre);
    }
    if (($pagina != $urlComprar) && ($pagina != $url)) {
        header('location: ' . URL . 'cliente/dashboard/');
    } else {
        #verificamos desde cual url se inicio sesion para realizar la redireccion
        if ($pagina == $url) {
            $redireccion = $url;
        } elseif ($pagina == $urlComprar) {
            $redireccion = $urlComprar;
        }
        header('location: ' . $redireccion);
    }
} else {
    // show login url
    //$this->view->fb_boton =  '<a href="' . $helperFB->getLoginUrl() . '">Login</a>';
    $login_url = $helperFB->getLoginUrl(array('scope' => $required_scope));
    $this->view->fb_boton = '<a href="' . $login_url . '"><img src="' . IMAGES . 'btn-fb-connect.png" class="img-responsive" /></a>';
}
?>