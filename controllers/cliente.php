<?php

class Cliente extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    public function dashboard() {
        $helper = new Helper();
        #cargamos informaciones del cliente
        $this->view->getRecentOrdes = $this->model->getRecentOrdes();
        #Direccion Principal
        $this->view->getMainDirection = $this->model->getMainDirection();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #titulo
        $this->view->title = "Mi Cuenta";
        #Cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/dashboard');
        $this->view->render('footer');
    }

    public function direcciones() {
        $helper = new Helper();
        #cargamos informaciones del cliente
        $this->view->getAllDirections = $this->model->getAllDirections();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #titulo
        $this->view->title = "Mis Direcciones";
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/direccion');
        $this->view->render('footer');
    }

    public function agregarDireccion() {
        $helper = new Helper();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #extra js
        $this->view->js = array('cliente/js/map.js', 'cliente/js/direccion_add.js');

        #funciones para la vista
        $this->view->loadDepartamentos = $this->model->loadDepartamentos();

        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/direccion_agregar');
        $this->view->render('footer');
    }

    public function getCities() {
        $this->model->getCities();
    }

    public function frmAddDirection() {
        $helper = new Helper();
        #asignamos los valores obtenidos del formulario
        $data = array();
        $data['id_departamento'] = $helper->cleanInput($_POST['direccion']['id_departamento']);
        $data['id_ciudad'] = $helper->cleanInput($_POST['direccion']['id_ciudad']);
        $data['barrio'] = $helper->cleanInput($_POST['direccion']['barrio']);
        $data['calle_principal'] = $helper->cleanInput($_POST['direccion']['calle_principal']);
        $data['calle_lateral1'] = $helper->cleanInput($_POST['direccion']['calle_lateral1']);
        $data['telefono'] = $helper->cleanInput($_POST['direccion']['telefono']);
        $data['tipo_vivienda'] = $helper->cleanInput($_POST['direccion']['tipo_vivienda']);
        $data['predeterminada'] = $helper->cleanInput($_POST['direccion']['predeterminada']);
        $data['latitude'] = $helper->cleanInput($_POST['direccion']['latitude']);
        $data['longitude'] = $helper->cleanInput($_POST['direccion']['longitude']);
        $data['id_cliente'] = $helper->cleanInput($_POST['direccion']['id_cliente']);

        #agregamos la direccion
        $this->model->crearDireccion($data);

        #redireccionamos
        header('location: ' . $helper->getUrlAnterior());
    }

    public function cuenta() {
        $helper = new Helper();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #obtenemos los datos del cliente
        $this->model->getClientData($_SESSION['cliente']['id']);
        $this->view->getTiposDocumentos = $this->model->getTiposDocumentos($_SESSION['client_data']['id_tipo_documento']);
        #titulo
        $this->view->title = "Mis Datos";
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/editar_cuenta');
        $this->view->render('footer');
        #destruimos la session creada
        unset($_SESSION['client_data']);
    }

    public function editar_cuenta() {
        $helper = new Helper();
        $data = array();
        $data['id_cliente'] = $helper->cleanInput($_POST['cliente']['id_cliente']);
        $data['nombre'] = $helper->cleanInput($_POST['cliente']['nombre']);
        $data['apellido'] = $helper->cleanInput($_POST['cliente']['apellido']);
        $data['documento_tipo'] = $helper->cleanInput($_POST['cliente']['documento_tipo']);
        $data['documento_nro'] = $helper->cleanInput($_POST['cliente']['documento_nro']);
        $data['telefono'] = $helper->cleanInput($_POST['cliente']['telefono']);
        $data['celular'] = $helper->cleanInput($_POST['cliente']['celular']);
        $data['email'] = $helper->cleanInput($_POST['cliente']['email']);
        $return = $this->model->updateClientData($data);
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Los datos han sido actualizados correctamente'));
        #cargamos la vista
        #cargamos informaciones del cliente
        $this->view->getRecentOrdes = $this->model->getRecentOrdes();
        $this->view->getMainDirection = $this->model->getMainDirection();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #actualizamos la variable de session
        $_SESSION['cliente']['nombre'] = $data['nombre'];
        $_SESSION['cliente']['apellido'] = $data['apellido'];
        $_SESSION['cliente']['email'] = $data['email'];
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/dashboard');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function cambiar_contrasena() {
        $this->view->title = 'Cambiar contraseña';
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/contrasena');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function cambiar_pass() {
        $helper = new Helper();
        $data = array();
        $data['pass1'] = $helper->cleanInput($_POST['contrasena']['pass1']);
        $data['pass2'] = $helper->cleanInput($_POST['contrasena']['pass2']);
        #verificamos que los campos no esten vacios
        if ((!empty($data['pass1'])) || (!empty($data['pass2']))) {
            #verficamos que las contraseñas coincidan
            if ($data['pass1'] == $data['pass2']) {
                $this->model->cambiarPass($data);
                Session::set('message', array(
                    'type' => 'success',
                    'mensaje' => 'La contraseña fue cambiada satisfactoriamente.'));
            } else {
                Session::set('message', array(
                    'type' => 'error',
                    'mensaje' => 'Las contraseñas ingresadas deben ser idénticas'));
            }
        } else {
            Session::set('message', array(
                'type' => 'info',
                'mensaje' => 'Las contraseñas no pueden estar vacías'));
        }
        $this->view->render('header');
        $this->view->render('cliente/contrasena');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function editar_direccion() {
        $helper = new Helper();
        $url = $helper->getUrl();
        $idDireccion = $url[2];
        $this->view->title = 'Modificar Dirección';
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());

        $this->model->datosDireccion($idDireccion);

        #extra js
        $this->view->js = array('cliente/js/map.php', 'cliente/js/direccion_add.js');

        #funciones para la vista
        $this->view->loadDepartamentosEdit = $this->model->loadDepartamentosEdit($idDireccion);
        $this->view->loadSelectedDepartamento = $this->model->loadSelectedDepartamento($idDireccion);
        $this->view->loadSelectedCiudad = $this->model->loadSelectedCiudad($idDireccion);
        $this->view->tipoVivienda = $this->model->tipoVivienda($idDireccion);

        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/direccion_editar');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function frmEditDirection() {
        $helper = new Helper();
        $data = array();
        $data['id_direccion'] = $helper->cleanInput($_POST['direccion']['id']);
        $data['id_departamento'] = $helper->cleanInput($_POST['direccion']['id_departamento']);
        $data['id_ciudad'] = $helper->cleanInput($_POST['direccion']['id_ciudad']);
        $data['barrio'] = $helper->cleanInput($_POST['direccion']['barrio']);
        $data['calle_principal'] = $helper->cleanInput($_POST['direccion']['calle_principal']);
        $data['calle_lateral1'] = $helper->cleanInput($_POST['direccion']['calle_lateral1']);
        $data['telefono'] = $helper->cleanInput($_POST['direccion']['telefono']);
        $data['tipo_vivienda'] = $helper->cleanInput($_POST['direccion']['tipo_vivienda']);
        $data['predeterminada'] = $helper->cleanInput($_POST['direccion']['predeterminada']);
        $data['latitude'] = $helper->cleanInput($_POST['direccion']['latitude']);
        $data['longitude'] = $helper->cleanInput($_POST['direccion']['longitude']);
        $data['id_cliente'] = $helper->cleanInput($_POST['direccion']['id_cliente']);

        #editamos la direccion
        $this->model->editarDireccion($data);

        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Los datos han sido actualizados correctamente'));
        #redireccionamos
        header('location: ' . $helper->getUrlAnterior());
    }

    public function ordenes() {
        $helper = new Helper();
        $url = $helper->getUrl();
        #id
        $idOrden = $url[2];
        $this->view->title = 'Orden Nro. ' . $idOrden;
        #cargamos los datos para la vista
        $this->view->cargarDatosOrden = $this->model->cargarDatosOrden($idOrden);

        #creamos una session
        Session::set('orden', array(
            'id' => $idOrden));
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/ordenes');
        $this->view->render('footer');
        unset($_SESSION['orden']);
    }

    public function compras() {
        $helper = new Helper();
        $this->view->getOrders = $this->model->getOrders();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #titulo
        $this->view->title = "Mis Compras";
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/mis-compras');
        $this->view->render('footer');
    }

    public function newsletter() {
        $helper = new Helper();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #datos de la vista
        $this->view->getSuscripcion = $this->model->getSuscripcion();
        #titulo
        $this->view->title = "Newsletter";
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/newsletter');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function suscripcion() {
        $helper = new Helper();
        $datos = array();
        $datos['existe'] = $_POST['subscripcion']['existe'];
        $datos['email'] = $_POST['subscripcion']['email'];
        $datos['nombre_completo'] = (!empty($_POST['subscripcion']['nombre_completo'])) ? $_POST['subscripcion']['nombre_completo'] : '';
        #de acuerdo a lo enviado agregamos al cliente o cambiamos su estado
        $this->model->verificaNewsletter($datos);
        #datos de la vista
        #redireccionamos
        header('location: ' . $helper->getUrlAnterior());
    }

    public function agregar_lista_deseo() {
        $helper = new Helper();
        $url = $helper->getUrl();
        $idCliente = $url[2];
        $idProducto = $url[3];
        $lista = $this->model->agregarListaDeseo($idCliente, $idProducto);
        if ($lista == true) {
            Session::set('message', array(
                'type' => 'success',
                'mensaje' => 'El producto se ha agregado a su Lista de Deseos'));
        } else {
            Session::set('message', array(
                'type' => 'warning',
                'mensaje' => 'El producto seleccionado ya se encuentra en su Lista de Deseos'));
        }
        #redireccionamos
        header('location: ' . $helper->getUrlAnterior());
    }

    public function lista_deseos() {
        #cargamos la lista
        $this->view->loadLista = $this->model->loadLista();
        #titulo
        $this->view->title = "Mi Lista de Deseos";
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/lista_deseos');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function removerLista() {
        $helper = new Helper();
        #obtenomos los datos a travez de la url
        $url = $helper->getUrl();
        $idCliente = $url[2];
        $idProducto = $url[3];
        #removemos el producto de la lista
        $this->model->removeProductoFromList($idCliente, $idProducto);
        #mostramos mensaje
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'El producto ha sido removido de su Lista de Deseos'));
        #redireccionamos
        header('location: ' . $helper->getUrlAnterior());
    }

    public function subasta() {
        $helper = new Helper();
        $id_cliente = (int) $_SESSION['cliente']['id'];
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #datos para la vista
        $this->view->cargarSubastas = $this->model->cargarSubastas($id_cliente);
        #titulo
        $this->view->title = "Mis Subastas";
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/subasta');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function agregarSubasta() {
        $helper = new Helper();
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #datos para la vista
        $this->view->selectCondicion = $helper->getEnumOptions('subasta', 'condicion');
        #css
        $this->view->public_css = array('bootstrap-datepicker.min.css');
        #js
        $this->view->pluggins_js = array('ckeditor/ckeditor.js');
        $this->view->public_js = array('bootstrap-datepicker.min.js');
        $this->view->js = array('cliente/js/custom.js');
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/agregar');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function addNewSubasta() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        $id_cliente = $helper->cleanInput($_POST['subasta']['id_cliente']);
        $images = '';
        if (!empty($_FILES['imagen']['name'])) {
            for ($i = 0; $i < count($_FILES['imagen']['name']); $i++) {
                $uploadfile = $_FILES["imagen"]["tmp_name"][$i];
                $folder = UPLOAD_SUBASTA;
                move_uploaded_file($uploadfile, $folder . $_FILES["imagen"]["name"][$i]);
            }
            $images = implode('|', $_FILES['imagen']['name']);
        }
        $datos = array(
            'id_cliente' => $helper->cleanInput($_POST['subasta']['id_cliente']),
            'nombre' => $helper->cleanInput($_POST['subasta']['nombre']),
            'marca' => $helper->cleanInput($_POST['subasta']['marca']),
            'oferta_minima' => $helper->cleanInput($_POST['subasta']['oferta_minima']),
            'fecha_inicio' => date('Y-m-d', strtotime($_POST['subasta']['fecha_inicio'])),
            'fecha_fin' => date('Y-m-d', strtotime($_POST['subasta']['fecha_fin'])),
            'condicion' => $helper->cleanInput($_POST['subasta']['condicion']),
            'descripcion_corta' => $_POST['subasta']['descripcion_corta'],
            'contenido' => $_POST['subasta']['contenido'],
            'imagen' => $images,
            'estado' => 'Revisión',
        );
        $this->model->addNewSubasta($datos);
        header('Location: ' . URL . 'cliente/subasta/');
    }

    public function modificar() {
        $helper = new Helper();
        #obtenomos los datos a travez de la url
        $url = $helper->getUrl();
        $idSubasta = $url[2];
        #datos para la vista
        $this->view->getDatosSubasta = $this->model->getDatosSubasta($idSubasta);
        $this->view->selectCondicion = $helper->getEnumOptions('subasta', 'condicion');
        #sidebar
        $this->view->acountSidebar = $this->model->acountSidebar($helper->getPage());
        #css
        $this->view->public_css = array('bootstrap-datepicker.min.css');
        #js
        $this->view->pluggins_js = array('ckeditor/ckeditor.js');
        $this->view->public_js = array('bootstrap-datepicker.min.js');
        $this->view->js = array('cliente/js/custom.js');
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('cliente/modificar');
        $this->view->render('footer');
        unset($_SESSION['message']);
    }

    public function eliminarImagenSubasta() {
        $helper = new Helper();
        $datos = array(
            'id' => $helper->cleanInput($_POST['id']),
            'imagen' => $helper->cleanInput($_POST['imagen']),
            'posicion' => $helper->cleanInput($_POST['posicion'])
        );
        $data = $this->model->eliminarImagenProducto($datos);
        echo $data;
    }
    
    public function modificarSubasta() {
        $helper = new Helper();
        $urlAnterior = $helper->getUrlAnterior();
        if (!empty($_FILES['imagen']['name'])) {
            for ($i = 0; $i < count($_FILES['imagen']['name']); $i++) {
                $uploadfile = $_FILES["imagen"]["tmp_name"][$i];
                $folder = UPLOAD_SUBASTA;
                move_uploaded_file($_FILES["imagen"]["tmp_name"][$i], $folder . $_FILES["imagen"]["name"][$i]);
            }
            $images = implode('|', $_FILES['imagen']['name']);
        }
        $datos = array(
            'id' => $helper->cleanInput($_POST['subasta']['id_subasta']),
            'nombre' => $helper->cleanInput($_POST['subasta']['nombre']),
            'marca' => $helper->cleanInput($_POST['subasta']['marca']),
            'oferta_minima' => $helper->cleanInput($_POST['subasta']['oferta_minima']),
            'fecha_inicio' => $_POST['subasta']['fecha_inicio'],
            'fecha_fin' => $_POST['subasta']['fecha_fin'],
            'condicion' => $helper->cleanInput($_POST['subasta']['condicion']),
            'descripcion_corta' => $_POST['subasta']['descripcion_corta'],
            'contenido' => $_POST['subasta']['contenido'],
            'imagen' => (!empty($images)) ? $images : '');

        $this->model->modificarSubasta($datos);

        header('Location: ' . URL .'cliente/subasta/');
    }
}
