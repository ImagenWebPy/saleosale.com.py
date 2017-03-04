<?php

class Admin extends Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * VISTAS
     */

    public function index() {
        #Autenticacion
        Auth::handleLoginAdmin();
        #items del dashboard
        $this->view->cantProductos = $this->model->cantProductos();
        $this->view->cantVentas = $this->model->cantVentas();
        $this->view->cantClientes = $this->model->cantClientes();
        $this->view->ultimasOrdenes = $this->model->ultimasOrdenes();
        $this->view->ultimosProductos = $this->model->ultimosProductos();

        $this->view->render('admin/header');
        $this->view->render('admin/dashboard/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function login() {
        //echo Hash::create('sha256', 'adminpass2016', HASH_PASSWORD_KEY);

        $this->view->render('admin/login/header');
        $this->view->render('admin/login/index');
        $this->view->render('admin/login/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function productos() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $url = $_GET['url'];
        $url = explode('/', $url);
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;

        $busqueda = (!empty($_GET['buscar'])) ? $_GET['buscar'] : '';
        #total de productos a paginar
        $totalProductos = $this->model->totalProductos($busqueda);
        #productos por pagina
        $this->view->productosPaginados = $this->model->productosPaginados($totalProductos, $pagina, $busqueda);
        #paginacion
        $this->view->paginacion = $this->model->paginacion($pagina, $totalProductos);

        $this->view->render('admin/header');
        $this->view->render('admin/productos/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function producto() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        $idProducto = $url[2];
        $this->view->getMarca = $this->model->getMarca($idProducto);
        $this->view->getMarcas = $this->model->getMarcas($idProducto);
        $this->view->getDatosProductos = $this->model->getDatosProductos($idProducto);
        $this->view->getCategoriaPadre = $this->model->getCategoriaPadre($idProducto);
        $this->view->getCategoriasPadre = $this->model->getCategoriasPadre($this->view->getCategoriaPadre['id']);
        $this->view->getSubCategoria = $this->model->getSubCategoria($idProducto);
        $this->view->getMoneda = $this->model->getMoneda($idProducto);
        $this->view->getMonedas = $this->model->getMonedas($this->view->getMoneda['id']);
        $this->view->render('admin/header');
        $this->view->render('admin/productos/producto');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function producto_agregar() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getCategoriasPadre = $this->model->getCategoriasPadre();
        $this->view->getMarcas = $this->model->getMarcas();
        $this->view->getMonedas = $this->model->getMonedas();
        $this->view->render('admin/header');
        $this->view->render('admin/productos/producto_agregar');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function clientes() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;
        #total de productos a paginar
        $totalClientes = $this->model->totalClientes();
        #productos por pagina
        $this->view->clientesPaginados = $this->model->clientesPaginados($totalClientes, $pagina);
        #paginacion
        $this->view->clientesPaginacion = $this->model->clientesPaginacion($pagina, $totalClientes);
        $this->view->render('admin/header');
        $this->view->render('admin/clientes/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function cliente() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        $idCliente = $url[2];
        $this->view->getCliente = $this->model->getCliente($idCliente);
        $this->view->getDocumento = $this->model->getDocumento($idCliente);
        $this->view->getDocumentos = $this->model->getDocumentos((!empty($this->getDocumento['id_tipo_documento'])) ? $this->getDocumento['id_tipo_documento'] : '');
        $this->view->render('admin/header');
        $this->view->render('admin/clientes/cliente');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function pedidos() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;
        #total de productos a paginar
        $totalPedidos = $this->model->totalPedidos();
        #productos por pagina
        $this->view->pedidosPaginados = $this->model->pedidosPaginados($totalPedidos, $pagina);
        #paginacion
        $this->view->pedidosPaginacion = $this->model->pedidosPaginacion($pagina, $totalPedidos);
        $this->view->render('admin/header');
        $this->view->render('admin/pedidos/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function pedido() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        $idPedido = $url[2];
        $this->view->getPedido = $this->model->getPedido($idPedido);
        $this->view->getItemsPedido = $this->model->getItemsPedido($this->view->getPedido['detalle']);
        $this->view->external_js = array('https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false');
        $this->view->getEstadoPago = $helper->getEnumOptions('pedido', 'estado_pago');
        $this->view->getEstadoPedido = $helper->getEnumOptions('pedido', 'estado_pedido');
        $this->view->js = array('admin/js/jquery.ui.map.full.min.js');
        $this->view->render('admin/header');
        $this->view->render('admin/pedidos/pedido');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function productos_destacados() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->secciones = $this->model->secciones();
        $this->view->css = array('admin/productos/css/multi-select.css');
        $this->view->js = array('admin/js/destacados.js', 'admin/productos/js/jquery.multi-select.js');
        $this->view->render('admin/header');
        $this->view->render('admin/productos/destacados');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function categorias() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getPadres = $this->model->getPadres();
        $this->view->js = array('admin/categorias/js/index.js');
        $this->view->render('admin/header');
        $this->view->render('admin/categorias/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function costo_envio() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->zonas = $this->model->zonas();
        $this->view->getDepartamentos = $this->model->getDepartamentos();
        $this->view->render('admin/header');
        $this->view->render('admin/gasto_envio/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function slider() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getSlider = $this->model->getBanners(1);
        $this->view->render('admin/header');
        $this->view->render('admin/slider/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function lateral_inicio() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getLaterales = $this->model->getBanners(2);
        $this->view->render('admin/header');
        $this->view->render('admin/lateral_inicio/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function inferior_inicio() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getLaterales = $this->model->getBanners(3);
        $this->view->render('admin/header');
        $this->view->render('admin/inferior_inicio/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function banner_categoria() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getBannersCategorias = $this->model->getBanners(6);
        $this->view->getCategoriasPadres = $this->model->getCategoriasPadre();
        $this->view->render('admin/header');
        $this->view->render('admin/banner_categoria/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function banner_menu() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getBannersCategorias = $this->model->getBanners(8);
        $this->view->getCategoriasPadres = $this->model->getCategoriasPadre();
        $this->view->render('admin/header');
        $this->view->render('admin/banner_menu/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function usuarios() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getUsuarios = $this->model->getUsuarios();
        $this->view->render('admin/header');
        $this->view->render('admin/usuarios/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function cambiar_contrasena() {
        #Autenticacion
        Auth::handleLoginAdmin();

        $this->view->render('admin/header');
        $this->view->render('admin/usuarios/cambiar_contrasena');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function resenas() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;
        #total de productos a paginar
        $totalResenas = $this->model->totalResenas();
        #resenas por pagina
        $this->view->resenasPaginados = $this->model->resenasPaginados($totalResenas, $pagina);
        #paginacion
        $this->view->resenasPaginacion = $this->model->resenasPaginacion($pagina, $totalResenas);

        $this->view->title = "Reseñas";
        $this->view->render('admin/header');
        $this->view->render('admin/resenas/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function subastas() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;

        #total de productos a paginar
        $totalSubasatas = $this->model->totalSubastas();
        #resenas por pagina
        $this->view->subastasPaginados = $this->model->subastasPaginados($totalSubasatas, $pagina);
        #paginacion
        $this->view->subastasPaginacion = $this->model->subastasPaginacion($pagina, $totalSubasatas);

        $this->view->title = 'Subastas';
        $this->view->render('admin/header');
        $this->view->render('admin/subastas/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function solicitudes() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $helper = new Helper();
        $url = $helper->getUrl();
        !empty($url[2]) ? $pagina = $url[2] : $pagina = NULL;

        #total de productos a paginar
        $totalSolicitudes = $this->model->totalSolicitudes();
        #solicitudes por pagina
        $this->view->getSolicitudes = $this->model->getSolicitudes($totalSolicitudes, $pagina);
        #paginacion
        $this->view->solcitudesPaginacion = $this->model->solcitudesPaginacion($pagina, $totalSolicitudes);

        $this->view->title = 'Solicitudes de Crédito';
        $this->view->render('admin/header');
        $this->view->render('admin/solicitudes/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function emails() {
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->getConfigCms = $this->model->getConfigCms();
        $this->view->title = 'Envio de E-mails';
        $this->view->render('admin/header');
        $this->view->render('admin/emails/index');
        $this->view->render('admin/footer');
    }

    /*     * ******************
     * METODOS***********
     * ******************* */

    public function loadSubCategoria() {
        $idPadre = (!empty($_GET['idPadre'])) ? $_GET['idPadre'] : '';
        $datos = $this->model->loadDatosSub($idPadre);
    }

    public function loginForm() {
        $helper = new Helper();
        $data = array(
            'email' => $helper->cleanInput($_POST['login']['email']),
            'password' => $helper->cleanInput($_POST['login']['password']),
            'recordar' => (!empty($_POST['login']['recordar'])) ? $helper->cleanInput($_POST['login']['recordar']) : ''
        );
        #validamos loss datos ingresados
        $this->model->iniciarSession($data);
    }

    public function salir() {
        session_destroy();
        Auth::handleLoginAdmin();
    }

    public function uploadProduct() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        if (!empty($_FILES['upload_file']['name'])) {
            for ($i = 0; $i < count($_FILES['upload_file']['name']); $i++) {
                $uploadfile = $_FILES["upload_file"]["tmp_name"][$i];
                $folder = UPLOAD_IMAGE;
                move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], $folder . $_FILES["upload_file"]["name"][$i]);
            }
            $images = implode('|', $_FILES['upload_file']['name']);
        }
        $data = array(
            'id' => $helper->cleanInput($_POST['producto']['id']),
            'categoria' => $helper->cleanInput($_POST['producto']['categoria']),
            'subcategoria' => $helper->cleanInput($_POST['producto']['subcategoria']),
            'marca' => $helper->cleanInput($_POST['producto']['marca']),
            'nombre' => $helper->cleanInput($_POST['producto']['nombre']),
            'moneda' => $helper->cleanInput($_POST['producto']['moneda']),
            'precio' => $helper->cleanInput($_POST['producto']['precio']),
            'precio_oferta' => $helper->cleanInput($_POST['producto']['precio_oferta']),
            'stock' => $helper->cleanInput($_POST['producto']['stock']),
            'estado' => $helper->cleanInput($_POST['producto']['estado']),
            'descripcion' => $_POST['producto']['descripcion'],
            'contenido' => $_POST['producto']['contenido'],
            'tags' => $helper->cleanInput($_POST['producto']['tags']),
            'nuevo' => $helper->cleanInput($_POST['producto']['nuevo']),
            'codigo' => $helper->cleanInput($_POST['producto']['codigo']),
            'estado' => $helper->cleanInput($_POST['producto']['estado']),
            'imagen' => (!empty($images)) ? $images : '');

        $this->model->saveProduct($data);

        header('Location: ' . $urlAnterior);
    }

    public function addProduct() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        if (!empty($_FILES['upload_file']['name'])) {
            for ($i = 0; $i < count($_FILES['upload_file']['name']); $i++) {
                $uploadfile = $_FILES["upload_file"]["tmp_name"][$i];
                $folder = UPLOAD_IMAGE;
                move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], $folder . $_FILES["upload_file"]["name"][$i]);
            }
            $images = implode('|', $_FILES['upload_file']['name']);
        }
        $data = array(
            'categoria' => $helper->cleanInput($_POST['producto']['categoria']),
            'subcategoria' => $helper->cleanInput($_POST['producto']['subcategoria']),
            'marca' => $helper->cleanInput($_POST['producto']['marca']),
            'nombre' => $helper->cleanInput($_POST['producto']['nombre']),
            'moneda' => $helper->cleanInput($_POST['producto']['moneda']),
            'precio' => $helper->cleanInput($_POST['producto']['precio']),
            'precio_oferta' => $helper->cleanInput($_POST['producto']['precio_oferta']),
            'stock' => $helper->cleanInput($_POST['producto']['stock']),
            'estado' => $helper->cleanInput($_POST['producto']['estado']),
            'descripcion' => $_POST['producto']['descripcion'],
            'contenido' => $_POST['producto']['contenido'],
            'tags' => $helper->cleanInput($_POST['producto']['tags']),
            'nuevo' => $helper->cleanInput($_POST['producto']['nuevo']),
            'codigo' => $helper->cleanInput($_POST['producto']['codigo']),
            'estado' => $helper->cleanInput($_POST['producto']['estado']),
            'imagen' => (!empty($images)) ? $images : '');

        $this->model->addProduct($data);

        header('Location: ' . $urlAnterior);
    }

    public function loadProductosSeccion() {
        $idSeccion = (int) $_POST['seccion'];
        $data = '';
        if ($idSeccion > 0) {
            $data = $this->model->getTableSeccion($idSeccion);
        }
        echo $data;
    }

    public function guardarDestacados() {
        $productos = $_POST['my-select'];
        $id_seccion = $_POST['id_seccion'];
        $seleccionados = array();
        $orden = 1;
        foreach ($productos as $item) {
            array_push($seleccionados, array('id_producto' => $item, 'orden' => $orden));
            $orden ++;
        }
        $this->model->modificarSeleccionados($id_seccion, $seleccionados);
        #Autenticacion
        Auth::handleLoginAdmin();
        $this->view->secciones = $this->model->secciones();
        $this->view->css = array('admin/productos/css/multi-select.css');
        $this->view->js = array('admin/js/destacados.js', 'admin/productos/js/jquery.multi-select.js');
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Los productos se han modificado correctamente'));
        $this->view->render('admin/header');
        $this->view->render('admin/productos/destacados');
        $this->view->render('admin/footer');
        unset($_SESSION['message']);
    }

    public function modificarEstadoPedido() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $idPedido = $helper->cleanInput($_POST['pedido']['id']);
        $estado = $helper->cleanInput($_POST['pedido']['estado_pedido']);
        $data = array(
            'id' => $idPedido,
            'estado_pedido' => $estado
        );
        $this->model->updateEstadoPedido($data);
        $cliente = $this->model->getDatosClientePedido($idPedido);
        $asunto = 'Hola ' . $cliente['cliente'] . ', el estado de uno de tus pedidos ha cambiado';
        $datos = array(
            'id_pedido' => $idPedido,
            'cliente' => $cliente['cliente'],
            'estado' => $estado
        );
        $helper->sendMail($cliente['email'], $asunto, 'pedido[cambioEstado]', $datos, $cliente['cliente']);
        header('Location: ' . $urlAnterior);
    }

    public function modificarEstadoPago() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $idPedido = $helper->cleanInput($_POST['pedido']['id']);
        $estado = $helper->cleanInput($_POST['pedido']['estado_pago']);
        $data = array(
            'id' => $idPedido,
            'estado_pago' => $estado
        );
        $this->model->updateEstadoPago($data);
        #enviamos el email
        $cliente = $this->model->getDatosClientePedido($idPedido);
        $asunto = 'Hola ' . $cliente['cliente'] . ', el estado del pago de uno de tus pedidos ha cambiado';
        $datos = array(
            'id_pedido' => $idPedido,
            'cliente' => $cliente['cliente'],
            'estado' => $estado
        );
        $helper->sendMail($cliente['email'], $asunto, 'pedido[cambioEstadoPago]', $datos, $cliente['cliente']);
        header('Location: ' . $urlAnterior);
    }

    public function loadHijos() {
        $idPadre = (int) $_POST['padre'];
        $data = '';
        if ($idPadre > 0) {
            $data = $this->model->getSectionHijos($idPadre);
        }
        echo $data;
    }

    public function modificarHijo() {
        $helper = new Helper();
        if (!empty($_POST['id'])) {
            $datos = array(
                'descripcion' => $helper->cleanInput($_POST['descripcion']),
                'url_rewrite' => $helper->cleanInput($_POST['url_rewrite']),
                'id' => $helper->cleanInput($_POST['id'])
            );
        } else {
            $datos = array(
                'descripcion' => $helper->cleanInput($_POST['descripcion']),
                'url_rewrite' => $helper->cleanInput($_POST['url_rewrite']),
                'padre_id' => $helper->cleanInput($_POST['padre_id'])
            );
        }
        $data = $this->model->guardarHijo($datos);
        echo $data;
    }

    public function eliminarHijo() {
        $helper = new Helper();
        $id = $helper->cleanInput($_POST['id']);
        $result = $this->model->eliminarHijo($id);
        echo $result;
    }

    public function modificarZona() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $datos = array(
            'descripcion' => $helper->cleanInput($_POST['txtDescripcion']),
            'costo' => $helper->cleanInput($_POST['txtCosto']),
            'id' => $helper->cleanInput($_POST['id'])
        );
        $data = $this->model->modificarZona($datos);
        header('Location: ' . $urlAnterior);
    }

    public function saveCity() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $datos = array(
            'id_ciudad' => $helper->cleanInput($_POST['ciudades']),
            'id_zona' => $helper->cleanInput($_POST['zona'])
        );
        $this->model->saveCity($datos);
        header('Location: ' . $urlAnterior);
    }

    public function delCity() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $id_ciudad = $helper->cleanInput($_POST['id_ciudad']);
        $this->model->delCity($id_ciudad);
        header('Location: ' . $urlAnterior);
    }

    public function editarSlider() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'texto_1' => $helper->cleanInput($_POST['texto_1']),
            'texto_2' => $helper->cleanInput($_POST['texto_2']),
            'texto_3' => $helper->cleanInput($_POST['texto_3']),
            'texto_enlace' => $helper->cleanInput($_POST['texto_enlace']),
            'orden' => $helper->cleanInput($_POST['orden']),
            'enlace' => $helper->cleanInput($_POST['enlace']),
            'imagen' => $imagen
        );
        $this->model->editarSlider($datos);
        header('Location: ' . $urlAnterior);
    }

    public function agregarSlider() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'texto_1' => $helper->cleanInput(utf8_encode($_POST['texto_1'])),
            'texto_2' => $helper->cleanInput(utf8_encode($_POST['texto_2'])),
            'texto_3' => $helper->cleanInput(utf8_encode($_POST['texto_3'])),
            'texto_enlace' => $helper->cleanInput(utf8_encode($_POST['texto_enlace'])),
            'orden' => $helper->cleanInput($_POST['orden']),
            'enlace' => $helper->cleanInput(utf8_encode($_POST['enlace'])),
            'imagen' => $imagen
        );
        $this->model->agregarSlider($datos);
        header('Location: ' . $urlAnterior);
    }

    public function editarLateral() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'enlace' => $helper->cleanInput($_POST['enlace']),
            'orden' => $helper->cleanInput($_POST['orden']),
            'imagen' => $imagen
        );
        $this->model->editarLateral($datos);
        header('Location: ' . $urlAnterior);
    }

    public function editarInferior() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'enlace' => $helper->cleanInput($_POST['enlace']),
            'orden' => $helper->cleanInput($_POST['orden']),
            'imagen' => $imagen
        );
        $this->model->editarInferior($datos);
        header('Location: ' . $urlAnterior);
    }

    public function eliminarSlider() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $id = $helper->cleanInput($_POST['id']);
        $this->model->eliminarSlider($id);
        header('Location: ' . $urlAnterior);
    }

    public function editarBannerCategoria() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD_CATEGORIAS;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'id_categoria' => $helper->cleanInput($_POST['id_categoria']),
            'orden' => $helper->cleanInput($_POST['orden']),
            'estado' => (!empty($_POST['estado'])) ? $helper->cleanInput($_POST['estado']) : 0,
            'enlace' => $helper->cleanInput($_POST['enlace']),
            'imagen' => $imagen
        );
        $this->model->editarBannerCategoria($datos);
        header('Location: ' . $urlAnterior);
    }

    public function agregarCategoriaSlider() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD_CATEGORIAS;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'id_categoria' => $helper->cleanInput($_POST['id_categoria']),
            'orden' => $helper->cleanInput($_POST['orden']),
            'estado' => (!empty($_POST['estado'])) ? $helper->cleanInput($_POST['estado']) : 0,
            'enlace' => $helper->cleanInput($_POST['enlace']),
            'imagen' => $imagen
        );
        $this->model->agregarBannerCategoria($datos);
        header('Location: ' . $urlAnterior);
    }

    public function agregarBannerMenu() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $imagen = '';
        if (!empty($_FILES['imagen']['name'])) {
            $uploadfile = $_FILES["imagen"]["tmp_name"];
            $folder = UPLOAD_CATEGORIAS;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $folder . $_FILES["imagen"]["name"]);
            $imagen = $_FILES['imagen']['name'];
        }
        $datos = array(
            'id_categoria' => $helper->cleanInput($_POST['id_categoria']),
            'orden' => $helper->cleanInput($_POST['orden']),
            'estado' => (!empty($_POST['estado'])) ? $helper->cleanInput($_POST['estado']) : 0,
            'estado_menu' => 1,
            'enlace' => $helper->cleanInput($_POST['enlace']),
            'imagen' => $imagen
        );
        $this->model->agregarMenuBanner($datos);
        header('Location: ' . $urlAnterior);
    }

    public function eliminarCategoriaSlider() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $id = $helper->cleanInput($_POST['id']);
        $this->model->eliminarCategoriaSlider($id);
        header('Location: ' . $urlAnterior);
    }

    public function agregarUsuario() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $pass1 = $helper->cleanInput($_POST['contrasena']);
        $pass2 = $helper->cleanInput($_POST['contrasena2']);
        if ($pass1 == $pass2) {
            $email = $_POST['email'];
            $existe = $this->model->verificaEmail($email);
            if ($existe == false) {
                $datos = array(
                    'nombre' => $helper->cleanInput($_POST['nombre']),
                    'email' => $email,
                    'nivel' => $helper->cleanInput($_POST['nivel']),
                    'contrasena' => $helper->cleanInput($_POST['contrasena'])
                );
                $this->model->agregarUsuario($datos);
            } else {
                Session::set('message', array(
                    'type' => 'warning',
                    'mensaje' => 'El email ingresado ya existe, por favor ingrese otro'));
            }
        } else {
            Session::set('message', array(
                'type' => 'danger',
                'mensaje' => 'Las contraseñas deben de coincidir'));
        }
        header('Location: ' . $urlAnterior);
    }

    public function modificarUsuario() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $pass1 = $helper->cleanInput($_POST['contrasena']);
        $pass2 = $helper->cleanInput($_POST['contrasena2']);
        if ((!empty($pass1)) && (!empty($pass2))) {
            if ($pass1 == $pass2) {
                $datos = array(
                    'id' => $helper->cleanInput($_POST['id']),
                    'nombre' => $helper->cleanInput($_POST['nombre']),
                    'nivel' => $helper->cleanInput($_POST['nivel']),
                    'contrasena' => Hash::create('sha256', $helper->cleanInput($_POST['contrasena']), HASH_PASSWORD_KEY)
                );
                $this->model->editarUsuario($datos);
            } else {
                Session::set('message', array(
                    'type' => 'danger',
                    'mensaje' => 'Las contraseñas deben de coincidir'));
            }
        } else {
            $datos = array(
                'id' => $helper->cleanInput($_POST['id']),
                'nombre' => $helper->cleanInput($_POST['nombre']),
                'nivel' => $helper->cleanInput($_POST['nivel'])
            );
            $this->model->editarUsuario($datos);
        }
        header('Location: ' . $urlAnterior);
    }

    public function eliminarUsuario() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $id = $helper->cleanInput($_POST['id']);
        $this->model->eliminarUsuario($id);
        header('Location: ' . $urlAnterior);
    }

    public function eliminarImagenProducto() {
        $helper = new Helper();
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'imagen' => $helper->cleanInput($_POST['imagen']),
            'posicion' => $helper->cleanInput($_POST['posicion'])
        );
        $data = $this->model->eliminarImagenProducto($datos);
        echo $data;
    }

    public function eliminarImagenSubasta() {
        $helper = new Helper();
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'imagen' => $helper->cleanInput($_POST['imagen']),
            'posicion' => $helper->cleanInput($_POST['posicion'])
        );
        $data = $this->model->eliminarImagenSubasta($datos);
        echo $data;
    }

    public function cambiarUserPass() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'contrasena' => Hash::create('sha256', $helper->cleanInput($_POST['contrasena']), HASH_PASSWORD_KEY)
        );
        $this->model->cambiarUserPass($datos);
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'La contraseña ha sido cambiada satisfactoriamente'));
        header('Location: ' . $urlAnterior);
    }

    public function modificarResena() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $datos = array(
            'id' => $helper->cleanInput($_POST['resena']['id']),
            'aprobado' => $helper->cleanInput($_POST['resena']['estado'])
        );
        $this->model->modificarResena($datos);
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Se ha modificado correctamente la reseña'));
        header('Location: ' . $urlAnterior);
    }

    public function modificarSubasta() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $idSubasta = $helper->cleanInput($_POST['subasta']['id']);
        $estado = $helper->cleanInput($_POST['subasta']['estado']);
        if (!empty($_FILES['upload_file']['name'])) {
            for ($i = 0; $i < count($_FILES['upload_file']['name']); $i++) {
                $uploadfile = $_FILES["upload_file"]["tmp_name"][$i];
                $folder = UPLOAD_SUBASTA;
                move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], $folder . $_FILES["upload_file"]["name"][$i]);
            }
            $images = implode('|', $_FILES['upload_file']['name']);
        }
        $data = array(
            'id' => $idSubasta,
            'categoria' => $helper->cleanInput($_POST['subasta']['marca']),
            'nombre' => $helper->cleanInput($_POST['subasta']['nombre']),
            'estado' => $estado,
            'descripcion_corta' => $helper->cleanInput($_POST['subasta']['descripcion_corta']),
            'contenido' => $helper->cleanInput($_POST['subasta']['contenido']),
            'imagen' => (!empty($images)) ? $images : ''
        );
        $this->model->modificarSubasta($data);
        $idCliente = $this->model->getSubastaCliente($idSubasta);
        $cliente = $this->model->getCliente($idCliente);
        $nombreCliente = $cliente['nombre'] . ' ' . $cliente['apellido'];
        $emailCliente = $cliente['email'];
        $datosSubasta = array(
            'id' => $idSubasta,
            'estado' =>$estado,
            'cliente' => $nombreCliente);
        $asunto = "Hola $nombreCliente, tu subasta ha cambiado de estado";
        $helper->sendMail($emailCliente, $asunto, 'subasta[cambioEstadoPago]', $datosSubasta, $nombreCliente);
        header('Location: ' . $urlAnterior);
    }

    public function editarConfig() {
        $helper = new Helper();
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'valor' => $helper->cleanInput($_POST['valor'])
        );
        $result = $this->model->editarConfig($datos);
        echo true;
    }

}
