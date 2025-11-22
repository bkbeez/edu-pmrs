<?php
    ob_start();
    session_start();
    require_once('app/start.php');
    $url = new URL($_GET);
    if( $url->getController() ){
        $class = $url->getController();
        require_once(APP_ROOT.'/app/controllers/'.$class.'.php');
        new $class($url->getView(), $url->getParameters());
    }else{
        require_once(APP_ROOT.'/app/controllers/Home.php');
        new Home();
    }
?>