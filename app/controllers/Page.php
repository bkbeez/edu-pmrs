<?php
/**
 * Page
 */
class Page extends Controller {

    public function __construct($view, $parameters=array()) {
        parent::__construct();
        if( $view ){
            if( method_exists($this, $view) ){
                $this->$view($parameters);
            }else{
                $this->render('PageNotFound');
            }
        }else{
            http_response_code(400);
            echo json_encode(array('error'=>array('code'=>"400",'message'=>"Bad Request")));
            exit();
        }
    }

    public function history() {
        echo "page/history";
    }

}
?>