<?php

class Footer_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function suscribir($data) {
        $helper = new Helper();
        $email = $data['email'];
        #verificamos que el email no sea nulo
        if (!empty($email)) {
            #verificamos si el email no existe todavia en la BD
            $verifica = $this->db->select("select email from newsletter where email = '$email'");
            if (empty($verifica)) {
                #insertamos el email en la BD
                $this->db->insert('newsletter', array(
                    'email' => $email
                ));
                Session::set('message', array(
                    'type' => 'success',
                    'mensaje' => 'Te has suscripto a nuestro newsletter, pronto estaras recibiendo todas nuestras novedades y ofertas.'));
            } else {
                Session::set('message', array(
                    'type' => 'warning',
                    'mensaje' => 'Ya estas suscripto a nuestro newsletter.'));
            }
        } else {
            Session::set('message', array(
                'type' => 'error',
                'mensaje' => 'La dirección de correo electrónico no puede permanecer vacía.'));
        }
    }

}
