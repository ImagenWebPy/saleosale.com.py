<?php

ob_start();

class Login_Model extends Model {

    function __construct() {
        parent::__construct();
        //echo Hash::create('sha256', '2544386', HASH_PASSWORD_KEY);
    }

    /**
     * Funcion para insertar un nuevo usuario en la BD
     * @param array $data
     */
    public function crear($data) {
        $this->db->insert('cliente', array(
            'id_tipo_documento' => $data['documento_tipo'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'documento_nro' => $data['documento_nro'],
            'telefono' => $data['telefono'],
            'celular' => $data['celular'],
            'email' => $data['email'],
            'fecha_registro' => date('Y-m-d H:i:s'),
            'contrasena' => Hash::create('sha256', $data['pass'], HASH_PASSWORD_KEY)
        ));
        Session::set('id_cliente', $this->db->lastInsertId('id'));
    }

    public function iniciar($data) {
        $helper = new Helper();
        //$pagina = $helper->getUrlAnterior();
        $pagina = $data['urlAnterior'];
        $sth = $this->db->prepare("SELECT id, nombre, apellido, email FROM cliente WHERE 
                email = :email AND contrasena = :password");
        $sth->execute(array(
            ':email' => $data['email'],
            ':password' => Hash::create('sha256', $data['password'], HASH_PASSWORD_KEY)
        ));

        $data = $sth->fetch();
        $count = $sth->rowCount();
        #datos para redireccion
        $url = URL . 'cart/carrito_resumen/';
        $urlComprar = URL . 'cart/carrito_comprar/';

        if ($count > 0) {
            // login
            Session::set('cliente', array(
                'id' => $data['id'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email']));

            if (($pagina != $urlComprar) && ($pagina != $url)) {
                //header('location: ' . URL . 'cliente/dashboard/');
                header('location: ' . $pagina);
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
            Session::set('message', array(
                'type' => 'error',
                'mensaje' => 'El usuario ingresado no existe o la contraseña ingresada no coincide'));
            if (($pagina != $urlComprar) && ($pagina != $url)) {
                header('location: ' . URL . 'login/');
                #cargamos la vista
            } else {
                #verificamos desde cual url se inicio sesion para realizar la redireccion
                if ($pagina == $url) {
                    $redireccion = $url;
                } elseif ($pagina == $urlComprar) {
                    $redireccion = $urlComprar;
                }
                header('location: ' . $redireccion);
            }
        }
    }

    /**
     * Funcion que retorna el select box armado de los tipo de documentos
     * @return array
     */
    public function cargarSelectDocumento() {
        $datos = array();
        $documentos = $this->db->select("Select * from tipo_documento");
        $select = '<select name="register[documento_tipo]" class="input-sm required-entry selectbox" required>';
        $select .= ' <option value="0">Seleccione una Opción</option>';
        foreach ($documentos as $item) {
            $select .= ' <option value="' . $item['id'] . '">' . utf8_encode($item['descripcion']) . '</option>';
        }
        $select .= '</select>';
        $datos = $select;
        return $datos;
    }

    /**
     * Funcion que retorna si existe o no el email registrado por un cliente
     * @param string $email
     * @return array con los datos del cliente
     */
    public function verificarEmail($email) {
        $data = array();
        $result = $this->db->select("Select email, nombre, apellido from cliente where email = '$email'");
        if (!empty($result))
            $data = array(
                'email' => $result[0]['email'],
                'nombre' => $result[0]['nombre'],
                'apellido' => $result[0]['apellido'],
                'exist' => true
            );
        return $data;
    }

    /**
     * Funcion para genererar un token para que el usuario pueda cambiar su contraseña
     * @param string $email
     * @param string $token
     */
    public function generarToken($email, $token) {
        $data = array(
            'forgot_token' => $token,
            'validado' => 1
        );
        $this->db->update('cliente', $data, "`email` = '$email'");
    }

    /**
     * Funcion que verifica si el token es valido
     * @param string $token
     * @return int
     */
    public function getUserForgot($token) {
        $id = '';
        $userId = $this->db->select("select id from cliente where forgot_token = '$token' and validado = 1");
        if (!empty($userId))
            $id = $userId[0]['id'];
        return $id;
    }

    /**
     * Funcion que actualiza la contaseña del cliente
     * @param int $idCliente
     * @param string $clientePass
     */
    public function updateClientPass($idCliente, $clientePass) {
        $data = array(
            'forgot_token' => '',
            'validado' => 0,
            'contrasena' => Hash::create('sha256', $clientePass, HASH_PASSWORD_KEY)
        );
        $this->db->update('cliente', $data, "`id` = '$idCliente'");
    }

}

ob_end_flush();
