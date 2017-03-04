<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();
        //echo $token = Hash::create('sha256', 'pass', HASH_PASSWORD_KEY);
    }

    public function index() {

        require_once FB_SDK . 'fb-connect.php';

        $this->view->render('header');
        $this->view->render('login/index');
        $this->view->render('footer');
        /**
         * destruimos la variable de session message
         * para que el mensaje se muestre una sola vez
         */
        unset($_SESSION['message']);
    }

    public function registro() {
        $this->view->js = array('login/js/user_validate.js');

        #cargamos los datos necesarios para la pagina
        $this->view->loadDocumento = $this->model->cargarSelectDocumento();

        #cargamos la vista
        $this->view->render('header');
        $this->view->render('login/registro');
        $this->view->render('footer');
    }

    public function crear() {
        $helper = new Helper();
        #asignamos los valores obtenidos del formulario
        $data = array();
        $data['nombre'] = $helper->cleanInput($_POST['register']['nombre']);
        $data['apellido'] = $helper->cleanInput($_POST['register']['apellido']);
        $data['documento_tipo'] = $helper->cleanInput($_POST['register']['documento_tipo']);
        $data['documento_nro'] = $helper->cleanInput($_POST['register']['documento_nro']);
        $data['telefono'] = $helper->cleanInput($_POST['register']['telefono']);
        $data['celular'] = $helper->cleanInput($_POST['register']['celular']);
        $data['email'] = $helper->cleanInput($_POST['register']['email']);
        $data['pass'] = $helper->cleanInput($_POST['register']['pass']);
        $data['pass_validate'] = $helper->cleanInput($_POST['register']['pass_validate']);

        #creamos el usuario
        $this->model->crear($data);


        #creamos la variable de session con los datos del usuario
        Session::set('cliente', array(
            'id' => $_SESSION['id_cliente'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email']));

        #enviamos la confirmacion del email
        $nombreCliente = $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido'];
        $asunto = 'Hola ' . $nombreCliente . ', gracias por registrarte';
        $destinatario = $_SESSION['cliente']['email'];
        $helper->sendMail($destinatario, $asunto, 'cliente[bienvenida]', '', $destinatarioNombre);

        #redireccionamos al dashboard
        header('location: ' . URL . 'cliente/dashboard/');
    }

    public function iniciar() {
        $helper = new Helper();
        $data = array(
            'email' => $helper->cleanInput($_POST['login']['email']),
            'password' => $helper->cleanInput($_POST['login']['password']),
            'urlAnterior' => $_POST['login']['urlAnterior']
        );

        #validamos loss datos ingresados
        $this->model->iniciar($data);
        #destruimos la session message
    }

    public function cerrar() {
        $helper = new Helper();
        #destruimos toda la sesion del sitio
        session_destroy();
        #redireccionamos a la url desde la cual fue llamada el metodo
        header('location: ' . $helper->getUrlAnterior());
    }

    public function contrasena() {
        $helper = new Helper();
        #title
        $this->view->title = 'Recuperar Contraseña';
        #si se produjo el evento post es porque se solicito la generacion de una nueva contraseña
        if (!empty($_POST['recuperar']['email'])) {
            $email = $helper->cleanInput($_POST['recuperar']['email']);
            $verificar = $this->model->verificarEmail($email);
            if (!empty($verificar)) {
                #enviamos el correo con las instrucciones
                $destinatario = $verificar['email'];
                $asunto = 'Recuperar Contraseña';
                $destinatarioNombre = $verificar['nombre'] . ' ' . $verificar['apellido'];
                $email = $verificar['email'];
                $token = Hash::create('sha256', microtime(), HASH_PASSWORD_KEY);
                $mensaje = array(
                    'email' => $email,
                    'token' => $token
                );
                $this->model->generarToken($email, $token);
                $helper->sendMail($destinatario, $asunto, 'recuperar[contrasena]', $mensaje, $destinatarioNombre);

                Session::set('message', array(
                    'type' => 'success',
                    'mensaje' => 'Se le han enviado instrucciones de como restaurar su contraseña a su correo electrónico.'));
            } else {
                Session::set('message', array(
                    'type' => 'error',
                    'mensaje' => 'El email ingresado no existe, por favor verificalo y vuelva a ingresarlo.'));
            }
        }
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('login/contrasena');
        $this->view->render('footer');
        /**
         * destruimos la variable de session message
         * para que el mensaje se muestre una sola vez
         */
        unset($_SESSION['message']);
    }

    public function cambiar() {
        $url = $_GET['url'];
        $url = explode('/', $url);
        $token = array_pop($url);
        $user_id = $this->model->getUserForgot($token);
        if (!empty($user_id)) {
            #title
            $this->view->title = 'Cambiar Contraseña';
            #guardamos el id del cliente
            Session::set('forgotCliente', array(
                'id_cliente' => $user_id
            ));
            #cargamos la vista
            $this->view->render('header');
            $this->view->render('login/cambiar');
            $this->view->render('footer');
            #destruimos la variable
            unset($_SESSION['forgotCliente']);
        } else {
            #redireccionamos a la pagina principal
            header('Location: ' . URL);
        }
    }

    public function cambiar_pass() {
        $helper = new Helper();
        $data = array();
        $data['id'] = (int) $_POST['contrasena']['id_cliente'];
        $data['pass1'] = $helper->cleanInput($_POST['contrasena']['pass1']);
        $data['pass2'] = $helper->cleanInput($_POST['contrasena']['pass2']);
        #verificamos que las contraseñas coincidan
        if ($data['pass1'] == $data['pass2']) {
            #realizamos el update de la tabla clientes
            $this->model->updateClientPass($data['id'], $data['pass1']);
            Session::set('message', array(
                'type' => 'success',
                'mensaje' => 'Su contraseña ha sido actualizada con éxito'));
            #cargamos la vista
            $this->view->render('header');
            $this->view->render('login/index');
            $this->view->render('footer');
            unset($_SESSION['message']);
        } else {
            #cargamos el mensaje de error
            Session::set('message', array(
                'type' => 'error',
                'mensaje' => 'Las contraseñas ingresadas no coinciden, por favor vuelva a ingresarlas.'));
            #volvemos a enviar el id del cliente
            Session::set('forgotCliente', array(
                'id_cliente' => $data['id']
            ));
            #cargamos la vista
            $this->view->render('header');
            $this->view->render('login/cambiar');
            $this->view->render('footer');
            #destruimos las variables de session
            unset($_SESSION['message']);
            unset($_SESSION['forgotCliente']);
        }
    }

}
