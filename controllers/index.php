<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->view->title = 'Lo que querés, como vos podés';
        
        $this->view->public_folderHeader = array("pluggins/jquery.countdown/css/main.css");
        $this->view->pluggins_js = array("jquery.countdown/js/lodash.min.js", "jquery.countdown/js/jquery.countdown.js");
        
        $this->view->render('header');
        $this->view->render('index/index');
        $this->view->render('footer');
        
        unset($_SESSION['message']);
    }

}
