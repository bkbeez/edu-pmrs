<?php
/**
 * URL Class
 */
class URL {
    private $controller = null;
    private $view = null;
    private $parameters = array();

    function __construct($request=null){
        if( $request&&isset($request['url'])&&$request['url'] ){
            $urls = explode('/', substr($request['url'],1));
            if( isset($urls[0])&&$urls[0] ){
                foreach($urls as $key => $value){
                    if( $key>2 ){
                        array_push($this->parameters, $value);
                    }else if( $key==1 ){
                        $this->view = $value;
                    }else if( $key==0 ){
                        $this->controller = $value;
                    }
                }
            }else{
                http_response_code(400);
                echo json_encode(array('error'=>array('code'=>"400",'message'=>"Bad Request")));
                exit();
            }
        }
    }

    /**
     * Get Controller
     *
     * @param  void
     * @return string
     */
    public function getController(){
        return $this->controller;
    }

    /**
     * Get View
     * @param  void
     * @return string
     */
    public function getView(){
        return $this->view;
    }

    /**
     * Get Parameters
     * @param  void
     * @return string
     */
    public function getParameters(){
        return $this->parameters;
    }

    /**
     * Error
     */
    public function error(){
        http_response_code(400);
        echo json_encode(array('error' => array('code'=>"400", 'message'=>"Bad Request") ));
        exit();
    }

}
?>