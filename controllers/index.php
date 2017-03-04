<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->view->title = 'Lo que querés, como vos podés';

        $this->view->render('header');
        $this->view->render('index/index');
        $this->view->render('footer');
        
        unset($_SESSION['message']);
    }

}
