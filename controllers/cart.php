<?php

class Cart extends Controller {

    function __construct() {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    public function agregar() {
        $helper = new Helper();
        $url = $_GET['url'];
        $url = explode('/', $url);
        $url = array_pop($url);
        $id = (int) $url;
        $cantidad = 1;
        if (isset($_POST['qty'])) {
            $qty = $_POST['qty'];
            if ($qty > 0)
                $cantidad = $qty;
        }
        #obtenemos los datos del producto para agregarlos al carrito
        $datos = $this->db->select("SELECT id, precio, precio_oferta, nombre, id_moneda, imagen from producto where id = $id");

        $this->model->agregar($datos[0], $cantidad);
    }

    public function eliminar() {
        $url = $_GET['url'];
        $url = explode('/', $url);
        $url = array_pop($url);
        $unique_id = $url;
        #eliminamos el producto del carrito
        $this->model->eliminar($unique_id);
    }

    public function carrito_resumen() {
        require_once FB_SDK . 'fb-connect.php';

        $this->view->render('header');
        $this->view->render('carrito/index');
        $this->view->render('footer');

        unset($_SESSION['message']);
    }

    public function borrarCarrito() {
        $this->model->borrarCarrito();
    }

    public function carrito_comprar() {
        if (!empty($_SESSION['cliente'])) {
            $this->view->getAdrressClient = $this->model->getAdrressClient($_SESSION['cliente']['id']);
        } else {
            require_once FB_SDK . 'fb-connect.php';
        }

        $this->view->suPedido = $this->model->suPedido();

        $this->view->render('header');
        $this->view->render('carrito/comprar');
        $this->view->render('footer');


        unset($_SESSION['message']);
    }

    public function carrito_paso2() {
        //$id_direccion_cliente = (int) $_POST['id_direccion_cliente'];
        #obtenemos la ultima cotizacion del dia
        $cotizacion = $this->db->select("select id from cotizacion_moneda ORDER BY id desc limit 1;");
        // if ($id_direccion_cliente > 0) {
        #creamos la session del carrito
        #Si la session del cliente no esta iniciada hacemos que se loguee
        if (!empty($_SESSION['cliente']['id'])) {
            Session::set('checkout', array(
                'id_cliente' => $_SESSION['cliente']['id'],
                //'id_direccion_cliente' => $id_direccion_cliente,
                'id_cotizacion_moneda' => $cotizacion[0]['id'],
                'forma_pago' => '',
                'monto_envio' => 0,
                'monto_pedido' => 0,
                'monto_descuento' => 0,
                'observacion_pedido' => '',
                'paso1' => true,
                'paso2' => false,
                'paso3' => false));

            $this->view->getPaymentsMethods = $this->model->getPaymentsMethods();
            $this->view->suPedido = $this->model->suPedido();
            #cargamos js y css exclusivos de la vista
            //CSS
            $this->view->css = array('carrito/css/progress_style.css');
            //JS
            $this->view->js = array('carrito/js/jquery.form.min.js', 'carrito/js/upload_progress.js');

            #mostramos la vista
            $this->view->render('header');
            $this->view->render('carrito/paso-2');
            $this->view->render('footer');
        } else {
            #redireccionamos al paso 1 (seleccionar direccion
            header('Location: ' . URL . 'login/');
        }
//        } else {
//            #redireccionamos al paso 1 (seleccionar direccion
//            header('Location: ' . URL . 'cart/carrito_comprar/');
//        }
    }

    public function carrito_paso3() {
        $forma_pago = (int) $_POST['forma_pago'];
        if ($forma_pago > 0) {
            $_SESSION['checkout']['forma_pago'] = $forma_pago;
            $_SESSION['checkout']['paso2'] = true;

            #resumen de los productos
            $this->view->loadCartReview = $this->model->loadCartReview();
            #sub total
            $this->view->getSubTotal = $this->model->getSubTotal();
            $_SESSION['checkout']['monto_pedido'] = $this->model->getSubTotal();
            #costo de envio
            //$this->view->getCostoEnvio = $this->model->getCostoEnvio();
            //$_SESSION['checkout']['monto_envio'] = $this->model->getCostoEnvio();
            #sumamos el costo de envio al carrito
            $_SESSION['carrito']['precio_total'] = $_SESSION['carrito']['precio_total']; // + $this->model->getCostoEnvio();

            /*
             * mostramos la vista solamente si es diferente al metodo de pago5
             * si es igual a 5 el metodo de pago el archivo upload_progress.js
             * se encarga de la redireccion
             */
            if ($_SESSION['checkout']['forma_pago'] == 5) {
                #subimos la imagen a ser tasada
                $uploadfile = $_FILES["upload_file"]["tmp_name"];
                $folder = IMAGE_CANJE;
                move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder . $_FILES["upload_file"]["name"]);
                $_SESSION['checkout']['img_canje'] = $_FILES["upload_file"]["name"];
            }
            #resumen pedido
            $this->view->suPedido = $this->model->suPedido();

            #mostramos la vista
            $this->view->render('header');
            $this->view->render('carrito/resumen_compra');
            $this->view->render('footer');
        } else {
            #redireccionamos al paso 1 (seleccionar direccion
            header('Location: ' . URL . 'cart/carrito_paso2/');
        }
    }

    public function carrito_canje() {
        $_SESSION['checkout']['paso2'] = true;

        #resumen de los productos
        $this->view->loadCartReview = $this->model->loadCartReview();
        #sub total
        $this->view->getSubTotal = $this->model->getSubTotal();
        $_SESSION['checkout']['monto_pedido'] = $this->model->getSubTotal();
        #costo de envio
        $this->view->getCostoEnvio = $this->model->getCostoEnvio();
        $_SESSION['checkout']['monto_envio'] = $this->model->getCostoEnvio();

        #sumamos el costo de envio al carrito
        $_SESSION['carrito']['precio_total'] = $_SESSION['carrito']['precio_total'] + $this->model->getCostoEnvio();
        #resumen pedido
        $this->view->suPedido = $this->model->suPedido();

        #mostramos la vista
        $this->view->render('header');
        $this->view->render('carrito/resumen_compra');
        $this->view->render('footer');
    }

    public function confirmar_compra() {
        $helper = new Helper();
        $formaPago = '';
        if (!empty($_SESSION['checkout']['forma_pago']))
            $formaPago = $_SESSION['checkout']['forma_pago'];
        #observaciones del pedido
        $observacion_pedido = (!empty($_POST['observacion_pedido'])) ? $helper->cleanInput($_POST['observacion_pedido']) : '';
        $_SESSION['checkout']['observacion_pedido'] = $observacion_pedido;
        #titulo
        $this->view->titleh2 = 'Gracias por su compra';
        #Insertamos los datos de la compra en la BD
        $this->model->insertCompra();
        #Mostramos el mensaje
        $this->view->message = $helper->messageAlert('success', 'Muchas Gracias por su compra, en breve le estaremos enviando un correo electrónico con la confirmación de su compra. Si no recibe ningún correo verifique su casilla de SPAM.');
        #enviamos el mail de confirmacion
        $destinatario = $_SESSION['cliente']['email'];
        $asunto = 'Gracias por su Compra';
        $destinatarioNombre = $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido'];
        $helper->sendMail($destinatario, $asunto, 'compra[finalizada]', '', $destinatarioNombre);
        $destinatarios = $helper->getEmailsAdmin('COMPRA');
        $asuntoAdmin = 'Nueva compra desde el sitio web';
        $destinatarioAdmin = 'SaleoSale Web';
        $helper->sendMail($destinatarios, $asuntoAdmin, 'compra[admin]', '', $destinatarioAdmin);

        #destruimos las sessiones del carrito y del checkout
        unset($_SESSION['carrito']);
        unset($_SESSION['checkout']);

        #mostramos la vista
        $this->view->render('header');
        $this->view->render('carrito/compra_finalizada');
        $this->view->render('footer');
    }

}
