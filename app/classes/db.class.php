<?php
/**
 * DB Class
 */
class DB {
    protected $host = DB_HOST;
    protected $dbname = DB_NAME;
    protected $username = DB_USER;
    protected $password = DB_PASS;

    /**
     * Test
     * @param  init
     * @return string
     */
    static function test($init=array()){
        $self = new DB();
        $driver = "mysql";
        $host = $self->host;
        $dbname = isset($init["dbname"]) ? $init["dbname"] : $self->dbname;
        $username = isset($init["username"]) ? $init["username"] : $self->username;
        $password = isset($init["password"]) ? $init["password"] : $self->password;
        $connect = null;
        try {
            $connect = new PDO("$driver:host=$host;dbname=$dbname", $username, $password);
            if (!$connect) {
                die("Connection failed: ");
            }else{
                echo $dbname." was connected.";
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        $connect = null;
    }

    /**
     * Create
     * @param  sql, init, parameters
     * @return boolean
     */
    static function create($sql, $init=array(), $parameters=array()){
        $self = new DB();
        $driver = "mysql";
        $host = $self->host;
        $dbname = isset($init["dbname"]) ? $init["dbname"] : $self->dbname;
        $username = isset($init["username"]) ? $init["username"] : $self->username;
        $password = isset($init["password"]) ? $init["password"] : $self->password;
        $result = null;
        $connect = null;
        try {
            $connect = new PDO("$driver:host=$host;dbname=$dbname", $username, $password);
            if (!$connect) {
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(500);
                echo json_encode(array('error' => array('code'=>"500", 'message'=>"Connection failed: ".$host."&rarr;".$dbname) ));
                exit();
            }
            $connect->exec("set names utf8");
            // Statement
            $statement = $connect->prepare($sql);
            // Execute
            if( count($parameters)>0 ){
                $result = $statement->execute($parameters);
            }else{
                $result = $statement->execute();
            }
        } catch(PDOException $e) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(500);
            echo json_encode(array('error' => array('code'=>"500", 'message'=>'<code>'.$sql.'</code><br>'.$e->getMessage()) ));
            exit();
        }
        $connect = null;
        return $result;
    }

    /**
     * Update
     * @param  sql, init, parameters
     * @return boolean
     */
    static function update($sql, $init=array(), $parameters=array()){
        $self = new DB();
        $driver = "mysql";
        $host = $self->host;
        $dbname = isset($init["dbname"]) ? $init["dbname"] : $self->dbname;
        $username = isset($init["username"]) ? $init["username"] : $self->username;
        $password = isset($init["password"]) ? $init["password"] : $self->password;
        $result = null;
        $connect = null;
        try {
            $connect = new PDO("$driver:host=$host;dbname=$dbname", $username, $password);
            if (!$connect) {
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(500);
                echo json_encode(array('error' => array('code'=>"500", 'message'=>"Connection failed: ".$host."&rarr;".$dbname) ));
                exit();
            }
            $connect->exec("set names utf8");
            // Statement
            $statement = $connect->prepare($sql);
            // Execute
            if( count($parameters)>0 ){
                $statement->execute($parameters);
            }else{
                $result = $statement->execute();
            }
            if( $statement->rowCount()>0 ){
                $result = true;
            }
        } catch(PDOException $e) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(500);
            echo json_encode(array('error' => array('code'=>"500", 'message'=>'<code>'.$sql.'</code><br>'.$e->getMessage()) ));
            exit();
        }
        $connect = null;
        return $result;
    }

    /**
     * Delete
     * @param  sql, init, parameters
     * @return boolean
     */
    static function delete($sql, $init=array(), $parameters=array()){
        $self = new DB();
        $driver = "mysql";
        $host = $self->host;
        $dbname = isset($init["dbname"]) ? $init["dbname"] : $self->dbname;
        $username = isset($init["username"]) ? $init["username"] : $self->username;
        $password = isset($init["password"]) ? $init["password"] : $self->password;
        $result = null;
        $connect = null;
        try {
            $connect = new PDO("$driver:host=$host;dbname=$dbname", $username, $password);
            if (!$connect) {
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(500);
                echo json_encode(array('error' => array('code'=>"500", 'message'=>"Connection failed: ".$host."&rarr;".$dbname) ));
                exit();
            }
            $connect->exec("set names utf8");
            // Statement
            $statement = $connect->prepare($sql);
            // Execute
            if( count($parameters)>0 ){
                $statement->execute($parameters);
            }else{
                $result = $statement->execute();
            }
        } catch(PDOException $e) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(500);
            echo json_encode(array('error' => array('code'=>"500", 'message'=>'<code>'.$sql.'</code><br>'.$e->getMessage()) ));
            exit();
        }
        $connect = null;
        return $result;
    }

    /**
     * Query
     * @param  sql, init, parameters
     * @return array
     */
    static function query($sql, $init=array(), $parameters=array()){
        $self = new DB();
        $driver = "mysql";
        $host = $self->host;
        $dbname = isset($init["dbname"]) ? $init["dbname"] : $self->dbname;
        $username = isset($init["username"]) ? $init["username"] : $self->username;
        $password = isset($init["password"]) ? $init["password"] : $self->password;
        $result = null;
        $connect = null;
        try {
            $connect = new PDO("$driver:host=$host;dbname=$dbname", $username, $password);
            if (!$connect) {
                header("Access-Control-Allow-Origin: *");
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(500);
                echo json_encode(array('error' => array('code'=>"500", 'message'=>"Connection failed: ".$host."&rarr;".$dbname) ));
                exit();
            }
            $connect->exec("set names utf8");
            // Statement
            $statement = $connect->prepare($sql);
            // Execute
            if( count($parameters)>0 ){
                $statement->execute($parameters);
            }else{
                $result = $statement->execute();
            }
            // Fetch
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetchAll();
        } catch(PDOException $e) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(500);
            echo json_encode(array('error' => array('code'=>"500", 'message'=>'<code>'.$sql.'</code><br>'.$e->getMessage()) ));
            exit();
        }
        $connect = null;
        return $result;
    }


    /**
     * One
     * @param  sql, init, parameters
     * @return array
     */
    static function one($sql, $init = array(), $parameters=array()){
        $result = DB::query($sql, $init, $parameters);
        return ( isset($result[0]) ? $result[0] : null );
    }

    /**
     * Sql
     * @param  sql, init, parameters
     * @return array
     */
    static function sql($sql, $init = array(), $parameters=array()){
        return DB::query($sql, $init, $parameters);
    }

    /**
     * Log
     */
    static function log($logs, $mode=null){
        if( $mode=='telegram_group' ){
            DB::create("INSERT INTO `logs_telegram_group` (`org_id`,`date_at`,`mode`,`service`,`chat_id`,`title`,`contents`,`send_by`,`status`,`message`) VALUES (:org_id, NOW(), :mode, :service, :chat_id, :title, :contents, :send_by, :status, :message);", array('dbname'=>'edumis_logs'), $logs);
        }else if( $mode=='telegram' ){
            DB::create("INSERT INTO `logs_telegram` (`personel_id`,`date_at`,`mode`,`service`,`chat_id`,`title`,`contents`,`send_by`,`status`,`message`) VALUES (:personel_id, NOW(), :mode, :service, :chat_id, :title, :contents, :send_by, :status, :message);", array('dbname'=>'edumis_logs'), $logs);
        }else if( $mode=='smartdoor' ){
            DB::create("INSERT INTO `logs_smartdoor` VALUES (NOW(), :username, :request, :user_id, :room, :application, :parameters, :status, :message);", array('dbname'=>"edumis_logs"), $logs);
        }else if( $mode=='login' ){
            DB::create("INSERT INTO `logs_apiapp` VALUES (NOW(), :email, :device, :platform, :browser, :ip_client, :ip_server, :status);", array('dbname'=>"edumis_logs"), $logs);
        }else{
            DB::create("INSERT INTO `logs_apiuser` VALUES (NOW(), :username, :request, :version, :function, :method, :action, :parameters, :status, :message);", array('dbname'=>"edumis_logs"), $logs);
        }
    }

}
?>