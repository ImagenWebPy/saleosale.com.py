<?php

class Pagina extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function seccion() {
        $helper = new Helper();
        $url = $helper->getUrl();
        #obtenemos los datos de la pagina
        $pagina = $this->model->getDatosPagina($url['2']);
        
        $nombrePagina =  $pagina['nombre_pagina'];
        #titulo de la pagina
        $this->view->title = $nombrePagina;

        Session::set('pagina', array(
            'titulo' => $pagina['nombre_pagina'],
            'contenido' => $pagina['contenido']));
        
        $this->view->sidebar = $this->model->sidebar($url['2']);
        #cargamos la vista
        $this->view->render('header');
        $this->view->render('pagina/index');
        $this->view->render('footer');
        unset($_SESSION['pagina']);
    }

}
