<?php
    // Timezone
    date_default_timezone_set('Asia/Bangkok');
    // Define
    define('APP_PATH', '');
    define('APP_ROOT', $_SERVER["DOCUMENT_ROOT"].APP_PATH);
    define('APP_HOST', ((in_array($_SERVER["HTTP_HOST"], array('127.0.0.1','localhost','pmrs.edu.cmu')))?'http://':'https://').$_SERVER["HTTP_HOST"]);
    define('APP_HOME', APP_HOST.APP_PATH);
    define('APP_CODE', 'PMRS EDU CMU');
    define('APP_NAME', 'Performance Measurement Reporting System');
    define('APP_FACT_TH', 'คณะศึกษาศาสตร์ มหาวิทยาลัยเชียงใหม่');
    define('APP_FACT_EN', 'Faculty of Education, Chiang Mai University');
    define('APP_ADDR_TH', '239 ถ.ห้วยแก้ว ต.สุเทพ อ.เมืองเชียงใหม่ จ.เชียงใหม่ 50200');
    define('APP_ADDR_EN', '239, Huay Kaew Road, Muang District,Chiang Mai Thailand, 50200');
    define('APP_EMAIL', 'edu@cmu.ac.th');
    define('APP_PHONE', '053-941215');
    define('APP_VERSION', '1');
    define('APP_COPYRIGHT', '© '.date("Y").' '.APP_CODE);
    // Theme
    define('THEME_JS', APP_PATH.'/theme/js');
    define('THEME_IMG', APP_PATH.'/theme/img');
    define('THEME_CSS', APP_PATH.'/theme/css');
    // Install
    if( file_exists(APP_ROOT."/app/install/.env") ){
        $config = explode("\n", file_get_contents(APP_ROOT."/app/install/.env"));
        if( isset($config)&&count($config)>0 ){
            foreach($config as $env){
                if( $env ){
                    $envs = explode('=', $env);
                    define(trim($envs[0]), trim($envs[1]));
                }
            }
        }
    }
    // Classes
    include_once(APP_ROOT."/app/classes/db.class.php");
    include_once(APP_ROOT."/app/classes/url.class.php");
    include_once(APP_ROOT."/app/classes/auth.class.php");
    include_once(APP_ROOT."/app/classes/lang.class.php");
    include_once(APP_ROOT."/app/classes/controller.class.php");
    include_once(APP_ROOT."/app/classes/helper.class.php");
    include_once(APP_ROOT."/app/classes/status.class.php");
    // Models
    $models = opendir(APP_ROOT."/app/models/");
    while (($inclass=readdir($models))!==false) {
        if( preg_match("/.php/i", $inclass) ){
            require_once(APP_ROOT."/app/models/".$inclass);
        }
    }
?>