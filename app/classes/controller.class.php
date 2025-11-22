<?php
/**
 * Controller Class
 */
class Controller {

    /**
     * @var object
     */
    private static $instance;

    public function __construct() {
        self::$instance = & $this;
    }

    public function render($view, $parameters=array()) {
        include_once(APP_ROOT.'/app/views/layout/header.php');
        if( count($parameters)>0 ){
            extract($parameters);
        }
        if( $view=='PageNotFound' ){
            include_once(APP_ROOT.'/app/views/404.php');
        }else{
            include_once(APP_ROOT.'/app/views/'.$view.'.php');
        }
        include_once(APP_ROOT.'/app/views/layout/footer.php');
    }

}
?>