<?php
/**
 * Home
 */
class Home extends Controller {

    public function __construct() {
        parent::__construct();
        $this->index();
    }

    public function index() {
        $this->render('home');
    }

}
?>