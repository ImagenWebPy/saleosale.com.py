<?php

class Producto extends Controller {

    function __construct() {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $this->view->js = array('producto/js/cloud-zoom.js', 'producto/js/jquery.flexslider.js');
    }

    public function item($idProducto) {
        $producto = explode('-', $idProducto);
        $id = array_pop($producto);
        $result = $this->db->select('SELECT * FROM producto where id = :id', array(':id' => $id));
        $marca = $this->db->select('SELECT descripcion FROM marca where id = :id', array(':id' => $result[0]['id_marca']));

        $this->view->title = utf8_encode($marca[0]['descripcion']) . ' - ' . utf8_encode($result[0]['nombre']);

        #listamos los productos de la categoria seleccionada
        $this->view->producto = $this->model->getProducto($result[0]);
        #productos realacionados e excluimos el producto que se esta mostrando
        $this->view->relacionados = $this->model->getProductos($result[0]['id_categoria'], $result[0]['id']);
        #Buscamos los banner que puedan tener los productos
        $flag = 1;
        $estado = 1;
        $banner = $this->db->select("SELECT * FROM banner WHERE producto = :producto and estado = :estado", array(':producto' => $flag, ':estado' => 1));
        if (!empty($banner[0]['id_posicion']))
            $idPosicion = $banner[0]['id_posicion'];
        if (!empty($banner[0]['id_categoria']))
            $idCategoria = $banner[0]['id_categoria'];
        #si la categoria no esta nula
        if ((!empty($idCategoria))) {
            //$catsProductos = $this->db->select("SELECT c.id FROM categoria c LEFT OUTER JOIN (SELECT padre_id FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id= :padre_id ", array(':padre_id' => $idCategoria));
            $catsProductos = $this->db->select("SELECT c.id FROM categoria c where c.id = :padre_id ", array(':padre_id' => $idCategoria));
            #verificamos si existe la categoria
            $clave = false;
            foreach ($catsProductos as $cats) {
                if ($cats['id'] == $result[0]['id_categoria'])
                    $clave = true;
            }
            #verificamos que la categoria coincida con el producto actual
            if ($clave == TRUE) {
                #cargamos los banners de publicidad relacionados al producto o a la categoria
                $this->view->publicidadProducto = $this->model->getPublicidadProducto($idPosicion, $idCategoria, $id);
            }
        }

        #comparit en las redes
        $this->view->share = $this->model->share();
        #valoracion de usuarios
        $this->view->getResenas = $this->model->getResenas($id);
        $this->view->verificaComentario = $this->model->verificaComentario($id);
        #formas de pago
        $this->view->formasdePago = $this->model->formasdePago();
        //$this->view->js = array('producto/js/calcular_cuota.js');

        $this->view->public_folderHeader = array("pluggins/jquery.countdown/css/main.css");
        $this->view->pluggins_js = array("jquery.countdown/js/lodash.min.js", "jquery.countdown/js/jquery.countdown.js");
        $this->view->render('header');
        $this->view->render('producto/item');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function categoria($idCategoria) {
        $categoria = explode('-', $idCategoria);
        $id = array_pop($categoria);
        $result = $this->db->select('SELECT id,descripcion, padre_id FROM categoria where id = :id', array(':id' => $id));

        $this->view->mostrarBanner = $this->model->mostrarBanner(6, $result[0]['id']);
        //preguntamos si la categoria es padre
        if ($result[0]['padre_id'] == 0) {
            //obtenemos todos los hijos del padre para pasarle como parametro
            $padre_id = $result[0]['id'];
            $hijos = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite FROM categoria c LEFT OUTER JOIN (SELECT padre_id FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id= :padre_id ORDER BY c.orden ASC", array(':padre_id' => $padre_id));
            $idCategoria = array();
            $nombresCategoria = array();
            foreach ($hijos as $item) {
                array_push($idCategoria, $item['id']);
                array_push($nombresCategoria, array('id' => $item['id'], 'descripcion' => $item['descripcion'], 'url_rewrite' => $item['url_rewrite']));
            }
            $idCategoria = implode(',', $idCategoria);
            #mostramos las categorias relacioanadas al padre
            if (!empty($nombresCategoria)) {
                $this->view->categoriasHijas = $this->model->getCategoriasHijas($result[0]['id'], $nombresCategoria);
            } else {
                $this->view->categoriasHijas = null;
            }
        } else {
            //solo pasamos la categoria hijo
            $idCategoria = $result[0]['id'];
            $this->view->categoriasHijas = $this->model->getCategoriasHijas($result[0]['id']);
        }

        //preguntamos por los parametros de la url
        $url = $_GET['url'];
        $url = explode('/', $url);
        !empty($url[3]) ? $pagina = $url[3] : $pagina = NULL;
        //items
        $this->view->paginacion = $this->model->getItemsPaginacion($id, $pagina);
        //$this->view->paginacion = $this->model->getItemsPaginacion($idCategoria, $pagina);
        //paginacion
        $this->view->paginas = $this->model->getPaginas($idCategoria, $url[2], $pagina);

        $this->view->categoria = utf8_encode($result[0]['descripcion']);
        $this->view->title = utf8_encode($result[0]['descripcion']);

        $this->view->render('header');
        $this->view->render('producto/categoria');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function busqueda() {
        #obtenemos la pagina
        $url = $_GET['url'];
        $url = explode('/', $url);
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;
        $queryString = $_SERVER['QUERY_STRING'];
        $queryString = explode('/', $queryString);
        $queryString = array_pop($queryString);
        $queryString = substr_replace($queryString, '?', 0, 1);
        #asignamos los parametros pasados por GET
        if (!empty($_GET['category_id'])) {
            $id_categoria = $_GET['category_id'];
            #obtenemos las categorias hijas
            $hijas = $this->db->select("SELECT c.id FROM categoria c LEFT OUTER JOIN (SELECT padre_id FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id = :padre_id", array(':padre_id' => $id_categoria));
            $cats = array();
            foreach ($hijas as $item) {
                array_push($cats, $item['id']);
            }
            $categorias = implode(',', $cats);
        } else {
            $categorias = 0;
        }
        $busqueda = $_GET['search'];
        #mostramos la paginacion
        $this->view->paginas = $this->model->getPaginas($categorias, $url[1], $pagina, $busqueda, $queryString);
        #mostramos los resultados de una busqueda
        $this->view->searchResult = $this->model->getBusqueda($pagina, $categorias, $busqueda);

        #Mostramos la pagina de busqueda
        $this->view->render('header');
        $this->view->render('producto/busqueda');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function agregar_resena() {
        $helper = new Helper();
        $id_cliente = $_SESSION['cliente']['id'];
        $fecha = date('Y-m-d H:i:s');
        $data = array(
            'id_cliente' => $id_cliente,
            'id_producto' => $helper->cleanInput($_POST['resena']['id_producto']),
            'valorizacion' => $helper->cleanInput($_POST['resena']['rating']),
            'opinion' => utf8_decode($helper->cleanInput($_POST['resena']['resena'])),
            'fecha_valorizacion' => $fecha,
            'titulo' => utf8_decode($helper->cleanInput($_POST['resena']['titulo'])),
            'aprobado' => 0
        );
        #guardamos el comentario
        $this->model->agregar_comentario($data);

        #mostramos el mensaje de fue creado satisfactoriamente el comentario
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Tu comentario ha sido creado satisfactoriamente. Una vez aprobado será publicado'));

        #redireccionamos a la url desde la cual fue llamada el metodo
        header('location: ' . $helper->getUrlAnterior());
    }

    public function financiar() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $email = $_POST['financiacion']['email'];
        $destinatarioNombre = $helper->cleanInput($_POST['financiacion']['nombre']);
        $datos = array(
            'nombre' => $destinatarioNombre,
            'email' => $email,
            'telefono' => $helper->cleanInput($_POST['financiacion']['telefono']),
            'cuotas' => $helper->cleanInput($_POST['financiacion']['cuotas']),
            'cantidad' => $helper->cleanInput($_POST['financiacion']['cantidad']),
            'monto_cuota' => $helper->cleanInput($_POST['financiacion']['monto_cuota']),
            'id_producto' => $helper->cleanInput($_POST['financiacion']['id_producto']),
        );
        $this->model->solicitud($datos);
        $asunto = 'Solicitud de Crédito';
        $helper->sendMail($email, $asunto, 'solicitud[financiacion]', $datos, $destinatarioNombre);
        #enviamos la solicitud al admin
        $adminEmails = $helper->getEmailsAdmin('SOLICITUDES');
        $adminAsunto = 'Nueva solictud de financiacion desde el sitio web';
        $destinatarioAdmin = 'SaleoSale Web';
        $helper->sendMail($adminEmails, $adminAsunto, 'solicitud[admin]', $datos, $destinatarioAdmin);
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Su solicitud ha sido enviada con éxito, en breve un asesor comercial se estará comunicando contigo. '));
        header('Location: ' . $urlAnterior);
    }

    public function liveVideo() {
        header('Content-type: application/json; charset=utf-8');
        #LIVE VIDEO
        $live = $this->model->liveVideo();
        echo json_encode($live);
    }

}
