<?php

class Subasta extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $url = $_GET['url'];
        $url = explode('/', $url);
        !empty($url[1]) ? $pagina = $url[1] : $pagina = NULL;
        #total de subastas a paginar
        $totalSubastas = $this->model->totalSubastas();
        #subastas por pagina
        $this->view->listarSubastas = $this->model->listarSubastas($totalSubastas, $pagina);
        #paginacion
        $this->view->paginacion = $this->model->paginacion($pagina, $totalSubastas);
        #Cargamos la vista
        $this->view->public_folderHeader = array("pluggins/jquery.countdown/css/main.css");
        $this->view->public_folder = array("pluggins/jquery.countdown/js/lodash.min.js","pluggins/jquery.countdown/js/jquery.countdown.min.js");
        $this->view->render('header');
        $this->view->render('subasta/index');
        $this->view->render('footer');
        if (isset($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function item() {
        Auth::handleLogin();
        $helper = new Helper();
        #obtenomos los datos a travez de la url
        $url = $helper->getUrl();
        $idSubasta = $url[2];
        #datos para la vista 
        $this->view->getItemSubasta = $this->model->getItemSubasta($idSubasta);
        $this->view->title = utf8_encode($this->view->getItemSubasta['nombre']) . ' - '.utf8_encode($this->view->getItemSubasta['marca']);
        #Cargamos la vista
        $this->view->js = array('producto/js/cloud-zoom.js', 'producto/js/jquery.flexslider.js');
        $this->view->render('header');
        $this->view->render('subasta/item');
        $this->view->render('footer');
        if (isset($_SESSION['message']))
            unset($_SESSION['message']);
    }
    
    public function ofertar(){
        $helper = new Helper();
        $fecha_oferta = date('Y-m-d H:i:s');
        $data = array(
            'id_subasta' => $helper->cleanInput($_POST['id_subasta']),
            'id_cliente' => $helper->cleanInput($_POST['id_cliente']),
            'monto_oferta' => $helper->cleanInput($_POST['monto']),
            'fecha_oferta' => $fecha_oferta
        );
        $datos = $this->model->ofertar($data);
        
    }
}
