<?php

class Footer extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function newsletter(){
        $helper = new Helper();
        
        $email = $helper->cleanInput($_POST['newsletter']['email']);
        $data = array(
            'email' => $email
        );
        
        $this->model->suscribir($data);
        
        #enviamos un email de bienvenida
        $destinatario = $email;
        $asunto = 'Suscripción al newsletter';
        $helper->sendMail($destinatario, $asunto, 'newsletter[bienvenida]', '');
        
        #redireccionamos a la url desde la cual fue llamada el metodo
        header('location: ' . $helper->getUrlAnterior());
    }
}
